<?php

namespace App\Models\Criterion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;

    protected $fillable = [
        'criterion_category_id',
        'name',
        'max_score',
        'entered_manually',
        'order',
    ];

    public function criterionCategory()
    {
        return $this->belongsTo(CriterionCategory::class);
    }

    public function criterionItems()
    {
        return $this->hasMany(CriterionItem::class);
    }
}
