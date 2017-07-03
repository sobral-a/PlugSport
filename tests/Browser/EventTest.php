<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventTest extends DuskTestCase
{
    /**
     * @group EventTest
     *
     * @return void
     */
    public function testGoToEvent()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('email', "khalis@hotmail.fr")
                ->type('password',  "test75")
                ->press('Se connecter')
                ->clickLink('Mes évènements')
                ->assertSee('Ajouter un évènement sportif');
        });
    }

    /**
     * @group EventTest
     *
     * @return void
     */
    public function testCreateEventFailed()
    {
        $this->browse(function ($browser) {
            $browser->clickLink('Mes évènements')
                ->type('name', 'Tournoi')
                ->type('adress', 'Kremlin Bicetre')
                ->type('teams_number', '8')
                ->type('date', 'blabla')
                ->select('sport')
                ->type('description', 'Un magnigfique tournoi')
                ->press('Ajouter')
                ->assertSee('The date is not a valid date.');
        });
    }

    /**
     * @group EventTest
     *
     * @return void
     */
    public function testCreateEventSuccessed()
    {
        $this->browse(function ($browser) {
            $browser->clickLink('Mes évènements')
                ->type('name', 'Tournoi')
                ->type('adress', 'Kremlin Bicetre')
                ->type('teams_number', '8')
                ->type('date', '2017-07-06')
                ->select('sport')
                ->type('description', 'Un magnigfique tournoi')
                ->press('Ajouter')
                ->assertSee('Tournoi');
        });
    }
}
