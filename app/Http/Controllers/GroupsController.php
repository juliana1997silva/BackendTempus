<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Helpers\Tempus;
use App\Http\Requests\GroupsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
   //listar grupo
    public function index()
    {
        $user = Auth::user();
        $groups = Groups::find($user->group_id);
         return response()->json([$groups],200);
    }

    //criar grupo
    public function create(GroupsRequest $request)
    {
        try {
            $result = (object)$request->handle();

            $groups = Groups::create([
                'id' => Tempus::uuid(),
                'name' => $result->name,
                'manager' => $result->manager,
                'status' => 1
            ]);


            return response()
                ->json(['data' => $groups ]);

        } catch (\Exception $e) {
            return response()->json(["message" => $e], 500);
        }
        
    }
   
    //atualizar grupo
    public function update($id, GroupsRequest $request)
    {
        $result = (object)$request->handle();
        $groups = Groups::find($id);

        $groups->update([
            'name' => $result->name,
            'manager' => $result->manager
        ]);

        return response()->json("Atualizado com sucesso", 200);
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
