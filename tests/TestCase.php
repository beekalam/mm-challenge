<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
    const API_PREFIX = "/api/v1/";

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install', ['-vvv' => true]);
    }

    public function url($route)
    {
        return self::API_PREFIX . $route;
    }


    protected function json_post($uri, $data = [], $headers = [])
    {
        return $this->json(
            'POST',
            $this->url($uri),
            $data,
            $headers
        );
    }

    protected function json_get($uri, $data = [], $headers = [])
    {
        return $this->json(
            'GET',
            $this->url($uri),
            $data,
            $headers
        );
    }

    protected function json_patch($uri, $data = [], $headers = [])
    {
        return $this->json(
            'PATCH',
            $this->url($uri),
            $data,
            $headers
        );
    }

    protected function signIn($user = null)
    {
        $user = is_null($user) ? factory(User::class)->create() : $user;

        Passport::actingAs($user);

        return $this;
    }


}
