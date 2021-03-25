<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abanks', function (Blueprint $table) {
            $table->id();
            $table->string('bank');
            $table->string('bankname');
            $table->string('bankbranch');
            $table->string('bankaddress');
            $table->string('contact');
            $table->string('email');
            $table->string('swiftcode');
            $table->string('accountno');
            $table->string('accountname');
            $table->string('paybill');
            $table->decimal('long',11,8);
            $table->decimal('lat',10,8);
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
        Schema::dropIfExists('abanks');
    }
}
