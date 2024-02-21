<?php

namespace App\Http\Controllers;

use App\Helpers\Tempus;
use App\Http\Requests\BusinessHoursRequest;
use App\Models\BusinessHours;
use App\Models\Coordinators;
use App\Models\Groups;
use App\Repositories\NonBusinessHoursRepository;
use App\Repositories\ConsultationsRepository;
use App\Repositories\CoordinatorsRepository;
use App\Repositories\UsersRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessHoursController extends Controller
{

    /**
     * NonBusinessHourRepositoryEloquent object
     *
     * @var \App\Repositories\NonBusinessHoursRepository
     */

    protected NonBusinessHoursRepository $repositoryNonBusinessHours;

    /**
     * ConsultationRepository object
     *
     * @var \App\Repositories\ConsultationsRepository
     */
    protected ConsultationsRepository $repositoryConsultation;

    /**
     * UsersRepository object
     *
     * @var \App\Repositories\UsersRepository
     */

    protected UsersRepository $repositoryUsers;

    /**
     * CoordinatorsRepository object
     *
     * @var \App\Repositories\CoordinatorsRepository
     */

    protected CoordinatorsRepository $repositoryCoordinators;


    //CoordinatorsRepository

    public function __construct(
        NonBusinessHoursRepository $repositoryNonBusinessHours,
        ConsultationsRepository $repositoryConsultation,
        UsersRepository $repositoryUsers,
        CoordinatorsRepository $repositoryCoordinators

    ) {
        $this->repositoryNonBusinessHours = $repositoryNonBusinessHours;
        $this->repositoryConsultation = $repositoryConsultation;
        $this->repositoryUsers = $repositoryUsers;
        $this->repositoryCoordinators = $repositoryCoordinators;
    }

    public function index()
    {

        $userId = Auth::user()->id;

        $times = BusinessHours::where("user_id", $userId)->orderBy('created_at', 'asc')->get();
        foreach ($times as $k => $value) {
            $times[$k]['nonbusiness'] = $this->repositoryNonBusinessHours->where('registry_id', $value['id'])->get();
            $times[$k]['consults'] = $this->repositoryConsultation->where('registry_id', $value['id'])->get();
        }

        return response()->json($times,  200);
    }

    public function users($id)
    {
        $time = BusinessHours::where("user_id", $id)->get();

        foreach($time as $k => $items){
            $time[$k]['nonbusiness'] = $this->repositoryNonBusinessHours->where('registry_id', $items['id'])->get();
            $time[$k]['consults'] = $this->repositoryConsultation->where('registry_id', $items['id'])->get();
        }

        return response()->json($time,  200);
    }

    //criar horario
    public function store(BusinessHoursRequest $request)
    {
        try {
            //retorno do request
            $BusinessHours = (object)$request->handle();
            //dd($BusinessHours);

            $total = (strtotime($BusinessHours->lunch_entry_time) - strtotime($BusinessHours->entry_time)) +
                (strtotime($BusinessHours->out_time) - strtotime($BusinessHours->lunch_out_time));

            $hours      = floor($total / 60 / 60);
            $minutes    = round(($total - ($hours * 60 * 60)) / 60);

            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
            $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

            //registro horario comercial
            $time = BusinessHours::create([
                'id'                                => Tempus::uuid(),
                'user_id'                           => $BusinessHours->user_id,
                'date'                              => $BusinessHours->date,
                'location'                          => $BusinessHours->location,
                'entry_time'                        => $BusinessHours->entry_time,
                'lunch_entry_time'                  => $BusinessHours->lunch_entry_time,
                'lunch_out_time'                    => $BusinessHours->lunch_out_time,
                'out_time'                          => $BusinessHours->out_time,
                'total_time'                        => $hours . ':' . $minutes,
                'observation'                       => isset($BusinessHours->observation) ? $BusinessHours->observation : "",
                'status'                            => isset($value['status']) ? $value['status'] : "pending",
            ]);


            //registro horario nao comercial
            if ($BusinessHours->nonbusiness !== null) {
                foreach ($BusinessHours->nonbusiness as $value) {

                    if ($value['lunch_entry_time'] !== null) {

                        $total = (strtotime($value['lunch_entry_time']) - strtotime($value['entry_time'])) +
                            (strtotime($value['out_time']) - strtotime($value['lunch_out_time']));

                        $hours      = floor($total / 60 / 60);
                        $minutes    = round(($total - ($hours * 60 * 60)) / 60);

                        $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);



                        $this->repositoryNonBusinessHours->create([
                            'id'                    => Tempus::uuid(),
                            'registry_id'           => $time->id,
                            'entry_time'            => $value['entry_time'],
                            'lunch_entry_time'      => isset($value['lunch_entry_time']) ? $value['lunch_entry_time'] : null,
                            'lunch_out_time'        => isset($value['lunch_out_time']) ? $value['lunch_out_time'] : null,
                            'out_time'              => $value['out_time'],
                            'total_time'            => $hours . ':' . $minutes,


                        ]);
                    } else {
                        $total = strtotime($value['out_time']) - strtotime($value['entry_time']);

                        $hours      = floor($total / 60 / 60);
                        $minutes    = round(($total - ($hours * 60 * 60)) / 60);

                        $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

                        $this->repositoryNonBusinessHours->create([
                            'id'                    => Tempus::uuid(),
                            'registry_id'           => $time->id,
                            'entry_time'            => $value['entry_time'],
                            'lunch_entry_time'      => isset($value['lunch_entry_time']) ? $value['lunch_entry_time'] : null,
                            'lunch_out_time'        => isset($value['lunch_out_time']) ? $value['lunch_out_time'] : null,
                            'out_time'              => $value['out_time'],
                            'total_time'            => $hours . ':' . $minutes,


                        ]);
                    }
                }
            }


            //registro de consultas
            if ($BusinessHours->consults !== null) {

                foreach ($BusinessHours->consults as $value) {
                    $this->repositoryConsultation->create([
                        'id'                => Tempus::uuid(),
                        'registry_id'       => $time->id,
                        'queries'           => $value['queries'],
                        'description'       => $value['description']
                    ]);
                }
            }

            return response()
                ->json(['message' => "Registro efetuado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e], 500);
        }
    }

    //editar
    public function update($id, BusinessHoursRequest $request)
    {
        try {
            $result = (object)$request->handle();



            $businessHours = BusinessHours::find($id);

            if ($businessHours) {
                // dd("JULIANA");
                $businessHours->update([
                    'location'        => $result->location
                ]);
            } else {
                response()->json(['message' => 'Registro não encontrado'], 422);
            }



            if ($result->nonbusiness !== null) {

                foreach ($result->nonbusiness as $value) {

                    $count = $this->repositoryNonBusinessHours->where('registry_id', $id)->count();

                    if ($count > 0) {

                        if ($value['lunch_entry_time'] !== null) {

                            $total = (strtotime($value['lunch_entry_time']) - strtotime($value['entry_time'])) +
                                (strtotime($value['out_time']) - strtotime($value['lunch_out_time']));

                            $hours      = floor($total / 60 / 60);
                            $minutes    = round(($total - ($hours * 60 * 60)) / 60);

                            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
                            $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

                            $this->repositoryNonBusinessHours->where('registry_id', $id)->update([
                                'entry_time'            => $value['entry_time'],
                                'lunch_entry_time'      => $value['lunch_entry_time'],
                                'lunch_out_time'        => $value['lunch_out_time'],
                                'out_time'              => $value['out_time'],
                                'total_time'            => $hours . ':' . $minutes,
                            ]);
                        } else {
                            $total = strtotime($value['out_time']) - strtotime($value['entry_time']);

                            $hours      = floor($total / 60 / 60);
                            $minutes    = round(($total - ($hours * 60 * 60)) / 60);

                            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
                            $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

                            $this->repositoryNonBusinessHours->where('registry_id', $id)->update([
                                'entry_time'            => $value['entry_time'],
                                'lunch_entry_time'      => $value['lunch_entry_time'],
                                'lunch_out_time'        => $value['lunch_out_time'],
                                'out_time'              => $value['out_time'],
                                'total_time'            => $hours . ':' . $minutes,
                            ]);
                        }
                    } else {

                        if ($value['lunch_entry_time'] !== null) {

                            $total = (strtotime($value['lunch_entry_time']) - strtotime($value['entry_time'])) +
                                (strtotime($value['out_time']) - strtotime($value['lunch_out_time']));

                            $hours      = floor($total / 60 / 60);
                            $minutes    = round(($total - ($hours * 60 * 60)) / 60);

                            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
                            $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

                            $this->repositoryNonBusinessHours->create([
                                'id'                    => Tempus::uuid(),
                                'registry_id'           => $id,
                                'entry_time'            => $value['entry_time'],
                                'lunch_entry_time'      => isset($value['lunch_entry_time']) ? $value['lunch_entry_time'] : null,
                                'lunch_out_time'        => isset($value['lunch_out_time']) ? $value['lunch_out_time'] : null,
                                'out_time'              => $value['out_time'],
                                'total_time'            => $hours . ':' . $minutes,


                            ]);
                        } else {
                            //dd('count == 0');
                            $total = strtotime($value['out_time']) - strtotime($value['entry_time']);

                            $hours      = floor($total / 60 / 60);
                            $minutes    = round(($total - ($hours * 60 * 60)) / 60);

                            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
                            $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

                            $this->repositoryNonBusinessHours->create([
                                'id'                    => Tempus::uuid(),
                                'registry_id'           => $id,
                                'entry_time'            => $value['entry_time'],
                                'lunch_entry_time'      => isset($value['lunch_entry_time']) ? $value['lunch_entry_time'] : null,
                                'lunch_out_time'        => isset($value['lunch_out_time']) ? $value['lunch_out_time'] : null,
                                'out_time'              => $value['out_time'],
                                'total_time'            => $hours . ':' . $minutes,


                            ]);
                        }
                    }
                }
            }

            if ($result->consults !== null) {
                foreach ($result->consults as $value) {

                    $count = $this->repositoryConsultation->where('registry_id', $id)->count();

                    if ($count > 0) {
                        $this->repositoryConsultation->where('registry_id', $id)->update([
                            'queries'           => $value['queries'],
                            'description'       => $value['description']
                        ]);
                    } else {
                        $this->repositoryConsultation->create([
                            'id'                => Tempus::uuid(),
                            'registry_id'       => $id,
                            'queries'           => $value['queries'],
                            'description'       => $value['description']
                        ]);
                    }
                }
            }



            return response()->json(['message' => 'Atualização realizada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function release($id, BusinessHoursRequest $request)
    {
        $result = (object)$request->handle();

        $businessHours = BusinessHours::find($id);
        if ($businessHours) {

            $businessHours->update([
                'status'     => $result->status
            ]);
        } else {
            response()->json(['message' => 'Registro não encontrado'], 422);
        }

        $time = BusinessHours::findOrFail($id);

        return response()->json(['message' => "Atualizado com sucesso", "data" => $time], 200);
    }

    public function generation($id)
    {
        $dados = BusinessHours::where('user_id', $id)->where('status', "approved")
            ->orderBy('created_at', 'asc')
            ->get();

        $user = $this->repositoryUsers->find($id);

        $coordenadores = Groups::find($user->group_id);

        foreach ($dados as $k => $value) {
            $dados[$k]['business'] = $this->repositoryNonBusinessHours->where('registry_id', $value['id'])->get();
            $dados[$k]['consults'] = $this->repositoryConsultation->where('registry_id', $value['id'])->get();
        }

        //dd($dados);

        $data = [
            'user_name' => $user->name,
            'coordenador_name' => $coordenadores->manager,
            'hours' => $dados,
            'today' => date('m/Y'),
            'hoje' => date('d/m/Y')
        ];

        $pdf = Pdf::loadView('pdf', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->download("Ficha Semanal - $user->name.pdf",[
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Ficha_Semanal.pdf"',
        ]);
    }
}
