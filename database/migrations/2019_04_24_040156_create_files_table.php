<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->increments('number')->unique();
            $table->smallInteger('age');
            $table->string('address', 255);
            $table->string('phone_number', 60)->nullable();
            $table->text('allergies')->nullable();
            $table->text('done_tests')->nullable();
            $table->dateTime('appointment_date');
            $table->text('symptoms');
            $table->text('diagnosis')->nullable();
            $table->text('todo_tests')->nullable();
            $table->text('results')->nullable();
            $table->text('treatment');

            //foreing keys
            $table->unsignedInteger('general_doctor_id');
            $table->foreign('general_doctor_id')->references('id')->on('users');
            $table->unsignedInteger('specialist_doctor_id')->nullable();
            $table->foreign('specialist_doctor_id')->references('id')->on('users');


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
        Schema::dropIfExists('files');
    }
}
