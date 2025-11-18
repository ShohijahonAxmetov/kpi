<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Patent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Patent::where('student_id', auth('students')->id())
            ->latest()
            ->get();
        return view('students.certificates.index', compact('certificates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'date' => 'required',
            'type' => 'required|max:8|min:1',
            'file' => 'required|file|max:2048'
        ]);

        $data = $request->all();
        $data['student_id'] = auth('students')->user()->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $file_name = Str::random(12) . '.' . $file->extension();
            $file->move(public_path('/upload/students/certificates_real'), $file_name);

            $data['file'] = $file_name;
        }

        Patent::create($data);

        return back()->with([
            'success' => true,
            'message' => 'Успешно сохранено'
        ]);
    }

    public function destroy(Patent $certificate)
    {
        $certificate->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удалено'
        ]);
    }
}
