<?php

namespace Database\Seeders;

use App\Helpers\Tempus;
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
        Users::create([
            'id'                => Tempus::uuid(),
            'name'              => "Root Tempus",
            'phone'             => "11 92222-4444",
            'email'             => "root@tempus.com.br",
            'entry_time'        => "08:00",
            'lunch_entry_time'  => "12:00",
            'lunch_out_time'    => "13:00",
            'out_time'          => "17:00",
            'password'          => Hash::make("12345678"),
            'status'            => 1,
            'admin'             => 2,
            'group_id'          => "root"
        ]);
    }
}
