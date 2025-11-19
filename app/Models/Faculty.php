<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'university_id',
        'code',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function directions()
    {
        return $this->hasMany(Direction::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
