<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_bahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menu')->cascadeOnDelete();
            $table->foreignId('bahan_id')->constrained('bahan_baku')->cascadeOnDelete();
            $table->decimal('jumlah_per_porsi', 12, 3);
            $table->string('satuan', 20)->nullable();
            $table->timestamps();

            $table->unique(['menu_id', 'bahan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_bahan');
    }
};
