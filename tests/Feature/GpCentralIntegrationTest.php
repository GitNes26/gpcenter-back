<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GpCentralIntegrationTest extends TestCase
{
    public function test_employee_lookup_is_proxied_with_service_credentials(): void
    {
        $secret = Str::random(64);
        config()->set('services.gpcentral', [
            'base_url' => 'https://central.test',
            'client_id' => 'gpcenter-test',
            'api_key' => $secret,
            'connect_timeout' => 1,
            'timeout' => 2,
        ]);
        Sanctum::actingAs(new User(['active' => true]));

        Http::fake([
            'https://central.test/api/v1/employees/by-code/612024' => Http::response([
                'status_code' => 200,
                'status' => true,
                'result' => ['employee_code' => '612024', 'full_name' => 'Persona Prueba'],
            ]),
        ]);

        $this->getJson('/api/gpCenter/employees/getBy/employee_code/612024')
            ->assertOk()
            ->assertJsonPath('data.result.employee_code', '612024');

        Http::assertSent(fn ($request) => $request->hasHeader('X-Client-Id', 'gpcenter-test')
            && $request->hasHeader('X-API-Key', $secret)
            && $request->url() === 'https://central.test/api/v1/employees/by-code/612024'
        );
    }

    public function test_central_authentication_failure_does_not_expire_human_session(): void
    {
        config()->set('services.gpcentral', [
            'base_url' => 'https://central.test',
            'client_id' => 'gpcenter-test',
            'api_key' => Str::random(64),
            'connect_timeout' => 1,
            'timeout' => 2,
        ]);
        Sanctum::actingAs(new User(['active' => true]));
        Http::fake(fn () => Http::response(['message' => 'No autorizado'], 401));

        $this->getJson('/api/gpCenter/employees/getBy/employee_code/612024')
            ->assertStatus(502)
            ->assertJsonPath('data.status_code', 502);
    }
}
