<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'settings', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('value');
            $table->integer('created_by');
            $table->timestamps();
            $table->unique(
                [
                    'name',
                    'created_by',
                ]
            );
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
        Schema::dropIfExists('settings');
    }
}
