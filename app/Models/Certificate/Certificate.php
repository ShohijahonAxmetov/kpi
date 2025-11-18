<?php

namespace App\Models\Certificate;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'certificate_language_id',
        'certificate_point_id',
        'date',
        'file'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function certificate_language()
    {
        return $this->belongsTo(CertificateLanguage::class);
    }

    public function certificate_point()
    {
        return $this->belongsTo(CertificatePoint::class);
    }

    public function getFilePathAttribute()
    {
        if($this->file) return '/upload/students/certificates/' . $this->file;

        return null;
    }
}
