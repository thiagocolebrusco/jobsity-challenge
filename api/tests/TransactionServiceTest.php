<?php

use App\Models\User;
use App\Models\Transaction;
use App\Jobsity\Services\TransactionService;
use Laravel\Lumen\Testing\DatabaseMigrations;

/**
 * @covers UserService
 */
class TransactionServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_balance_zero()
    {
        User::factory()->create();
        $data = [
            "id" => 1
        ];
        $balance = (new TransactionService())->GetBalance($data);
        $this->assertEquals(0, $balance);
    }

    public function test_get_balance_ten()
    {
        User::factory()->create();
        Transaction::factory()->create();

        $data = [
            "id" => 1
        ];
        $balance = (new TransactionService())->GetBalance($data);
        $this->assertEquals(10, $balance);
    }

    public function test_get_balance_thirty()
    {
        $user = User::factory()->create();
        Transaction::factory()->create([ 'amount' => 50, 'currency' => "BRL"]);
        Transaction::factory()->create([ 'amount' => -20, 'currency' => "BRL"]);
        
        $data = [
            "id" => 1
        ];
        $balance = (new TransactionService())->GetBalance($data);
        $this->assertEquals(30, $balance);
    }
    
    public function test_deposit_with_conversion() {
        $user = User::factory()->create(["currency" => "BRL"]);
        $transaction_data = [
            "user_id" => $user->id,
            "amount" => "1",
            "currency" => "USD"
        ];
        $result = (new TransactionService())->Deposit($transaction_data);
        $this->assertTrue($result);
    }
    
    public function test_deposit_without_conversion() {
        $user = User::factory()->create(["currency" => "BRL"]);
        $transaction_data = [
            "user_id" => $user->id,
            "amount" => "1",
            "currency" => "BRL"
        ];
        $result = (new TransactionService())->Deposit($transaction_data);
        $this->assertTrue($result);
    }
}