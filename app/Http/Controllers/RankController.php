<?php

namespace App\Http\Controllers;

use App\Models\Dictionaries\Rank;
use App\Models\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RankController extends Controller
{
    public $title = 'Unvonlar';
    public $route_name = 'ranks';
    public $route_parameter = 'rank';

    public function index()
    {
        ${$this->route_name} = Rank::latest()
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

        Rank::create($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dictionaries\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function show(Rank $rank)
    {
        //
    }

    public function edit(Rank $rank)
    {
        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => Lang::all(),
            $this->route_parameter => ${$this->route_parameter}
        ]);
    }

    public function update(Request $request, Rank $rank)
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

        ${$this->route_parameter}->update($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }

    public function destroy(Rank $rank)
    {
        ${$this->route_parameter}->delete();

        return back()->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli o\'chirildi'
        ]);
    }
}
