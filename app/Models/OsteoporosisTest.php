<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsteoporosisTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'age',
        'weight',
        'current_oestrogen_use',
        'recommendations',
        'investigation',
    ] ;
}
