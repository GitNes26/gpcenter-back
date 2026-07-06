<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(
            "CREATE PROCEDURE `sp_vehicle_history`(IN in_vehicle_id INT)
                BEGIN
                    SELECT vm.*, 
                        vh.vehicle_status AS old_vehicle_status, 
                        ta.km_assignment AS km, 
                        ta.user_id, 
                        u.username
                    FROM vehicle_movements vm
                    INNER JOIN vehicle_status vh ON vm.old_vehicle_status_id = vh.id
                    INNER JOIN assigned_vehicles ta ON vm.table_assoc = 'assigned_vehicles' 
                                                    AND vm.table_assoc_register_id = ta.id
                    INNER JOIN users u ON ta.user_id = u.id
                    WHERE vm.vehicle_id = in_vehicle_id
                    
                    UNION

                    SELECT vm.*, 
                        vh.vehicle_status AS old_vehicle_status, 
                        if(ta.active_loan=0,ta.initial_km,ta.delivery_km) AS km, -- ta.initial_km AS km, -- ta.initial_km  | ta.delivery_km
                        ta.requesting_user_id, 
                        u.username
                    FROM vehicle_movements vm
                    INNER JOIN vehicle_status vh ON vm.old_vehicle_status_id = vh.id
                    INNER JOIN loaned_vehicles ta ON vm.table_assoc = 'loaned_vehicles'
                                                    AND vm.table_assoc_register_id = ta.id
                    INNER JOIN users u ON ta.requesting_user_id = u.id
                    WHERE vm.vehicle_id = in_vehicle_id
                    
                    UNION

                    SELECT vm.*, 
                        vh.vehicle_status AS old_vehicle_status, 
                        0 AS km, 
                        ta.mechanic_id, 
                        u.username
                    FROM vehicle_movements vm
                    INNER JOIN vehicle_status vh ON vm.old_vehicle_status_id = vh.id
                    INNER JOIN services ta ON vm.table_assoc = 'services'
                                            AND vm.table_assoc_register_id = ta.id
                    LEFT JOIN users u ON ta.mechanic_id = u.id
                    WHERE vm.vehicle_id = in_vehicle_id
                    
                    UNION

                    SELECT vm.*, 
                        vh.vehicle_status AS old_vehicle_status, 
                        ta.km_deliver AS km, 
                        av.user_id, 
                        u.username
                    FROM vehicle_movements vm
                    INNER JOIN vehicle_status vh ON vm.old_vehicle_status_id = vh.id
                    INNER JOIN delivered_vehicles ta ON vm.table_assoc = 'delivered_vehicles'
                                                    AND vm.table_assoc_register_id = ta.id
                    INNER JOIN assigned_vehicles av ON ta.assigned_vehicle_id = av.id
                    INNER JOIN users u ON av.user_id = u.id

                    WHERE vm.vehicle_id = in_vehicle_id
                    ORDER BY created_at desc;
                END
            ;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::statement('DROP VIEW IF EXISTS vw_vehicle_movements_log');
    }
};
