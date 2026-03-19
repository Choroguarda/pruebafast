<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    protected $table = 'packets';

    protected $fillable = [
        'tracking_code',
        'recipient_name',
        'recipient_email',
        'destination_address',
        'weight_grams',
        'status',
    ];

    //Estados de los paquetes
    public const STATUS_CREATED = 'created';
    public const STATUS_IN_TRANSIT = 'in_transit';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_FAILED = 'failed';


    //Funcion que setea las transisiones posibles
    public static function transitions(): array
    {
    return [
        self::STATUS_CREATED => [
            self::STATUS_IN_TRANSIT
        ],
        self::STATUS_IN_TRANSIT => [
            self::STATUS_DELIVERED,
            self::STATUS_FAILED
        ]
    ];
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $allowedTransitions = self::transitions()[$this->status] ?? [];

        return in_array($newStatus, $allowedTransitions);
    }
}
