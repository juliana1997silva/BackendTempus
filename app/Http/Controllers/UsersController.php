<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Tempus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsersRequest;

class UsersController extends Controller
{
    //listar usuarios
    public function index()
    {
        $user = Users::all();

        return response()
            ->json(['data' => $user]);
    }

    //criar usuarios
    public function register(UsersRequest $request)
    {
       // $request->validated();
       // dd();
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255 | unique:users',
            'coordinator_id' => 'required',
            'entry_time' => 'required|string|max:255',
            'lunch_entry_time' => 'required|string|max:255',
            'lunch_out_time' => 'required|string|max:255',
            'out_time' => 'required|string|max:255',
            'password' => 'required|string|min:8'
        ], [
            'email.unique' => "E-mail já cadastrado !"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        } 

        $user = Users::create([
            'id' => Tempus::uuid(),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'coordinator_id' => $request->coordinator_id,
            'entry_time' => $request->entry_time,
            'lunch_entry_time' => $request->lunch_entry_time,
            'lunch_out_time' => $request->lunch_out_time,
            'out_time' => $request->out_time,
            'password' => Hash::make($request->password),
            'status' => 1
        ]);

        return response()
            ->json(['data' => $user]);
    }

    //atualizar usuarios
    public function update(Request $request, $id)
    {
        try {

           Users::findOrFail($id)->update($request->all());
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

            $users =  Users::findOrFail($id);
            if ($users->status > 0) {
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
