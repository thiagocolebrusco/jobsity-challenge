<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function __construct() {}

    public function Send(Request $request) {
        $message = $request->input("message");
        if(!$message) {
            throw new \Exception("Message can't be empty");
        }

        return "Ok";
    }
}
