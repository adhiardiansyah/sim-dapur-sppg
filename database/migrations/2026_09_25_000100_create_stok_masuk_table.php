<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_id')->constrained('bahan_baku')->cascadeOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('supplier')->nullOnDelete();
            $table->decimal('jumlah', 14, 3);
            $table->decimal('harga_satuan', 14, 2)->nullable();
            $table->date('tanggal');
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_masuk');
    }
};
