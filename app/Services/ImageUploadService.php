<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageUploadService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.gpc_api_url', 'https://api.gpcenter.gomezpalacio.gob.mx');
    }

    /**
     * Sube una imagen al microservicio de forma genérica.
     *
     * @param UploadedFile $file          Archivo a subir
     * @param string       $dirDestination ID/destino del directorio (ej: IDDetalle)
     * @param string       $dirPath        Ruta relativa del directorio (ej: "presidencia/producto")
     * @param string       $imgName        Nombre base para el archivo (se le agrega timestamp)
     * @param string       $requestFileName Nombre del campo que espera la API remota (ej: "Firma_Director")
     * @param string|null  $endpoint       Endpoint personalizado (default: /api/smImgUpload)
     * @return string Nombre del archivo subido
     * @throws \Exception
     */
    public function upload(
        UploadedFile $file,
        string $dirDestination,
        string $dirPath,
        string $imgName,
        string $requestFileName = 'file',
        ?string $endpoint = null
    ): string {
        if (!$file->isValid()) {
            throw new \Exception('El archivo no es válido');
        }

        $extension = $file->getClientOriginalExtension();
        $filename = $imgName . '_' . time() . '.' . $extension;
        $endpoint ??= '/api/smImgUpload';

        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');

        $multipart = [
            ['name' => $requestFileName, 'contents' => fopen($file->getPathname(), 'r'), 'filename' => $filename],
            ['name' => 'dirDestination', 'contents' => $dirDestination],
            ['name' => 'dirPath',        'contents' => $dirPath],
            ['name' => 'imgName',        'contents' => $filename],
            ['name' => 'requestFileName', 'contents' => $requestFileName],
        ];

        Log::info("ImageUploadService: enviando a {$url}", [
            'filename'      => $filename,
            'dirDestination' => $dirDestination,
            'dirPath'       => $dirPath,
            'requestFileName' => $requestFileName,
        ]);

        $response = Http::timeout(30)
            ->withOptions(['verify' => false, 'multipart' => $multipart])
            ->send('POST', $url);

        if (!$response->successful()) {
            Log::error("ImageUploadService: error HTTP {$response->status()}", ['body' => $response->body()]);
            throw new \Exception("Error al subir la imagen. Código: {$response->status()}");
        }

        Log::info("ImageUploadService: imagen subida exitosamente", ['filename' => $filename]);
        return $filename;
    }
}