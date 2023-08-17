<?php

namespace App\Http\Controllers;

use App\Models\Queries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Tempus;

class GroupsController extends Controller
{
   //listar grupo
    public function index()
    {
        $groups = Queries::all();
         return response()->json($groups, 200);
    }

    //criar grupo
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'level' => 'required'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors());       
            }

            $groups = Queries::create([
                'id' => Tempus::uuid(),
                'name' => $request->name,
                'level' => $request->level,
                'status' => 1
            ]);


            return response()
                ->json(['data' => $groups ]);

        } catch (\Exception $e) {
            return response()->json(["message" => $e], 500);
        }
        
    }
   
    //atualizar grupo
    public function update(Request $request, $id)
    {
        try {

            Queries::findOrFail($id)->update($request->all());

            return response()->json(['message' => 'Atualizado com sucesso'], 200);

        }catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }

    //atualizar status do grupo
    public function release($id)
    {
        try {

            $group =  Queries::findOrFail($id);
            if ($group->status > 0) {
                $group->update(['status' => 0]);
            } else {
                $group->update(['status' => 1]);
            }

            return response()->json(['message' => 'Status atualizado com sucesso'], 200);

        }catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }
   
}
