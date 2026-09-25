<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'supplier';

    protected $guarded = ['id'];

    public function stokMasuk(): HasMany
    {
        return $this->hasMany(StokMasuk::class);
    }
}
