<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class WhatsappController extends Controller
{
    public function createInstance() {}
    public function sendMessage($number, $message, $instance) {}
    public function setWebhook() {}
    public function sendMedia($number, $message, $instance, $media) {}
}
