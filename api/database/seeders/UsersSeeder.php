<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            'name' => 'Thiago',
            'email' => 'thiagocolebrusco@gmail.com',
            'password' => app('hash')->make('123123'),
            'currency' => "BRL"
        ]);
    }
}
