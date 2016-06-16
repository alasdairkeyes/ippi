<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ip_range_id')->unsigned();
            $table->string('address');
            $table->string('hostname');
            $table->string('description')->isNullable();
            $table->timestamps();
            $table->foreign('ip_range_id')
                  ->references('id')->on('ip_ranges')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ip_addresses');
    }
}
