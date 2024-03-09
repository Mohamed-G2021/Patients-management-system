<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GynaecologicalTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'date_of_last_period',
        'menstrual_cycle_abnormalities',
        'contact_bleeding',
        'menopause',
        'menopause_age',
        'using_of_contraception',
        'contraception_method',
        'other_contraception_method',
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
        return $this->hasMany(GynaecologicalHistoryTest::class, 'test_id','id');
    }
}
