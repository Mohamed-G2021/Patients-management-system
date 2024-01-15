<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvarianCancerTest extends Model
{
    use HasFactory;
    protected $fillable = [
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
