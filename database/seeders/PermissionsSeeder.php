<?php

namespace Database\Seeders;

use App\Helpers\Tempus;
use App\Models\Permissions;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'name' => "menu_dashboard",
                'description' => "Pagina Dashboard"
            ],
            [
                'name' => "menu_release_checkpoint",
                'description' => "Pagina Liberação de ficha"
            ],
            [
                'name' => "menu_users",
                'description' => "Pagina Usuarios"
            ],
            [
                'name' => "menu_groups",
                'description' => "Pagina Grupos"
            ],
            [
                'name' => "menu_consults",
                'description' => "Pagina Consulta"
            ],
            [
                'name' => "menu_user_groups",
                'description' => "Pagina Usuarios X Grupo"
            ],
            [
                'name' => "menu_permissions",
                'description' => "Pagina Permissão"
            ],
            [
                'name' => "menu_checkpoint",
                'description' => "Pagina Registro de Ponto"
            ],
            [
                'name' => "menu_schedule",
                'description' => "Pagina Agenda"
            ],
            [
                'name' => "permission_standard",
                'description' => "Permissão padrão"
            ],
            [
                'name' => "button_new_groups",
                'description' => "Botão criar novo grupo"
            ]

        ];

        foreach ($permission as $permissions) {
            Permissions::create([
                'id'            => Tempus::uuid(),
                'name'          => $permissions['name'],
                'description'   => $permissions['description'],
                'status'        => 1
            ]);
        }
    }
}
