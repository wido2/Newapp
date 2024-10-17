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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('alamat_pengiriman')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('nomor_telepon_penerima')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('alamat_pengiriman');
            $table->dropColumn('nama_penerima');
            $table->dropColumn('nomor_telepon_penerima');
        });
    }
};
