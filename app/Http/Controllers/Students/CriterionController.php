<?php

namespace App\Http\Controllers\Students;

use App\Models\Application;
use App\Models\Criterion\Criterion;
use App\Models\Criterion\CriterionCategory;
use App\Models\Criterion\CriterionMainCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    public function index(int $id)
    {
        $criterionCategory = CriterionCategory::query()
            ->with('criterions')
            ->where('id', $id)
            ->first();

        $criterion = $criterionCategory->criterions->first();
        $files = Application::query()
            ->where([
                ['student_id', auth()->id()],
                ['criterion_id', $criterion->id ?? 0]
            ])
            ->latest()
            ->get();

        return view('students.criterions.index', [
            'criterionCategory' => $criterionCategory,
            'criterionMainCategories' => CriterionMainCategory::orderBy('order')->get(),
            'criterion' => $criterion,
            'files' => $files,
        ]);
    }

    public function show(int $id, int $criterionId)
    {
        $criterion = Criterion::query()
            ->with('criterionItems')
            ->where('id', $criterionId)
            ->first();

        $criterionCategory = CriterionCategory::query()
            ->with('criterions')
            ->where('id', $id)
            ->first();

        $files = Application::query()
            ->where([
                ['student_id', auth()->id()],
                ['criterion_id', $criterionId]
            ])
            ->latest()
            ->get();

        return view('students.criterions.index', [
            'criterion' => $criterion,
            'criterionCategory' => $criterionCategory,
            'criterionMainCategories' => CriterionMainCategory::orderBy('order')->get(),
            'files' => $files
        ]);
    }
}
