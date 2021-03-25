<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_tdetails', function (Blueprint $table) {
    
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
        Schema::dropIfExists('product_tdetails');
    }
}
