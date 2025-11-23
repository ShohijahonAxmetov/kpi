<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use App\Models\Criterion\CriterionMainCategory;
use App\Models\Criterion\CriterionCategory;
use App\Models\Criterion\Criterion;
use App\Models\Criterion\CriterionItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CriterionItemController extends Controller
{
    public $title = 'Mezon bandlari';
    public $route_name = 'criterion_items';
    public $route_parameter = 'criterion_item';

    public function index()
    {
        ${$this->route_name} = CriterionItem::with('criterion.criterionCategory.criterionMainCategory')
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
            'criterions' => Criterion::orderBy('order')->get(),
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
            'criterion_id' => 'required|exists:criteria,id',
            'is_need_basis' => 'required|in:HA,YOQ',
            'order' => 'integer'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $data['is_need_basis'] = $data['is_need_basis'] == 'HA' ? 1 : 0;
        CriterionItem::create($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Criterion\CriterionItem  $criterionItem
     * @return \Illuminate\Http\Response
     */
    public function show(CriterionItem $criterionItem)
    {
        //
    }

    public function edit(CriterionItem $criterionItem)
    {
        $criterionItem->is_need_basis = $criterionItem->is_need_basis ? 'HA' : 'YOQ';

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'criterionMainCategories' => CriterionMainCategory::orderBy('order')->get(),
            'criterionCategories' => CriterionCategory::orderBy('order')->get(),
            'criterions' => Criterion::orderBy('order')->get(),
            'langs' => Lang::all(),
            $this->route_parameter => ${Str::camel($this->route_parameter)}
        ]);
    }

    public function update(Request $request, CriterionItem $criterionItem)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'max_score' => 'required|integer',
            'criterion_main_category_id' => 'required|exists:criterion_main_categories,id',
            'criterion_category_id' => 'required|exists:criterion_categories,id',
            'criterion_id' => 'required|exists:criteria,id',
            'is_need_basis' => 'required|in:HA,YOQ',
            'order' => 'integer'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $data['is_need_basis'] = $data['is_need_basis'] == 'HA' ? 1 : 0;
        ${Str::camel($this->route_parameter)}->update($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    public function destroy(CriterionItem $criterionItem)
    {
        ${Str::camel($this->route_parameter)}->delete();

        return back()->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli o\'chirildi'
        ]);
    }
}
