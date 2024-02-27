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
        Schema::table('detail_penjualans', function (Blueprint $table) {
            $table->unsignedBigInteger('transaksi_id')->after('id')->nullable()->after('jumlah');
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_penjualans', function (Blueprint $table) {
            
        });
    }
};
