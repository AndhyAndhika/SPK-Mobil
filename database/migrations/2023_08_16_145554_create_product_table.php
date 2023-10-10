<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->nullable();
            $table->string('nama')->nullable();
            $table->string('type')->nullable();
            $table->integer('price')->nullable();
            $table->integer('kode_price')->default(1);
            $table->string('eksterior')->nullable();
            $table->integer('kode_eksterior')->default(1);
            $table->string('kapasitas_cc')->nullable();
            $table->integer('kode_kapasitas_cc')->default(1);
            $table->string('dimensi')->nullable();
            $table->integer('kode_dimensi')->default(1);
            $table->string('kapasitas_orang')->nullable();
            $table->integer('kode_kapasitas_orang')->default(1);
            $table->string('safety')->nullable();
            $table->integer('kode_safety')->default(1);
            $table->string('interior')->nullable();
            $table->integer('kode_interior')->default(1);
            $table->string('velg')->nullable();
            $table->integer('kode_velg')->default(1);
            $table->string('fitur_tambahan')->nullable();
            $table->integer('kode_fitur_tambahan')->default(1);
            $table->string('warna_tersedia')->nullable();
            $table->integer('kode_warna_tersedia')->default(1);
            $table->integer('kode_sumber_pendapatan')->default(1);
            $table->integer('kode_lokasi_tinggal')->default(1);
            $table->integer('kode_kepemilikan_kendaraan')->default(1);
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
        Schema::dropIfExists('product');
    }
}
