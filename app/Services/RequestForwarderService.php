<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RequestForwarderService
{
    /**
     * Reenvía el request completo (campos + archivos) a una URL remota.
     *
     * @param Request    $request      Request original de Laravel
     * @param string     $url          URL destino (ej: https://api.gpcentral.com/api/employees/createOrUpdate)
     * @param array      $override     Campos a agregar/sobrescribir (ej: ['id' => $request->gpc_employee_id])
     * @param array      $except       Campos a excluir (default: ['_token', '_method'])
     * @param array      $fileFields   Nombres de los campos que contienen archivos (default: ['avatar','signature_image','seal_image'])
     * @param int        $timeout      Timeout en segundos
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function forward(
        Request $request,
        string $url,
        array $override = [],
        array $except = ['_token', '_method'],
        array $fileFields = ['avatar', 'signature_image', 'seal_image'],
        int $timeout = 30
    ) {
        $allData = $request->except($except);
        $allData = array_merge($allData, $override);

        $multipart = [];

        foreach ($allData as $key => $value) {
            if (is_string($value) || is_numeric($value) || is_bool($value)) {
                $multipart[] = ['name' => $key, 'contents' => (string)$value];
            }
        }

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $multipart[] = [
                    'name'     => $field,
                    'contents' => fopen($file->getPathname(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ];
            }
        }

        Log::info('RequestForwarderService: reenviando request', [
            'url'      => $url,
            'fields'   => array_keys($allData),
            'files'    => $fileFields,
            'override' => $override,
        ]);

        $response = Http::timeout($timeout)
            ->withOptions(['verify' => false, 'multipart' => $multipart])
            ->send('POST', $url);

        if (!$response->successful()) {
            Log::error("RequestForwarderService: error {$response->status()}", [
                'url'  => $url,
                'body' => $response->body(),
            ]);
        }

        return $response;
    }
}
