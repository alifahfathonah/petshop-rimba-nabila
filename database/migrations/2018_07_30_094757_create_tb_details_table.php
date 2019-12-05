<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_details', function (Blueprint $table) {
            $table->string('kd_trans');
            $table->foreign('kd_trans')->references('kd_trans')->on('transactions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('kd_brg');
            $table->foreign('kd_brg')->references('kd_brg')->on('barangs')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('hrg_brg');
            $table->integer('jml_brg');
            $table->integer('total');
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
        Schema::drop('tb_details');
        Schema::dropIfExists('tb_details');
    }
}
