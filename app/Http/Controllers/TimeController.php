<?php

namespace App\Http\Controllers;

use App\Models\Times;
use App\Models\Queries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Tempus;

class TimeController extends Controller
{
    //criar horario
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date'                              => 'required|string',
                'user_id'                           => 'required|string',
                'entry_time'                        => 'required|string',
                'lunch_entry_time'                  => 'required|string',
                'lunch_out_time'                    => 'required|string',
                'out_time'                          => 'required|string',
                'entry_time_nocommercial'           => 'string',
                'lunch_entry_time_nocommercial'     => 'string',
                'lunch_out_time_nocommercial'       => 'string',
                'out_time_nocommercial'             => 'string',
                'observation'                       => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $time = Times::create([
                'id'                                => Tempus::uuid(),
                'user_id'                           => $request->user_id,
                'date'                              => $request->date,
                'entry_time'                        => $request->entry_time,
                'lunch_entry_time'                  => $request->lunch_entry_time,
                'lunch_out_time'                    => $request->lunch_out_time,
                'out_time'                          => $request->out_time,
                'entry_time_nocommercial'           => $request->entry_time_nocommercial,
                'lunch_entry_time_nocommercial'     => $request->lunch_entry_time_nocommercial,
                'lunch_out_time_nocommercial'       => $request->lunch_out_time_nocommercial,
                'out_time_nocommercial'             => $request->out_time_nocommercial,
                'observation'                       => $request->observation
            ]);

            $consults = Queries::create([
                'id'                                => Tempus::uuid(),
                'user_id'                           => $request->user_id,
                'date'                              => $request->date,
                'consultation'                      => $request->consultation,
                'description'                       => $request->description,
            ]);

            return response()
                ->json(['message' => "Cadastro efetuado com sucesso", $time, $consults], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e], 500);
        }
    }

    //atualizar grupo
    public function update(Request $request, $id)
    {
        try {

            Times::findOrFail($id)->update($request->all());

            return response()->json(['message' => 'Atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }

    //atualizar status do grupo
    public function release($id)
    {
        try {

            $group =  Times::findOrFail($id);
            if ($group->status > 0) {
                $group->update(['status' => 0]);
            } else {
                $group->update(['status' => 1]);
            }

            return response()->json(['message' => 'Status atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }
}
