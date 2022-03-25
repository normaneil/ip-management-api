<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpAddressHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_address_histories', function (Blueprint $table) {
            $table->id();
            
            $table->text('history');
            $table->bigInteger('ip_address_id')->unsigned()->index(); // this is working
            $table->foreign('ip_address_id')->references('id')->on('ip_addresses')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->index(); // this is working
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('ip_address_histories');
    }
}
