<?php

namespace Tests\Feature;

use App\Team;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTeamTest extends TestCase
{
    /** @test */
    function unauthenticated_users_may_view_teams()
    {
        $team = factory(Team::class)->create();
        $this->get('/teams')
             ->assertStatus(200)
             ->assertSee($team->name);
    }

    /** @test */
    function unauthenticated_users_may_view_single_team()
    {
        $team = factory(Team::class)->create();
        $this->get("/teams/{$team->id}")
             ->assertStatus(200)
             ->assertSee($team->name);
    }

    /** @test */
    function unauthenticated_users_can_not_delete_teams()
    {
        $team = factory(Team::class)->create();
        $this->withExceptionHandling();
        $this->delete("/teams/{$team->id}")
             ->assertRedirect('/login');

    }

    /** @test */
    function unauthenticated_users_can_not_create_teams()
    {
        $this->withExceptionHandling();
        $this->post("/teams", ['name' => 'test name'])
             ->assertRedirect('/login');
    }

    /** @test */
    function unauthenticated_users_can_not_edit_teams()
    {
        $team = factory(Team::class)->create();
        $this->withExceptionHandling();
        $this->patch("/teams/{$team->id}", ['name' => 'test name'])
             ->assertRedirect('/login');
    }


    /** @test */
    function authenticated_users_may_delete_teams()
    {
        $this->signIn();
        $team = factory(Team::class)->create();
        $this->delete("/teams/{$team->id}")
             ->assertStatus(302);
        $this->assertDatabaseMissing('teams', ['name' => $team->id]);
    }

    /** @test */
    function authenticated_users_may_create_teams()
    {
        $this->signIn();
        $this->post("/teams/", [
            'name' => 'team name'
        ]);

        $this->assertDatabaseHas('teams', ['name' => 'team name']);
    }

    /** @test */
    function authenticated_users_may_update_teams()
    {
        $team = factory(Team::class)->create();
        $this->signIn();
        $this->patch("/teams/{$team->id}", [
            'name' => 'name changed'
        ]);

        $this->assertDatabaseHas('teams', ['name' => 'name changed']);
    }

}
