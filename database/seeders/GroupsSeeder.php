<?php

namespace Database\Seeders;

use App\Helpers\Tempus;
use App\Models\Groups;
use Illuminate\Database\Seeder;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'name' => "Desenvolvimento",
                'manager' => "Reynaldo",
                'status' => 1
            ],
            [
                'name' => "Equipe Wilson",
                'manager' => "Wilson",
                'status' => 1
            ],
            [
                'name' => "Equipe Josmi",
                'manager' => "Josmi",
                'status' => 1
            ],
            [
                'name' => "Equipe Caio",
                'manager' => "Caio",
                'status' => 1
            ],
            [
                'name' => "Equipe Bianou",
                'manager' => "Bianou",
                'status' => 1
            ],
            [
                'name' => "Equipe Diego",
                'manager' => "Diego",
                'status' => 1
            ],
            [
                'name' => "Equipe Renato",
                'manager' => "Renato",
                'status' => 1
            ],
            [
                'name' => "Equipe Miriã",
                'manager' => "Miriã",
                'status' => 1
            ],
        ];

        foreach ($groups as $group) {
            Groups::create([
                'id'      => Tempus::uuid(),
                'name'    => $group['name'],
                'manager' => $group['manager'],
                'status'  => $group['status']
            ]);
        }
    }
}
