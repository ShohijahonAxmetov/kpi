<?php

namespace App\Models\Criterion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriterionMainCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max_score',
        'order',
    ];

    public function criterionCategories()
    {
        return $this->hasMany(CriterionCategory::class);
    }
}
