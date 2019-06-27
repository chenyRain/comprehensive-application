@extends('frontend.layouts.main')

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/login.js') }}'></script>
@endsection

@section('head')
    <header class="bar bar-nav">
        <a href="{{ route('site.login') }}" class="external">
            <button class="button button-link button-nav pull-right">
                登 录
                <span class="icon icon-right"></span>
            </button>
        </a>
        <h1 class="title">注 册</h1>
    </header>
@endsection

@section('content')
    <div id="list-block-login" class="list-block">
        <ul>
            <!-- Text inputs -->
            <li>
                <div class="item-content">
                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                    <div class="item-inner">
                        <div class="item-title label login-label">用户名</div>
                        <div class="item-input">
                            <input type="text" id="name" placeholder="Your name">
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-media"><i class="icon icon-form-password"></i></div>
                    <div class="item-inner">
                        <div class="item-title label login-label">密码</div>
                        <div class="item-input">
                            <input type="password" id="password" placeholder="Password" class="">
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-media"><i class="icon icon-form-password"></i></div>
                    <div class="item-inner">
                        <div class="item-title label login-label">确认密码</div>
                        <div class="item-input">
                            <input type="password" id="repassword" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="content-block">
        <div class="row">
            <div class="col-100 register"><a href="#" class="button button-big button-fill button-success">登 录</a></div>
        </div>
    </div>
@endsection