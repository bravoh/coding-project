<?php

namespace Tests\Unit;

use Tests\TestCase;

class TripTest extends TestCase
{
    /**
     * Test getting all trips
     *
     * @return void
     */

    public function testGettingAllTrips(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
