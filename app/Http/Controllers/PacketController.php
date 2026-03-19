<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePacketRequest;
use App\Http\Resources\PacketResource;
use App\Services\PacketService;
use Illuminate\Http\Request;

class PacketController extends Controller
{
    public function __construct(private PacketService $packetService)
    {
    }

    public function store(StorePacketRequest $request)
    {
        $packet = $this->packetService->create(
            $request->validated()
        );

        return new PacketResource($packet);
    }
}
