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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('folio');
            $table->foreignId('vehicle_id')->constrained('vehicles', 'id');
            $table->string('contact_name');
            $table->string('contact_cellphone');
            $table->text('pre_diagnosis')->comment("lo que el usuario le dice al mecanico");
            $table->text('final_diagnosis')->nullable()->comment("lo que el mecanico determina despues de revisarlo");
            $table->string('evidence_img_path')->nullable()->comment("por si desea subir foto NO CONTEMPLADO AUN");
            $table->foreignId('mechanic_id')->constrained('users', 'id')->nullable()->comment("Usuario que recibe y revisa la unidad");
            $table->enum('status', ['ABIERTA', 'APROBADA', 'RECHAZADA', 'EN REVISIÓN', 'APROBADA POR CV', 'RECHAZADA POR CV', 'CERRADA'])->default("ABIERTA");
            $table->foreignId('requested_by')->constrained('users', 'id')->nullable()->comment("Usuario director que solicita el servicio");
            $table->dateTime('requested_at')->nullable();
            $table->foreignId('approved_by')->constrained('users', 'id')->nullable()->comment("Usuario control vehicular que aprueba el servicio");
            $table->dateTime('approved_at')->nullable();
            $table->foreignId('reviewed_by')->constrained('users', 'id')->nullable()->comment("Usuario mecanico que revisa la unidad");
            $table->dateTime('reviewed_at')->nullable();
            $table->foreignId('rejected_by')->constrained('users', 'id')->nullable()->comment("Usuario control vehicular que rechaza el servicio");
            $table->dateTime('rejected_at')->nullable();
            $table->foreignId('confirmed_by')->constrained('users', 'id')->nullable()->comment("Usuario control vehicular que rechaza el servicio");
            $table->dateTime('confirmed_at')->nullable();
            $table->boolean('request_material')->default(true);
            $table->dateTime('closed_at')->nullable();

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
        Schema::dropIfExists('services');
    }
};
