<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testBookablePrice()
    {
        $response = $this->get('/api/bookables/32/price?from=2021-04-04&to=2021-04-07');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());
    }
}
