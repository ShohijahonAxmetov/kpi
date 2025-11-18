<?php

namespace App\Models\Dictionaries;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicDegree extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_active',
    ];

    public function users()
    {
        return $this->hasMany(Student::class);
    }
}
