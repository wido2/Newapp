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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')
            ->constrained('vendors')
            ->cascadeOnDelete();
            $table->string('nama');
            $table->string('nomor_polisi');
            $table->string('jenis_kendaraan');
            $table->string('merk');
            $table->date('tahun_pembuatan')->nullable();
            $table->string('warna')->nullable();
            $table->string('nomor_rangka')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->string('nomor_stnk')->nullable();
            $table->string('nomor_bpkb')->nullable();
            $table->date('tanggal_stnk')->nullable();
            $table->date('tanggal_bpkb')->nullable();
            $table->json('scan_stnk')->nullable();
            $table->json('scan_bpkb')->nullable();
            $table->json('foto_kendaraan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
