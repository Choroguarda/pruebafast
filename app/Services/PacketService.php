<?php

namespace App\Services;
use App\Models\Packet;

class PacketService
{
  public function create(array $data): Packet
    {
        return Packet::create([
            ...$data,
            'status' => Packet::STATUS_CREATED
        ]);
    }
}