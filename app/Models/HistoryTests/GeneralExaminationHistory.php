<?php

namespace App\Models\HistoryTests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneralExaminationHistory extends Model
{
    use HasFactory;

    protected $table = 'general_examinations_history';
    
    protected $fillable=[
        'test_id',
        'patient_id',
        'doctor_id',
        'height',
        'pulse',
        'weight',
        'random_blood_sugar',
        'blood_pressure',
        'investigation_files',
    ];

    //------------ one to many relationship history test with test -----------
    public function test(): BelongsTo
    {
        return $this->belongsTo(GeneralExamination::class);
    }


}
