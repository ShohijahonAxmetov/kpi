<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('test', function() {
    $res = Http::get('https://api.elsevier.com/content/search/author?query=authlast(Alimova)%20and%20authfirst(Fotima)&apiKey=413b87c3e16e914b1bc8f17bc474330c');
    
    dd($res->json());
});