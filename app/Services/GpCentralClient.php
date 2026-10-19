<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GpCentralClient
{
    private function request(): PendingRequest
    {
        $baseUrl = rtrim((string) config('services.gpcentral.base_url'), '/');
        $clientId = (string) config('services.gpcentral.client_id');
        $apiKey = (string) config('services.gpcentral.api_key');

        if ($baseUrl === '' || $clientId === '' || $apiKey === '') {
            throw new RuntimeException('La integración con GP Central no está configurada.');
        }

        return Http::baseUrl($baseUrl)
            ->acceptJson()
            ->withHeaders([
                'X-Client-Id' => $clientId,
                'X-API-Key' => $apiKey,
            ])
            ->connectTimeout((int) config('services.gpcentral.connect_timeout', 5))
            ->timeout((int) config('services.gpcentral.timeout', 15))
            ->retry(2, 200, function ($exception) {
                return $exception instanceof ConnectionException
                    || ($exception instanceof RequestException && $exception->response->serverError());
            }, throw: false);
    }

    public function employeeByCode(string $employeeCode): Response
    {
        return $this->request()->get('/api/v1/employees/by-code/'.rawurlencode($employeeCode));
    }

    public function authenticatedRequest(): PendingRequest
    {
        return $this->request();
    }
}
