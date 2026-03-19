<?php

namespace App\Services;
use App\Models\Packet;
use Illuminate\Support\Facades\Cache;

class PacketService
{ //Crear paquete
  public function create(array $data): Packet
    {
        return Packet::create([
            ...$data,
            'status' => Packet::STATUS_CREATED
        ]);
    }
    //Actualiza paquete
    public function updateStatus(Packet $packet, string $newStatus): Packet
    {
        //LLama a funcion de la case  para verificar si es posible transision de estado.
        if (!$packet->canTransitionTo($newStatus)) {
            throw new \Exception(
                "No se pudo transisionar el estado del paquete de {$packet->status} a {$newStatus}"
            );
    }

    $packet->update([
        'status' => $newStatus
    ]);

    return $packet;
    }
    //Lista paquetes segun tipo de estado
    public function listPackets(?string $status = null)
    {
        //Genera caches segun el filtor
        $cacheKey = "packets_list_" . ($status ?? 'all');
        //verifica si el cache existe para cargarlo, duracion del cache es de 5 minutos
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($status) {
            return Packet::when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })->latest()->get();
        });
    }
    //Obtener infromacion especifica de paquete por id
    public function getPacketById(int $id): Packet
    {
        return Packet::findOrFail($id);
        
    }
}