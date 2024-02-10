<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionHistory extends Model
{
    use HasFactory;

    //----------- one to many relationship action history with doctore ------------
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
