<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use App\Models\Criterion\CriterionMainCategory;
use App\Models\Criterion\CriterionCategory;
use App\Models\Criterion\Criterion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    public $title = 'Mezonlar';
    public $route_name = 'criterions';
    public $route_parameter = 'criterion';

    public function index()
    {
        ${$this->route_name} = Criterion::with('criterionCategory.criterionMainCategory')
            ->latest()
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
            'criterionMainCategories' => CriterionMainCategory::orderBy('order')->get(),
            'criterionCategories' => CriterionCategory::orderBy('order')->get(),
            'langs' => Lang::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'max_score' => 'required|integer',
            'criterion_main_category_id' => 'required|exists:criterion_main_categories,id',
            'criterion_category_id' => 'required|exists:criterion_categories,id',
            'entered_manually' => 'required|in:HA,YOQ',
            'order' => 'integer'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $data['entered_manually'] = $data['entered_manually'] == 'HA' ? 1 : 0;
        Criterion::create($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Criterion\Criterion  $criterion
     * @return \Illuminate\Http\Response
     */
    public function show(Criterion $criterion)
    {
        //
    }

    public function edit(Criterion $criterion)
    {
        $criterion->entered_manually = $criterion->entered_manually ? 'HA' : 'YOQ';
        
        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'criterionMainCategories' => CriterionMainCategory::orderBy('order')->get(),
            'criterionCategories' => CriterionCategory::orderBy('order')->get(),
            'langs' => Lang::all(),
            $this->route_parameter => ${Str::camel($this->route_parameter)}
        ]);
    }

    public function update(Request $request, Criterion $criterion)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'max_score' => 'required|integer',
            'criterion_main_category_id' => 'required|exists:criterion_main_categories,id',
            'criterion_category_id' => 'required|exists:criterion_categories,id',
            'entered_manually' => 'required|in:HA,YOQ',
            'order' => 'integer'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $data['entered_manually'] = $data['entered_manually'] == 'HA' ? 1 : 0;
        ${Str::camel($this->route_parameter)}->update($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    public function destroy(Criterion $criterion)
    {
        ${Str::camel($this->route_parameter)}->delete();

        return back()->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli o\'chirildi'
        ]);
    }
}
