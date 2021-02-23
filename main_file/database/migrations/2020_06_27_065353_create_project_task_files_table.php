<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTaskFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'project_task_files', function (Blueprint $table){
            $table->id();
            $table->string('file');
            $table->string('name');
            $table->string('extension');
            $table->string('file_size');
            $table->integer('task_id');
            $table->String('user_type');
            $table->integer('created_by');
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_task_files');
    }
}
