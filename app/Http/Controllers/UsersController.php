<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Helpers\Tempus;

class UsersController extends Controller
{
    //listar usuarios
    public function index() {
        $user = Users::all();

        return response()
            ->json(['data' => $user ]);

    }

    //criar usuarios
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'group_id' => 'required',
            'entry_time' => 'required|string|max:255',
            'lunch_entry_time' => 'required|string|max:255',
            'lunch_out_time' => 'required|string|max:255',
            'out_time' => 'required|string|max:255',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = Users::create([
            'id' => Tempus::uuid(),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'group_id' => $request->group_id,
            'entry_time' => $request->entry_time,
            'lunch_entry_time' => $request->lunch_entry_time,
            'lunch_out_time' => $request->lunch_out_time,
            'out_time' => $request->out_time,
            'password' => Hash::make($request->password),
            'status' => 1
         ]);

        return response()
            ->json(['data' => $user ]);
    }

    //atualizar usuarios
    public function update(Request $request, $id)
    {
        try {

            Users::findOrFail($id)->update($request->all());

            return response()->json(['message' => 'Atualizado com sucesso'], 200);

        }catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }

    //atualizar status do usuarios
    public function release($id)
    {
        try {

           Users::findOrFail($id)->update(['status' => 0]);

            return response()->json(['message' => 'Status atualizado com sucesso'], 200);

        }catch (\Exception $e) {
            return response()->json([
                'message' => "Ocorreu um erro. Tente Novamente !"
            ], 500);
        }
    }
}
