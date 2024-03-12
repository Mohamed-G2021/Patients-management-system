<?php

namespace App\Models\HistoryTests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CervixCancerHistoryTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'test_id',
        'doctor_id',
        'hpv_vaccine',
        'via_test_result',
        'via_test_comment',
        'pap_smear_result',
        'pap_smear_comment',
        'recommendations',
        'investigation_files'
    ];
    //------------ one to many relationship history test with test -----------
    public function test(): BelongsTo
    {
        return $this->belongsTo(CervixCancerTest::class);
    }


}
