<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_user', function (Blueprint $table) {
          $table->string('kd_brg');
          $table->foreign('kd_brg')->references('kd_brg')->on('barangs');
          $table->unsignedInteger('id');
          $table->foreign('id')->references('id')->on('users');
          $table->integer('jumlah')->default(1);
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
      Schema::table('barang_user', function (Blueprint $table) {
       $table->dropForeign(['kd_brg']);
       $table->dropForeign(['id']);
       $table->dropColumn(['kd_brg','id']);
   });
        Schema::dropIfExists('barang_user');

    }
}
