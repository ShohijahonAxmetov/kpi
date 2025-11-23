<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Students\ApplicationController;
use App\Http\Controllers\Students\CriterionController;
use App\Http\Controllers\Students\{
    Auth\LoginController,
    HomeController,
    TestController,
    IELTSController,
    CertificateController,
    ArticleController,
    ProjectController,
    ScholarshipController
};

// Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale(), 'middleware' => 'locale'], function(){

// });

Route::get('/', [LoginController::class, 'showLoginForm']);
Route::middleware(['students'])->prefix('students')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('students.showLoginForm');
    Route::post('/login', [LoginController::class, 'login'])->name('students.login');

    Route::middleware(['auth:students'])->group(function() {
        Route::get('/home', [HomeController::class, 'index'])->name('students.home');
        Route::post('/logout', [HomeController::class, 'logout'])->name('students.logout');
        Route::put('/update', [HomeController::class, 'update'])->name('students.update');

        Route::get('criterion_categories/{id}', [CriterionController::class, 'index'])->name('students.criterions.index');
        Route::get('criterion_categories/{id}/criterions/{criterion_id}', [CriterionController::class, 'show'])->name('students.criterions.show');
        Route::resource('applications', ApplicationController::class);

        Route::get('/tests', [TestController::class, 'index'])->name('tests.index');
        Route::post('/tests', [TestController::class, 'store'])->name('tests.store');
        Route::get('/ielts', [IELTSController::class, 'index'])->name('ielts.index');
        Route::post('/ielts', [IELTSController::class, 'store'])->name('ielts.store');
        Route::delete('/ielts/{certificate}', [IELTSController::class, 'destroy'])->name('ielts.destroy');
        Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
        Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
        Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::get('/scholarships', [ScholarshipController::class, 'index'])->name('scholarships.index');
        Route::post('/scholarships', [ScholarshipController::class, 'store'])->name('scholarships.store');
        Route::delete('/scholarships/{document}', [ScholarshipController::class, 'destroy'])->name('scholarships.destroy');
    });
});
