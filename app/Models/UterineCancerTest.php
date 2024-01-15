<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UterineCancerTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'lynch_syndrome(+ve,-ve)',
        'irregular_bleeding',
        'tvs_perimetrium_result',
        'tvs_myometrium_result',
        'tvs_endometrium_result',
        'biopsy_result',
        'biopsy_comment',
        'tvs_perimetrium_comment',
        'tvs_myometrium_comment',
        'tvs_endometrium_comment',
        'investigation',
    ];
}
