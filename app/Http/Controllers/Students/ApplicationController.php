<?php

namespace App\Http\Controllers\Students;

use App\Models\Application;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'criterion_id' => 'required|exists:criteria,id',
            'criterion_item_id' => 'exists:criterion_items,id'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        if ($request->hasFile('basis')) {
            $basis = $request->file('basis');

            $fileName = Str::random(12) . '.' . $basis->extension();
            $basis->move(public_path('/upload/files'), $fileName);
            $data['basis'] = $fileName;
        }

        Application::query()
            ->create([
                'student_id' => auth()->id(),
                'criterion_id' => $data['criterion_id'],
                'criterion_item_id' => $data['criterion_item_id'] ?? null,
                'basis' => $data['basis'] ?? null,
                'comment' => $data['comment'],
                'status' => 1,
            ]);

        return back()->with([
            'success' => true,
            'message' => 'Ma\'lumot muvaffaqiyatli saqlandi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return back()->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli o\'chirildi'
        ]);
    }
}
