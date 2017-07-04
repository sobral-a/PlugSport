<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @group UserTest
     *
     * @return void
     */
    public function testCreateUser()
    {
        $user = factory(User::class)->create([
            'name' => 'Abigail',
        ]);

        $this->assertDatabaseHas('users', ['name' => 'Abigail']);
    }

    /**
     * @group UserTest
     *
     * @return void
     */
    public function testCreateAdmin()
    {
        $user = factory(User::class)->create([
            'name' => 'John',
            'isAdmin' => 1
        ]);
        
        $this->assertDatabaseHas('users', ['name' => 'John', 'isAdmin' => 1]);
    }

    /**
     * @group UserTest
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = User::first();
        $user->delete();
        
        $this->assertDatabaseMissing('users', ['name' => $user->name]);
    }
}
