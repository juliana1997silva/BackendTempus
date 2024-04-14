<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Groups;
use App\Models\Users;
use App\Repositories\GroupPermissionsRepository;
use App\Repositories\GroupsRepository;
use App\Repositories\PermissionsRepository;
use App\Repositories\UsersGroupsRepository;
use App\Repositories\UsersRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * permissionsRepository object
     *
     * @var \App\Repositories\PermissionsRepository
     */
    protected $permissionsRepository;

    /**
     * usersRepository object
     *
     * @var \App\Repositories\UsersRepository
     */
    protected $usersRepository;

    /**
     * userGroupRepository object
     *
     * @var \App\Repositories\UsersGroupsRepository
     */
    protected $userGroupRepository;

    /**
     * groupPermissionsRepository object
     *
     * @var \App\Repositories\GroupPermissionsRepository
     */
    protected $groupPermissionsRepository;

    /**
     * groupRepository object
     *
     * @var \App\Repositories\GroupsRepository
     */
    protected $groupsRepository;

    public function __construct(
        PermissionsRepository $permissionsRepository,
        UsersRepository $usersRepository,
        UsersGroupsRepository $userGroupRepository,
        GroupPermissionsRepository $groupPermissionsRepository,
        GroupsRepository $groupsRepository

    ) {
        $this->permissionsRepository = $permissionsRepository;
        $this->usersRepository = $usersRepository;
        $this->userGroupRepository = $userGroupRepository;
        $this->groupPermissionsRepository = $groupPermissionsRepository;
        $this->groupsRepository = $groupsRepository;
    }

    //realizar login
    public function signin(AuthRequest $request)
    {

        $result = (object)$request->handle();
        $user = $this->usersRepository->where('email', $result->email)->first();
        // if ( $user != NULL )
        //     $user = Users::where('user_interpres_code', $result->email)->first();

        if ($user) {
            $group = Groups::find($user->team_id);

            if (!Hash::check($result->password, $user->password)) {
                return response()->json([
                    'message' => 'Senha incorreta'
                ], 401);
            } else {
                if ($user->status === 1 && $group->status === 1) {
                    $token = $user->createToken('auth_token');
                    $groups = $this->userGroupRepository->where('user_id', $user->id)->get();

                    $permissionList = [];
                    foreach ($groups as $items) {
                        $dataGroup = $this->groupsRepository->where('id', $items->group_id)->first();

                        if ($dataGroup->name != "Desenvolvimento") {
                            $groupPermissions = $this->groupPermissionsRepository->where('group_id', $items->group_id)->get();

                            foreach ($groupPermissions as $groupPermission) {
                                $permission = $this->permissionsRepository->find($groupPermission->permissions_id);

                                if ($permission) {
                                    $permissionList[] = $permission->name;
                                }
                            }
                        }
                    }

                    $response = [
                        'id'                => $user->id,
                        'name'              => $user->name,
                        'phone'             => $user->phone,
                        'email'             => $user->email,
                        'team_id'           => $user->team_id,
                        'entry_time'        => $user->entry_time,
                        'lunch_entry_time'  => $user->lunch_entry_time,
                        'lunch_out_time'    => $user->lunch_out_time,
                        'out_time'          => $user->out_time,
                        'status'            => $user->status,
                        'admin'             => $user->admin,
                        'token'             => $token->plainTextToken,
                        'manager'           => $user->manager,
                        "permissions"       => $permissionList
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

    public function forgoutPassword(AuthRequest $request)
    {
        $user = Auth::user();
        $result = (object)$request->handle();

        if (Hash::check($result->password, $user->password)) {
            if ($result->new_password === $result->confirmation_password) {
                $updateUser = Users::find($user->id);
                $updateUser->update([
                    'password' => Hash::make($result->new_password)
                ]);

                return response()->json("Senha atualizada com sucesso .", 200);
            } else {
                return response()->json("As senhas não conferem .", 402);
            }
        }
    }
}
