<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        $menuDashboard = ['index' => 1, 'url' => '/admin'];
        $menuAdmin = ['index' => 3, 'url' => '/admin'];
        $menuGarage = ['index' => 15, 'url' => '/admin/taller'];
        $menuCove = ['index' => 19, 'url' => '/admin/cove'];
        $menuVales = ['index' => 25, 'url' => '/admin/vales'];

        // Arreglo con todos los menús en el orden deseado
        // El orden dentro de cada belongs_to se asignará automáticamente
        $menus = [
            // ==================== DASHBOARD (belongs_to = 0 para el grupo, y belongs_to = 1 para sus ítems) ====================
            ['id' => 1, 'menu' => 'Dashboard', 'caption' => '', 'type' => 'group', 'belongs_to' => 0, 'url' => null, 'icon' => null, 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 2, 'menu' => 'Buscador', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuDashboard['index'], 'url' => $menuDashboard['url'], 'icon' => 'IconSearch', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => 'Solicitar Servicio,Asignar Vehículo,Prestar Vehículo,Devolver Préstamo,Entregar Vehículo', 'read_only' => 0, 'active' => 1],

            // ==================== ADMINISTRATIVO (belongs_to = 0 para el grupo, y belongs_to = 3 para sus ítems) ====================
            ['id' => 3, 'menu' => 'Administrativo', 'caption' => 'Control de usuarios', 'type' => 'group', 'belongs_to' => 0, 'url' => null, 'icon' => null, 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 4, 'menu' => 'Menus', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/menus", 'icon' => 'IconCategory2', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 5, 'menu' => 'Roles y Permisos', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/roles-y-permisos", 'icon' => 'IconPaperBag', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => 'Asignar Permisos', 'read_only' => 0, 'active' => 1],
            ['id' => 6, 'menu' => 'Departamentos', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/departamentos", 'icon' => 'IconBuildingSkyscraper', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 0],
            ['id' => 7, 'menu' => 'Usuarios', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/usuarios", 'icon' => 'IconUsers', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 35, 'menu' => 'Empleados', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/empleados", 'icon' => 'IconUsers', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 1, 'active' => 1],
            ['id' => 8, 'menu' => 'Administradores', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/administradores", 'icon' => 'IconUsers', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 9, 'menu' => 'Encargados de Almacen', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/encargados-de-almacen", 'icon' => 'IconUsers', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 10, 'menu' => 'Mecánicos', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/mecanicos", 'icon' => 'IconUsers', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 11, 'menu' => 'Directores', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/directores", 'icon' => 'IconUsers', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 12, 'menu' => 'Conductores', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/conductores", 'icon' => 'IconUsers', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 13, 'menu' => 'Admins de Vales', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuAdmin['index'], 'url' => "$menuAdmin[url]/admins-de-vales", 'icon' => 'IconUsers', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 0],

            // ==================== TALLER (belongs_to = 0 para el grupo, y belongs_to = 15 para sus ítems) ====================
            ['id' => 15, 'menu' => 'Taller', 'caption' => 'Catálogos del Taller', 'type' => 'group', 'belongs_to' => 0, 'url' => null, 'icon' => null, 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 16, 'menu' => 'Almacen (Stock)', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuGarage['index'], 'url' => "$menuGarage[url]/almacen", 'icon' => 'IconBuildingWarehouse', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 18, 'menu' => 'Requisiciones - PENDIENTE', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuGarage['index'], 'url' => "$menuGarage[url]/requisiciones", 'icon' => 'IconFileInvoice', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 17, 'menu' => 'Listado de Servicios', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuGarage['index'], 'url' => "$menuGarage[url]/servicios", 'icon' => 'IconTool', 'show_counter' => 1, 'counter_name' => 'services', 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 30, 'menu' => 'S. Serv. Por Aprobar', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuGarage['index'], 'url' => "$menuGarage[url]/servicios/abiertas", 'icon' => 'IconHexagonLetterA', 'show_counter' => 1, 'counter_name' => 'servicesOpened', 'others_permissions' => 'Aprobar Servicio, Rechazar Servicio', 'read_only' => 1, 'active' => 1],
            ['id' => 31, 'menu' => 'S. Serv. Aprob.', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuGarage['index'], 'url' => "$menuGarage[url]/servicios/aprobadas", 'icon' => 'IconFileCheck', 'show_counter' => 1, 'counter_name' => 'servicesApproved', 'others_permissions' => 'Revisar Unidad', 'read_only' => 1, 'active' => 1],
            ['id' => 32, 'menu' => 'S. Serv. en Rev.', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuGarage['index'], 'url' => "$menuGarage[url]/servicios/en-revision", 'icon' => 'IconHexagonLetterR', 'show_counter' => 1, 'counter_name' => 'servicesInReviewed', 'others_permissions' => 'Cargar Material, Cerrar Servicio, Aprobar Material, Rechazar Material', 'read_only' => 1, 'active' => 1],
            ['id' => 33, 'menu' => 'S. Serv. Cerradas', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuGarage['index'], 'url' => "$menuGarage[url]/servicios/cerradas", 'icon' => 'IconHexagonLetterC', 'show_counter' => 1, 'counter_name' => 'servicesClosed', 'others_permissions' => null, 'read_only' => 1, 'active' => 1],
            ['id' => 34, 'menu' => 'S. Serv. Rechazadas', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuGarage['index'], 'url' => "$menuGarage[url]/servicios/rechazadas", 'icon' => 'IconFilesOff', 'show_counter' => 1, 'counter_name' => 'servicesRejected', 'others_permissions' => null, 'read_only' => 1, 'active' => 1],

            // ==================== CoVe (belongs_to = 0 para el grupo, y belongs_to = 19 para sus ítems) ====================
            ['id' => 19, 'menu' => 'CoVe', 'caption' => 'Control Vehicular', 'type' => 'group', 'belongs_to' => 0, 'url' => null, 'icon' => null, 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 20, 'menu' => 'Marcas', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuCove['index'], 'url' => "$menuCove[url]/marcas", 'icon' => 'IconBadgeTm', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 21, 'menu' => 'Modelos', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuCove['index'], 'url' => "$menuCove[url]/modelos", 'icon' => 'IconBoxModel2', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 22, 'menu' => 'Estatus de Vehículos', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuCove['index'], 'url' => "$menuCove[url]/estatus-vehiculo", 'icon' => 'IconStatusChange', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 23, 'menu' => 'Vehículos', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuCove['index'], 'url' => "$menuCove[url]/vehiculos", 'icon' => 'IconCar', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],

            // ==================== VALES (belongs_to = 0 para el grupo, y belongs_to = 25 para sus ítems) ====================
            ['id' => 25, 'menu' => 'Vales', 'caption' => 'Control de Vales', 'type' => 'group', 'belongs_to' => 0, 'url' => null, 'icon' => null, 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 14, 'menu' => 'Solicitadores de Vales', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuVales['index'], 'url' => '/admin/solicitadores-de-vales', 'icon' => 'IconUsers', 'show_counter' => 0, 'counter_name' => null, 'others_permissions' => 'Activar y Desactivar Solicitador de Vales', 'read_only' => 0, 'active' => 1],
            ['id' => 24, 'menu' => 'Listado Global', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuVales['index'], 'url' => "$menuVales[url]", 'icon' => 'IconTicket', 'show_counter' => 1, 'counter_name' => 'vouchers', 'others_permissions' => 'Aprobar Vale, Cancelar Vale, VoBo, Generar Vale, Solicitador Externo', 'read_only' => 0, 'active' => 1],
            ['id' => 26, 'menu' => 'Vales en Alta', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuVales['index'], 'url' => "$menuVales[url]/altas", 'icon' => 'IconFileStack', 'show_counter' => 1, 'counter_name' => 'vouchersCreated', 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 27, 'menu' => 'Vales en VoBo', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuVales['index'], 'url' => "$menuVales[url]/vobos", 'icon' => 'IconEyeCheck', 'show_counter' => 1, 'counter_name' => 'vouchersVoBo', 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
            ['id' => 28, 'menu' => 'Vales Aprobados', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuVales['index'], 'url' => "$menuVales[url]/aprobadas", 'icon' => 'IconFileCheck', 'show_counter' => 1, 'counter_name' => 'vouchersApproved', 'others_permissions' => 'Exportar Todas Las Solicitudes En PDF', 'read_only' => 0, 'active' => 1],
            ['id' => 29, 'menu' => 'Vales Cancelados', 'caption' => '', 'type' => 'item', 'belongs_to' => $menuVales['index'], 'url' => "$menuVales[url]/canceladas", 'icon' => 'IconFilesOff', 'show_counter' => 1, 'counter_name' => 'vouchersCanceled', 'others_permissions' => null, 'read_only' => 0, 'active' => 1],
        ];

        // Recalcular el order automáticamente por belongs_to
        $groupOrders = [];
        foreach ($menus as &$menu) {
            $belongsTo = $menu['belongs_to'];
            if (!isset($groupOrders[$belongsTo])) {
                $groupOrders[$belongsTo] = 0;
            }
            $groupOrders[$belongsTo]++;
            $menu['order'] = $groupOrders[$belongsTo];
        }
        unset($menu);

        // Preparar los datos finales con timestamps
        $data = [];
        foreach ($menus as $menu) {
            $data[] = [
                'id' => $menu['id'],
                'menu' => $menu['menu'],
                'caption' => $menu['caption'],
                'type' => $menu['type'],
                'belongs_to' => $menu['belongs_to'],
                'url' => $menu['url'],
                'icon' => $menu['icon'],
                'order' => $menu['order'],
                'show_counter' => $menu['show_counter'],
                'counter_name' => $menu['counter_name'],
                'others_permissions' => $menu['others_permissions'],
                'read_only' => $menu['read_only'],
                'active' => $menu['active'],
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ];
        }

        // Insertar todos los registros
        DB::table('menus')->insert($data);

        $this->command->info('Menús insertados correctamente (' . count($data) . ' registros) con órdenes reiniciados por belongs_to.');

        // $menuDashboard = 1;
        // $menuAdmin = 3;
        // $menuGarage = 15;
        // $menuCove = 19;

        // // DASHBOARD
        // $order = 0;
        // DB::table('menus')->insert([ #1
        //     'menu' => 'Dashboard',
        //     'caption' => '',
        //     'type' => 'group',
        //     'belongs_to' => 0,
        //     'order' => 1,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #2 Buscador
        //     'menu' => 'Buscador',
        //     'caption' => '',
        //     'type' => 'item',
        //     'belongs_to' => $menuDashboard,
        //     'url' => '/admin',
        //     'icon' => 'IconSearch',
        //     'order' => $order,
        //     'others_permissions' => "2@Solicitar Servicio,2@Asignar Vehículo,2@Prestar Vehículo,2@Devolver Prestamo,2@Devolver Vehículo",
        //     'created_at' => now(),
        // ]);

        // // ADMINISTRATIVO
        // $order = 0;
        // DB::table('menus')->insert([ #3
        //     'menu' => 'Administrativo',
        //     'caption' => 'Control de usuarios',
        //     'type' => 'group',
        //     'belongs_to' => 0,
        //     'order' => 2,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #4 Menus
        //     'menu' => 'Menus',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/menus',
        //     'icon' => 'IconCategory2',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #5 Roles
        //     'menu' => 'Roles y Permisos',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/roles-y-permisos',
        //     'icon' => 'IconPaperBag',
        //     'order' => $order,
        //     'others_permissions' => "5@Asignar Permisos",
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #6 Departamentos
        //     'menu' => 'Departamentos',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/departamentos',
        //     'icon' => 'IconBuildingSkyscraper',
        //     'order' => $order,
        //     'active' => false,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #7 Usuarios
        //     'menu' => 'Usuarios',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/usuarios',
        //     'icon' => 'IconUsers',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #8 Administradores
        //     'menu' => 'Administradores',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/administradores',
        //     'icon' => 'IconUsers',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #9 Encargado de Almacen
        //     'menu' => 'Encargados de Almacen',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/encargados-de-almacen',
        //     'icon' => 'IconUsers',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #10 Mecánicos
        //     'menu' => 'Mecánicos',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/mecanicos',
        //     'icon' => 'IconUsers',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #11 Directores
        //     'menu' => 'Directores',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/directores',
        //     'icon' => 'IconUsers',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #12 Conductores
        //     'menu' => 'Conductores',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/conductores',
        //     'icon' => 'IconUsers',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #13 Admins de Vales
        //     'menu' => 'Admins de Vales',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/admins-de-vales',
        //     'icon' => 'IconUsers',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #14 Solciitadores de Vales
        //     'menu' => 'Solicitadores de Vales',
        //     'type' => 'item',
        //     'belongs_to' => $menuAdmin,
        //     'url' => '/admin/solicitadores-de-vales',
        //     'icon' => 'IconUsers',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);

        // // TALLER
        // $order = 0;
        // DB::table('menus')->insert([ #15
        //     'menu' => 'Taller',
        //     'caption' => 'Catálogos del Taller',
        //     'type' => 'group',
        //     'belongs_to' => 0,
        //     'order' => 3,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #16 Almacen (Stock)
        //     'menu' => 'Almacen (Stock)',
        //     'type' => 'item',
        //     'belongs_to' => $menuGarage,
        //     'url' => '/admin/taller/almacen',
        //     'icon' => 'IconBuildingWarehouse',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #17 Servicios
        //     'menu' => 'Servicios',
        //     'type' => 'item',
        //     'belongs_to' => $menuGarage,
        //     'url' => '/admin/taller/servicios',
        //     'icon' => 'IconTool',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #18 Requisiciones
        //     'menu' => 'Requisiciones - PENDIENTE',
        //     'type' => 'item',
        //     'belongs_to' => $menuGarage,
        //     'url' => '/admin/taller/requisiciones',
        //     'icon' => 'IconFileInvoice',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);

        // // CoVe
        // $order = 0;
        // DB::table('menus')->insert([ #19
        //     'menu' => 'CoVe',
        //     'caption' => 'Control Vehicular',
        //     'type' => 'group',
        //     'belongs_to' => 0,
        //     'order' => 4,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #20 Marcas
        //     'menu' => 'Marcas',
        //     'type' => 'item',
        //     'belongs_to' => $menuCove,
        //     'url' => '/admin/cove/marcas',
        //     'icon' => 'IconBadgeTm',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #21 Modelos
        //     'menu' => 'Modelos',
        //     'type' => 'item',
        //     'belongs_to' => $menuCove,
        //     'url' => '/admin/cove/modelos',
        //     'icon' => 'IconBoxModel2',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #22 Estatus de Vehículo
        //     'menu' => 'Estatus de Vehículos',
        //     'type' => 'item',
        //     'belongs_to' => $menuCove,
        //     'url' => '/admin/cove/estatus-vehiculo',
        //     'icon' => 'IconStatusChange',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #23 Vehículos
        //     'menu' => 'Vehículos',
        //     'type' => 'item',
        //     'belongs_to' => $menuCove,
        //     'url' => '/admin/cove/vehiculos',
        //     'icon' => 'IconCar',
        //     'order' => $order,
        //     'created_at' => now(),
        // ]);
        // $order += 1;
        // DB::table('menus')->insert([ #24 Control de vales
        //     'menu' => 'Control de Vales',
        //     'type' => 'item',
        //     'belongs_to' => $menuCove,
        //     'url' => '/admin/cove/vales',
        //     'icon' => 'IconTicket',
        //     'order' => $order,
        //     'others_permissions' => "24@Aprobar Vale, 24@Cancelar Vale",
        //     'created_at' => now(),
        // ]);
    }
}


// INSERT INTO menus VALUES
// (1,'Dashboard','','group',0,null,null,1,0,1,'2023-11-05 01:55:45',null,null),
// (2,'Buscador','','item',1,'/admin','IconSearch',1,0,1,'2023-11-05 01:55:45',null,null),
// (3,'Administrativo','Control de usuarios','group',0,null,null,2,0,1,'2023-11-05 01:55:45',null,null),
// (4,'Usuarios','','item',3,'/admin/usuarios','IconUsers',1,0,1,'2023-11-05 01:55:45',null,null),
// (5,'Roles','','item',3,'/admin/roles','IconPaperBag',2,0,1,'2023-11-05 01:55:45',null,null),
// (6,'Departamentos','','item',3,'/admin/departamentos','IconBuildingSkyscraper',3,0,1,'2023-11-05 01:55:45',null,null),
// (7,'Menus','','item',3,'/admin/menus','IconCategory2',4,0,1,'2023-11-05 01:55:45',null,null),
// (8,'Taller','Catálogos del Taller','group',0,null,null,3,0,1,'2023-11-05 01:55:45',null,null),
// (9,'Almacen (Stock)','','item',8,'/admin/taller/almacen','IconCarGarage',1,0,1,'2023-11-05 01:55:45',null,null),
// (10,'Servicios','','item',8,'/admin/taller/servicios','IconTool',2,0,1,'2023-11-05 01:55:45',null,null),
// (11,'Requisiones - PENDIENTE','','item',8,'/admin/taller/requisiciones','IconFileInvoice',3,0,1,'2023-11-05 01:55:45',null,null),
// (12,'CoVe','Control Vehicular','group',0,null,null,4,0,1,'2023-11-05 01:55:45',null,null),
// (13,'Marcas','','item',12,'/admin/cove/marcas','IconBadgeTm',1,0,1,'2023-11-05 01:55:45',null,null),
// (14,'Modelos','','item',12,'/admin/cove/modelos','IconBoxModel2',2,0,1,'2023-11-05 01:55:45',null,null),
// (15,'Estatus de Vehículos','','item',12,'/admin/cove/estatus-vehiculo','IconStatusChange',3,0,1,'2023-11-05 01:55:45',null,null),
// (16,'Vehículos','','item',12,'/admin/cove/vehiculos','IconCar',3,0,1,'2023-11-05 01:55:45',null,null);