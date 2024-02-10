<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    //-------------------------- Relationships ------------------------------------------------

    //----------------- many to many relationship doctor with tests ------
    public function generaLexaminationTests(): MorphToMany
    {
        return $this->morphedByMany(GeneralExamination::class, 'doctor_tests');
    }

    public function GynaecologicalTests(): MorphToMany
    {
        return $this->morphedByMany(GynaecologicalTest::class, 'doctor_tests');
    }
    
    public function ObstetricTests(): MorphToMany
    {
        return $this->morphedByMany(ObstetricTest::class, 'doctor_tests');
    }

    public function CervixCancerTests(): MorphToMany
    {
        return $this->morphedByMany(CervixCancerTest::class, 'doctor_tests');
    }

    public function BreastCancerTests(): MorphToMany
    {
        return $this->morphedByMany(BreastCancerTest::class, 'doctor_tests');
    }

    public function OvarianCancerTests(): MorphToMany
    {
        return $this->morphedByMany(OvarianCancerTest::class, 'doctor_tests');
    }

    public function UterineCancerTests(): MorphToMany
    {
        return $this->morphedByMany(UterineCancerTest::class, 'doctor_tests');
    }

    public function OsteoporosisTests(): MorphToMany
    {
        return $this->morphedByMany(OsteoporosisTest::class, 'doctor_tests');
    }

    public function PreEclampsiaTests(): MorphToMany
    {
        return $this->morphedByMany(PreEclampsiaTest::class, 'doctor_tests');
    }

    //---------------------------end ---------------------------------

    //---------------------------------------------------

    //------------------ many to many relationship doctor with patient -----------------
    
    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'doctor_patients','doctor_id','id');
    }
    //------------------ end ------------------------------------------------

    //-----------------------------------------------------

    //------------------ Actions History -----------------
    //----------------- one to many relationship doctor with action ------------------
    public function actionsHistory(): HasMany
    {
        return $this->hasMany(ActionHistory::class, 'doctor_id','id');
    }
    //------------------ end ------------------------------------------------
   

}
