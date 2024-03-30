<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
}
