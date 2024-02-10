<?php

namespace App\Models\HistoryTests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UterineCancerHistoryTest extends Model
{
    use HasFactory;
        
    //------------ one to many relationship history test with test -----------
    public function test(): BelongsTo
    {
        return $this->belongsTo(UterineCancerTest::class);
    }



}
