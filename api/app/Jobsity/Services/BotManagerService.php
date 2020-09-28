<?php

namespace App\Jobsity\Services;
use Illuminate\Support\Facades\DB;

class BotManagerService
{

    public function CallServiceMethod($server_action, $data) {
        list($service_name, $service_method) = explode('||', $server_action);
        $service_name = "App\\Jobsity\\Services\\" . $service_name;
        $service = new $service_name();
        return $service->$service_method($data);
    }

    public function Send(String $text, ?String $next_step, ?String $additional_data) {
        if($next_step) {
            $bot_response = DB::table("bot_responses")
                                ->where("key", $next_step)
                                ->first();

        } else {
            $bot_response = DB::table("bot_responses")
                                ->join("bot_hears", "bot_hears.bot_responses_key", "=", "bot_responses.key")
                                ->where("bot_hears.hears", $text)
                                ->select("bot_responses.*")
                                ->first();
        }
        

        // For empty responses
        if(!$bot_response) {
            $bot_response = DB::table("bot_responses")
                                ->where("key", "unrecognized_response")
                                ->first();
        } else if($bot_response->server_action){
            $decoded = $additional_data ? (array) json_decode($additional_data) : [];
            if(auth()->user()){
                $decoded["user"] = auth()->user();
            }

            $additional_response = $this->CallServiceMethod($bot_response->server_action, $decoded);
            if(isset($additional_response->concat)) {
                foreach($additional_response->concat as $key => $value) {
                    $bot_response->message = str_replace("{{" . $key. "}}", $value, $bot_response->message);
                }
            }
        }

        return [ 
            'bot_response' => $bot_response,
            'additional_response' => isset($additional_response) ? $additional_response : null
        ];
    }
}