<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::query()
            ->latest()
            ->paginate(24);

        return view('app.applications.index', [
            'title' => 'Arizalar',
            'route_name' => 'applications',
            'route_parameter' => 'application',
            'applications' => $applications
        ]);
    }

    public function edit(Application $application)
    {
        return view('app.applications.edit', [
            'application' => $application,
            'title' => 'Arizalar',
            'route_name' => 'applications',
            'route_parameter' => 'application'
        ]);
    }

    public function update(Application $application, Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'answer' => 'required',
            'score' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $application->update([
            'answer' => $data['answer'],
            'score' => $data['score'],
            'status' => 10
        ]);

        return redirect()->route('admin.applications.index')->with([
            'success' => true,
            'message' => 'Muvaffaqiyatli saqlandi'
        ]);
    }
}
