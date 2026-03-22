<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Packet;

class UpdatePacketStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_packet_can_change_status()
    {
        $packet = Packet::create([
            'tracking_code' => 'TEST-456',
            'recipient_name' => 'Pedro',
            'recipient_email' => 'pedro@test.com',
            'destination_address' => 'Osorno',
            'weight_grams' => 500,
            'status' => 'created'
        ]);

        $response = $this->putJson("/api/packets/{$packet->id}/status", [
            'status' => 'in_transit'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('packets', [
            'id' => $packet->id,
            'status' => 'in_transit'
        ]);
    }
}