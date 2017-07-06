<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class ProfileControllerTest extends TestCase
{
    /**
     * Test if wantsRappel is correctly updated.
     * @test
     * @return void
     */
    public function updateProfileToFalse()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $response = $this->call('POST', 'profile/rappel');
        $this->assertEquals($user->wantsRappel, false);
    }

    /**
     * Test if wantsRappel is correctly updated.
     * @test
     * @return void
     */
    public function updateProfileToTrue()
    {
        $user = factory(User::class)->create(['wantsRappel' => 0]);
        $this->be($user);
        $response = $this->call('POST', 'profile/rappel', array ('notif'=> 'notif'));
        $this->assertEquals($user->wantsRappel, true);
    }
}
