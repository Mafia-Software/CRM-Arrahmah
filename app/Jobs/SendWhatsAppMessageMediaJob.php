<?php

namespace App\Jobs;

use App\Models\PesanKeluar;
use Illuminate\Bus\Batchable;
use App\Services\WhatsappService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppMessageMediaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $number;
    protected $message;
    protected $api_key;
    protected $media;
    protected $customerId;
    protected $historyId;
    protected $delayInSeconds;
    /**
     * Create a new job instance.
     */
    public function __construct($historyId, $whatsappServer, $customer, $contentPlanner)
    {
        $this->api_key = $whatsappServer->api_key;
        $this->number = $customer->no_wa;
        $this->message = $contentPlanner->pesan;
        $this->media = $contentPlanner->media;
        $this->customerId = $customer->id;
        $this->historyId = $historyId;
        $this->delayInSeconds = $whatsappServer->delay;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsappService $WhatsAppService): void
    {
        $res = $WhatsAppService->sendMediaFromUrl(
            $this->api_key,
            $this->number,
            $this->message,
            asset('storage/' . $this->media),
            0
        );
        PesanKeluar::create(['id' => $res['results']['id_message'], 'customer_id' => $this->customerId, 'history_id' => $this->historyId, 'status' => $res['code']]);
    }
}
