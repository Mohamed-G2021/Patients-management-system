<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'national_id',
        'name',
        'age',
        'phone_number',
        'patient_id',
        'date_of_birth',
        'address',
        'marital_state',
        'password',
        'username',
        'relative_name',
        'relative_phone'
    ];

    //------------------- many to many patients with doctors ---------------------
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'doctor_patients','patient_id','id');
    }
    //------------------------------------------------------------------------------------

    // -------------- one to many patients with test ---------------------------------
    public function generaLexaminationTests(): HasMany
    {
        return $this->hasMany(GeneralExamination::class, 'patient_id','id');
    }

    public function GynaecologicalTests(): HasMany
    {
        return $this->hasMany(GynaecologicalTest::class, 'patient_id','id');
    }
    
    public function ObstetricTests(): HasMany
    {
        return $this->hasMany(ObstetricTest::class,  'patient_id','id');
    }

    public function CervixCancerTests(): HasMany
    {
        return $this->hasMany(CervixCancerTest::class,  'patient_id','id');
    }

    public function BreastCancerTests(): HasMany
    {
        return $this->hasMany(BreastCancerTest::class,  'patient_id','id');
    }

    public function OvarianCancerTests(): HasMany
    {
        return $this->hasMany(OvarianCancerTest::class,  'patient_id','id');
    }

    public function UterineCancerTests(): HasMany
    {
        return $this->hasMany(UterineCancerTest::class,  'patient_id','id');
    }

    public function OsteoporosisTests(): HasMany
    {
        return $this->hasMany(OsteoporosisTest::class,  'patient_id','id');
    }

    public function PreEclampsiaTests(): HasMany
    {
        return $this->hasMany(PreEclampsiaTest::class,  'patient_id','id');
    }
    //----------------------------- end  -----------------------------------
}
