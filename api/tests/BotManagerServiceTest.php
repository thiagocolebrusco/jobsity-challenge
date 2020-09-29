<?php

use App\Services\BotManagerService;
use Laravel\Lumen\Testing\DatabaseMigrations;

use App\Models\User;

/**
 * @covers UserService
 */
class BotManagerServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_call_service_method()
    {
        $user = User::factory()->create(["currency" => "BRL"]);
        $data = [];
        
        $result = (new BotManagerService($user))->CallServiceMethod("TransactionService||GetBalance", $data);
        $this->assertNotNull($result);
    }
}