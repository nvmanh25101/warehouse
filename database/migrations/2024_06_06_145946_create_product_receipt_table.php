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
        Schema::create('product_receipt', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained();
            $table->foreignId('receipt_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_id', 'receipt_id']);
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_receipt');
    }
};
