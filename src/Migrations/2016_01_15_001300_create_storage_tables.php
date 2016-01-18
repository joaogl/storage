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

        Schema::create('FileGroup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('description', 250);
        });

        Schema::create('File', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('stored_name', 150);
            $table->string('extension', 50);
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->creation();
        });

        Schema::create('File_FileGroup', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file')->unsigned();
            $table->integer('filegroup')->unsigned();

            $table->foreign('file')->references('id')->on('File');
            $table->foreign('filegroup')->references('id')->on('FileGroup');
        });

        Schema::create('File_Entity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file')->unsigned();

            $table->morphs("entity");
            $table->timestamps();
            $table->softDeletes();
            $table->creation();

            $table->foreign('file')->references('id')->on('File');
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
        Schema::drop('File_Entity');
        Schema::drop('File_FileGroup');
        Schema::drop('File');
        Schema::drop('FileGroup');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
