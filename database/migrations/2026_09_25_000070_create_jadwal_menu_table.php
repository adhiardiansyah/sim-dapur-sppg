<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_menu', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('menu_id')->constrained('menu')->cascadeOnDelete();
            $table->integer('jumlah_porsi');
            $table->enum('status', ['direncanakan', 'diproduksi', 'selesai'])->default('direncanakan');
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_menu');
    }
};
