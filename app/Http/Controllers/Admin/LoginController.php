<?php
/**
 * Created by PhpStorm.
 * User: karthus
 * Date: 2019/7/24
 * Time: 15:54
 */

namespace App\Http\Controllers\Admin;


use App\Models\Admin\AdminUser;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends BaseController
{
    public function login()
    {
        return view('admin.login');
    }


    /**
     * 登录执行
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginStore(Request $request)
    {
        $data = $request->input();
        try {
            if ($this->validateLogin($data)) {
                throw new \Exception('验证规则不通过');
            }
            if (session('CAPTCHA_IMG') !== $data['captcha']) {
                throw new \Exception('验证码错误');
            }

            $credentials = ['name' => $data['username'], 'password' => $data['password']];
            if (! Auth::guard('admin')->attempt($credentials)) {
                throw new \Exception('用户名或密码错误');
            }

            $this->jsonRes['code'] = 1;
            $this->jsonRes['msg'] = '登录成功';
        } catch (\Exception $e) {
            $this->jsonRes['msg'] = $e->getMessage();
        }
        return response()->json($this->jsonRes);
    }


    /**
     * 设置并输出图片
     */
    public function getCaptcha()
    {
        $phrase = new PhraseBuilder();
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象,配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色25,25,112
        $builder->setBackgroundColor(25, 25, 112);
        // 设置倾斜角度
        $builder->setMaxAngle(25);
        // 设置验证码后面最大行数
        $builder->setMaxBehindLines(10);
        // 设置验证码前面最大行数
        $builder->setMaxFrontLines(10);
        // 设置验证码颜色
        $builder->setTextColor(255, 255, 0);
        // 可以设置图片宽高及字体
        $builder->build($width = 130, $height = 40, $font = null);

        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        session()->put('CAPTCHA_IMG', $phrase);

        // 生成图片
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type:image/jpeg');
        $builder->output();
    }


    /**
     * 源码文件Illuminate\Validation;
     * 验证字段规则
     * @param $data
     * @return bool
     */
    protected function validateLogin($data)
    {
        $validator = \Validator::make($data, [
            'name' => 'bail|required|string|between:1,20',
            'password' => 'bail|required|string|between:6,18',
            'captcha' => 'bail|required|string|size:5'
        ]);

        // 确认数据是否符合规则 Illuminate\Validation
        if ($validator->passes()) {
            return true;
        }
        return false;
    }
}