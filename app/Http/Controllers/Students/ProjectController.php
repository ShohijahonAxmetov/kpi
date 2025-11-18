<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('student_id', auth('students')->id())
            ->latest()
            ->get();

        return view('students.projects.index', [
            'projects' => $projects
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'date' => 'required',
            'file' => 'required|file|max:2048'
        ]);

        $data = $request->all();
        $data['student_id'] = auth()->user()->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $file_name = Str::random(12) . '.' . $file->extension();
            $file->move(public_path('/upload/students/projects'), $file_name);

            $data['file'] = $file_name;
        }

        Project::create($data);

        return back()->with([
            'success' => true,
            'message' => 'Успешно сохранено'
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удалено'
        ]);
    }
}
