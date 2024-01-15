<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GeneralExamination extends Model
{
    use HasFactory;
    protected $table = 'general_examinations';
    protected $fillable=[
        'height',
        'pulse',
        'weight',
        'random_blood_sugar',
        'blood_pressure',
        'investigation',
     ];
     public function getInvestigationUrlAttribute()
     {
         return $this->attributes['investigation']
             ? Storage::url('investigations/' . $this->attributes['investigation'])
             : null;
     }
}
