<?php

namespace App\Http\Controllers\Students\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function showLoginForm()
    {
        return view('students.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'passport_number' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('students')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/students/home');
        }

        return back()->withErrors([
            'passport_number' => 'Предоставленные учетные данные не соответствуют нашим записям.',
        ]);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::STUDENTS_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('students')->except('logout');
    }
}
