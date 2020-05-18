<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $statuses = $user->statusses()
                        ->orderBy('created_at','desc')
                        ->paginate(10);
        return view('user.show', compact('user','statuses'));
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
       
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
        // Auth::login($user);
        //session()->flash('success', '欢迎您来到这片荒原！');
        //return redirect()->route('user.show', [$user]);
    }

    protected function sendEmailConfirmationTo($user)
    {
        # code...
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 WeiBo APP ! 请确认您的邮箱。";
        Mail::send($view, $data, function ($message) 
        use ( $to, $subject){
            $message->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {
        # code...
        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success','恭喜你，激活成功');
        return redirect()->route('users.show',[$user]);
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


    public function destroy(User $user = null)
    {
        $this->authorize('delete', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }

    public function __construct()
    {
        # code...
        $this->middleware('auth', [
            'except' => ['create','store', 'index', 'show','confirmEmail']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }


}
