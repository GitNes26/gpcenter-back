<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW vw_vouchers_prev AS
        SELECT v.*,
        -- CONCAT(v.name,' ',v.plast_name,' ',v.mlast_name) 'creditor_fullname',
        ua.username 'username_approved', uvb.username 'username_vobo', uv.username 'username_viewed', uc.username 'username_canceled',
        ur.role_id 'requested_role_id', ure.username 'requested_by_name'
        FROM vouchers v
        INNER JOIN users ur ON v.requested_by=ur.id
        LEFT JOIN users uvb ON v.vobo_by=uvb.id
        LEFT JOIN users uv ON v.viewed_by=uv.id
        LEFT JOIN users ua ON v.approved_by=ua.id
        LEFT JOIN users uc ON v.canceled_by=uc.id
        LEFT JOIN users ure ON v.requested_by=ure.id
        WHERE v.active=1
        ;
        ");

        DB::statement("
        CREATE OR REPLACE VIEW vw_vouchers AS
        SELECT vvp.*, u.username 'requested_fullname', 'JEFE DEL DEPARTAMENTO DE CONTROL VEHÍCULAR' as 'workstation', NULL 'signature_image', NULL 'seal_image', 
        NULL 'requested_employee_code', NULL 'requested_department', NULL 'requested_cellphone'
        FROM vw_vouchers_prev vvp INNER JOIN users u ON vvp.requested_by=u.id WHERE vvp.requested_role_id IN (1,7)
        UNION
        SELECT vvp.*, vd.full_name 'requested_fullname', CONCAT('DIRECTOR DEL DEPARTAMENTO DE ',vd.department) 'workstation', vd.signature_image, NULL 'seal_image',
        vd.employee_code 'requested_employee_code', vd.department 'requested_department', vd.cellphone 'requested_cellphone'
        FROM vw_vouchers_prev vvp INNER JOIN vw_directors vd ON vvp.requested_by=vd.user_id WHERE vvp.requested_role_id=5
        UNION
        SELECT vvp.*, vvr.full_name 'requested_fullname', IF(vvr.department like 'Coordi%' or vvr.department like '%Regi%', vvr.department, IF(vvr.department like 'SubSecretaria del R. Ayuntamiento', 'SUBSECRETARIO DEL R. AYUNTAMIENTO',CONCAT('DIRECTOR DEL DEPARTAMENTO DE ',vvr.department)) ) 'workstation', vvr.signature_image, vvr.seal_image,
        vvr.employee_code 'requested_employee_code', vvr.department 'requested_department', vvr.cellphone 'requested_cellphone'
        FROM vw_vouchers_prev vvp INNER JOIN vw_voucher_requesters vvr ON vvp.requested_by=vvr.user_id 
        WHERE vvp.requested_role_id=8 and vvr.active=1
        ;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('DROP VIEW IF EXISTS vw_vouchers');
    }
};
