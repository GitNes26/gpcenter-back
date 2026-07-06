<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
                $now = now();

                $roles = [
                        [
                                'id' => 1,
                                'role' => 'SuperAdmin',
                                'description' => 'Rol dedicado para la completa configuracion del sistema desde el area de desarrollo.',
                                'read' => 'todas',
                                'create' => 'todas',
                                'update' => 'todas',
                                'delete' => 'todas',
                                'more_permissions' => 'Solicitar Servicio,Asignar Vehículo,Prestar Vehículo,Devolver Préstamo,Entregar Vehículo,Asignar Permisos,Activar y Desactivar Solicitador de Vales,Aprobar Servicio,Rechazar Servicio,Revisar Unidad,Cerrar Servicio,Cargar Material,Aprobar Material,Rechazar Material,Aprobar Vale,Cancelar Vale,Generar Vale,Solicitador Externo,VoBo,Exportar Todas Las Solicitudes En PDF',
                                'page_index' => '/admin',
                                'active' => 1,
                                'created_at' => '2024-03-19 19:19:16',
                                'updated_at' => '2024-11-21 20:04:40',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 2,
                                'role' => 'Administrador',
                                'description' => 'Rol dedicado para usuarios que gestionaran el sistema.',
                                'read' => '1,2,3,8,11,12,15,17,30,31,32,33,34,19,20,21,22,23',
                                'create' => '1,2,3,5,6,7,8,9,10,11,12,13,15,19,20,21,22,23,14',
                                'update' => '1,2,3,5,6,7,8,9,10,11,12,13,15,19,20,21,22,23,14',
                                'delete' => '1,2,3,5,6,7,8,9,10,11,12,13,15,19,20,21,22,23,14',
                                'more_permissions' => 'Solicitar Servicio,Asignar Vehículo,Prestar Vehículo,Devolver Préstamo,Entregar Vehículo,Asignar Permisos,Aprobar Servicio,Rechazar Servicio',
                                'page_index' => '/admin',
                                'active' => 1,
                                'created_at' => '2024-03-19 19:19:16',
                                'updated_at' => '2025-02-18 11:02:37',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 3,
                                'role' => 'Encargado de Almacen',
                                'description' => 'Rol dedicado para usuarios que darán seguimiento a las solicitudes de servicio',
                                'read' => '1,2',
                                'create' => '1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17,18,30,31,32,33,34,19,20,21,22,23,25,26,27,28,29',
                                'update' => '1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17,18,30,31,32,33,34,19,20,21,22,23,25,26,27,28,29',
                                'delete' => 'todas',
                                'more_permissions' => '',
                                'page_index' => '2',
                                'active' => 1,
                                'created_at' => '2024-03-19 19:19:16',
                                'updated_at' => '2025-03-18 15:36:30',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 4,
                                'role' => 'Mecánico',
                                'description' => 'Rol dedicado para mecánicos del taller.',
                                'read' => '1,2,15,31,32,33,19,23',
                                'create' => '',
                                'update' => '',
                                'delete' => '',
                                'more_permissions' => 'Revisar Unidad,Cerrar Servicio,Cargar Material',
                                'page_index' => '/admin',
                                'active' => 1,
                                'created_at' => '2024-03-19 19:19:16',
                                'updated_at' => '2024-11-25 12:50:49',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 5,
                                'role' => 'Director',
                                'description' => 'Rol dedicado para usuarios a quienes se les asignaran las unidades y haran uso de ella.',
                                'read' => '1,2,3,12,15,17,19,23,24',
                                'create' => '',
                                'update' => '',
                                'delete' => '',
                                'more_permissions' => 'Prestar Vehículo,Entregar Vehículo,Solicitar Servicio,Devolver Préstamo,Cancelar Vale',
                                'page_index' => '/admin',
                                'active' => 1,
                                'created_at' => '2024-03-19 19:19:16',
                                'updated_at' => '2024-12-16 09:04:55',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 6,
                                'role' => 'Conductor',
                                'description' => 'Rol dedicado para conductores permitidos por los directores.',
                                'read' => '1,2,19,23',
                                'create' => '',
                                'update' => '',
                                'delete' => '',
                                'more_permissions' => 'Devolver Préstamo',
                                'page_index' => '/admin',
                                'active' => 1,
                                'created_at' => '2024-03-19 19:19:16',
                                'updated_at' => '2024-03-19 19:19:16',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 7,
                                'role' => 'Admin. Contro de Vales',
                                'description' => 'Rol dedicado persolan de control Vehícular para aprobar vales.',
                                'read' => '1,2,3,14,15,17,30,31,32,33,34,19,23,25,24,26,27,28,29',
                                'create' => '14,24',
                                'update' => '14,23',
                                'delete' => '14',
                                'more_permissions' => 'Activar y Desactivar Solicitador de Vales,Aprobar Material,Rechazar Material,Aprobar Vale,Cancelar Vale,Generar Vale,Exportar Todas Las Solicitudes En PDF',
                                'page_index' => '/admin/vales',
                                'active' => 1,
                                'created_at' => '2024-03-19 19:19:16',
                                'updated_at' => '2024-11-21 20:05:17',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 8,
                                'role' => 'Solicitador de Vales',
                                'description' => 'Rol dedicado unicamente para solicitar Vales.',
                                'read' => '25,24',
                                'create' => '24',
                                'update' => '',
                                'delete' => '',
                                'more_permissions' => 'Cancelar Vale',
                                'page_index' => '/admin/vales',
                                'active' => 1,
                                'created_at' => '2024-03-19 19:19:16',
                                'updated_at' => '2025-01-02 08:41:23',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 9,
                                'role' => 'Supervisor de Vales',
                                'description' => 'Rol dedicado para usuarios que se encargan de dar visto bueno (VoBo) a solicitud de vales antes de asignar vales.',
                                'read' => '25,24,26,27,28,29',
                                'create' => '24',
                                'update' => '',
                                'delete' => '24',
                                'more_permissions' => 'Cancelar Vale,VoBo',
                                'page_index' => '/admin/vales',
                                'active' => 1,
                                'created_at' => '2024-03-21 01:34:44',
                                'updated_at' => '2025-09-01 09:51:52',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 10,
                                'role' => 'Supervisor OF',
                                'description' => null,
                                'read' => '1,2,3,8,11,12,19,20,21,22,23,25,24',
                                'create' => '8,11,12,20,21,22,23,24',
                                'update' => '',
                                'delete' => '',
                                'more_permissions' => 'Cancelar Vale',
                                'page_index' => '/admin',
                                'active' => 1,
                                'created_at' => '2024-07-09 17:41:31',
                                'updated_at' => '2025-01-02 08:41:40',
                                'deleted_at' => null,
                        ],
                        [
                                'id' => 11,
                                'role' => 'ControlyPatrimonio',
                                'description' => 'Rol especial para mauricio',
                                'read' => '1,2,3,11,12,15,16,17,18,30,31,32,33,34,19,20,21,23,25,14,24,26,27,28,29',
                                'create' => '14,24',
                                'update' => '23,14',
                                'delete' => '24',
                                'more_permissions' => 'Solicitar Servicio,Prestar Vehículo,Asignar Vehículo,Devolver Préstamo,Entregar Vehículo,Aprobar Servicio,Rechazar Servicio,Aprobar Material,Rechazar Material,Activar y Desactivar Solicitador de Vales,Cancelar Vale,VoBo,Solicitador Externo,Aprobar Vale,Generar Vale,Exportar Todas Las Solicitudes En PDF',
                                'page_index' => '/admin',
                                'active' => 1,
                                'created_at' => '2024-11-26 08:58:36',
                                'updated_at' => '2025-01-02 08:46:54',
                                'deleted_at' => null,
                        ],
                ];

                // Insertar registros
                DB::table('roles')->insert($roles);

                $this->command->info('Roles insertados correctamente (' . count($roles) . ' registros).');
        }
}