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
            "CREATE OR REPLACE VIEW vw_vehicle_movements_log AS
            SELECT vml.*, us.username sys_user, vs.vehicle_status, vs.bg_color, vs.letter_black, vs.description vehicle_status_description,
            -- de la tabla vehicle que pongo?... la vinculo con detail_vehicle_view?
            ua.username active_user
            FROM vehicle_movements_log vml
            INNER JOIN users us ON vml.user_id=us.id
            INNER JOIN vehicle_status vs ON vml.vehicle_status_id=vs.id
            INNER JOIN vehicles v ON vml.vehicle_id=v.id
            LEFT JOIN users ua ON vml.active_user_id=ua.id
            ORDER BY vml.id DESC, vml.created_at DESC
            ;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_vehicle_movements_log');
    }
};