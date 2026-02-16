<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EvolutionService
{
    protected $baseUrl = 'http://localhost:8080';
    protected $apiKey = 'alcecar_secret_token';

    public function createInstance($name)
    {
        $response = Http::withHeaders(['apikey' => $this->apiKey])
            ->post("{$this->baseUrl}/instance/create", [
                'instanceName' => $name,
                'qrcode' => true
            ]);
        return $response->json();
    }

    public function getQrCode($name)
    {
        $response = Http::withHeaders(['apikey' => $this->apiKey])
            ->get("{$this->baseUrl}/instance/connect/{$name}");
        return $response->json();
    }

    public function sendText($name, $number, $message)
    {
        return Http::withHeaders(['apikey' => $this->apiKey])
            ->post("{$this->baseUrl}/message/sendText/{$name}", [
                'number' => $number,
                'textMessage' => ['text' => $message]
            ])->json();
    }
}