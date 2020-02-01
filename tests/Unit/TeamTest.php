<?php

namespace Tests\Feature;

use App\Player;
use App\Team;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    /** @test */
    function team_players_should_be_removed_upon_team_deletion()
    {
        $this->withoutExceptionHandling();

        $team = factory(Team::class)->create();

        $player = factory(Player::class, 10)->create();

        $team->players()->attach($player);

        $team->delete();

        $this->assertEquals(0, DB::table('player_team')->count());
    }
}
