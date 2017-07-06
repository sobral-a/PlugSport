<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Sport;

class SportTest extends TestCase
{

    protected $sport;
    
    /**
     * @group SportTest
     *
     * @return void
     */
    public function testAddSport()
    {
        $sport = new Sport();
        $sport->name = 'Natation';
        $sport->number = 4;
        $sport->save();

        $this->assertDatabaseHas('sport', ['name' => 'Natation']);
    }

    /**
     * @group SportTest
     *
     * @return void
     */
    public function testListSport()
    {
        $sports = Sport::all();
        $this->assertNotEmpty($sports);
    }

    /**
     * @group SportTest
     *
     * @return void
     */
    public function testDeleteSport()
    {
        $sport = Sport::first();
        $sport->delete();
        
        $this->assertDatabaseMissing('sport', ['name' => $sport->name]);
    }
}
