<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CervixCancerTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'hpv_vaccine',
        'via_test_result',
        'via_test_comment',
        'pap_smear_result',
        'pap_smear_comment',
        'recommendations',
        'investigation_files'
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
        return $this->hasMany(CervixCancerHistoryTest::class, 'test_id','id');
    }

   
}
