<?php

namespace Database\Seeders;

use App\Helpers\Tempus;
use App\Models\Groups;
use Illuminate\Database\Seeder;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupAdmin = Groups::where("name", "Administrador")->first();
        $groupWilson = Groups::where("name", "Equipe Wilson")->first();

        $users = [
            [
                'name'              => "Administrador Tempus",
                'phone'             => "11 92222-4444",
                'email'             => "adm@conecto.com.br",
                'entry_time'        => "08:00",
                'lunch_entry_time'  => "12:00",
                'lunch_out_time'    => "13:00",
                'out_time'          => "17:00",
                'password'          => Hash::make("12345678"),
                'status'            => 1,
                'admin'             => 1,
                'manager'           => 0,
            ],
            [
                'name'              => "Wilson Felix",
                'phone'             => "11 989701516",
                'email'             => "wfelix@conecto.com.br",
                'entry_time'        => "08:00",
                'lunch_entry_time'  => "12:00",
                'lunch_out_time'    => "13:00",
                'out_time'          => "17:00",
                'password'          => Hash::make("12345678"),
                'status'            => 1,
                'admin'             => 0,
                'manager'           => 1,
            ],
            [
                'name'              => "Juliana Jesus",
                'phone'             => "11 912063113",
                'email'             => "jjesus@conecto.com.br",
                'entry_time'        => "08:00",
                'lunch_entry_time'  => "12:00",
                'lunch_out_time'    => "13:00",
                'out_time'          => "17:00",
                'password'          => Hash::make("12345678"),
                'status'            => 1,
                'admin'             => 0,
                'manager'           => 0,
            ],

        ];

        foreach($users as $items){
            if($items['admin'] === 1){
                Users::create([
                    'id'                => Tempus::uuid(),
                    'name'              => $items['name'],
                    'phone'             => $items['phone'],
                    'email'             => $items['email'],
                    'entry_time'        => $items['entry_time'],
                    'lunch_entry_time'  => $items['lunch_entry_time'],
                    'lunch_out_time'    => $items['lunch_out_time'],
                    'out_time'          => $items['out_time'],
                    'password'          => $items['password'],
                    'status'            => $items['status'],
                    'admin'             => $items['admin'],
                    'manager'           => $items['manager'],
                    'group_id'          => $groupAdmin->id

                ]);
            }else {
                Users::create([
                    'id'                => Tempus::uuid(),
                    'name'              => $items['name'],
                    'phone'             => $items['phone'],
                    'email'             => $items['email'],
                    'entry_time'        => $items['entry_time'],
                    'lunch_entry_time'  => $items['lunch_entry_time'],
                    'lunch_out_time'    => $items['lunch_out_time'],
                    'out_time'          => $items['out_time'],
                    'password'          => $items['password'],
                    'status'            => $items['status'],
                    'admin'             => $items['admin'],
                    'manager'           => $items['manager'],
                    'group_id'          => $groupWilson->id

                ]);
            }
        }

        
    }
}
