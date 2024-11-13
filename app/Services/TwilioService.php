<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->twilio = new Client($sid, $token);
    }

    public function sendWhatsAppMessage($to, $message)
    {
        return $this->twilio->messages->create(
            "whatsapp:$to", // Destinatario
            [
                'from' => "whatsapp:" . env('TWILIO_WHATSAPP_NUMBER'), // Tu número de Twilio
                'body' => $message,
            ]
        );
    }
}
