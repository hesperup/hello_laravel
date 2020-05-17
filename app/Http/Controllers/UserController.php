<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
        # code...
        $users = User::paginate(8);
        return view('user.index', compact('users'));
    }
    //
    public function create()
    {
        return view('user.create');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success', '欢迎您来到这片荒原！');
        return redirect()->route('user.show', [$user]);
    }

    public function edit(User $user)
    {
        # code...
        Log::debug('传入数据为' . $user->toJson());
        $this->authorize('update', $user);
        return view('user.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {

        $this->authorize('update', $user);
        # code...
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }

    public function __construct()
    {
        # code...
        $this->middleware('auth', [
            'except' => ['store', 'index', 'show']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
}
