<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use App\Models\Criterion\CriterionMainCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CriterionMainCategoryController extends Controller
{
    public $title = 'Mezon bo\'limlari';
    public $route_name = 'criterion_main_categories';
    public $route_parameter = 'criterion_main_category';

    public function index()
    {
        ${$this->route_name} = CriterionMainCategory::latest()
            ->paginate(12);

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            $this->route_name => ${$this->route_name},
            'languages' => Lang::all()
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
            'max_score' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        CriterionMainCategory::create($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Criterion\CriterionMainCategory  $criterionMainCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CriterionMainCategory $criterionMainCategory)
    {
        //
    }

    public function edit(CriterionMainCategory $criterionMainCategory)
    {
        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => Lang::all(),
            $this->route_parameter => ${Str::camel($this->route_parameter)}
        ]);
    }

    public function update(Request $request, CriterionMainCategory $criterionMainCategory)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'max_score' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        ${Str::camel($this->route_parameter)}->update($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    public function destroy(CriterionMainCategory $criterionMainCategory)
    {
        ${Str::camel($this->route_parameter)}->delete();

        return back()->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli o\'chirildi'
        ]);
    }
}
