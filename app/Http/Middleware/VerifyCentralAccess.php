<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyCentralAccess
{
    public function handle(Request $request, Closure $next, string $systemCode)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Token no proporcionado'], 401);
        }

        // Consulta al núcleo central
        $response = Http::withToken($token)
            ->get(config('services.gpcentral.url') . '/api/verify-system-access', [
                'system_code' => $systemCode
            ]);

        if ($response->failed() || !$response->json('result.has_access')) {
            return response()->json(['message' => 'Acceso denegado al sistema'], 403);
        }

        // Opcional: almacenar el rol en la request para usarlo después
        $request->merge(['system_role' => $response->json('result.role')]);

        return $next($request);
    }
}
