<?php

namespace Tests\Unit;

use App\Team;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResponsiveTest extends TestCase
{
    /** @test */
    function should_respond_json_for_not_found_routes()
    {
        $this->json_get('none-existent-route')
             ->assertStatus(404);
    }

    /** @test */
    function should_respond_json_for_not_authorized_exception()
    {
        $team = factory(Team::class)->create();
        $this->json_post("teams/{$team->id}",[])
             ->assertStatus(403);
    }

    /** @test */
    function should_respond_json_for_validation_exceptions()
    {
        $this->signIn()
             ->json_post('teams', [])
             ->assertStatus(422)
             ->assertJsonFragment(['status' => 'fail']);
    }
}
