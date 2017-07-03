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
}
