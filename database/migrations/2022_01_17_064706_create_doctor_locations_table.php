<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_locations', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id');
            $table->string('name');
            $table->text('district_id');
            $table->text('thana_id');
            $table->text('address');
            $table->time('start_time');
            $table->time('end_time');
            $table->bigInteger('consultation_fee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_locations');
    }
}
