<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('export_warehouse', function (Blueprint $table) {
            $table->foreignId('warehouse_id')->constrained();
            $table->foreignId('export_id')->constrained()->cascadeOnDelete();
            $table->primary(['warehouse_id', 'export_id']);
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_product');
    }
};
