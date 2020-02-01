<?php

namespace Tests\Feature;

use App\Player;
use App\Team;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlayerTest extends TestCase
{
    /** @test */
    function player_team_membership_should_be_removed_upon_player_deletion()
    {
        $this->withoutExceptionHandling();

        $team = factory(Team::class)->create();

        $player = factory(Player::class)->create();

        $team->players()->attach($player);

        $player->delete();

        $this->assertEquals(0, DB::table('player_team')->count());
    }
}
