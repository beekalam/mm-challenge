<?php

namespace Tests\Feature;

use App\Team;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTests extends TestCase
{
    /** @test */
    function unauthenticated_users_may_not_view_teams()
    {
        $this->json("GET", $this->url("teams"))
             ->assertStatus(403);
    }


    /** @test */
    function authenticated_users_may_view_teams()
    {
        $team = factory(Team::class)->create();
        $this->signIn()
             ->json_get("teams")
             ->assertJsonFragment([
                 "name" => $team->name
             ]);

        $this->json_get("teams/{$team->id}")
             ->assertJsonFragment([
                 "name" => $team->name
             ]);
    }

    /** @test */
    function authenticated_users_may_create_teams()
    {
        $team = factory(Team::class)->make();
        $response = $this->signIn()
                         ->json_post("teams", $team->toArray())
                         ->assertStatus(201)
                         ->assertJsonFragment(['name' => $team->name]);

        $this->assertDatabaseHas("teams", $team->toArray());
    }

    /** @test */
    function name_is_required_to_create_team()
    {
        $this->signIn()
             ->json_post("teams", [])
             ->assertStatus(422);

        $this->assertEquals(0, Team::count());
    }

    /** @test */
    function authenticated_users_may_update_teams()
    {
        $team = factory(Team::class)->create();
        $this->signIn()
             ->json_patch("teams/{$team->id}", ['name' => 'new name'])
             ->assertOk()
             ->assertJsonFragment(['name' => 'new name']);

        $this->assertDatabaseHas("teams", ['name' => 'new name']);
    }

    /** @test */
    function authenticated_users_may_delete_teams()
    {
        $team = factory(Team::class)->create();
        $this->signIn()
             ->delete($this->url("teams/{$team->id}"))
             ->assertOk();

        $this->assertDatabaseMissing("teams", ['name' => $team->name]);
    }

}
