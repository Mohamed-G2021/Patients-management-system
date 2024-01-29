<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UterineCancerTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'lynch_syndrome(+ve,-ve)',
        'irregular_bleeding',
        'tvs_perimetrium_result',
        'tvs_myometrium_result',
        'tvs_endometrium_result',
        'biopsy_result',
        'biopsy_comment',
        'tvs_perimetrium_comment',
        'tvs_myometrium_comment',
        'tvs_endometrium_comment',
        'investigation',
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
        return $this->hasMany(UterineCancerHistoryTest::class, 'test_id','id');
    }
}
