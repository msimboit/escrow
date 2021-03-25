<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dets', function (Blueprint $table) {
            $table->unsignedInteger('tdetails_id');
            $table->unsignedInteger('product_id');
            $table->string('itemdetail');
            $table->integer('quantity');
            $table->decimal('price');
            $table->string('image');
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
        Schema::dropIfExists('dets');
    }
}
