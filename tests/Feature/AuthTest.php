<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{

    /** @test */
    function signup_requires_email()
    {
        $values = $this->build_signup_values();
        unset($values['email']);
        $this->json_post("signup", $values);
        $this->assertEquals(User::count(), 0);
    }

    /** @test */
    function signup_requires_password()
    {
        $values = $this->build_signup_values();
        unset($values['password']);
        $this->json_post("signup", $values);
        $this->assertEquals(User::count(), 0);
    }

    /** @test */
    public function guests_can_signup()
    {
        $this->json_post("signup", $values = $this->build_signup_values())
             ->assertOk()
             ->assertJsonStructure(["token"]);

        $this->assertDatabaseHas("users", [
            "name"  => $values['name'],
            'email' => $values['email']
        ]);
    }

    /** @test */
    function guests_can_login_with_valid_credentials()
    {
        $this->json_post("signup", $values = $this->build_signup_values());

         $this->json_post("login", [
            "email"    => $values['email'],
            'password' => $values['password']
        ])->assertJsonStructure(['token']);
    }

    private function build_signup_values($values = [])
    {
        $default_values = [
            'name'             => 'test name',
            'email'            => 'test@demo.com',
            'password'         => 'secret',
            'confirm_password' => 'secret'
        ];
        return array_merge($default_values, $values);
    }

}
