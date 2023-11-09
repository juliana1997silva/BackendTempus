<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Tempus;
use App\Models\BusinessHour;
use App\Models\Consultation;
use App\Models\NonBusinessHour;
use PhpParser\Node\Stmt\TryCatch;

class BusinessHourController extends Controller
{

    public function index()
    {
        $business = BusinessHour::all();
        return response()->json([$business], 200);
    }

    //criar horario
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date'                                              => 'required|string',
                'location'                                          => 'required|string',
                'user_id'                                           => 'required|string',
                'entry_time'                                        => 'required|string',
                'lunch_entry_time'                                  => 'required|string',
                'lunch_out_time'                                    => 'required|string',
                'out_time'                                          => 'required|string',
                'observation'                                       => 'string',
                'entry_time_nocommercial'                           => 'string',
                'lunch_entry_time_nocommercial'                     => 'string',
                'lunch_out_time_nocommercial'                       => 'string',
                'out_time_nocommercial'                             => 'string',
                'observation_nocommercial'                          => 'string',
                'queries'                                           => 'string',
                'description'                                       => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $time = BusinessHour::create([
                'id'                                => Tempus::uuid(),
                'user_id'                           => $request->user_id,
                'date'                              => $request->date,
                'location'                          => $request->location,
                'entry_time'                        => $request->entry_time,
                'lunch_entry_time'                  => $request->lunch_entry_time,
                'lunch_out_time'                    => $request->lunch_out_time,
                'out_time'                          => $request->out_time,
                'observation'                       => $request->observation
            ]);
            
            if($request['entry_time_nocommercial'] != null) {
                $nonbusiness = NonBusinessHour::create([
                    'id'                                => Tempus::uuid(),
                    'registry_id'                       => $time->id,
                    'entry_time'                        => $request['entry_time_nocommercial'],
                    'lunch_entry_time'                  => $request['lunch_entry_time_nocommercial'],
                    'lunch_out_time'                    => $request['lunch_out_time_nocommercial'],
                    'out_time'                          => $request['out_time_nocommercial'],
                    'observation'                       => $request['observation_nocommercial']
                ]);
            }

            

            $consults = Consultation::create([
                'id'                                => Tempus::uuid(),
                'registry_id'                       => $time->id,
                'queries'                           => $request['queries'],
                'description'                       => $request['description'],
            ]);

            $dados = [
                'business_hour' => $time,
                'nonbusiness_hour' => $nonbusiness,
                'consults' => $consults
            ];

            return response()
                ->json(['message' => "Registro efetuado com sucesso", 'data' => $dados], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e], 500);
        }
    }


    //atualizar
    public function update(Request $request, $id)
    {
        try {

            BusinessHour::findOrFail($id)->update($request->all());

            return response()->json(['message' => 'Registro atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !",
                'data' => $e
            ], 500);
        }
    }

    //delete
    public function delete($id)
    {
        try {

            BusinessHour::findOrFail($id)->delete();
            return response()->json(['message' => 'Registro deletado com sucesso'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }
}
