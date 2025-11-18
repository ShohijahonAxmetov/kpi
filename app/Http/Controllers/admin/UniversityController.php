<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{District, Region, University,};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{
    protected $title = 'Университеты';
    protected $route_name = 'universities';
    protected $route_parameter = 'university';

    protected $regions;
    protected $districts;

    public function __construct()
    {
        $this->regions = Region::all();
        $this->districts = District::all();
    }

    public function index()
    {
        $universities = University::orderBy('title');

        if (!is_null(auth()->user()->university_id)) $universities = $universities->where('id', auth()->user()->university_id);

        $universities = $universities->paginate(12);

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'universities' => $universities,
            'regions' => $this->regions,
            'districts' => $this->districts
        ]);
    }

    public function create()
    {
        return view('app.universities.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'regions' => $this->regions,
            'districts' => $this->districts
        ]);
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'region' => 'required',
            'district' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $data['region_id'] = $data['region'];
        $data['district_id'] = $data['district'];

        University::create($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function show(University $university)
    {
        return view('app.universities.show', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'regions' => $this->regions,
            'districts' => $this->districts,
            'university' => $university
        ]);
    }

    public function edit(University $university)
    {
        $faculties = $university->faculties;

        return view('app.universities.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'university' => $university,
            'faculties' => $faculties,
            'regions' => $this->regions,
            'districts' => $this->districts
        ]);
    }

    public function update(Request $request, University $university)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'region_id' => 'required',
            'district_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $university->update($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroy(University $university)
    {
        //
    }
}
