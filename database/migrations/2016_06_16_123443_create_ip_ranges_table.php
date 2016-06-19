<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_ranges', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('ip_version', array('4','6'));
            $table->string('network','39');
            $table->string('cidr', '4');
            $table->integer('owner_id')->unsigned();
            $table->timestamps();

            $table->unique([
                'owner_id', 'network', 'cidr',
            ]);
            $table->foreign('owner_id')
                  ->references('id')->on('owners')
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
        Schema::drop('ip_ranges');
    }
}
