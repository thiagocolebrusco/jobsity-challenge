<?php


namespace App\Services;
use App\Models\BotResponse;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class BotManagerService
{
    private ?User $logged_user;

    public function __construct(?User $logged_user = null) {
        $this->logged_user = $logged_user;
    }

    public function CallServiceMethod($server_action, $data) {
        list($service_name, $service_method) = explode('||', $server_action);
        $service_name = "App\\Services\\" . $service_name;
        $service = new $service_name($this->logged_user);
        return $service->$service_method($data);
    }

    public function Send(String $user_message, ?String $next_step, ?String $additional_data) {
        try {
            if($next_step) {
                $bot_response = DB::table("bot_responses")
                                    ->where("key", $next_step)
                                    ->first();
    
            } else {
                $bot_response = DB::table("bot_responses")
                                    ->join("bot_hears", "bot_hears.bot_responses_key", "=", "bot_responses.key")
                                    ->where("bot_hears.hears", $user_message)
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
        } catch (\Exception $e) {
            return [ 
                'bot_response' => new BotResponse([
                    "message" => $e->getMessage() . "<br/>What can I do for now?",
                    "next_step" => null,
                ]),
            ];
        }
    }
}