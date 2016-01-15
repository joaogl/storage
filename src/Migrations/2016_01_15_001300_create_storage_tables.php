<?php

use Illuminate\Database\Migrations\Migration;
use \jlourenco\base\Database\Blueprint;

class CreateStorageTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('File', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('stored_name', 150);
            $table->string('entity', 150);
            $table->integer('registry');
            $table->string('extension', 50);
            $table->text('description')->nullable();
            $table->integer('uploaded_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('uploaded_by')->references('id')->on('User');
        });

        Schema::create('FileGroup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('description', 250);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('File_FileGroup', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file')->unsigned();
            $table->integer('filegroup')->unsigned();

            $table->foreign('file')->references('id')->on('File');
            $table->foreign('filegroup')->references('id')->on('FileGroup');
        });

        Schema::create('File_Tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file')->unsigned();
            $table->integer('tag')->unsigned();

            $table->foreign('file')->references('id')->on('File');
            $table->foreign('tag')->references('id')->on('Tag');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('File_FileGroup');
        Schema::drop('File');
        Schema::drop('FileGroup');
        Schema::drop('File_Tag');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
