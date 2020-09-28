<?php

namespace App\Jobsity\Services;


class AmdorenService
{
    private $api_key;
    private $api_url;

    public function __construct() {
        $this->api_key = env('AMDOREN_API_KEY');
        $this->api_url = env('AMDOREN_API_URL');
    }

    public function ExchangeCurrency($amount, $currency_from, $currency_to) {
        $client = new \GuzzleHttp\Client();
        $res = $client->get($this->api_url,[
            "query" => [
                "api_key" => $this->api_key,
                "from" => $currency_from,
                "to" => $currency_to,
                "amount" => $amount
            ]
        ]);
        $result = json_decode((string)$res->getBody());
        if($result && $result->error == 0)
            return $result->amount;
        else
            throw new \Exception("Error on converting currency amount");
    }
}