<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Tempus;

class GroupsController extends Controller
{
   //listar grupo
    public function index()
    {
        $groups = Groups::all();
         return response()->json(['data' => $groups],200);
    }

    //criar grupo
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
               
            ]);

            if($validator->fails()){
                return response()->json($validator->errors());       
            }

            $groups = Groups::create([
                'id' => Tempus::uuid(),
                'name' => $request->name,
                
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

            Groups::findOrFail($id)->update($request->all());
            $group = Groups::findOrFail($id);

            return response()->json(['data' => $group], 200);

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

            $group =  Groups::findOrFail($id);
            if ($group->status > 0) {
                $group->update(['status' => 0]);
            } else {
                $group->update(['status' => 1]);
            }

            $groupStatus =
            Groups::findOrFail($id);

            return response()->json(['data' => $groupStatus], 200);

        }catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }
   
}
