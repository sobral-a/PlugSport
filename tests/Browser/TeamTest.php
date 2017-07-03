<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class TeamTest extends DuskTestCase
{
    /**
     * @group TeamTest
     *
     * @return void
     */
    public function testGoToTeam()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('email', "khalis@hotmail.fr")
                ->type('password',  "test75")
                ->press('Se connecter')
                ->clickLink('Equipes')
                ->assertSee('Equipes');
        });
    }

    /**
     * @group TeamTest
     *
     * @return void
     */
    public function testCreateTeamFailed()
    {
        $this->browse(function ($browser) {
            $browser->clickLink('Equipes')
                ->select('sport')
                ->assertDontSee('MTI Club');
        });
    }   
    
    /**
     * @group TeamTest
     *
     * @return void
     */
    public function testCreateTeamSuccessed()
    {
        $this->browse(function ($browser) {
            $browser->clickLink('Equipes')
                ->type('name', 'MTI Club')
                ->select('sport')
                ->press('Créer')
                ->assertSee('MTI Club');
        });
    }   
}
