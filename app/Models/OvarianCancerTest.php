<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OvarianCancerTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        "breast_cancer_history",
        "relatives_with_ovarian_cancer",
        "gene_mutation_or_lynch_syndrome",
        "tvs_result",
        "tvs_comment",
        "ca-125_result",
        "ca-125_comment",
        "recommendations",
    ];
}
