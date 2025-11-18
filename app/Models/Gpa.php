<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gpa extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'file',
        'points'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
