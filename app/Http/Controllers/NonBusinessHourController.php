<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Tempus;
use App\Models\NonBusinessHour;

class BusinessHourController extends Controller
{

    public function index()
    {
        $business = NonBusinessHour::all();
        return response()->json([$business], 200);
    }

    //criar horario
    public function create(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'entry_time'                        => 'required|string',
                'lunch_entry_time'                  => 'required|string',
                'lunch_out_time'                    => 'required|string',
                'out_time'                          => 'required|string',
                'observation'                       => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $time = NonBusinessHour::create([
                'id'                                => Tempus::uuid(),
                'registry_id'                       => $id,  
                'entry_time'                        => $request->entry_time,
                'lunch_entry_time'                  => $request->lunch_entry_time,
                'lunch_out_time'                    => $request->lunch_out_time,
                'out_time'                          => $request->out_time,
                'observation'                       => $request->observation
            ]);

            return response()
                ->json(['message' => "Registro efetuado com sucesso", 'data' => $time], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e], 500);
        }
    }


    //atualizar
    public function update(Request $request, $id)
    {
        try {

            NonBusinessHour::findOrFail($id)->update($request->all());

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

            NonBusinessHour::findOrFail($id)->delete();
            return response()->json(['message' => 'Registro deletado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }
}
