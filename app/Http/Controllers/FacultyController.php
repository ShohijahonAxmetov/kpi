<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Faculty;
use App\Models\University;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public $title = 'Факультеты';
    public $route_name = 'faculties';
    public $route_parameter = 'faculty';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
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
            if ($data['university_id'] != auth()->user()->university_id) abort(403);
        }

        Faculty::create($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        //
    }
}
