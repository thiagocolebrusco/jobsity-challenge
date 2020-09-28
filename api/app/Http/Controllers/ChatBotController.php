<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobsity\Services\BotManagerService;

class ChatBotController extends Controller
{
    private BotManagerService $botManagerService;
    public function __construct() {
        $this->botManagerService = new BotManagerService;
    }

    public function Send(Request $request) {
        try {
            $text = $request->input("text");
            $next_step = $request->input("next_step");
            $additional_data = $request->input("additional_data");
            if(!$next_step && !$text) {
                throw new \Exception("Message can't be empty");
            }
            $bot_response = $this->botManagerService->Send($text, $next_step, $additional_data);
            
            return response()->json($bot_response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
