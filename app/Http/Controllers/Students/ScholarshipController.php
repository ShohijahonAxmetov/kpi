<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::where('student_id', auth('students')->id())
            ->latest()
            ->get();

        return view('students.scholarships.index', [
            'scholarships' => $scholarships
        ]);
    }

    public function store(Request $request)
    {
        $data = [];
        $data['student_id'] = auth('students')->id();

        if ($request->file('president')) {
            $file = $request->file('president');

            $file_name = Str::random(12) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/upload/students/scholarships'), $file_name);

            $data['president'] = $file_name;
        }

        if ($request->file('beruniy')) {
            $file = $request->file('beruniy');

            $file_name = Str::random(12) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/upload/students/scholarships'), $file_name);

            $data['beruniy'] = $file_name;
        }

        if ($request->file('grant')) {
            $file = $request->file('grant');

            $file_name = Str::random(12) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/upload/students/scholarships'), $file_name);

            $data['grant'] = $file_name;
        }
        
        Scholarship::updateOrCreate(
            ['student_id' => $data['student_id']],
            $data
        );

        return back()->with([
            'success' => true,
            'message' => 'Успешно сохранено'
        ]);
    }

    public function destroy($document)
    {
        if(!in_array($document, ['beruniy', 'grant', 'president'])) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка'
            ]);
        }

        auth('students')->user()->scholarships()->whereNotNull($document)
            ->update([
                $document => null
            ]);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
