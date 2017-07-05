<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\User;

class LoginTest extends DuskTestCase
{
    /**
     * @group LoginTest
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

    /**
     * @group LoginTest
     *
     * @return void
     */
    public function testMissingFields()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->press('Se connecter')
                ->assertPathIs('/login');
        });
    }

    /**
     * @group LoginTest
     *
     * @return void
     */
    public function testMissingPassword()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('email',  'test@hotmail.fr')
                ->press('Se connecter')
                ->assertPathIs('/login');
        });
    }

     /**
     * @group LoginTest
     *
     * @return void
     */
    public function testMissingEmail()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('password',  'test')
                ->press('Se connecter')
                ->assertPathIs('/login');
        });
    }

    /**
     * @group LoginTest
     *
     * @return void
     */
    public function testLoginSuccessed()
    {
        $user = factory(User::class)->create();
        $user = User::first();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password',  'secret75')
                ->press('Se connecter')
                ->assertPathIs('/home');
        });
    }
}