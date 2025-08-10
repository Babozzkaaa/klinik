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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade');
            $table->foreignId('kasir_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('no_pembayaran')->unique();
            $table->decimal('total_tagihan', 15, 2);
            $table->decimal('jumlah_dibayar', 15, 2);
            $table->decimal('kembalian', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->string('status')->default('pending');
            $table->dateTime('tanggal_pembayaran');
            $table->enum('metode_pembayaran', ['cash', 'debit', 'kredit']);
            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
