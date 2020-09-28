<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BotHearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("bot_hears")->insert([
            'hears' => 'Hi',
            'bot_responses_key' => 'hello'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Hello',
            'bot_responses_key' => 'hello'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Hi there',
            'bot_responses_key' => 'hello'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Hi!',
            'bot_responses_key' => 'hello'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Hello!',
            'bot_responses_key' => 'hello'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Hi there!',
            'bot_responses_key' => 'hello'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Sign up',
            'bot_responses_key' => 'start_register'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Sign-up',
            'bot_responses_key' => 'start_register'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Register',
            'bot_responses_key' => 'start_register'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Log in',
            'bot_responses_key' => 'login'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Login',
            'bot_responses_key' => 'login'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Log-in',
            'bot_responses_key' => 'login'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Balance',
            'bot_responses_key' => 'balance'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Deposit',
            'bot_responses_key' => 'deposit'
        ]);
        DB::table("bot_hears")->insert([
            'hears' => 'Withdraw',
            'bot_responses_key' => 'withdraw'
        ]);
    }
}
