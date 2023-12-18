<?php

namespace App\Http\Controllers;

use App\Helpers\Tempus;
use App\Http\Requests\CoordinatorRequest;
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
    public function create(CoordinatorRequest $request)
    {
        try {

            $result = (object)$request->handle();
            $Coordinator = Coordinators::create([
                'id' => Tempus::uuid(),
                'name' => $result->name,
                'group_id' => $result->group_id,
                'status' => 1
            ]);


            return response()
                ->json(['data' => $Coordinator]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e], 500);
        }
    }

    //atualizar coordenadores
    public function update(CoordinatorRequest $request, $id)
    {
        try {
            $result = (object)$request->handle();

            Coordinators::findOrFail($id)->update($result->all());
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
