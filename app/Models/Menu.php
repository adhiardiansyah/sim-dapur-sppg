<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'menu';

    protected $guarded = ['id'];

    public function menuBahan(): HasMany
    {
        return $this->hasMany(MenuBahan::class);
    }

    public function bahanBaku(): BelongsToMany
    {
        return $this->belongsToMany(BahanBaku::class, 'menu_bahan')
            ->withPivot('jumlah_per_porsi', 'satuan')
            ->withTimestamps();
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(JadwalMenu::class);
    }
}
