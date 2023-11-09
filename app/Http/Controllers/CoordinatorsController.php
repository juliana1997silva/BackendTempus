<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Tempus;
use App\Models\Coordinators;

class CoordinatorsController extends Controller
{
    //listar coordenadores
    public function index()
    {
        $coordinator = Coordinators::all();
        return response()->json(['data' => $coordinator], 200);
    }

    //criar coordenadores
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'group_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $Coordinator = Coordinators::create([
                'id' => Tempus::uuid(),
                'name' => $request->name,
                'group_id' => $request->group_id,
                'status' => 1
            ]);


            return response()
                ->json(['data' => $Coordinator]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e], 500);
        }
    }

    //atualizar coordenadores
    public function update(Request $request, $id)
    {
        try {

            Coordinators::findOrFail($id)->update($request->all());
            $update = Coordinators::findOrFail($id);

            return response()->json(['data' => $update], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }

    //atualizar status do coordenadores
    public function release($id)
    {
        try {

            $coordinator =  Coordinators::findOrFail($id);
            if ($coordinator->status > 0) {
                $coordinator->update(['status' => 0]);
            } else {
                $coordinator->update(['status' => 1]);
            }

            $update =
            Coordinators::findOrFail($id);

            return response()->json(['data' => $update], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }
}
