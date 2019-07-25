@extends('admin.layout.main')

@section('title', '登 录')

@section('css')
    @parent
    <link href="{{ asset('css/admin/login.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="m-login-bg">
        <div class="m-login">
            <h3>后台系统登录</h3>
            <div class="m-login-warp">
                <form class="layui-form">
                    <div class="layui-form-item">
                        <input type="text" name="username" required lay-verify="username" placeholder="用户名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                        <input type="text" name="password" required lay-verify="password" placeholder="密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <input type="text" name="captcha" required lay-verify="captcha" placeholder="验证码" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline">
                            <img class="verifyImg" src="{{ route('admin.getCaptcha') }}">
                        </div>
                    </div>
                    <div class="layui-form-item m-login-btn">
                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="login">登录</button>
                        </div>
                    </div>
                </form>
            </div>
            <p class="copyright"><a href="http://ca.yuchuisay.com">Powered by yuchuisay</a></p>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/admin/login.js') }}'></script>
@endsection