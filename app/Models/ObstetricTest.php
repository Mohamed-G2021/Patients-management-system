<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObstetricTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'gravidity',
        'parity',
        'abortion',
        'notes',
        'investigation_files',   
    ] ;
}
