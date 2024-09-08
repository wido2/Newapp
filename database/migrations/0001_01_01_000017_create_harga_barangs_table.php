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
        Schema::create('harga_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->nullable()->constrained('produks')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->decimal('harga_kemarin',14,0)->nullable();
            $table->decimal('harga_terbaru',14,0)->nullable();
            $table->date('tahun_kemarin');
            $table->date('tahun_terbaru');
            $table->decimal('perubahan',12,2);
            $table->decimal('status_perubahan',5,2)->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_barangs');
    }
};
