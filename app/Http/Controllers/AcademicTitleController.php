<?php

namespace App\Http\Controllers;

use App\Models\Dictionaries\AcademicTitle;
use App\Models\Lang;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AcademicTitleController extends Controller
{
    public $title = 'Ilmiy unvonlar';
    public $route_name = 'academic_titles';
    public $route_parameter = 'academic_title';

    public function index()
    {
        ${$this->route_name} = AcademicTitle::latest()
            ->paginate(12);
        $languages = Lang::all();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            $this->route_name => ${$this->route_name},
            'languages' => $languages
        ]);
    }

    public function create()
    {
        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => Lang::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ma\'lumotlar notog\'ri kiritildi'
            ]);
        }

        AcademicTitle::create($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dictionaries\AcademicTitle  $academicTitle
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicTitle $academicTitle)
    {
        //
    }

    public function edit(AcademicTitle $academicTitle)
    {
        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => Lang::all(),
            $this->route_parameter => ${Str::camel($this->route_parameter)}
        ]);
    }

    public function update(Request $request, AcademicTitle $academicTitle)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ma\'lumotlar notog\'ri kiritildi'
            ]);
        }

        ${Str::camel($this->route_parameter)}->update($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    public function destroy(AcademicTitle $academicTitle)
    {
        ${Str::camel($this->route_parameter)}->delete();

        return back()->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli o\'chirildi'
        ]);
    }
}
