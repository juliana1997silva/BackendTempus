<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class ClearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_groups')->delete();
        DB::table('users')->delete();
        DB::table('groups')->delete();
    }
}

