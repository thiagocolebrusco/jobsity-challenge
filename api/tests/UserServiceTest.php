<?php

use App\Models\User;
use App\Services\UserService;
use Laravel\Lumen\Testing\DatabaseMigrations;

/**
 * @covers UserService
 */
class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_login_with_invalid_email()
    {
        User::factory()->create();

        $data = [
            "email" => "wrongemail@email.com",
            "password" => app('hash')->make("123123")
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Email or password incorrect");
        $user = (new UserService())->Login($data);
    }

    public function test_login_with_invalid_password()
    {
        User::factory()->create([ 'email' => 'email@email.com']);

        $data = [
            "email" => "email@email.com",
            "password" => app('hash')->make("123123")
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Email or password incorrect");
        $user = (new UserService())->Login($data);
    }

    public function test_login_valid_data()
    {
        $fake_user = User::factory()->create([ 'email' => 'email@email.com', 'password' => app('hash')->make("123123")]);
        $data = [
            "email" => "email@email.com",
            "password" => "123123"
        ];

        $result = (new UserService())->Login($data);
        $this->assertNotNull($result->data["token"]);
    }

    public function test_register_user_valid_data()
    {
        $data = [
            "name" => "Thiago",
            "email" => "thiagocolebrusco@gmail.com",
            "password" => "123123",
            "currency" => "BRL"
        ];

        $user = (new UserService())->RegisterUser($data);
        $this->assertNotNull($user);
    }

    public function test_register_user_invalid_data()
    {
        $data = [
            "asd" => "Thiago",
            "asd" => "thiagocolebrusco@gmail.com",
            "passasdword" => "123123",
            "asd" => "BRL"
        ];

        $this->expectException(\Exception::class);
        $user = (new UserService())->RegisterUser($data);
    }

    public function test_register_user_empty_name()
    {
        $data = [
            "email" => "thiagocolebrusco@gmail.com",
            "password" => "123123",
            "currency" => "BRL"
        ];

        $this->expectException(\Exception::class);
        $user = (new UserService())->RegisterUser($data);
    }
}