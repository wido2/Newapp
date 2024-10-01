<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Livewire\after;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
        $table->foreignId('project_id')->after('vendor_id')->nullable()->constrained('projects')->cascadeOnDelete();
        $table->foreignId('project_item_id')->after('project_id')->nullable()->constrained('project_items')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropForeign(['project_id', 'project_item_id']);
            $table->dropColumn('project_id');
            $table->dropColumn('project_item_id');
           
            //
        });
    }
};
