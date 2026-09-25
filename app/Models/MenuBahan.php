<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuBahan extends Model
{
    protected $table = 'menu_bahan';

    protected $guarded = ['id'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }
}
