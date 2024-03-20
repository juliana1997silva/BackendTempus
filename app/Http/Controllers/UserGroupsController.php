<?php

namespace App\Http\Controllers;

use App\Helpers\Tempus;
use App\Http\Requests\UserGroupsRequest;
use App\Models\Groups;
use App\Models\UsersGroups;
use DB;

class UserGroupsController extends Controller
{
    public function store(UserGroupsRequest $request)
    {
        $result = (object)$request->handle();

        $groups = Groups::find($result->group_id);
        DB::table('users_groups')->where('group_id',$result->group_id)->delete();

        foreach ($result->user_id as $value) {
            UsersGroups::create([
                'id' => Tempus::uuid(),
                'group_id' => $result->group_id,
                'user_id' => $value
            ]);
        }
        return response()->json("Usuario(s) vinculado ao grupo " . $groups->name . " com sucesso", 200);
    }
}
