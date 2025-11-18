<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'student_id',
        'journal_title',
        'type',
        'date',
        'members_count',
        'file',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getTypeStringAttribute()
    {
        $types = [
            1 => 'Республика тезис',
            2 => 'Халкаро тезис',
            3 => 'Махаллий газета тезис',
            4 => 'Илмий республика макола',
            5 => 'Илмий халкаро макола',
            6 => 'Илмий халкаро ОАК макола',
            7 => 'Илмий республика ОАК макола',
            8 => 'Илмий халкаро скопус макола',
        ];
        return $types[$this->type];
    }

    public function getFilePathAttribute(): ?string
    {
        if($this->file) return '/upload/students/articles/' . $this->file;

        return null;
    }
}
