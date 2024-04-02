<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPersonalInfoHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'national_id',
        'name',
        'age',
        'phone_number',
        'patient_code',
        'date_of_birth',
        'address',
        'marital_state',
        'relative_name',
        'relative_phone',
        'email'
    ];
}
