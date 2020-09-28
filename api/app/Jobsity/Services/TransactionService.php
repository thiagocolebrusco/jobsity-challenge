<?php

namespace App\Jobsity\Services;

use App\Models\Transaction;
use App\Models\User;

class TransactionService
{

    private AmdorenService $amdorenService;

    public function __construct() {
        $this->amdorenService = new AmdorenService;
    }

    public function GetBalance(Array $data) {
        try {
            if(! $data || !isset($data["user"]))
                throw new \Exception("Empty user data");

            $user = $data["user"];
            
            $balance = Transaction::where("user_id", $user->id)->sum("amount");

            return (object) [
                "concat" => [
                    "currency" => $user->currency,
                    "balance" => number_format($balance, 2, '.', ',')
                ]
            ];

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function Withdraw(Array $data) {
        $data["amount"] = $data["amount"] * -1;
        $this->Transact($data);
    }

    public function Deposit(Array $data) {
        $this->Transact($data);
    }

    public function Transact(Array $data){
        try {
            if(! $data || !isset($data["user"]))
                throw new \Exception("Empty user data");
            $user = $data["user"];

            if(!$user)
                throw new \Exception("User not found");
            else {
                $transaction = new Transaction([
                    "user_id" => $user->id
                ]);
                if($user->currency != $data["currency"]) {
                    $transaction->original_amount = $data["amount"];
                    $transaction->original_currency = $data["currency"];
                    $transaction->currency = $user->currency;
                    $transaction->amount = $this->amdorenService->ExchangeCurrency($data["amount"], $data["currency"], $user->currency);
                } else {
                    $transaction->amount = $data["amount"];
                    $transaction->currency = $data["currency"];
                }

                return $transaction->save();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


}