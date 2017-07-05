<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\User;

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

        $this->browse(function ($browser) use ($user) {
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
        $user = factory(User::class)->create();
        $user = User::first();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/register')
                ->type('first_name', $user->first_name)
                ->type('name', $user->name)
                ->type('email', "toto")
                ->type('description', 'Cool')
                ->type('password', 'secret75')
                ->type('password_confirmation', 'secret75')
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
        $user = factory(User::class)->create();
        $user = User::first();

         $this->browse(function ($browser) use ($user) {
            $browser->visit('/register')
                ->type('first_name', $user->first_name)
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('description', 'Cool')
                ->type('password', 'secret75')
                ->type('password_confirmation', 'secret')
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
        $user = factory(User::class)->create();
        $user = User::first();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/register')
               ->type('first_name', $user->first_name)
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('description', 'Cool')
                ->type('password', 'secret75')
                ->type('password_confirmation', 'secret75')
                ->press("S'inscrire")
                ->assertPathIs('/home');
        });
    }
}
