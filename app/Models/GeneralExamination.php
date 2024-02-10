<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeneralExamination extends Model
{
    use HasFactory;
    protected $table = 'general_examination_tests';
    protected $fillable=[
        'patient_id',
        'height',
        'pulse',
        'weight',
        'random_blood_sugar',
        'blood_pressure',
        'investigation_files',
    ];

    //------------ many to many relationship test with doctor -----------
    public function doctors(): MorphToMany
    {
        return $this->morphToMany(User::class, 'doctor_tests');
    }
    
    //------------ one to many relationship test with patient -----------
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    //------------ many to many relationship test with history test ----------- 
    public function historyTest(): HasMany
    {
        return $this->hasMany(GeneralExaminationHistory::class, 'test_id','id');
    }
}
