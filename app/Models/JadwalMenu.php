<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JadwalMenu extends Model
{
    protected $table = 'jadwal_menu';

    protected $guarded = ['id'];

    protected $casts = ['tanggal' => 'date'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function produksi(): HasOne
    {
        return $this->hasOne(Produksi::class, 'jadwal_id');
    }
}
