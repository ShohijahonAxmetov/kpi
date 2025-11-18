<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'title',
        'date',
        'file',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getFilePathAttribute(): ?string
    {
        if($this->file) return '/upload/students/projects/' . $this->file;

        return null;
    }
}
