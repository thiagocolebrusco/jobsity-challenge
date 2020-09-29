<?php

use App\Models\User;
use App\Models\Transaction;
use App\Services\TransactionService;
use Laravel\Lumen\Testing\DatabaseMigrations;

/**
 * @covers TransactionService
 */
class TransactionServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_balance_zero()
    {
        $user = User::factory()->create();
        $balance = (new TransactionService($user))->GetBalance();
        $this->assertEquals(0, $balance);
    }

    public function test_get_balance_ten()
    {
        $user = User::factory()->create();
        Transaction::factory()->create(['user_id' => $user->id]);
        $balance = (new TransactionService($user))->GetBalance();
        $this->assertEquals(10, $balance);
    }

    public function test_get_balance_thirty()
    {
        $user = User::factory()->create();
        Transaction::factory()->create([ 'amount' => 50, 'currency' => "BRL", "user_id" => $user->id]);
        Transaction::factory()->create([ 'amount' => -20, 'currency' => "BRL", "user_id" => $user->id]);
        
        $balance = (new TransactionService($user))->GetBalance();
        $this->assertEquals(30, $balance);
    }
    
    public function test_deposit_with_conversion() {
        $user = User::factory()->create(["currency" => "BRL"]);
        $transaction_data = [
            "amount" => "1",
            "currency" => "USD"
        ];
        $result = (new TransactionService($user))->Deposit($transaction_data);
        $this->assertTrue($result);
    }
    
    public function test_deposit_without_conversion() {
        $user = User::factory()->create(["currency" => "BRL"]);
        $transaction_data = [
            "amount" => 1,
            "currency" => "BRL"
        ];
        $result = (new TransactionService($user))->Deposit($transaction_data);
        $this->assertTrue($result);
    }
    
    public function test_withdraw_having_enough_balance_without_conversion() {
        $user = User::factory()->create(["currency" => "BRL"]);
        Transaction::factory()->create([ 'amount' => 50, 'currency' => "BRL", "user_id" => $user->id]);
        $transaction_data = [
            "amount" => 20,
            "currency" => "BRL"
        ];
        $result = (new TransactionService($user))->Withdraw($transaction_data);
        $this->assertTrue($result);
    }
    
    public function test_withdraw_not_having_enough_balance_without_conversion() {
        $user = User::factory()->create(["currency" => "BRL"]);
        Transaction::factory()->create([ 'amount' => 50, 'currency' => "BRL", "user_id" => $user->id]);
        $transaction_data = [
            "amount" => 100,
            "currency" => "BRL"
        ];
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("You don't have not enough balance");
        $result = (new TransactionService($user))->Withdraw($transaction_data);
    }

    public function test_check_if_user_has_enough_balance_to_withdraw_with_enough_balance() {
        $user = User::factory()->create(["currency" => "BRL"]);
        Transaction::factory()->create([ 'amount' => 50, 'currency' => "BRL", "user_id" => $user->id]);

        $amount = 10;
        $result = (new TransactionService($user))->CheckIfUserHasEnoughBalanceToWithdraw($amount);
        $this->assertTrue($result);
    }

    public function test_check_if_user_has_enough_balance_to_withdraw_without_enough_balance() {
        $user = User::factory()->create(["currency" => "BRL"]);
        Transaction::factory()->create([ 'amount' => 50, 'currency' => "BRL", "user_id" => $user->id]);

        $amount = 100;
        $result = (new TransactionService($user))->CheckIfUserHasEnoughBalanceToWithdraw($amount);
        $this->assertFalse($result);
    }
}