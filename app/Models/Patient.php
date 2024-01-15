<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'national_id',
        'name',
        'age',
        'date_of_birth',
        'address',
        'marital_state',
        'password',
        'username',
        'relative_name',
        'relative_phone'
    ];
}
