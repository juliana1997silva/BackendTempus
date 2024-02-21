<?php

namespace Database\Seeders;

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
            "name" => "Coordenador Teste",
            "email" => "coordenador@teste.com.br",
            "phone" => "11999999999",
            "entry_time" => "08:00",
            "lunch_entry_time" => "13:00",
            "lunch_out_time" => "14:00",
            "out_time" => "17:00",
            "password" => Hash::make("12345678"),
            "admin" => 1,
            "status" => 1
        ]);
    }
}
