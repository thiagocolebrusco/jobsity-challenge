<?php

use App\Jobsity\Services\BotManagerService;
use Laravel\Lumen\Testing\DatabaseMigrations;

/**
 * @covers UserService
 */
class BotManagerServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_call_service_method()
    {
        $data = [];
        
        $user = (new BotManagerService())->CallServiceMethod("TransactionService||GetBalance", $data);
        $this->assertEquals($user->email, "thiagocolebrusco@gmail.com");
    }
}