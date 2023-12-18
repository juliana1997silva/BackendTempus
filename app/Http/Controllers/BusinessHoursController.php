<?php

namespace App\Http\Controllers;

use App\Entities\BusinessHour;
use Illuminate\Http\Request;
use App\Helpers\Tempus;
use App\Http\Requests\BusinessHoursRequest;
use App\Models\BusinessHours;
use App\Models\Consultations;
use App\Models\NonBusinessHours;
use App\Repositories\NonBusinessHoursRepository;
use App\Repositories\ConsultationsRepository;

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

    public function __construct(
        NonBusinessHoursRepository $repositoryNonBusinessHours,
        ConsultationsRepository $repositoryConsultation
    ) {
        $this->repositoryNonBusinessHours = $repositoryNonBusinessHours;
        $this->repositoryConsultation = $repositoryConsultation;
    }

    public function index()
    {
        return response()->json(BusinessHours::all(),  200);
    }

    //pesquisa os dados do registro daquele id enviado
    //horario comercial, horario nao comercial e consultas
    public function show($id)
    {
        $business = BusinessHours::find($id);
        $nonbusiness = $this->repositoryNonBusinessHours->where('registry_id', $id)->get();
        $consults = $this-> repositoryConsultation->where('registry_id', $id)->get();

        $data = [
            'business' => $business,
            'nonbusiness' => $nonbusiness,
            'consults' => $consults
        ];
        return response()->json($data,  200);
    }

    //criar horario
    public function create(BusinessHoursRequest $request)
    {
        try {
            //retorno do request
            $BusinessHours = (object)$request->handle();
            //dd($BusinessHours->nonbusiness);

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
                'observation'                       => $BusinessHours->observation
            ]);

            //registro horario nao comercial
            if ($BusinessHours->nonbusiness !== null) {
                foreach ($BusinessHours->nonbusiness as $value) {
                    //dd($value);
                    $this->repositoryNonBusinessHours->create([
                        'id'                    => Tempus::uuid(),
                        'registry_id'           => $time->id,
                        'entry_time'            => $value['entry_time'],
                        'lunch_entry_time'      => isset($value['lunch_entry_time']) ? $value['lunch_entry_time'] : null,
                        'lunch_out_time'        => isset($value['lunch_out_time']) ? $value['lunch_out_time'] : null,
                        'out_time'              => $value['out_time'],

                    ]);
                }
            }
            $nonbusiness = $this->repositoryNonBusinessHours->where('registry_id', $time->id)->get();

          
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
            $consults = $this->repositoryConsultation->where('registry_id', $time->id)->get();

            $dados = [
                'business' => $time,
                'nonbusiness' => $nonbusiness,
                'consults' => $consults
            ];

            return response()
                ->json(['message' => "Registro efetuado com sucesso", 'data' => $dados], 200);
                
        } catch (\Exception $e) {
            return response()->json(["error" => $e], 500);
        }
    }

    //editar
    public function update(Request $request, $id)
    {
        try {
            $result = (object)$request->handle();

            BusinessHours::find($id)->update([
                'observation'     => $result->observation,
                'location'        => $result->location
            ]);

            $time = BusinessHours::find($id);

            if ($result->nonbusiness !== null) {
                foreach ($result->nonbusiness as $value) {
                    $nonbusiness = $this->repositoryNonBusinessHours->find($value['id'])->update([
                        'entry_time'            => $value['entry_time'],
                        'lunch_entry_time'      => $value['lunch_entry_time'],
                        'lunch_out_time'        => $value['lunch_out_time'],
                        'out_time'              => $value['out_time'],
                    ]);
                }
            }

            $nonbusiness = $this->repositoryNonBusinessHours->where('registry_id', $time->id)->get();

            if ($result->consults !== null) {
                //registro de consultas
                foreach ($result->consults as $value) {
                    $consults = $this->repositoryConsultation->findOrFail($value['id'])->update([
                        'queries'           => $value['queries'],
                        'description'       => $value['description']
                    ]);
                }
            }

            $consults = $this->repositoryConsultation->where('registry_id', $id)->get();

            $dados = [
                'business' => $time,
                'nonbusiness' => $nonbusiness,
                'consults' => $consults
            ];

            return response()->json(['message' => 'Registro atualizado com sucesso', "data" => $dados], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !",
                'data' => $e
            ], 500);
        }
    }
}
