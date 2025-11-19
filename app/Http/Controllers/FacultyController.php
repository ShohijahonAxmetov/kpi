<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\University;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public $title = 'Факультеты';
    public $route_name = 'faculties';
    public $route_parameter = 'faculty';

    public function index()
    {
        $universities = University::orderBy('title');
        $faculties = Faculty::orderBy('title');
        if (isset($_GET['university_id']) && $_GET['university_id'] != '') {
            $faculties = $faculties->where('university_id', $_GET['university_id']);
        }

        if (!is_null(auth()->user()->university_id)) {
            $universities = $universities->where('id', auth()->user()->university_id);
            $faculties = $faculties->where('university_id', auth()->user()->university_id);
        }

        $universities = $universities->get();
        $faculties = $faculties->paginate(12);

        $filter_university = $_GET['university_id'] ?? null;

        return view('app.faculties.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'faculties' => $faculties,
            'universities' => $universities,
            'filter_university' => $filter_university
        ]);
    }

    public function create()
    {
        $universities = University::orderBy('title');

        if (!is_null(auth()->user()->university_id)) {
            $universities = $universities->where('id', auth()->user()->university_id);
        }

        $universities = $universities->get();

        return view('app.faculties.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'universities' => $universities
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'university_id' => 'required|integer',
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ma\'lumotlar notog\'ri kiritildi'
            ]);
        }

        if (!is_null(auth()->user()->university_id)) {
            if ($data['university_id'] != auth()->user()->university_id) abort(403);
        }

        Faculty::create($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    public function show(Faculty $faculty)
    {
        //
    }

    public function edit(Faculty $faculty)
    {
        $universities = University::orderBy('title');

        if (!is_null(auth()->user()->university_id)) {
            if ($faculty->university_id != auth()->user()->university_id) abort(403);
            $universities = $universities->where('id', auth()->user()->university_id);
        }

        $universities = $universities->get();

        return view('app.faculties.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'universities' => $universities,
            'faculty' => $faculty
        ]);
    }

    public function update(Request $request, Faculty $faculty)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'university_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        if (!is_null(auth()->user()->university_id)) {
            if ($faculty->university_id != auth()->user()->university_id) abort(403);
        }

        $faculty->update($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroy(Faculty $faculty)
    {
        ${Str::camel($this->route_parameter)}->delete();

        return back()->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli o\'chirildi'
        ]);
    }
}
