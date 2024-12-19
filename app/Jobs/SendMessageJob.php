<?php

namespace App\Jobs;

use App\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendMessageJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle($number, $type, $message, $instance_id): void
    {
        $whatsAppService  = new WhatsAppService();
        $whatsAppService->sendMessage($number, $type, $message, $instance_id);
    }
}
