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
                'name' => "Administrador",
                'manager' => "Administrador",
                'status' => 1
            ],
            [
                'name' => "Equipe Wilson",
                'manager' => "Wilson Felix",
                'status' => 1
            ],
        ];

        foreach($groups as $items){
            Groups::create([
                'id'      => Tempus::uuid(),
                'name'    => $items['name'],
                'manager' => $items['manager'],
                'status'  => $items['status']
            ]);
        }        
    }
}
