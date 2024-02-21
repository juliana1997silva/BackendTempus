<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Groups;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //realizar login
    public function signin(AuthRequest $request)
    {

        $result = (object)$request->handle();

        $user = Users::where('email', $result->email)->first();
        $group = Groups::find($user->group_id);

        if ($user) {

            if (!Hash::check($result->password, $user->password)) {
                return response()->json([
                    'message' => 'Senha incorreta'
                ], 401);
            } else {
                if($user->status === 1 && $group->status === 1 ){
                    $token = $user->createToken('auth_token');

                    $response = [
                        'id'                => $user->id,
                        'name'              => $user->name,
                        'phone'             => $user->phone,
                        'email'             => $user->email,
                        'group_id'    => $user->group_id,
                        'entry_time'        => $user->entry_time,
                        'lunch_entry_time'  => $user->lunch_entry_time,
                        'lunch_out_time'    => $user->lunch_out_time,
                        'out_time'          => $user->out_time,
                        'status'            => $user->status,
                        'admin'             => $user->admin,
                        'token'             => $token->plainTextToken
                    ];

                    return response()->json($response, 200);
                } else {
                    return response()->json([
                        'message' => 'Usuário/Grupo está desativado ! '
                    ], 401);
                }
                
            }
        } else {

            return response()->json([
                'message' => 'Usuario não cadastrado'
            ], 402);
        }
    }
}
