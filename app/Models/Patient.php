<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'national_id',
        'name',
        'phone_number',
        'patient_code',
        'date_of_birth',
        'address',
        'marital_state',
        'relative_name',
        'relative_phone',
        'email'
    ];

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
    return Carbon::parse($this->attributes['date_of_birth'])->age;
    }
}
