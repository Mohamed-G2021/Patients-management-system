<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObstetricHistoryTest extends Model
{
    use HasFactory;
    protected $fillable = [
     'gravidity',
     'parity',
     'abortion',
     'notes',
     'investigation',   
    ] ;
}
