<?php

namespace App\Jobs;

use App\Models\PesanKeluar;
use Illuminate\Bus\Batchable;
use App\Services\WhatsappService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWhatsAppMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $number;
    protected $message;
    protected $api_key;
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
        $this->customerId = $customer->id;
        $this->historyId = $historyId;
        $this->delayInSeconds = $whatsappServer->delay;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsappService $WhatsAppService)
    {
        $res = $WhatsAppService->sendMessage(
            $this->api_key,
            $this->number,
            $this->message,
        );
        PesanKeluar::create(['id' => $res['results']['id_message'], 'customer_id' => $this->customerId, 'history_id' => $this->historyId, 'status' => $res['code']]);
    }
}
