<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Team;

class TeamTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @group TeamTest
     * @return void
     */
    public function TestAddTeam()
    {
        $user = factory(User::class)->create(['profil' => 'entraineur']);
        $team = factory(Team::class)->create(['user_id' => $user->id]);
        $this->assertDatabaseHas('teams', ['user_id' => $user->id]);
    }

    /**
     * A basic test example.
     * @test
     * @group TeamTest
     * @return void
     */
    public function testDeleteTeam()
    {
        $team = Team::first();
        $team->delete();

        $this->assertDatabaseMissing('teams', ['name' => $team->name]);
    }
}
