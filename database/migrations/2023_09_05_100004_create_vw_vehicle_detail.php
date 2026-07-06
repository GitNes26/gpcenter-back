<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_vehicle_detail AS
            SELECT v.*,
                b.brand, b.img_path AS brand_img,
                m.model,
                vs.vehicle_status, vs.bg_color, vs.letter_black, vs.description AS vehicle_status_description,
                vp.plates, vp.initial_date, vp.due_date, vp.expired
            FROM vehicles v
            JOIN brands b ON v.brand_id = b.id
            JOIN models m ON v.model_id = m.id
            JOIN vehicle_status vs ON v.vehicle_status_id = vs.id
            LEFT JOIN vehicle_plates vp ON v.id = vp.vehicle_id AND vp.expired = 0
        ");
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS vw_vehicle_detail');
    }
};
