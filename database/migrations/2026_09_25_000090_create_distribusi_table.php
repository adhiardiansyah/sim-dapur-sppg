<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produksi_id')->constrained('produksi')->cascadeOnDelete();
            $table->foreignId('sekolah_id')->constrained('sekolah')->cascadeOnDelete();
            $table->integer('jumlah_porsi');
            $table->time('jam_berangkat')->nullable();
            $table->time('jam_tiba')->nullable();
            $table->enum('status', ['dijadwalkan', 'dikirim', 'diterima'])->default('dijadwalkan');
            $table->text('catatan')->nullable();
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusi');
    }
};
