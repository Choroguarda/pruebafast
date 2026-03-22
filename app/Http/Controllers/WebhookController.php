<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\CarrierWebhookRequest;

class WebhookController extends Controller
{
   public function carrier(CarrierWebhookRequest $request)
{
    $data = $request->validated();

    $signature = $data['signature'];


    $payload = $data;
    unset($payload['signature']);

    $generatedSignature = 'sha256=' . hash_hmac(
        'sha256',
        json_encode($payload),
        env('CARRIER_WEBHOOK_SECRET')
    );

  
    if (!hash_equals($generatedSignature, $signature)) {
        return response()->json([
            'message' => 'Firma inválida'
        ], 401);
    }


    $packet = Packet::where('tracking_code', $data['tracking_code'])->first();

    if (!$packet) {
        return response()->json([
            'message' => 'Packet no encontrado'
        ], 404);
    }

    $packet->update([
        'status' => Packet::STATUS_DELIVERED
    ]);

    return response()->json([
        'message' => 'Estado actualizado correctamente'
    ]);
}
}
