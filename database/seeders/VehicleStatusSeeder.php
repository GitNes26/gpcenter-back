<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class VehicleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'id' => 1,
                'vehicle_status' => 'SIN ASIGNAR',
                'bg_color' => '#d9d9d9',
                'letter_black' => 1,
                'description' => 'EL vehículo no tiene un estatus definido.',
                'active' => 1,
                'created_at' => '2023-10-31 12:44:57',
                'updated_at' => '2023-10-31 12:44:57',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'vehicle_status' => 'DISPONIBLE',
                'bg_color' => '#128129',
                'letter_black' => 0,
                'description' => 'EL vehículo esta disponible en patrimonio. Documentación lista (VEHICULO LISTO PARA ASIGNAR)',
                'active' => 1,
                'created_at' => '2023-10-31 12:44:57',
                'updated_at' => '2024-02-06 20:59:57',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'vehicle_status' => 'ASIGNADO',
                'bg_color' => '#083691',
                'letter_black' => 0,
                'description' => 'EL vehículo solo puede ser asignado a directores registrados en el sistema.',
                'active' => 1,
                'created_at' => '2023-10-31 12:44:57',
                'updated_at' => '2024-02-06 21:00:36',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'vehicle_status' => 'PRESTADO',
                'bg_color' => '#99860a',
                'letter_black' => 0,
                'description' => 'EL vehículo fue prestado a un conductor despues de ser asignado a un director.',
                'active' => 1,
                'created_at' => '2023-10-31 12:44:57',
                'updated_at' => '2024-02-06 21:01:11',
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'vehicle_status' => 'EN SERVICIO',
                'bg_color' => '#59575c',
                'letter_black' => 0,
                'description' => 'EL vehículo se encuentra en el taller para revisión.',
                'active' => 1,
                'created_at' => '2023-10-31 12:44:57',
                'updated_at' => '2024-11-21 19:29:46',
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'vehicle_status' => 'COMODATO',
                'bg_color' => '#2ca9c9',
                'letter_black' => 0,
                'description' => null,
                'active' => 1,
                'created_at' => '2023-11-16 02:31:48',
                'updated_at' => '2023-11-16 02:31:48',
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'vehicle_status' => 'POR APROBAR SERVICIO',
                'bg_color' => '#6457c1',
                'letter_black' => 0,
                'description' => 'En este estatus, se genero una solicitud de servicio, pero necesita la confirmación de PATRIMONIO para acceder la unidad a taller.',
                'active' => 1,
                'created_at' => '2024-11-21 14:41:36',
                'updated_at' => '2024-11-21 19:30:04',
                'deleted_at' => null,
            ],
            [
                'id' => 8,
                'vehicle_status' => 'SERVICIO APROBADO',
                'bg_color' => '#2db49d',
                'letter_black' => 0,
                'description' => 'En este estatus, PATRIMONIO ya acepto la solicitud de servicio. el vehículo ya puede ser llevado a taller y esperar a que el mecánico empiece la revisión.',
                'active' => 1,
                'created_at' => '2024-11-21 19:30:51',
                'updated_at' => '2024-11-21 19:30:51',
                'deleted_at' => null,
            ],
        ];

        DB::table('vehicle_status')->insert($statuses);

        $this->command->info('Estados de vehículos insertados correctamente (' . count($statuses) . ' registros).');
    }
}