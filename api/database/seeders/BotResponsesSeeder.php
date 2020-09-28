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
            'client_action' => 'SetUserEmail|SetInputTypeToPassword',
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
            'client_action' => 'SetUserCurrency|SetUserAsAdditionalData',
            'next_step' => 'register_complete',
            'message' => "Ok. What is your default currency?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'register_complete',
            'server_action' => "UserService||RegisterUser",
            'client_action' => null,
            'next_step' => null,
            'message' => "Great! Now you are already registered here at Jobsity's Currency Bot"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'login',
            'server_action' => null,
            'client_action' => "SetUserEmail|SetInputTypeToPassword",
            'next_step' => "login_email",
            'message' => "Ok, let's do this! What is your email?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'login_email',
            'server_action' => null,
            'client_action' => 'SetUserPassword|SetUserAsAdditionalData',
            'next_step' => "login_complete",
            'message' => "Nice, <strong>{{email}}</strong>. What about your password?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'login_complete',
            'server_action' => "UserService||Login",
            'client_action' => null,
            'next_step' => null,
            'message' => "You are logged in, <strong>{{email}}</strong>. What can I do for you?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'balance',
            'server_action' => "TransactionService||GetBalance",
            'client_action' => null,
            'next_step' => null,
            'message' => "Your balance is: {{balance}} {{currency}}.<br/>What else can I do for you?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'deposit',
            'server_action' => null,
            'client_action' => 'SetTransactionCurrency',
            'next_step' => "deposit_amount",
            'message' => "In what currency do you want to deposit?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'deposit_amount',
            'server_action' => null,
            'client_action' => 'SetTransactionAmount|SetTransactionAsAdditionalData',
            'next_step' => 'deposit_complete',
            'message' => "How much do you want to deposit?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'deposit_complete',
            'server_action' => "TransactionService||Deposit",
            'client_action' => null,
            'next_step' => null,
            'message' => "Thanks! Your deposit was completed successfully.<br/>What else can I do for you?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'withdraw',
            'server_action' => null,
            'client_action' => 'SetTransactionCurrency',
            'next_step' => "withdraw_amount",
            'message' => "In what currency do you want to withdraw?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'withdraw_amount',
            'server_action' => null,
            'client_action' => 'SetTransactionAmount|SetTransactionAsAdditionalData',
            'next_step' => 'withdraw_complete',
            'message' => "How much do you want to withdraw?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'withdraw_complete',
            'server_action' => "TransactionService||Withdraw",
            'client_action' => null,
            'next_step' => null,
            'message' => "Thanks! Your withdraw was completed successfully.<br/>What else can I do for you?"
        ]);
        DB::table("bot_responses")->insert([
            'key' => 'logout',
            'server_action' => 'UserService||Logout',
            'client_action' => null,
            'next_step' => null,
            'message' => "Ok, bye-bye. See you soon!"
        ]);
    }
}
