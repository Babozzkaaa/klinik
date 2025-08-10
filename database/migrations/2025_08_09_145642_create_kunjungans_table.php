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
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('didaftarkan_oleh')->constrained('pegawais')->onDelete('cascade');
            $table->datetime('tanggal_kunjungan');
            $table->enum('jenis_kunjungan', ['umum', 'rujukan', 'kontrol', 'rutin', 'vaksinasi', 'darurat']);
            $table->text('keluhan')->nullable();
            $table->text('diagnosa')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
