<?php

namespace App\Http\Controllers\Students;

use App\Models\Criterion\CriterionMainCategory;
use App\Models\Certificate\Certificate;
use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        $criterionMainCategories = CriterionMainCategory::with('criterionCategories')->orderBy('order')->get();
        $user = auth()->user();
        $total = round(($user->ielts_calculate() + $user->patents_calculate() + $user->articles_calculate() + $user->projects_calculate() + $user->schoolarships_calculate() + $user->test_calculate())/6, 2);
        return view('students.home', compact('total', 'criterionMainCategories'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'surname' => 'nullable|max:255',
            'password' => 'nullable|min:6|max:255'
        ]);
        auth()->user()->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'father_name' => $request->father_name,
            'password' => $request->password ? Hash::make($request->password) : auth()->user()->password
        ]);

        return back()->with([
            'success' => true,
            'message' => 'Успешно обновлено'
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
