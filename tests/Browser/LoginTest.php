<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginFailed()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('email', "test@test.fr")
                ->type('password',  "test")
                ->press('Se connecter')
                ->assertSee('Ces identifiants ne correspondent pas');
        });
    }

    public function testLoginSuccessed()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('email', "khalis@hotmail.fr")
                ->type('password',  "test75")
                ->press('Se connecter')
                ->assertPathIs('/home');
        });
    }
}