<?php

namespace App\Jobs;
use App\Models\Packet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendPacketStatusWebhook implements ShouldQueue
{
    use Queueable,Dispatchable, InteractsWithQueue,SerializesModels;

    //Cantidad de intentos
     public $tries = 2;
    /**
     * Create a new job instance.
     */
    public function __construct(
        public Packet $packet,
        public string $oldStatus,
        public string $newStatus
    ) {
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        //Envio a la URL de .env la informacion
        Http::post(env('WEBHOOK_URL'), [
            'tracking_code' => $this->packet->tracking_code,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'updated_at' => now()->toISOString(),
        ]);
    }
}
