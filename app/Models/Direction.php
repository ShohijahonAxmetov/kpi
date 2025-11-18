<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'university_id',
        'faculty_id',
        'code'
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function experts()
    {
        return $this->belongsToMany(Expert::class);
    }
}
