<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'region_id',
        'district_id'
    ];

    protected $appends = [
        'students_kpi',
        'students_max_kpi',
    ];

    public function faculties()
    {
        return $this->hasMany(Faculty::class);
    }

    public function directions()
    {
        return $this->hasMany(Direction::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getStudentsKpiAttribute(): string
    {
        $universityTotal = 0;
        // dd($this->students->sum('total_points'));

        foreach ($this->students as $student) {
            $universityTotal += round((
                $student->ielts_calculate() +
                $student->patents_calculate() +
                $student->articles_calculate() +
                $student->projects_calculate() +
                $student->schoolarships_calculate() +
                $student->test_calculate())/6, 2);
            // dd($universityTotal);
        }

        return $this->students->count() == 0 ? 0 : $universityTotal/$this->students->count();
    }

    public function getStudentsMaxKpiAttribute(): string
    {
        $universityMaxKpi = 0;
        foreach ($this->students as $student) {
            $total = round((
                    $student->ielts_calculate() +
                    $student->patents_calculate() +
                    $student->articles_calculate() +
                    $student->projects_calculate() +
                    $student->schoolarships_calculate() +
                    $student->test_calculate())/6, 2);
            if ($universityMaxKpi < $total) $universityMaxKpi = $total;

        }

        return $universityMaxKpi;
    }
}
