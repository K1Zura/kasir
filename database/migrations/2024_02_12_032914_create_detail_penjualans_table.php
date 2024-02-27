<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id();
            $table->String('kode_penjualan',11);
            $table->unsignedBigInteger('penjualan_id')->nullable();
            $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('restrict');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('restrict');
            $table->UnsignedInteger('harga')->nullable();
            $table->UnsignedInteger('jumlah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};
