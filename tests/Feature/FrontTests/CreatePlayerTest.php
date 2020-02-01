<?php

namespace Tests\Feature;

use App\Player;
use App\Team;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePlayerTest extends TestCase
{
    /** @test */
    function unauthenticated_users_may_view_players()
    {
        $player = factory(Player::class)->create();
        $this->get('/players')
             ->assertStatus(200)
             ->assertSee($player->name);
    }

    /** @test */
    function unauthenticated_users_may_view_single_player()
    {
        $player = factory(Player::class)->create();
        $this->get("/players/{$player->id}")
             ->assertStatus(200)
             ->assertSee($player->name);
    }

    /** @test */
    function unauthenticated_users_can_not_delete_players()
    {
        $player = factory(Player::class)->create();
        $this->withExceptionHandling();
        $this->delete("/players/{$player->id}")
             ->assertRedirect('/login');

    }

    /** @test */
    function unauthenticated_users_can_not_create_players()
    {
        $this->withExceptionHandling();
        $this->post("/players", ['name' => 'test name'])
             ->assertRedirect('/login');
    }

    /** @test */
    function unauthenticated_users_can_not_edit_teams()
    {
        $player = factory(Player::class)->create();
        $this->withExceptionHandling();
        $this->patch("/teams/{$player->id}", ['name' => 'test name'])
             ->assertRedirect('/login');
    }


    /** @test */
    function authenticated_users_may_delete_player()
    {
        $this->signIn();
        $player = factory(Player::class)->create();
        $this->delete("/players/{$player->id}")
             ->assertStatus(302);
        $this->assertDatabaseMissing('players', ['name' => $player->id]);
    }

    /** @test */
    function authenticated_users_may_create_players()
    {
        $this->signIn();
        $this->post("/players/", [
            'name' => 'player name'
        ]);

        $this->assertDatabaseHas('players', ['name' => 'player name']);
    }

    /** @test */
    function authenticated_users_may_update_players()
    {
        $player = factory(Player::class)->create();
        $this->signIn();
        $this->patch("/players/{$player->id}", [
            'name' => 'name changed'
        ]);

        $this->assertDatabaseHas('players', ['name' => 'name changed']);
    }

    /** @test */
    function authenticated_users_can_create_user_with_avatar()
    {
        Storage::fake('public');
        $this->signIn();
        $this->post("/players/", [
            'name' => 'test name ',
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $player = Player::first();
        $this->assertNotEmpty($player->avatar_path);
        Storage::disk('public')->assertExists($player->avatar_path);
    }

    /** @test */
    function authenticated_users_can_update_player_avatar()
    {
        Storage::fake('public');
        $player = factory(Player::class)->create();
        $this->signIn();
        $this->patch("/players/{$player->id}", [
            'name'   => 'name changed',
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $player = Player::first();
        $this->assertNotEmpty($player->avatar_path);
        Storage::disk('public')->assertExists($player->avatar_path);
    }

}
