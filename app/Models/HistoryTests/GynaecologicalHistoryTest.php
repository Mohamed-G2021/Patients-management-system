<?php

namespace App\Models\HistoryTests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GynaecologicalHistoryTest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_id',
        'test_id',
        'doctor_id',
        'date_of_last_period',
        'menstrual_cycle_abnormalities',
        'contact_bleeding',
        'menopause',
        'menopause_age',
        'using_of_contraception',
        'contraception_method',
        'investigation_files',  
    ];
    //------------ one to many relationship history test with test -----------
    public function test(): BelongsTo
    {
        return $this->belongsTo(GynaecologicalTest::class);
    }


}
