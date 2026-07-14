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
        // Schema::create('mechanics', function (Blueprint $table) {
        //     $table->id();
        //     // $table->foreignId('user_id')->constrained('users','id');
        //     $table->string('employee_code')->nullable();
        //     $table->string('avatar')->nullable();
        //     $table->string('name');
        //     $table->string('plast_name');
        //     $table->string('mlast_name');
        //     $table->string('email')->nullable();
        //     $table->string('cellphone')->nullable();
        //     // $table->string('department');
        //     $table->boolean('active')->default(true);
        //     $table->timestamps();
        //     $table->dateTime('deleted_at')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('mechanics');
    }
};
