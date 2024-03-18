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
        if ($user->admin === 1) {
            $groups = Groups::all();
        } else {
            $groups = Groups::where('id', $user->team_id)->get();
        }

        return response()->json($groups, 200);
    }
            

    //criar grupo
    public function create(GroupsRequest $request)
    {
        $result = (object)$request->handle();

        $user = Auth::user();

        if ($user->admin === 1) {
            $groups = Groups::create([
                'id' => Tempus::uuid(),
                'name' => $result->name,
                'manager' => $result->manager,
                'status' => 1
            ]);
            return response()
                ->json(['data' => $groups]);
        } else {
            return response()
                ->json("Usuario não tem permissão");
        }
    }

    //atualizar grupo
    public function update($id, GroupsRequest $request)
    {
        $result = (object)$request->handle();

        $user = Auth::user();

        if ($user->admin === 1) {
            $groups = Groups::find($id);

            $groups->update([
                'name' => $result->name,
                'manager' => $result->manager
            ]);

            return response()->json("Atualizado com sucesso", 200);
        } else {
            return response()
                ->json("Usuario não tem permissão");
        }
    }

    //atualizar status do grupo
    public function release($id)
    {

        $user = Auth::user();
        if ($user->admin === 1) {
            $group =  Groups::findOrFail($id);
            if ($group->status > 0) {
                $group->update(['status' => 0]);
            } else {
                $group->update(['status' => 1]);
            }

            return response()->json("Status atualizado", 200);
        } else {
            return response()
                ->json("Usuario não tem permissão");
        }
    }

    public function destroy($id)
    {
        $groups = Groups::find($id);

        if ($groups) {
            $groups->delete();
            return response()->json("Grupo Deletado", 200);
        } else {
            return response()->json("Grupo não encontrado", 401);
        }
    }
}
