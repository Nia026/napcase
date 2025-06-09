<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon');
            $table->text('alamat');
            $table->unsignedBigInteger('metode_pembayaran_id');
            $table->string('bukti_pembayaran');
            $table->decimal('total', 12, 2);
            $table->enum('status', [
                'transaksi terkirim ke admin',
                'admin konfirmasi transaksi',
                'admin menyiapkan produk',
                'produk diserahkan ke kurir',
                'produk dalam perjalanan'
            ])->default('transaksi terkirim ke admin');
            $table->timestamps();

            $table->foreign('metode_pembayaran_id')->references('id')->on('metode_pembayarans');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
