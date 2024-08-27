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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_jalan_id')
                ->constrained('surat_jalans')
                ->cascadeOnDelete();
            $table->foreignId('produk_id')
                ->constrained('produks')
                ->cascadeOnDelete();
            $table->decimal('qty',8,0);
            $table->foreignId('satuan_id')
                    ->constrained('satuans')
                    ->cascadeOnDelete();
            $table->string('deskripsi')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
