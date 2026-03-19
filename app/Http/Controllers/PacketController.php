<?php

namespace App\Http\Controllers;

use App\Models\Packet;
use App\Http\Requests\UpdatePacketStatusRequest;
use App\Http\Requests\StorePacketRequest;
use App\Http\Resources\PacketResource;
use App\Services\PacketService;
use Illuminate\Http\Request;

class PacketController extends Controller
{

    //
    public function __construct(private PacketService $packetService)
    {
    }

    public function index(Request $request)
    {
        $status = $request->query('status');

        $packets = $this->packetService->listPackets($status);

        return PacketResource::collection($packets);
    }

    public function store(StorePacketRequest $request)
    {
        $packet = $this->packetService->create(
            $request->validated()
        );

        return new PacketResource($packet);
    }

    public function updateStatus(UpdatePacketStatusRequest $request, $id)
    { 
        $packet = Packet::findOrFail($id);

        $packet = $this->packetService->updateStatus(
            $packet,
            $request->status
    );

        return new PacketResource($packet);
    }

    public function show($id)
    {
        $packet = $this->packetService->getPacketById($id);

        return new PacketResource($packet);
    }
}
