<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PreEclampsiaTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'history_of_pre-eclampsia',
        'number_of_pregnancies_with_pe',
        'date_of_pregnancies_with_pe',
        'fate_of_the_pregnancy',
        'investigation_files',
    ];
}
