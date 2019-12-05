<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('kd_brg')->primary();
            $table->string('kd_kategori');
            $table->foreign('kd_kategori')->references('kd_kategori')->on('kategoris')->onUpdate('cascade')->onDelete('set null');
            $table->string('nm_brg');
            $table->integer('harga');
            $table->string('berat');
            $table->string('bahan');
            $table->integer('stok');
            $table->string('usia');
            $table->string('gambar');
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

        Schema::dropIfExists('barangs');
    }
}
