<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;
    protected $number;
    protected $message;
    protected $api_key;
    protected $customerId;
    protected $historyId;
    /**
     * Create a new job instance.
     */
    public function __construct($historyId, $whatsappServer, $customer, $contentPlanner)
    {
        $this->api_key = $whatsappServer;
        $this->number = $customer['no_wa'];
        $this->message = $contentPlanner->pesan;
        $this->customerId = $customer['id'];
        $this->historyId = $historyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
