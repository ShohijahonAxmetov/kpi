<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Certificate\Certificate;
use App\Models\Certificate\CertificateLanguage;
use App\Models\Certificate\CertificatePoint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IELTSController extends Controller
{
    public function index()
    {
        $certificates = Certificate::where('student_id', auth('students')->id())
            ->latest()
            ->get();
        $certificateLanguages = CertificateLanguage::all();
        $certificatePoints = CertificatePoint::all();

        return view('students.ielts.index', compact('certificates', 'certificateLanguages', 'certificatePoints'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|integer',
            'date' => 'required',
            'points' => 'required|integer',
            'file' => 'required|file|max:2048'
        ]);

        $data = $request->all();
        $data['student_id'] = auth()->user()->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $file_name = Str::random(12) . '.' . $file->extension();
            $file->move(public_path('/upload/students/certificates'), $file_name);

            $data['file'] = $file_name;
        }

        $data['certificate_language_id'] = $data['title'];
        $data['certificate_point_id'] = $data['points'];

        Certificate::create($data);

        return back()->with([
            'success' => true,
            'message' => 'Успешно сохранено'
        ]);
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удалено'
        ]);
    }
}
