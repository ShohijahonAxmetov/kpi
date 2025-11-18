<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'variant1',
        'variant2',
        'variant3',
        'expert_id'
    ];

    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }
}
