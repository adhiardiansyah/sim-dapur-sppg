<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BahanBaku extends Model
{
    protected $table = 'bahan_baku';

    protected $guarded = ['id'];

    public function menuBahan(): HasMany
    {
        return $this->hasMany(MenuBahan::class);
    }

    public function stokMasuk(): HasMany
    {
        return $this->hasMany(StokMasuk::class);
    }

    public function getStokRendahAttribute(): bool
    {
        return (float) $this->stok <= (float) $this->stok_minimum;
    }
}
