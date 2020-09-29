<?php

namespace App\Services;

use App\Models\User as User;
use Illuminate\Support\Facades\Auth;

use App\Util\Currency;


class UserService
{
    private ?User $logged_user;

    public function __construct(?User $logged_user = null) {
        $this->logged_user = $logged_user;
    }

    public function RegisterUser(Array $user_data) {
        try {
            if(! $user_data)
                throw new \Exception("Empty user data");
            
            $user = new User;
            $user->name = $user_data["name"];
            $user->email = $user_data["email"];
            $user->password = $user_data["password"];
            $user->currency = $user_data["currency"];

            if(!$user)
                throw new \Exception("Invalid user data");
                
            if(!Currency::Exists($user->currency))
                throw new \Exception("Invalid currency");
            
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

    public function Logout() {
        return (object) [
            "action" => "Logout",
            "data" => []
        ];
    }

}