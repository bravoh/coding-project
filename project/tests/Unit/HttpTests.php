<?php

namespace Tests\Unit;

use Tests\TestCase;

class HttpTests extends TestCase
{
    /**
     * Test getting all /
     *
     * @return void
     */

    public function testHome(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }


    /**
     * Test GET /trips
     *
     * @return void
     */

    public function testTripsGet(){
        $response = $this->get('/trips');
        $response->assertStatus(200);
    }

    /**
     * Test Query on /trips
     *
     * @return void
     */

    public function testTripsPost(){
        $response = $this->post('/trips');
        $response->assertStatus(200);
    }
}
