<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
                    ->assertSee('Connexion')
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
                    ->assertSee('Connexion')
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
                    ->assertSee("S'inscrire")
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
                    ->assertSee("S'inscrire")
                    ->assertPathIs('/register');
        });
    }
}
