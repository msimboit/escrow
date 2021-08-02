<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdetails', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('client_phone');
            $table->string('transactioncode');
            $table->string('vendor_id');
            $table->string('transdetail');
            $table->string('deliverylocation');
            $table->decimal('deliveryamount');
            $table->string('delivery_fee_handler');
            $table->string('transamount');
            $table->decimal('trans_long',11,8);
            $table->decimal('trans_lat',10,8);
            $table->integer('users_id');
            $table->boolean('validated')->default(0);
            $table->string('deposited')->default(0);
            $table->boolean('delivered')->default(0);
            $table->boolean('closed')->default(0);
            $table->boolean('suspended')->default(0);
            $table->boolean('negotiated')->default(0);
            $table->string('suspensionremarks')->nullable();
            $table->boolean('expired')->default(0);
            $table->boolean('void')->default(0);
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
        Schema::dropIfExists('tdetails');
    }
}
