<?php

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
            $table->string('file_id')->unique();
            $table->string('name');
            $table->string('extension')->nullable();
            $table->string('path')->nullable();
            $table->string('mime_type');
            $table->integer('byte_size');
            $table->json('data');
            $table->string('disk');
            $table->dateTime('saved_at');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }
}
