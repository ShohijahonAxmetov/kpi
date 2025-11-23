<?php

namespace App\Models;

use App\Models\Dictionaries\AcademicTitle;
use App\Models\Dictionaries\AcademicDegree;
use App\Models\Dictionaries\Rank;
use App\Models\Certificate\Certificate;
use Dotenv\Store\File\Paths;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'passport_number',
        // 'student_passport_number',
        'surname',
        'father_name',
        'university_id',
        'faculty_id',
        'direction_id',
        // 'scholarship_id',
        'password',

        'academic_title_id',
        'academic_degree_id',
        'rank_id',


        'ielts_points',
        'patents_points',
        'articles_points',
        'projects_points',
        'schoolarships_points',
        'tests_points',
    ];

    protected $appends = [
        'total_points'
    ];

    protected $hidden = [
        'password'
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function gpa()
    {
        return $this->hasMany(Gpa::class);
    }

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function schoolCertificate()
    {
        return $this->hasOne(SchoolCertificate::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function patents()
    {
        return $this->hasMany(Patent::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function academicTitle()
    {
        return $this->belongsTo(AcademicTitle::class);
    }

    public function academicDegree()
    {
        return $this->belongsTo(AcademicDegree::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function getTotalPointsAttribute(): int
    {
        return Application::query()
            ->where([
                ['student_id', '=', $this->id],
                ['status', '!=', 1]
            ])->sum('score');
        
        // return round(
        //     (
        //         $this->ielts_calculate() +
        //         $this->patents_calculate() +
        //         $this->articles_calculate() +
        //         $this->projects_calculate() +
        //         $this->schoolarships_calculate() +
        //         $this->test_calculate()
        //     )/6, 2);
    }

    // for get total points
    public function ielts_calculate(): float
    {
        $c2 = [];
        $c1 = [];
        $b2 = [];
        foreach($this->certificates as $certificate) {
            switch ($certificate->certificate_point->name) {
                case 'C2':
                    $c2[] = $certificate;
                    break;
                case 'C1':
                    $c1[] = $certificate;
                    break;
                case 'B2':
                    $b2[] = $certificate;
                    break;
            }
        }

        if(count($c2) > 0) return 1;
        if(count($c1) > 0) return 0.8;
        if(count($b2) > 0) return 0.6;

        return 0;
    }

    public function test_calculate(): float
    {
        $total = $this->tests_points;
        $totalWithBall = $total / 5;
        $result = $totalWithBall / 3;
        return $result >= 1 ? 1 : round($result, 2);
    }

    public function patents_calculate(): float
    {
        $patents = $this->patents()->latest();

        $type1 = $patents->where('type', 1)->limit(4)->count();
        $type2 = $patents->where('type', 2)->limit(4)->count();
        $type3 = $patents->where('type', 3)->limit(4)->count();
        $result = (($type1 + $type2 + $type3)/5)/3;

        return $result >= 1 ? 1 : round($result, 2);
    }

    public function articles_calculate(): float
    {
        $type1 = $this->articles()->where('type', 1)->limit(4);
        $type2 = $this->articles()->where('type', 2)->limit(4);
        $type3 = $this->articles()->where('type', 3)->limit(4);
        $type4 = $this->articles()->where('type', 4)->limit(4);
        $type5 = $this->articles()->where('type', 5)->limit(4);
        $type6 = $this->articles()->where('type', 6)->limit(4);
        $type7 = $this->articles()->where('type', 7)->limit(4);
        $type8 = $this->articles()->where('type', 8)->limit(4);

        $type1_total = $type1->count() * 0.2;
        $type2_total = $type2->count() * 0.2;
        $type3_total = $type3->count() * 0.1;
        $type4_total = $type4->count() * 0.5;
        $type5_total = $type5->count() * 0.5;
        $type6_total = $type6->count() * 0.6;
        $type7_total = $type7->count() * 0.6;
        $type8_total = $type8->count() * 0.6;

        $result = ($type1_total + $type2_total + $type3_total + $type4_total + $type5_total + $type6_total + $type7_total + $type8_total)/8;

        return $result >= 1 ? 1 : round($result, 2);
    }

    public function projects_calculate(): float
    {
        $projects = $this->projects;
        $result = $projects->count() / 5;

        return $result >= 1 ? 1 : round($result, 2);
    }

    public function schoolarships_calculate(): float
    {
        $schoolarship = $this->schoolarship;

        $result = 0;
        if($schoolarship) {
            if($schoolarship->president) $result += 1;
            if($schoolarship->beruniy) $result += 0.5;
            if($schoolarship->grant) $result += 0.3;
        }

        return $result >= 1 ? 1 : round($result, 2);
    }
}
