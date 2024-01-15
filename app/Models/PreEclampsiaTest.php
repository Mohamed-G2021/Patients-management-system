<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreEclampsiaTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'history_of_pre-eclampsia',
        'number_of_pregnancies_with_pe',
        'date_of_pregnancies_with_pe',
        'fate_of_the_pregnancy',
        'investigation',
    ];
}
