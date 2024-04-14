<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Helpers\Tempus;
use App\Models\Groups;
use App\Models\Users;
use App\Models\UsersGroups;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $groupAdmin = Groups::where("name", "Desenvolvimento")->first();
        $groupWilson = Groups::where("name", "Equipe Wilson")->first();

        $users = [
            [
                'name'                => "Administrador Tempus",
                'phone'               => "11 92222-4444",
                'email'               => "adm@conecto.com.br",
                'entry_time'          => "08:00",
                'lunch_entry_time'    => "12:00",
                'lunch_out_time'      => "13:00",
                'out_time'            => "17:00",
                'password'            => Hash::make("12345678"),
                'status'              => 1,
                'admin'               => 1,
                'manager'             => 0,
                'user_interpres_code' => 'adm'
            ],
            [
                'name'                => "Wilson Felix",
                'phone'               => "11 989701516",
                'email'               => "wfelix@conecto.com.br",
                'entry_time'          => "08:00",
                'lunch_entry_time'    => "12:00",
                'lunch_out_time'      => "13:00",
                'out_time'            => "17:00",
                'password'            => Hash::make("12345678"),
                'status'              => 1,
                'admin'               => 0,
                'manager'             => 1,
                'user_interpres_code' => 'wfelix'
            ],
            [
                'name'                => "Juliana Jesus",
                'phone'               => "11 912063113",
                'email'               => "jjesus@conecto.com.br",
                'entry_time'          => "08:00",
                'lunch_entry_time'    => "12:00",
                'lunch_out_time'      => "13:00",
                'out_time'            => "17:00",
                'password'            => Hash::make("12345678"),
                'status'              => 1,
                'admin'               => 0,
                'manager'             => 0,
                'user_interpres_code' => 'jjesus'
            ],
            [
                'name'                => "Julian Bernal",
                'phone'               => "11 912063113",
                'email'               => "jbernal@conecto.com.br",
                'entry_time'          => "08:00",
                'lunch_entry_time'    => "12:00",
                'lunch_out_time'      => "13:00",
                'out_time'            => "17:00",
                'password'            => Hash::make("12345678"),
                'status'              => 1,
                'admin'               => 0,
                'manager'             => 0,
                'user_interpres_code' => 'jbernal'
            ],
            [
                'name'                => "Guilherme Alves",
                'phone'               => "11 989691704",
                'email'               => "gasantos@conecto.com.br",
                'entry_time'          => "08:00",
                'lunch_entry_time'    => "12:00",
                'lunch_out_time'      => "13:00",
                'out_time'            => "17:00",
                'password'            => Hash::make("12345678"),
                'status'              => 1,
                'admin'               => 0,
                'manager'             => 0,
                'user_interpres_code' => 'gasantos'
            ],
            [
                'name'                => "Rafael Soares",
                'phone'               => "11 973053921",
                'email'               => "rsoares@conecto.com.br",
                'entry_time'          => "08:00",
                'lunch_entry_time'    => "12:00",
                'lunch_out_time'      => "13:00",
                'out_time'            => "17:00",
                'password'            => Hash::make("12345678"),
                'status'              => 1,
                'admin'               => 0,
                'manager'             => 0,
                'user_interpres_code' => 'rsoares'
            ],
            [
                'name'                => "Adriele Ramos",
                'phone'               => "11 912463551",
                'email'               => "aramos@conecto.com.br",
                'entry_time'          => "08:00",
                'lunch_entry_time'    => "12:00",
                'lunch_out_time'      => "13:00",
                'out_time'            => "17:00",
                'password'            => Hash::make("12345678"),
                'status'              => 1,
                'admin'               => 0,
                'manager'             => 0,
                'user_interpres_code' => 'aramos'
            ],
        ];

        foreach ($users as $items) {
            if ($items['admin'] === 1) {
                $user = Users::create([
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
                    'team_id'          => $groupAdmin->id,
                    'user_interpres_code' => $items['user_interpres_code']

                ]);

                UsersGroups::create([
                    'id'                => Tempus::uuid(),
                    'user_id'           => $user->id,
                    'group_id'          => $groupAdmin->id,
                ]);
            } else {
                $user = Users::create([
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
                    'team_id'          => $groupWilson->id,
                    'user_interpres_code' => $items['user_interpres_code']

                ]);

                UsersGroups::create([
                    'id'                => Tempus::uuid(),
                    'user_id'           => $user->id,
                    'group_id'          => $groupAdmin->id,
                ]);

                UsersGroups::create([
                    'id'                => Tempus::uuid(),
                    'user_id'           => $user->id,
                    'group_id'          => $groupWilson->id,
                ]);
            }
        }
    }
}
