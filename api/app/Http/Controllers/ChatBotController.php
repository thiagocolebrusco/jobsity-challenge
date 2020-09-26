<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatBotController extends Controller
{
    public function __construct() {}

    public function Send(Request $request) {
        try {
            $text = $request->input("text");
            $next_step = $request->input("next_step");
            $additional_data = $request->input("additional_data");
            if(!$next_step && !$text) {
                throw new \Exception("Message can't be empty");
            }

            if($next_step) {
                $bot_response = DB::table("bot_responses")
                                    ->where("key", $next_step)
                                    ->first();
                if($bot_response->server_action){
                    $this->{$bot_response->server_action}($additional_data);
                }

            } else {
                $bot_response = DB::table("bot_responses")
                                    ->join("bot_hears", "bot_hears.bot_responses_key", "=", "bot_responses.key")
                                    ->where("bot_hears.hears", $text)
                                    ->select("bot_responses.*")
                                    ->first();
            }

            if(!$bot_response) {
                $bot_response = DB::table("bot_responses")
                                    ->where("key", "unrecognized_response")
                                    ->first();
            }
            
            return response()->json($bot_response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function RegisterUser($additional_data) {
        $user = json_decode($additional_data);
        DB::table("users")->insert([
            "name" => $user->name,
            "email" => $user->email,
            "password" => $user->password,
            "currency" => $user->currency
        ]);
    }
}
