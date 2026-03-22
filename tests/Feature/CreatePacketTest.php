<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePacketTest extends TestCase
{
    /**
     * A basic feature test example.
     */
  use RefreshDatabase;

    public function test_can_create_packet()
    {
        $response = $this->postJson('/api/packets', [
            'tracking_code' => 'TEST-123',
            'recipient_name' => 'Juan Perez',
            'recipient_email' => 'juan@test.com',
            'destination_address' => 'Osorno',
            'weight_grams' => 1000
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('packets', [
            'tracking_code' => 'TEST-123',
            'status' => 'created'
        ]);
    }
}
