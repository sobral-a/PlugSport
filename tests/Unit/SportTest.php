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
        $result = count($sports);

        $sport = new Sport();
        $sport->name = "Natation";
        $sport->number = 4;
        $sport->save();

        $this->assertTrue($sports->has("Natation"));
    }
}
