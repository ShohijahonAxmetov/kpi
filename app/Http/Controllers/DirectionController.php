<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\University;
use App\Models\Faculty;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    public $title = 'Kafedralar va yo\'nalishlar';
    public $route_name = 'directions';
    public $route_parameter = 'direction';

    public function index()
    {
        $universities = University::orderBy('title');
        $faculties = Faculty::orderBy('title');
        $directions = Direction::orderBy('title');

        if (isset($_GET['university_id']) && $_GET['university_id'] != '') {
            $directions = $directions->where('university_id', $_GET['university_id']);
        }
        if (isset($_GET['faculty_id']) && $_GET['faculty_id'] != '') {
            $directions = $directions->where('faculty_id', $_GET['faculty_id']);
        }

        if (!is_null(auth()->user()->university_id)) {
            $universities = $universities->where('id', auth()->user()->university_id);
            $faculties = $faculties->where('university_id', auth()->user()->university_id);
            $directions = $directions->where('university_id', auth()->user()->university_id);
        }

        $universities = $universities->get();
        $faculties = $faculties->get();
        $directions = $directions->paginate(12);

        $filter_university = $_GET['university_id'] ?? null;
        $filter_faculty = $_GET['faculty_id'] ?? null;

        return view('app.directions.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'directions' => $directions,
            'universities' => $universities,
            'faculties' => $faculties,
            'filter_university' => $filter_university,
            'filter_faculty' => $filter_faculty
        ]);
    }

    public function create()
    {
        $universities = University::orderBy('title');
        $faculties = Faculty::orderBy('title');

        if (!is_null(auth()->user()->university_id)) {
            $universities = $universities->where('id', auth()->user()->university_id);
            $faculties = $faculties->where('university_id', auth()->user()->university_id);
        }

        $universities = $universities->get();
        $faculties = $faculties->get();

        return view('app.directions.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'universities' => $universities,
            'faculties' => $faculties,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'university_id' => 'required|integer',
            'faculty_id' => 'required|integer',
            'code' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        if (!is_null(auth()->user()->university_id)) {
            if ($data['university_id'] != auth()->user()->university_id) abort(403);
            if (!Faculty::where('university_id', auth()->user()->university_id)->exists()) abort(403);
        }

        Direction::create($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function show(Direction $direction)
    {
        //
    }

    public function edit(Direction $direction)
    {
        $universities = University::orderBy('title');
        $faculties = Faculty::orderBy('title');

        if (!is_null(auth()->user()->university_id)) {
            if ($direction->university_id != auth()->user()->university_id) abort(403);
            $universities = $universities->where('id', auth()->user()->university_id);
            $faculties = $faculties->where('university_id', auth()->user()->university_id);
        }

        $universities = $universities->get();
        $faculties = $faculties->get();

        return view('app.directions.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'universities' => $universities,
            'faculties' => $faculties,
            'direction' => $direction
        ]);
    }

    public function update(Request $request, Direction $direction)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'university_id' => 'required|integer',
            'faculty_id' => 'required|integer',
            'code' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        if (!is_null(auth()->user()->university_id)) {
            if ($direction->university_id != auth()->user()->university_id) abort(403);
        }

        $direction->update($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroy(Direction $direction)
    {
        ${Str::camel($this->route_parameter)}->delete();

        return back()->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli o\'chirildi'
        ]);
    }
}
