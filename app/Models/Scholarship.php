<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'president',
        'beruniy',
        'grant'
    ];

    public function students()
    {
        return $this->belongsTo(Student::class);
    }

    public function getPresidentPathAttribute()
    {
        if($this->president) return '/upload/students/scholarships/' . $this->president;

        return null;
    }

    public function getBeruniyPathAttribute()
    {
        if($this->beruniy) return '/upload/students/scholarships/' . $this->beruniy;

        return null;
    }

    public function getGrantPathAttribute()
    {
        if($this->grant) return '/upload/students/scholarships/' . $this->grant;

        return null;
    }
}
