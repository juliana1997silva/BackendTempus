<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;

use App\Helpers\Tempus;

use App\Models\Users;
use App\Models\Groups;
use App\Models\UsersGroups;

use App\Http\Requests\UsersRequest;

use App\Http\Resources\UsersGroupsResource;

use App\Repositories\GroupsRepository;
use App\Repositories\UsersRepository;
use App\Repositories\UsersGroupsRepository;


class UsersController extends Controller
{
    protected $usersRepository;

    protected $usersGroupsRepository;

    protected $groupsRepository;


    public function __construct(
        UsersRepository $usersRepository,
        UsersGroupsRepository $usersGroupsRepository,
        GroupsRepository $groupsRepository
    )
    {
        $this->usersRepository = $usersRepository;
        $this->usersGroupsRepository = $usersGroupsRepository;
        $this->groupsRepository = $groupsRepository;
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


    public function listUserByGroup($id) {

        $users_by_groups = $this->usersGroupsRepository->get();
        $groups = $this->groupsRepository->get();
        $users = $this->usersRepository->get();

        $group_id_dev = "";
        foreach($groups as $group) {
            if ( $group->name == "Desenvolvimento" ) {
                $group_id_dev = $group->id;
            }
        }
        
        $response = [];
        foreach ( $users_by_groups as $users_by_group_item ) {
            if ( $users_by_group_item->group_id == $id )
                $user_group[$users_by_group_item->group_id][$users_by_group_item->user_id] = 1;
            else
                $user_group[$users_by_group_item->group_id][$users_by_group_item->user_id] = 1;
        }

        foreach ( $user_group[$group_id_dev] as $id_user => $v ) {
            // dd( $id_user);
            if ( isset($user_group[$id][$id_user]) ) {
                unset($user_group[$group_id_dev][$id_user]);
            }
        }

        foreach ( $user_group[$id] as $id_user => $v ) {
            foreach ( $users as $user ) {

                if ( $id_user == $user->id ) {
                    $user_data = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'team_id' => $id,
                    ];
        
                    $response[] = $user_data;
                }
            } 
        }


        foreach ( $user_group[$group_id_dev] as $id_user => $v ) {
            foreach ( $users as $user ) {

                if ( $id_user == $user->id ) {
                    $user_data = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'team_id' => $group_id_dev,
                    ];
        
                    $response[] = $user_data;
                }
            } 
        }
        


        return response()->json($response, 200);
    }

    //criar usuarios
    public function store(UsersRequest $request)
    {
        $result = (object)$request->handle();

        $group = Groups::where("name", "Desenvolvimento")->first();

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

        $user = $this->usersRepository->find($id);
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
        $users =  $this->usersRepository->find($id);

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
