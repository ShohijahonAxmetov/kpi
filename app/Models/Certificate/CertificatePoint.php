<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificatePoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
