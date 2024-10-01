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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nomor_po');
            $table->string('nomor_penawaran');
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('kontak_id')->nullable()->constrained('kontaks')->cascadeOnDelete();
            $table->date('tanggal_pengiriman')->nullable();
            $table->decimal('total_po',12,2);
            $table->decimal('ppn',12,2)->nullable();
            $table->decimal('diskon',12,2)->nullable();
            $table->decimal('total_bayar',14,2)->nullable();
            $table->decimal('biaya_kirim',12,2)->nullable();
            $table->string('status')->default('draft');
            $table->longText('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
