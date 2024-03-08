<?php

namespace App\Models\HistoryTests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObstetricHistoryTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'test_id',
        'gravidity',
        'parity',
        'abortion',
        'notes',
        'investigation_files',   
    ] ;
        
    //------------ one to many relationship history test with test -----------
    public function test(): BelongsTo
    {
        return $this->belongsTo(ObstetricTest::class);
    }


}
