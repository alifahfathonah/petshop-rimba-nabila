<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('kd_trans')->primary();
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('total_beli');
            $table->integer('ongkir');
            $table->integer('grand_biaya');
            $table->string('status');
            $table->string('bukti');
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

        Schema::dropIfExists('transactions');

    }
}
