<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $host = config('database.connections.mysql_gpcentral.host');
        $port = config('database.connections.mysql_gpcentral.port');
        $database = config('database.connections.mysql_gpcentral.database');
        $username = config('database.connections.mysql_gpcentral.username');
        $password = config('database.connections.mysql_gpcentral.password');

        $connectionString = "mysql://{$username}:{$password}@{$host}:{$port}/{$database}/vw_employees";

        // dump("HOST: $host");
        // dump("PORT: $port");
        // dump("DATABASE: $database");
        // dump("USERNAME: $username");
        // dd("CONNECTION STRING: $connectionString");

        DB::statement("
            CREATE TABLE IF NOT EXISTS vw_employees_gpc (
                employee_id BIGINT UNSIGNED,
                employee_code VARCHAR(50),
                hire_date DATE,
                employee_active TINYINT(1),
                name VARCHAR(255),
                plast_name VARCHAR(255),
                mlast_name VARCHAR(255),
                full_name TEXT,
                full_name_reverse TEXT,
                rfc VARCHAR(20),
                curp VARCHAR(20),
                cellphone VARCHAR(50),
                gender ENUM('M','F'),
                avatar VARCHAR(255),
                signature_image VARCHAR(255),
                assignment_id BIGINT UNSIGNED,
                position_uuid CHAR(36),
                position_start DATE,
                position_end DATE,
                position_active TINYINT(1),
                position_name VARCHAR(255),
                position_office_phone VARCHAR(50),
                position_ext VARCHAR(20),
                department_uuid CHAR(36),
                department_name VARCHAR(255),
                department_logo VARCHAR(255),
                seal_image VARCHAR(255),
                organization_id BIGINT UNSIGNED,
                organization_name VARCHAR(255),
                administration_id BIGINT UNSIGNED,
                administration_name VARCHAR(255),
                president_name VARCHAR(255),
                administration_logo VARCHAR(255),
                user_id BIGINT UNSIGNED,
                username VARCHAR(255),
                email VARCHAR(255),
                active TINYINT(1)
            ) ENGINE=FEDERATED
            CONNECTION='{$connectionString}'
        ");
    }

    public function down()
    {
        Schema::dropIfExists('vw_employees_gpc');
    }
};