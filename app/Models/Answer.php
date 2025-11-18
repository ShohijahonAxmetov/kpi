<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'student_id',
        'answer'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
