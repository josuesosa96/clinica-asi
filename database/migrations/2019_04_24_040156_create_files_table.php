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
            $table->string('number', 15);
            $table->string('names', 60);
            // $table->string('first_name', 60);
            // $table->string('second_name', 60);
            $table->string('first_lastname', 60);
            $table->string('second_lastname', 60);
            $table->date('birthdate');
            $table->smallInteger('age');
            $table->char('sex', 1);
            $table->string('dui', 10)->nullable();
            $table->string('nit', 17)->nullable();
            $table->string('responsible_name', 150)->nullable();
            $table->string('responsible_phone_number', 9)->nullable();
            $table->string('address', 255);
            $table->string('phone_number', 9)->nullable();
            $table->text('allergies')->nullable();
            $table->text('done_tests')->nullable();
            $table->date('appointment_date')->nullable();
            $table->text('symptoms');
            $table->text('diagnosis')->nullable();
            $table->text('todo_tests')->nullable();
            $table->text('results')->nullable();
            $table->text('treatment')->nullable();

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
