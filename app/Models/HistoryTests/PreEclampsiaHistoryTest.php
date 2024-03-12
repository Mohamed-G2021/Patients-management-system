<?php

namespace App\Models\HistoryTests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreEclampsiaHistoryTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'test_id',
        'doctor_id',
        'history_of_pre-eclampsia',
        'number_of_pregnancies_with_pe',
        'date_of_pregnancies_with_pe',
        'fate_of_the_pregnancy',
        'investigation_files',
    ];
        
    //------------ one to many relationship history test with test -----------
    public function test(): BelongsTo
    {
        return $this->belongsTo(PreEclampsiaTest::class);
    }



}
