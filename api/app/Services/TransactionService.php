<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Util\Currency;

class TransactionService
{
    private ?User $logged_user;
    private AmdorenService $amdorenService;

    public function __construct(?User $logged_user) {
        $this->logged_user = $logged_user;
        $this->amdorenService = new AmdorenService;
    }

    public function ShowBalanceToUser(?Array $data) {
        $balance = $this->GetBalance();
        return (object) [
            "concat" => [
                "currency" => $this->logged_user->currency,
                "balance" => number_format($balance, 2, '.', ',')
            ]
        ];

    }

    public function GetBalance() {
        try {
            if(!$this->logged_user)
                throw new \Exception("You have to sign up or sign in before.");
            else {
                return Transaction::where("user_id", $this->logged_user->id)->sum("amount");
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function Withdraw(Array $data) {
        $data = $this->ConvertCurrencyIfNecessary($data);
        if($this->CheckIfUserHasEnoughBalanceToWithdraw($data['amount'])){
            $data["amount"] = $data["amount"] * -1;
            if(isset($data["original_amount"]))
                $data["original_amount"] = $data["original_amount"] * -1;
            return $this->Transact($data);
        } else
            throw new \Exception("You don't have not enough balance");
    }
    
    public function Deposit(Array $data) {
        $data = $this->ConvertCurrencyIfNecessary($data);
        return $this->Transact($data);
    }

    public function Transact(Array $data){
        try {
            if(! $data)
                throw new \Exception("Empty transaction data");

            if(!$this->logged_user)
                throw new \Exception("You have to sign up or sign in before.");
            else {
                $transaction = new Transaction([
                    "user_id" => $this->logged_user->id
                ]);
                if($this->logged_user->currency != $data["currency"]) {
                    $transaction->original_amount = $data["amount"];
                    $transaction->original_currency = $data["currency"];
                    $transaction->currency = $this->logged_user->currency;
                    $transaction->amount = $this->amdorenService->ExchangeCurrency($data["amount"], $data["currency"], $this->logged_user->currency);
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

    public function CheckIfUserHasEnoughBalanceToWithdraw($amount) {
        $balance = $this->GetBalance();
        return $amount <= $balance;
    }

    public function ConvertCurrencyIfNecessary($data) {
        if(!Currency::Exists($data["currency"]))
            throw new \Exception("Invalid currency");

        if($this->logged_user->currency != $data["currency"]) {
            return [
                'original_amount' => $data["amount"],
                'original_currency' => $data["currency"],
                'currency' => $this->logged_user->currency,
                'amount' => $this->amdorenService->ExchangeCurrency($data["amount"], $data["currency"], $this->logged_user->currency),
            ];
        } else {
            return $data;
        }
    }

}