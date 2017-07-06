<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class NavigationTest extends DuskTestCase
{
    /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testHome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('PlugSport')
                    ->assertPathIs('/');
        });
    }

    /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testConnection()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Connexion')
                    ->assertPathIs('/login');
        });
    }

    /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testConnection2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->clickLink('Se connecter')
                    ->assertPathIs('/login');
        });
    }

    /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Inscription')
                    ->assertPathIs('/register');
        });
    }

    /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testRegister2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink("S'inscrire")
                    ->assertPathIs('/register');
        });
    }

    /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testDashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'khalis@hotmail.fr')
                    ->type('password', 'test75')
                    ->press('Se connecter')
                    ->assertPathIs('/home');
        });
    }

    /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testAllEvents()
    {
        $this->browse(function (Browser $browser) {
            $browser->clickLink('Tous les évènements')
                    ->assertPathIs('/events');
        });
    }

     /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testAvailability()
    {
        $this->browse(function (Browser $browser) {
            $browser->clickLink('Disponibilités')
                    ->assertPathIs('/availability');
        });
    }

    /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testProfile()
    {
        $this->browse(function (Browser $browser) {
            $browser->clickLink('khalis')
                    ->clickLink('Profile')
                    ->assertPathIs('/profile');
        });
    }

    /**
     * @group NavigationTest
     *
     * @return void
     */
    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->clickLink('khalis')
                    ->clickLink('Se déconnecter')
                    ->assertPathIs('/');
        });
    }
}
