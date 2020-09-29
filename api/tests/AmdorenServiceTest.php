<?php

use App\Services\AmdorenService;
use Laravel\Lumen\Testing\DatabaseMigrations;

/**
 * @covers UserService
 */
class AmdorenServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_exchange_fifty_usd_to_brl()
    {
        $amount = 50;
        $currency_from = "USD";
        $currency_to = "BRL";
        $converted_amount = (new AmdorenService())->ExchangeCurrency($amount, $currency_from, $currency_to);
        $this->assertGreaterThan(0, $converted_amount);
    }
}