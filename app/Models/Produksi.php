<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produksi extends Model
{
    protected $table = 'produksi';

    protected $guarded = ['id'];

    protected $casts = ['tanggal' => 'date'];

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalMenu::class, 'jadwal_id');
    }

    public function distribusi(): HasMany
    {
        return $this->hasMany(Distribusi::class);
    }
}
