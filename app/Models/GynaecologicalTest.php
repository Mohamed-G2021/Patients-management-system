<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GynaecologicalTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'doctor_id',
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
}
