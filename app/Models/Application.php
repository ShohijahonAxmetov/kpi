<?php

namespace App\Models;

use App\Models\Criterion\Criterion;
use App\Models\Criterion\CriterionItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'criterion_id',
        'criterion_item_id',
        'basis',
        'comment',
        'status',
        'answer',
        'score',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function criterion()
    {
        return $this->belongsTo(Criterion::class);
    }

    public function criterionItem()
    {
        return $this->belongsTo(CriterionItem::class);
    }
}
