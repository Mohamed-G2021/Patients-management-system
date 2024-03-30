<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralExamination extends Model
{
    use HasFactory;
    protected $table = 'general_examination_tests';
    protected $fillable=[
        'patient_id',
        'doctor_id',
        'height',
        'pulse',
        'weight',
        'random_blood_sugar',
        'blood_pressure',
        'investigation_files',
    ];
}
