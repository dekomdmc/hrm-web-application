<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'promotions', function (Blueprint $table){
            $table->id();
            $table->integer('employee_id');
            $table->integer('designation_id');
            $table->string('promotion_title');
            $table->date('promotion_date');
            $table->text('description')->nullable();
            $table->string('created_by');
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
        Schema::dropIfExists('promotions');
    }
}
