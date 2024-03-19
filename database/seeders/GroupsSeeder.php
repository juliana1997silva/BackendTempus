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
                'status' => 1
            ],
            [
                'name' => "Equipe Wilson",
                'status' => 1
            ],
            [
                'name' => "Equipe Josmi",
                'status' => 1
            ],
            [
                'name' => "Equipe Caio",
                'status' => 1
            ],
            [
                'name' => "Equipe Bianou",
                'status' => 1
            ],
            [
                'name' => "Equipe Diego",
                'status' => 1
            ],
            [
                'name' => "Equipe Renato",
                'status' => 1
            ],
            [
                'name' => "Equipe Miriã",
                'status' => 1
            ],
        ];

        foreach ($groups as $items) {
            Groups::create([
                'id'      => Tempus::uuid(),
                'name'    => $items['name'],
                'status'  => $items['status']
            ]);
        }
    }
}
