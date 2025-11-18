<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Support\Facades\Validator;
use App\Models\Lang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $title = 'Модераторы';
    public $route_name = 'users';
    public $route_parameter = 'user';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 'moderator')
            ->latest()
            ->paginate(12);
        $universities = University::orderBy('title')
            ->get();
        $languages = Lang::all();

        return view('app.users.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'users' => $users,
            'universities' => $universities,
            'languages' => $languages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universities = University::orderBy('title')
            ->get();
        $langs = Lang::all();

        return view('app.users.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'universities' => $universities,
            'langs' => $langs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:100',
            'username' => 'required|max:100|unique:users',
            'password' => 'required|min:8|max:255|confirmed',
            'university_id' => 'nullable|integer'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'moderator';

        User::create($data);

        return redirect()->route('users.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $langs = Lang::all();

        return view('app.users.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => $langs,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:100',
            'username' => 'required|max:100|unique:users,username,'.$user->id,
            'password' => 'required|min:8|max:255|confirmed'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $user->update($data);

        return redirect()->route('users.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->role == 'admin') {
            return back()->with([
                'success' => false,
                'message' => 'Нельзя удалить админа'
            ]);
        }

        $user->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
