<?php

namespace App\Jobsity\Services;

use App\Models\User as User;
use Illuminate\Support\Facades\Auth;


class UserService
{

    public function RegisterUser(Array $user_data) {
        try {
            if(! $user_data)
                throw new \Exception("Empty user data");
            
            $user = new User($user_data);
            if(!$user)
                throw new \Exception("Invalid user data");
                
            if($user->save()){
                $token = auth()->login($user);
                return (object) [
                    "action" => "SetToken",
                    "data" => [
                        "token" => $token,
                        "user" => $user
                    ]
                ];;
            }
            else
                throw new \Exception("It was not possible to register user.");
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function Login(Array $user_data) {
        try {
            ;
            if(!$token = auth()->attempt(["email" => $user_data["email"], "password" => $user_data["password"]])){
                throw new \Exception("Email or password incorrect");
            } else {
                $user = auth()->user();
                return (object) [
                    "action" => "SetToken",
                    "data" => [
                        "token" => $token,
                        "user" => $user
                    ]
                ];
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}