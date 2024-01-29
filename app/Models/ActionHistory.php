<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionHistory extends Model
{
    use HasFactory;


    public function doctor(): HasMany
    {
        return $this->belongsTo(User::class);
    }
}
