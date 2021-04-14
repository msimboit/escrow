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
                $table->string('itemdetail')->nullable();
                $table->integer('quantity')->nullable();
                $table->decimal('price')->nullable();
                $table->string('image')->nullable();
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
