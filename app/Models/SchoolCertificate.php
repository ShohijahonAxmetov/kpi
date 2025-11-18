<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'points',
        'file'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
