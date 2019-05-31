<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoneTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('done_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->text('results');

            //foreign keys
            $table->unsignedInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests');
            $table->unsignedInteger('todo_test_id');
            $table->foreign('todo_test_id')->references('id')->on('todo_tests');
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');
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
        Schema::dropIfExists('done_tests');
    }
}
