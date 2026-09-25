<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distribusi extends Model
{
    protected $table = 'distribusi';

    protected $guarded = ['id'];

    public function produksi(): BelongsTo
    {
        return $this->belongsTo(Produksi::class);
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
