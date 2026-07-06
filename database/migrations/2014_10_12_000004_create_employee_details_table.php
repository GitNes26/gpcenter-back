<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->integer('gpc_employee_id')->comment('ID del empleado en GPCentral (sistema central)');

            $table->string('license_number')->nullable();
            $table->string('license_type')->nullable();
            $table->date('license_due_date')->nullable();
            $table->string('img_license')->nullable();
            $table->integer('community_id')->default(0)->comment("ID de la comunidad en la API que por medio del C.P. nos arroja de estado a colonia");
            $table->string('street')->nullable();
            $table->string('num_ext')->default("S/N");
            $table->string('num_int')->nullable()->default("S/N");
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_details');
    }
};
