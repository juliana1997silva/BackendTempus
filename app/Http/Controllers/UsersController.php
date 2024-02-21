<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Helpers\Tempus;
use App\Http\Requests\UsersRequest;
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

    //listar usuarios
    public function index()
    {

        $user = Auth::user();

            $users = Users::where("group_id", $user->group_id)
            ->where("admin", 0)
            ->get();
            return response()->json($users, 200);

    }

    //criar usuarios
    public function store(UsersRequest $request)
    {
        $result = (object)$request->handle();

        Users::create([
            'id'                => Tempus::uuid(),
            'name'              => $result->name,
            'phone'             => $result->phone,
            'email'             => $result->email,
            'group_id'    => $result->group_id,
            'entry_time'        => $result->entry_time,
            'lunch_entry_time'  => $result->lunch_entry_time,
            'lunch_out_time'    => $result->lunch_out_time,
            'out_time'          => $result->out_time,
            'password'          => Hash::make($result->password),
            'status'            => $result->status,
            'admin'             => $result->admin,
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
            'group_id'    => $result->group_id,
            'entry_time'        => $result->entry_time,
            'lunch_entry_time'  => $result->lunch_entry_time,
            'lunch_out_time'    => $result->lunch_out_time,
            'out_time'          => $result->out_time,
            'status'            => $result->status,
            'admin'             => $result->admin,
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
}
