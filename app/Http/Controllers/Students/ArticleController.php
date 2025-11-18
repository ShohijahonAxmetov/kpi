<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Article;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('student_id', auth('students')->id())
            ->latest()
            ->get();
        return view('students.articles.index', compact('articles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'journal_title' => 'required|max:255',
            'date' => 'required',
            'members_count' => 'nullable|max:255',
            'type' => 'required|max:8|min:1',
            'file' => 'required|file|max:2048'
        ]);

        $data = $request->all();
        $data['student_id'] = auth()->user()->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $file_name = Str::random(12) . '.' . $file->extension();
            $file->move(public_path('/upload/students/articles'), $file_name);

            $data['file'] = $file_name;
        }

        Article::create($data);

        return back()->with([
            'success' => true,
            'message' => 'Успешно сохранено'
        ]);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удалено'
        ]);
    }
}
