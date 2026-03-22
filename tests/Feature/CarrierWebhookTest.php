<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Packet;

class CarrierWebhookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
     use RefreshDatabase;

    public function test_carrier_webhook_updates_packet()
    {
        $packet = Packet::create([
            'tracking_code' => 'EJE-111',
            'recipient_name' => 'Test',
            'recipient_email' => 'test@test.com',
            'destination_address' => 'Osorno',
            'weight_grams' => 1000,
            'status' => 'in_transit'
        ]);

        $payload = [
            'tracking_code' => 'EJE-111',
            'status' => 'delivered',
            'timestamp' => '2024-03-10T15:30:00Z'
        ];

        $signature = 'sha256=' . hash_hmac(
            'sha256',
            json_encode($payload),
            env('CARRIER_WEBHOOK_SECRET')
        );

        $response = $this->postJson('/api/webhooks/carrier', [
            ...$payload,
            'signature' => $signature
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('packets', [
            'tracking_code' => 'EJE-111',
            'status' => 'delivered'
        ]);
    }
}
