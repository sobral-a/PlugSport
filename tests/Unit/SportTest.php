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
        $sports = Sport::all();
        $result1 = count($sports);

        $sport = new Sport();
        $sport->name = "Natation";
        $sport->number = 4;
        $sport->save();

        $sports = Sport::all();
        $result2 = count($sports);

        $this->assertGreaterThan($result1, $result2);
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
        $sports = Sport::all();
        $result1 = count($sports);

        $sport = Sport::first();
        $sport->delete();
        
        $sports = Sport::all();
        $result2 = count($sports);

        $this->assertLessThan($result1, $result2);
    }
}
