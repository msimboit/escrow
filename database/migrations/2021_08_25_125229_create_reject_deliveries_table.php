<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reject_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('details')->nullable();
            $table->string('clientName');
            $table->string('clientNumber');
            $table->string('clientEmail');
            $table->string('vendorName');
            $table->string('vendorNumber');
            $table->string('vendorEmail');
            $table->string('orderId');
            $table->string('orderdate');
            $table->string('transdetail');
            $table->string('quantity');
            $table->string('subtotal');
            $table->string('tariff');
            $table->string('total');
            $table->string('deliveryfee');
            $table->boolean('resolved')->default(0);
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
        Schema::dropIfExists('reject_deliveries');
    }
}
