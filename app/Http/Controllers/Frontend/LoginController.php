<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Validator;

class LoginController extends BasicController
{
    /**
     * 登录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('frontend.login');
    }

    /**
     * 执行登陆
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function loginStore(Request $request)
    {
        if (! $request->ajax()) {
            return back()->withInput();
        }

        $data = $request->all();

        // 验证规则
        if ($this->validateLogin($data)) {
            return response()->json($this->jsonRes);
        }

        // 验证用户是否存在
        $user = User::select('id', 'name', 'password')->where('name', $data['name'])->first();
        if (empty($user)) {
            $this->jsonRes['msg'] = '用户名不存在~';
            return response()->json($this->jsonRes);
        }

        // 验证密码是否正确
        if (! Hash::check($data['password'], $user->password)) {
            $this->jsonRes['msg'] = '用户名或密码错误~';
            return response()->json($this->jsonRes);
        }

        // 登陆
        Auth::login($user);

        // 存入用户信息
        $redis_info = array(
            'id:'.$user->id => $user->id,
            'name:'.$user->id => $user->name
        );
        Redis::hmset('userinfo', $redis_info);

        $this->jsonRes['code'] = 200;
        return response()->json($this->jsonRes);
    }

    /**
     * 注册
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        return view('frontend.register');
    }

    /**
     *  执行注册
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerStore(Request $request)
    {
        if (! $request->ajax()) {
            return back()->withInput();
        }

        $data = $request->all();

        // 验证
        if ($this->validateRegister($data)) {
            return response()->json($this->jsonRes);
        }

        if (User::where('name', $data['name'])->first()) {
            $this->jsonRes['msg'] = '用户名已存在~';
            return response()->json($this->jsonRes);
        }

        // 添加用户信息
        if (! User::register($data)) {
            return response()->json($this->jsonRes);
        }
        $this->jsonRes['code'] = 200;
        return response()->json($this->jsonRes);
    }


    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        // 清除redis用户信息
        $uid = Auth::id();
        $redis_info = array(
            'id:'.$uid,
            'name:'.$uid
        );
        Redis::hdel('userinfo', $redis_info);

        // 清除session数据
        Auth::logout();

        return redirect()->route('site.login');
    }


    /**
     * @param $data
     * @return bool
     */
    protected function validateRegister($data)
    {
        $validator = Validator::make($data, [
            'name' => 'bail|required|string|max:180',
            'password' => 'bail|required|string|max:30|confirmed'
        ]);

        if ($validator->fails()) {
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function validateLogin($data)
    {
        $validator = Validator::make($data, [
            'name' => 'bail|required|string|max:180',
            'password' => 'bail|required|string|max:30'
        ]);

        if ($validator->fails()) {
            return true;
        }
        return false;
    }
}