<?php

namespace App\Models\Criterion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriterionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'criterion_id',
        'name',
        'max_score',
        'is_need_basis',
        'order',
    ];

    public function criterion()
    {
        return $this->belongsTo(Criterion::class);
    }
}
