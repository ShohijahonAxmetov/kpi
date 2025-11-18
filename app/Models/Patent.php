<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'student_id',
        'type',
        'file',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getTypeStringAttribute()
    {
        $types = [
            1 => 'Дастур гувохномаси',
            2 => 'МБ гувохномаси',
            3 => 'Патент гувохномаси',
        ];
        return $types[$this->type];
    }

    public function getFilePathAttribute(): ?string
    {
        if($this->file) return '/upload/students/certificates_real/' . $this->file;

        return null;
    }
}
