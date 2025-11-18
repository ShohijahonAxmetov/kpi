<?php

namespace App\Http\Controllers\Integrations;

use App\Models\Faculty;
use App\Models\Direction;
use App\Jobs\ImportStudents;
use App\Traits\Integrations\HemisTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HemisController extends Controller
{
	use HemisTrait {
        studentGradeList as traitStudentGradeList;
        studentInfo as traitStudentInfo;
        studentList as traitStudentList;
    }

    protected $baseUrl;
    public function __construct()
    {
    	$this->baseUrl = $this->getBaseUrl();
    }

    public function getDepartments()
    {
    	$allDepartments = $this->getAllItems('/v1/data/department-list', 'departments');
    	$tuitId = 1;

    	foreach ($allDepartments as $department) {
    		Faculty::updateOrCreate([
    			'code' => $department['code'],
    		], [
    			'university_id' => $tuitId,
    			'title' => 	$department['name']
    		]);
    	}
    }

    public function getSpecialities()
    {
    	$allSpecialities = $this->getAllItems('/v1/data/specialty-list', 'specialities');
    	$tuitId = 1;

    	foreach ($allSpecialities as $speciality) {
    		if (!Faculty::where('code', $speciality['department']['code'])->first()) dd($speciality);
    		Direction::create([
    			'code' => $speciality['code'],
    			'university_id' => $tuitId,
    			'faculty_id' => Faculty::where('code', $speciality['department']['code'])->first()->id,
    			'title' => 	$speciality['name']
    		]);
    	}
    }

    public function getStudents()
    {
    	ImportStudents::dispatch($this->baseUrl);
    }

    public function studentGradeList() // Kunlik baholar ro'yxati
    {
        dd($this->traitStudentGradeList());
    }

    public function studentInfo() // Talabaning administrativ va akademik ma'lumotlarini olish
    {
        dd($this->traitStudentInfo());
    }

    public function studentList() // Talabalar ro'yxati
    {
        dd($this->traitStudentList());
    }

    public function oAuthTest()
    {
    	$this->oAuth();
    }

    // public function getClassifiers(Request $request)
    // {
    // 	$url = $this->baseUrl.'/v1/data/classifier-list';
    //     $res = Http::withToken(env('HEMIS_KEY'))
    //         ->get($url);

    //     $resArray = $res->json();



    //     return response($resArray);
    // }

}
