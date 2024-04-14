<?php

namespace App\Http\Controllers;

use App\Helpers\Tempus;
use App\Http\Requests\PermissionsImageRequest;
use App\Http\Requests\PermissionsRequest;
use App\Models\Permissions;
use App\Repositories\GroupPermissionsRepository;

class PermissionsController extends Controller
{

    /**
     * groupPermissionsRepository object
     *
     * @var \App\Repositories\GroupPermissionsRepository
     */
    protected $groupPermissionsRepository;

    public function __construct(
        GroupPermissionsRepository $groupPermissionsRepository

    ) {
        $this->groupPermissionsRepository = $groupPermissionsRepository;
    }

    public function index()
    {
        return response()->json(Permissions::all(), 200);
    }

    public function store(PermissionsRequest $request)
    {
        $result = (object)$request->handle();

        $permission = Permissions::create([
            'id' => Tempus::uuid(),
            'name' => $result->name,
            'description' => $result->description,
            'status' => 1
        ]);

        return response()->json($permission, 200);
    }

    public function updateImage(PermissionsImageRequest $request, $permissionId)
    {
        $result = $request->handle();

        $permission = Permissions::find($permissionId);
        $permission->image = $result['images'];
        $permission->save();

        return response()->json("Imagem inserida com sucesso", 200);
    }

    public function update($id, PermissionsRequest $request)
    {
        $result = (object)$request->handle();

        Permissions::find($id)->update([
            'name' => $result->name,
            'description' => $result->description,
            'status' => 1
        ]);
        return response()->json(Permissions::find($id), 200);
    }

    public function delete($id)
    {
        Permissions::find($id)->delete();
        return response()->json("Permissão deletada com sucesso", 200);
    }


    public function listGroupsPermissions($id)
    {
        $permissions = Permissions::all();
        $permissionsGroups = [];

        foreach ($permissions as $permission) {
            $groupPermission = $this->groupPermissionsRepository
                ->where('group_id', $id)
                ->where('permissions_id', $permission->id)
                ->first(); // Obtenha apenas o primeiro item, se existir

            if ($groupPermission) {
                // Se houver uma relação na tabela groupPermissions, adicione o item encontrado
               if($permission->id == $groupPermission->permissions_id){
                    $permissionsGroups[] = [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'description' => $permission->description,
                        'status' => 1
                    ];
               }
            } else {
                // Se não houver relação, adicione apenas a permissão
                $permissionsGroups[] = [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'description' => $permission->description,
                    'status' => 0
                ];
            }
        }
        return response()->json($permissionsGroups, 200);
    }

    public function connect($idGroup, $idPermission)
    {
        $permission = Permissions::find($idPermission);
        $permissionsGroups = $this->groupPermissionsRepository->where('group_id', $idGroup)->where('permissions_id', $idPermission)->first();

        if($permissionsGroups != null){
            $permissionsGroups->delete();
            return response()->json("Permissão desabilitada com sucesso", 200);
        }else {
            if ($permission) {
                $this->groupPermissionsRepository->create([
                    'id' => Tempus::uuid(),
                    'group_id' => $idGroup,
                    'permissions_id' => $idPermission,
                ]);
                return response()->json("Permissão habilitada com sucesso", 200);
            } else {
                return response()->json("Permissão não encontrada", 404);
            }
        }

        
    }
}
