<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Helpers\Tempus;
use App\Http\Requests\UsersRequest;
use App\Models\Groups;
use App\Models\UsersGroups;
use App\Repositories\UsersRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    protected $repository;


    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listUsers($id) {

        $users_rsl = Users::where("team_id", $id)
        ->orWhereNull("team_id")
        ->get();
        return response()->json($users_rsl, 200);
    }

    //listar usuarios
    public function index()
    {
        $user = Auth::user();
        $users = Users::where("team_id", $user->team_id)
            //->where('manager', 0)
            ->get();

        return response()->json($users, 200);
    }

    //criar usuarios
    public function store(UsersRequest $request)
    {
        $result = (object)$request->handle();

        $group = Groups::where("name", "Desenv")->first();

        $user = Users::create([
            'id'                => Tempus::uuid(),
            'name'              => $result->name,
            'phone'             => $result->phone,
            'email'             => $result->email,
            'team_id'           => NULL,
            'entry_time'        => $result->entry_time,
            'lunch_entry_time'  => $result->lunch_entry_time,
            'lunch_out_time'    => $result->lunch_out_time,
            'out_time'          => $result->out_time,
            'password'          => Hash::make($result->password),
            'status'            => $result->status,
            'admin'             => $result->admin,
            'manager'             => $result->manager,
            'user_interpres_code' => $result->user_interpres_code

        ]);

        UsersGroups::create([
            'id'                => Tempus::uuid(),
            'user_id'              => $user->id,
            'group_id'             => $group->id,
        ]);

        return response()
            ->json("Cadastro realizado com sucesso");
    }

    //atualizar usuarios
    public function update(UsersRequest $request, $id)
    {
        $result = (object)$request->handle();

        $user = $this->repository->find($id);
        $user->update([
            'name'              => $result->name,
            'phone'             => $result->phone,
            'email'             => $result->email,
            'team_id'          => $result->team_id,
            'entry_time'        => $result->entry_time,
            'lunch_entry_time'  => $result->lunch_entry_time,
            'lunch_out_time'    => $result->lunch_out_time,
            'out_time'          => $result->out_time,
            'status'            => $result->status,
            'admin'             => $result->admin,
            'manager'           => $result->manager,
            'user_interpres_code' => $result->user_interpres_code
        ]);

        return response()->json("Atualização realizada com sucesso", 200);
    }

    //atualizar status do usuarios
    public function release($id)
    {
        $users =  $this->repository->find($id);

        if ($users->status > 0) {
            $users->update(['status' => 0]);
        } else {
            $users->update(['status' => 1]);
        }

        return response()->json(['message' => 'Status atualizado com sucesso'], 200);
    }

    public function destroy($id)
    {
        $users = Users::find($id);

        if ($users) {
            $users->delete();
            return response()->json("Usuario Deletado", 200);
        } else {
            return response()->json("Usuario não encontrado", 401);
        }
    }
}
