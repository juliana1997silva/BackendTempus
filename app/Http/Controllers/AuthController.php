<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Auth;
use Tempus;

class AuthController extends Controller
{
    //realizar login

    public function login(Request $request)
    {
        try {
        $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
       ]);

       if($validator->fails()){
        return response()->json(['message' => $validator->errors()], 401);
       }

       if(Auth::attempt($request->all())){
        $user = Auth::user();
        $success = $user->createToken('auth_token')->plainTextToken;
        $dataUsers = Users::findOrFail($request->email);

        return response()->json(['token' => $success, 'data' => $dataUsers],200);
       }

       return response()->json(['message' => 'E-mail ou Senha Incorreto'],406);
        }catch (\Exception $e) {
            return response()->json(["message" => "Ocorreu um erro. Tente Novamente !"], 500);
        }

      
        
    }
}
