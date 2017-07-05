<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class RegisterTest extends DuskTestCase
{
    /**
     * @group RegisterTest
     *
     * @return void
     */
    public function testRegisterMissingField()
    {
        $user = factory(User::class)->create();

        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('first_name', $user->first_name)
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
        $user = User::first();

        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('first_name', $user->first_name)
                ->type('name', $user->name)
                ->type('email', "toto")
                ->type('password', $user->password)
                ->type('password_confirmation', $user->password)
                ->press("S'inscrire")
                ->assertPathIs('/register');
        });
    }

     /**
     * @group RegisterTest
     *
     * @return void
     */
    public function testRegisterPasswordFailed()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('first_name', "Simon")
                ->type('name', "Radier")
                ->type('email', "simon@hotmail.fr")
                ->type('password', "mti2018")
                ->type('password_confirmation', "mti")
                ->press("S'inscrire")
                ->assertSee('The password confirmation does not match.');
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
