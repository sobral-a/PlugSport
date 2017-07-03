<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    /**
     * @group RegisterTest
     *
     * @return void
     */
    public function testRegisterMissingField()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('first_name', "Simon")
                ->press("S'inscrire")
                ->assertPathIs('/register');
        });
    }

    /**
     * @group RegisterTest
     *
     * @return void
     */
    public function testRegisterEmailFailed()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('first_name', "Simon")
                ->type('name', "Radier")
                ->type('email', "simon")
                ->type('password', "mti2018")
                ->type('password_confirmation', "mti2018")
                ->press("S'inscrire")
                ->assertPathIs('/register');
        });
    }

     /**
     * @group RegisterTest
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('first_name', "Simon")
                ->type('name', "Radier")
                ->type('email', "simon@hotmail.fr")
                ->type('password', "mti2018")
                ->type('password_confirmation', "mti2018")
                ->press("S'inscrire")
                ->assertPathIs('/home');
        });
    }

     /**
     * @group RegisterTest
     *
     * @return void
     */
    public function testRegisterFailed()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('first_name', "Simon")
                ->type('name', "Radier")
                ->type('email', "simon@hotmail.fr")
                ->type('password', "mti2018")
                ->type('password_confirmation', "mti2018")
                ->press("S'inscrire")
                ->assertSee('The email has already been taken.');
        });
    }
}
