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
                ->type('name', 'Tournoi MTI')
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
                ->type('name', 'Tournoi MTI')
                ->type('adress', 'Kremlin Bicetre')
                ->type('teams_number', '8')
                ->type('date', '2017-07-06')
                ->select('sport')
                ->type('description', 'Un magnigfique tournoi')
                ->press('Ajouter')
                ->assertSee('Tournoi MTI');
        });
    }

    /**
     * @group EventTest
     *
     * @return void
     */
    public function testSeeEvent()
    {
        $this->browse(function ($browser) {
            $browser->clickLink('Mes évènements')
                ->clickLink('Tournoi MTI')
                ->assertSee('Tournoi MTI');
        });
    }

    /**
     * @group EventTest
     *
     * @return void
     */
    public function testJoinEvent()
    {
        $this->browse(function ($browser) {
            $browser->press('Rejoindre')
                ->clickLink('Mes évènements')
                ->assertSee('En attente');
        });
    }

    /**
     * @group EventTest
     *
     * @return void
     */
    public function testAcceptEvent()
    {
        $this->browse(function ($browser) {
            $browser->clickLink('Mes évènements')
                ->clickLink('Tournoi MTI')
                ->press('Accepter')
                ->assertSee('Notifier mes joueurs par mail');
        });
    }

     /**
     * @group EventTest
     *
     * @return void
     */
    public function testSendMail()
    {
        $this->browse(function ($browser) {
            $browser->press('Notifier mes joueurs par mail')
                ->assertSee("Un mail a été envoyé à tous les joueurs de l'équipe.");
        });
    }

    /**
     * @group EventTest
     *
     * @return void
     */
    public function testCheckStatus()
    {
        $this->browse(function ($browser) {
            $browser->clickLink('Mes évènements')
                ->assertSee("Vérifier les disponibilités de l'équipe");
        });
    }

    /**
     * @group EventTest
     *
     * @return void
     */
    public function testDeleteEventSuccessed()
    {
        $this->browse(function ($browser) {
            $browser->clickLink('Mes évènements')
                ->press('Supprimer')
                ->assertDontSee('Tournoi MTI');
        });
    }
}
