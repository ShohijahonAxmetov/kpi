<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CriterionItemController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\CriterionCategoryController;
use App\Http\Controllers\CriterionMainCategoryController;
use App\Http\Controllers\AcademicTitleController;
use App\Http\Controllers\AcademicDegreeController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\{admin\StudentController,
    admin\UniversityController,
    DirectionController,
    ExpertController,
    FacultyController,
    HomeController,
    LogController,
    PostController,
    PostsCategoryController,
    UserController,
	Controller};
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
	->prefix('admin')
	->group(function () {
        // universities
        Route::resource('universities', UniversityController::class);
        // faculties
        Route::resource('faculties', FacultyController::class);
        // directions
        Route::resource('directions', DirectionController::class);
        // academic titles
        Route::resource('academic_titles', AcademicTitleController::class);
        // academic degreed
        Route::resource('academic_degrees', AcademicDegreeController::class);
        // ranks
        Route::resource('ranks', RankController::class);
        Route::resource('criterion_main_categories', CriterionMainCategoryController::class);
        Route::resource('criterion_categories', CriterionCategoryController::class);
        Route::resource('criterions', CriterionController::class);
        Route::resource('criterion_items', CriterionItemController::class);
        Route::get('applications', [ApplicationController::class, 'index'])->name('admin.applications.index');
        Route::get('applications/{application}', [ApplicationController::class, 'edit'])->name('admin.applications.edit');
        Route::put('applications/{application}', [ApplicationController::class, 'update'])->name('admin.applications.update');

        // students
        Route::get('students/import', [StudentController::class, 'import_form'])->name('students.import_form');
        Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
        Route::get('students/{student}/set_score', [StudentController::class, 'setScore'])->name('students.set_score');
        Route::put('students/{student}/set_score', [StudentController::class, 'setScoreUpdate'])->name('admin.students.set_score.update');
        Route::resource('students', StudentController::class);

        // experts
        Route::resource('experts', ExpertController::class);

        Route::resource('lang_certificate_langs', \App\Http\Controllers\admin\Certificate\CertificateLanguageController::class);
        Route::resource('certificate_points', \App\Http\Controllers\admin\Certificate\CertificatePointController::class);





        // users
        Route::resource('users', UserController::class);
        // logs
        Route::resource('logs', LogController::class);

        // dropzone upload files
        Route::post('/upload_from_dropzone', [HomeController::class, 'upload_from_dropzone']);
        // upload image for CKEditor
        Route::post('upload-image', [HomeController::class, 'uploadImage'])->name('upload-image');
    });

Auth::routes(['register' => false]);
Route::get('/admin', [HomeController::class, 'index'])->name('admin');

//Переключение языков
Route::get('setlocale/{lang}', function ($lang) {
    $referer = Redirect::back()->getTargetUrl(); //URL предыдущей страницы
    $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

    //разбиваем на массив по разделителю
    $segments = explode('/', $parse_url);

    //Если URL (где нажали на переключение языка) содержал корректную метку языка
    if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {

        unset($segments[1]); //удаляем метку
    }

    //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
    if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage) {
        array_splice($segments, 1, 0, $lang);
    }

    //формируем полный URL
    $url = Request::root() . implode("/", $segments);

    //если были еще GET-параметры - добавляем их
    if (parse_url($referer, PHP_URL_QUERY)) {
        $url = $url . '?' . parse_url($referer, PHP_URL_QUERY);
    }
    return redirect($url); //Перенаправляем назад на ту же страницу

})->name('setlocale');

// universities.json to DB
Route::get('json2db', function () {
    $jsonString = file_get_contents('../public/init_data/universities.json');
    $dataArray = json_decode($jsonString, true);

    foreach ($dataArray['universities'] as $university) {
        $region = Region::where('name', 'like', '%'.$university['city'].'%')
            ->first();

        if (!$region) $region = Region::create(['name' => $university['city']]);

        \App\Models\University::create([
            'title' => $university['name'],
            'region_id' => $region->id,
            'district_id' => null
        ]);
    }
});
// viloyatlarning atini to'g'irlash
Route::get('done', function () {
    $universities = \App\Models\University::all();

    foreach ($universities as $university) {
        if ($university->region_id == 1) $university->update(['region_id' => 2]);
        if ($university->region_id == 3) $university->update(['region_id' => 20]);
        if ($university->region_id == 4) $university->update(['region_id' => 17]);
        if ($university->region_id == 6) $university->update(['region_id' => 14]);
        if ($university->region_id == 7) $university->update(['region_id' => 21]);
        if ($university->region_id == 15) $university->update(['region_id' => 21]);
        if ($university->region_id == 8) $university->update(['region_id' => 22]);
        if ($university->region_id == 10) $university->update(['region_id' => 18]);
        if ($university->region_id == 19) $university->update(['region_id' => 21]);
    }

    Region::whereIn('id', [1,3,4,6,7,8,15,10,19])->delete();
});

Route::get('dwn', [Controller::class, 'dwn']);