<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_user_employee AS
            SELECT
                u.id,
                u.id AS user_id,
                u.username,
                u.email,
                u.password,
                u.role_id,
                r.role,
                r.read,
                r.create,
                r.update,
                r.delete,
                r.more_permissions,
                r.page_index,
                u.gpc_employee_id,
                u.active,
                u.created_at,
                u.updated_at,
                u.deleted_at,
                e.employee_code COLLATE utf8mb4_unicode_ci AS employee_code,
                e.hire_date,
                e.employee_active,
                e.name COLLATE utf8mb4_unicode_ci AS name,
                e.plast_name COLLATE utf8mb4_unicode_ci AS plast_name,
                e.mlast_name COLLATE utf8mb4_unicode_ci AS mlast_name,
                e.full_name COLLATE utf8mb4_unicode_ci AS full_name,
                e.full_name_reverse COLLATE utf8mb4_unicode_ci AS full_name_reverse,
                e.rfc COLLATE utf8mb4_unicode_ci AS rfc,
                e.curp COLLATE utf8mb4_unicode_ci AS curp,
                e.cellphone COLLATE utf8mb4_unicode_ci AS cellphone,
                e.gender COLLATE utf8mb4_unicode_ci AS gender,
                e.avatar COLLATE utf8mb4_unicode_ci AS avatar,
                e.signature_image COLLATE utf8mb4_unicode_ci AS signature_image,
                e.position_uuid COLLATE utf8mb4_unicode_ci AS position_uuid,
                e.position_name COLLATE utf8mb4_unicode_ci AS position_name,
                e.department_uuid COLLATE utf8mb4_unicode_ci AS department_uuid,
                e.department_name COLLATE utf8mb4_unicode_ci AS department_name,
                e.department_name COLLATE utf8mb4_unicode_ci AS `department`,
                e.department_logo COLLATE utf8mb4_unicode_ci AS department_logo,
                e.seal_image COLLATE utf8mb4_unicode_ci AS seal_image,
                e.organization_name COLLATE utf8mb4_unicode_ci AS organization_name,
                e.administration_name COLLATE utf8mb4_unicode_ci AS administration_name,
                e.president_name COLLATE utf8mb4_unicode_ci AS president_name,
                e.administration_logo COLLATE utf8mb4_unicode_ci AS administration_logo,
                ed.license_number,
                ed.license_type,
                ed.license_due_date,
                ed.img_license,
                ed.community_id,
                ed.street,
                ed.num_ext,
                ed.num_int
            FROM users u
            INNER JOIN roles r ON u.role_id = r.id
            LEFT JOIN vw_employees_gpc e ON u.gpc_employee_id = e.employee_id
            LEFT JOIN employee_details ed ON u.gpc_employee_id = ed.gpc_employee_id
        ");

        DB::statement("CREATE OR REPLACE VIEW vw_directors AS SELECT * FROM vw_user_employee WHERE role_id = 5");
        DB::statement("CREATE OR REPLACE VIEW vw_drivers AS SELECT * FROM vw_user_employee WHERE role_id = 6");
        DB::statement("CREATE OR REPLACE VIEW vw_voucher_requesters AS SELECT * FROM vw_user_employee WHERE role_id = 8");
        DB::statement("CREATE OR REPLACE VIEW vw_mechanics AS SELECT * FROM vw_user_employee WHERE role_id = 4");
        DB::statement("CREATE OR REPLACE VIEW vw_workshop_managers AS SELECT * FROM vw_user_employee WHERE role_id = 2");
        DB::statement("CREATE OR REPLACE VIEW vw_voucher_supervisors AS SELECT * FROM vw_user_employee WHERE role_id = 9");
        DB::statement("CREATE OR REPLACE VIEW vw_voucher_admins AS SELECT * FROM vw_user_employee WHERE role_id = 7");
        DB::statement("CREATE OR REPLACE VIEW vw_patrimony AS SELECT * FROM vw_user_employee WHERE role_id = 11");
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS vw_patrimony');
        DB::statement('DROP VIEW IF EXISTS vw_voucher_admins');
        DB::statement('DROP VIEW IF EXISTS vw_voucher_supervisors');
        DB::statement('DROP VIEW IF EXISTS vw_workshop_managers');
        DB::statement('DROP VIEW IF EXISTS vw_mechanics');
        DB::statement('DROP VIEW IF EXISTS vw_voucher_requesters');
        DB::statement('DROP VIEW IF EXISTS vw_drivers');
        DB::statement('DROP VIEW IF EXISTS vw_directors');
        DB::statement('DROP VIEW IF EXISTS vw_user_employee');
    }
};
