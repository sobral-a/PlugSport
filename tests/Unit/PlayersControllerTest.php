<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Team;
use App\Sport;

class PlayersControllerTest extends TestCase
{
    /**
     * Test if addUserTeam works
     * @test
     * @return void
     */
    public function testAddUserTeam()
    {
        $coach = factory(User::class)->create(['profil' => 'entraineur']);
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create(['user_id' => $coach->id,
                                                'sport_id' => factory(Sport::class)->create(['number' => 2])]);
        $this->be($coach);
        $response = $this->call('POST', 'players/' . $team->id . '/' . $user->id );

        $this->assertDatabaseHas('user_team', ['user_id' => $user->id, 'team_id' => $team->id]);
    }
    /**
     * Test if setPlayer works
     * @test
     * @return void
     */
    public function testSetPlayer()
    {
        $coach = factory(User::class)->create(['profil' => 'entraineur']);
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create(['user_id' => $coach->id,
            'sport_id' => factory(Sport::class)->create(['number' => 1])]);
        $team->players()->attach($user);
        $this->be($coach);
        $response = $this->call('PATCH', 'players/' . $team->id . '/' . $user->id . '/player');

        $this->assertDatabaseHas('user_team', ['user_id' => $user->id, 'team_id' => $team->id, 'status' => 'player']);
    }
}
