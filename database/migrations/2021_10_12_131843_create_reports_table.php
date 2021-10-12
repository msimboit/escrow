<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('transaction_initiation_time');
            $table->string('transaction_completion_time')->nullable();
            $table->integer('tariff')->nullable();
            $table->string('goods_price')->nullable();
            $table->string('buyer_sent_amount')->nullable();
            $table->string('buyer_sent_mpesa_code')->nullable();
            $table->integer('sms_count')->nullable();
            $table->string('vendor_received_amount')->nullable();
            $table->string('buyer_received_amount')->nullable();
            $table->string('escrow_sent_mpesa_code')->nullable();
            $table->string('mpesa_charge')->nullable();
            $table->integer('escrow_fee')->nullable();
            $table->string('transaction_status')->nullable();

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
        Schema::dropIfExists('reports');
    }
}
