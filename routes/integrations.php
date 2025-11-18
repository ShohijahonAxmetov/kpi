<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'hemis'], function () {
    Route::get('get-departments', [\App\Http\Controllers\Integrations\HemisController::class, 'getDepartments']);
    Route::get('get-specialities', [\App\Http\Controllers\Integrations\HemisController::class, 'getSpecialities']);
    Route::get('get-students', [\App\Http\Controllers\Integrations\HemisController::class, 'getStudents']);
    Route::get('student-grade-list', [\App\Http\Controllers\Integrations\HemisController::class, 'studentGradeList']); // Kunlik baholar ro'yxati
    Route::get('student-info', [\App\Http\Controllers\Integrations\HemisController::class, 'studentInfo']); // Talabaning administrativ va akademik ma'lumotlarini olish
    Route::get('student-list', [\App\Http\Controllers\Integrations\HemisController::class, 'studentList']); // Talabalar ro'yxati


    // Route::get('get-classifiers', [\App\Http\Controllers\Integrations\HemisController::class, 'getClassifiers']);

    Route::get('o-auth', [\App\Http\Controllers\Integrations\HemisController::class, 'oAuthTest']);
});
