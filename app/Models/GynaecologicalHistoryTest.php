<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GynaecologicalHistoryTest extends Model
{
    use HasFactory;
    protected $fillable = [
      'date_of_last_period',
      'menstrual_cycle_abnormalities',
      'contact_bleeding',
      'menopause',
      'menopause_age',
      'using_of_contraception',
      'contraception_method',
      'investigation',  
    ];
}
