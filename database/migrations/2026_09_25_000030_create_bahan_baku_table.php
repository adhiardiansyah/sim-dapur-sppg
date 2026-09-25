<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('satuan', 20);
            $table->decimal('stok', 14, 3)->default(0);
            $table->decimal('stok_minimum', 14, 3)->default(0);
            $table->decimal('kalori', 10, 2)->nullable();
            $table->decimal('protein', 10, 2)->nullable();
            $table->decimal('karbohidrat', 10, 2)->nullable();
            $table->decimal('lemak', 10, 2)->nullable();
            $table->decimal('harga_referensi', 14, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan_baku');
    }
};
