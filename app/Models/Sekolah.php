<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sekolah extends Model
{
    protected $table = 'sekolah';

    protected $guarded = ['id'];

    public function penerima(): HasMany
    {
        return $this->hasMany(Penerima::class);
    }

    public function distribusi(): HasMany
    {
        return $this->hasMany(Distribusi::class);
    }
}
