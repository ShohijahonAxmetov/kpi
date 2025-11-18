<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'father_name',
        'username',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function directions()
    {
        return $this->belongsToMany(Direction::class);
    }
}
