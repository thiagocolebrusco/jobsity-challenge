<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BotResponsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("bot_responses")->insert([
            'key' => 'unrecognized_response',
            'server_action' => null,
            'client_action' => null,
            'next_step' => null,
            'message' => "Sorry, I could not understand you..."
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'hello',
            'server_action' => null,
            'client_action' => null,
            'next_step' => null,
            'message' => "Hi! How can I help you?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'start_register',
            'server_action' => null,
            'client_action' => 'SetUserName',
            'next_step' => 'register_step_2',
            'message' => "Nice! What is your name?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'register_step_2',
            'server_action' => null,
            'client_action' => 'SetUserEmail',
            'next_step' => 'register_step_3',
            'message' => "Ok, <strong>{{name}}</strong>. Now, what is your email?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'register_step_3',
            'server_action' => null,
            'client_action' => 'SetUserPassword',
            'next_step' => 'register_step_4',
            'message' => "Nice. What about your password?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'register_step_4',
            'server_action' => null,
            'client_action' => 'SetUserCurrency',
            'next_step' => 'register_complete',
            'message' => "Ok. What is your default currency?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'register_complete',
            'server_action' => "RegisterUser",
            'client_action' => null,
            'next_step' => null,
            'message' => "Great! Now you are already registered here at Jobsity's Currency Bot"
        ]);
    }
}
