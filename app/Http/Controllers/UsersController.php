<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Tempus;
use App\Http\Requests\UsersRequest;
use App\Repositories\UsersRepository;

class UsersController extends Controller
{
    protected $repository;

    public function __construct(UsersRepository $repository){
        $this->repository = $repository;
    }
    
    //listar usuarios
    public function index()
    {
        return response()->json(['data' => Users::all()]);
    }

    //criar usuarios
    public function store(UsersRequest $request)
    {
        $result = (object)$request->handle();
        //dd($result);

        $user = Users::create([
            'id'                => Tempus::uuid(),
            'name'              => $result->name,
            'phone'             => $result->phone,
            'email'             => $result->email,
            'coordinator_id'    => $result->coordinator_id,
            'entry_time'        => $result->entry_time,
            'lunch_entry_time'  => $result->lunch_entry_time,
            'lunch_out_time'    => $result->lunch_out_time,
            'out_time'          => $result->out_time,
            'password'          => Hash::make($result->password),
            'status'            => $result->status,
            'admin'             => $result->admin,
        ]);

        return response()
            ->json(['data' => $user]);
    }

    //atualizar usuarios
    public function update(UsersRequest $request, $id)
    {
        try {

            $result = (object)$request->handle();
           $this->repository->update($result->all(), $id);
           $user = Users::findOrFail($id);

            return response()->json(['data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }

    //atualizar status do usuarios
    public function release($id)
    {
        try {

            $users =  $this->repository->find($id, ['status']);
            if ($users > 0) {
                $users->update(['status' => 0]);
            } else {
                $users->update(['status' => 1]);
            }

            return response()->json(['message' => 'Status atualizado com sucesso'], 200);
            //return response()->json(['message' => 'OK OK OK', 'data' => $id], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }
}
