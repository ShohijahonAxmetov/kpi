<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dictionaries\AcademicDegree;
use App\Models\Dictionaries\AcademicTitle;
use App\Models\Dictionaries\Rank;
use App\Models\Direction;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class StudentController extends Controller
{
    public $title = 'O\'qituvchilar ro\'yxati';
    public $route_name = 'students';
    public $route_parameter = 'student';

    public function index()
    {
        $universities = University::orderBy('title');
        $faculties = Faculty::orderBy('title');
        $directions = Direction::orderBy('title');

        $students = Student::orderBy('surname');
        if (isset($_GET['university_id']) && $_GET['university_id'] != '') {
            $students = $students->where('university_id', $_GET['university_id']);
        }
        if (isset($_GET['faculty_id']) && $_GET['faculty_id'] != '') {
            $students = $students->where('faculty_id', $_GET['faculty_id']);
        }

        if (!is_null(auth()->user()->university_id)) {
            $universities = $universities->where('id', auth()->user()->university_id);
            $faculties = $faculties->where('university_id', auth()->user()->university_id);
            $directions = $directions->where('university_id', auth()->user()->university_id);
            $students = $students->where('university_id', auth()->user()->university_id);
        }

        $universities = $universities->get();
        $faculties = $faculties->get();
        $directions = $directions->get();
        $students = $students->paginate(12);

        $filter_university = $_GET['university_id'] ?? null;
        $filter_faculty = $_GET['faculty_id'] ?? null;
        $filter_direction = $_GET['direction_id'] ?? null;

        return view('app.students.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'directions' => $directions,
            'universities' => $universities,
            'faculties' => $faculties,
            'filter_university' => $filter_university,
            'filter_faculty' => $filter_faculty,
            'filter_direction' => $filter_direction,
            'students' => $students
        ]);
    }

    public function create()
    {
        $universities = University::orderBy('title');
        $faculties = Faculty::orderBy('title');
        $directions = Direction::orderBy('title');

        if (!is_null(auth()->user()->university_id)) {
            $universities = $universities->where('id', auth()->user()->university_id);
            $faculties = $faculties->where('university_id', auth()->user()->university_id);
            $directions = $directions->where('university_id', auth()->user()->university_id);
        }

        $universities = $universities->get();
        $faculties = $faculties->get();
        $directions = $directions->get();

        return view('app.students.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'universities' => $universities,
            'faculties' => $faculties,
            'directions' => $directions,
            'ranks' => Rank::where('is_active', 1)->get(),
            'academicDegrees' => AcademicDegree::where('is_active', 1)->get(),
            'academicTitles' => AcademicTitle::where('is_active', 1)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'surname' => 'required',
            'university_id' => 'required|integer',
            'faculty_id' => 'required|integer',
            'direction_id' => 'required|integer',
            'passport_number' => 'required|max:32|min:8|unique:students',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ma\'lumotlar notog\'ri kiritildi'
            ]);
        }

        $data['password'] = Hash::make('123');

        if (!is_null(auth()->user()->university_id)) {
            if ($data['university_id'] != auth()->user()->university_id) abort(403);
            if (!Faculty::where('university_id', auth()->user()->university_id)->exists()) abort(403);
            if (!Direction::where('university_id', auth()->user()->university_id)->exists()) abort(403);
        }

        Student::create($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    public function show(Student $student)
    {
        //
    }

    public function edit(Student $student)
    {
        $universities = University::orderBy('title');
        $faculties = Faculty::orderBy('title');
        $directions = Direction::orderBy('title');

        if (!is_null(auth()->user()->university_id)) {
            if ($student->university_id != auth()->user()->university_id) abort(403);
            if ($student->faculty->university_id != auth()->user()->university_id) abort(403);
            if ($student->direction->faculty->university_id != auth()->user()->university_id) abort(403);
            $universities = $universities->where('id', auth()->user()->university_id);
            $faculties = $faculties->where('university_id', auth()->user()->university_id);
            $directions = $directions->where('university_id', auth()->user()->university_id);
        }

        $universities = $universities->get();
        $faculties = $faculties->get();
        $directions = $directions->get();

        return view('app.students.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'universities' => $universities,
            'faculties' => $faculties,
            'directions' => $directions,
            'student' => $student,
            'ranks' => Rank::where('is_active', 1)->get(),
            'academicDegrees' => AcademicDegree::where('is_active', 1)->get(),
            'academicTitles' => AcademicTitle::where('is_active', 1)->get(),
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'surname' => 'required',
            'university_id' => 'required|integer',
            'faculty_id' => 'required|integer',
            'direction_id' => 'required|integer',
            'passport_number' => 'required|max:32|min:8|unique:students,passport_number,' . $student->id,
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ma\'lumotlar notog\'ri kiritildi'
            ]);
        }

        $data['password'] = Hash::make(123);

        if (!is_null(auth()->user()->university_id)) {
            if ($student->university_id != auth()->user()->university_id) abort(403);
            if ($student->faculty->university_id != auth()->user()->university_id) abort(403);
            if ($student->direction->faculty->university_id != auth()->user()->university_id) abort(403);
        }

        $student->update($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    public function destroy(Student $student)
    {
        //
    }

    public function import_form()
    {
        $universities = University::orderBy('title');
        $faculties = Faculty::orderBy('title');
        $directions = Direction::orderBy('title');

        if (!is_null(auth()->user()->university_id)) {
            $universities = $universities->where('id', auth()->user()->university_id);
            $faculties = $faculties->where('university_id', auth()->user()->university_id);
            $directions = $directions->where('university_id', auth()->user()->university_id);
        }

        $universities = $universities->get();
        $faculties = $faculties->get();
        $directions = $directions->get();

        return view('app.students.import', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'universities' => $universities,
            'faculties' => $faculties,
            'directions' => $directions,
        ]);
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'university_id' => 'required|integer',
            'faculty_id' => 'required|integer',
            'direction_id' => 'required|integer',
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

        if (!is_null(auth()->user()->university_id)) {
            if ($request->input('university_id') != auth()->user()->university_id) abort(403);
        }

        $the_file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet       = $spreadsheet->getActiveSheet();
            $row_limit   = $sheet->getHighestDataRow();
            $row_range   = range(3, $row_limit);

            $data = array();
            $student_exist = false;
            foreach ($row_range as $row) {
                if(DB::table('students')->where('passport_number', $sheet->getCell('E' . $row)->getValue())->exists()) continue;

                $data[] = [
                    'name' => $sheet->getCell('D' . $row)->getValue(),
                    'passport_number' => $sheet->getCell('E' . $row)->getValue(),
                    // 'student_passport_number' => $sheet->getCell('E' . $row)->getValue(),
                    'university_id' => 1,
                    'faculty_id' => Faculty::where('code', trim($sheet->getCell('J' . $row)->getValue()))->firstOrFail()->id,
                    'direction_id' => 1,
                    'password' => Hash::make($sheet->getCell('E' . $row)->getValue())
                ];
            }

            DB::table('students')->insert($data);

        } catch (Exception $e) {
            return back()->with([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return redirect()
            ->route($this->route_name.'.index')
            ->with([
                'success' => true,
                'message' => 'Импортировано'
        ]);
    }
}
