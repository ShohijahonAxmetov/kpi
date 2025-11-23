<?php

namespace App\Models\Criterion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriterionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'criterion_main_category_id',
        'name',
        'max_score',
        'order',
    ];

    public function criterionMainCategory()
    {
        return $this->belongsTo(CriterionMainCategory::class);
    }

    public function criterions()
    {
        return $this->hasMany(Criterion::class);
    }
}
