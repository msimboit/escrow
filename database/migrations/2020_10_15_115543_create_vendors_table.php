<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename');
             $table->string('lastname');
             $table->string('IdNo') ->unique();
             $table->string('phoneno')->unique();;
             $table->string('email')->unique();
             $table->string('country');
             $table->string('physicaladdress');
             $table->decimal('vendor_long',11,8);
             $table->decimal('vendor_lat',10,8);
             $table->boolean('acceptedtnc')->default(0);
             $table->boolean('verified')->default(0);
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
        Schema::dropIfExists('vendors');
    }
}
