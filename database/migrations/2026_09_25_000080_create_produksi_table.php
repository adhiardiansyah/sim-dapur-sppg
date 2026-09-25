<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->unique()->constrained('jadwal_menu')->cascadeOnDelete();
            $table->date('tanggal');
            $table->integer('porsi_realisasi');
            $table->enum('status', ['berjalan', 'selesai'])->default('berjalan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
