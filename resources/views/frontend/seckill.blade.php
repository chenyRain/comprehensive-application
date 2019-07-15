@extends('frontend.layouts.main')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/seckill.css')  }}">
@endsection

@section('head')
    <!-- 标题栏 -->
    <header class="bar bar-nav">
        <a href="{{ route('index') }}" class="icon icon-left pull-left external"></a>
        <h1 class="title">秒杀</h1>
    </header>
@endsection

@section('content')
    <div data-type="2" data-super="{{ $user->is_super }}" class="content" data-id="{{ $user->id }}">
        <div class="card demo-card-header-pic">
            <div class="card-header no-border">
                <div class="facebook-avatar"><a href="javascript:;" class="open-popup" data-popup=".popup-desc">说明</a></div>
                <div class="facebook-name">{{ $goods['name'] }}</div>
                <div class="facebook-date">库存：{{ $goods['repertory'] }}</div>
            </div>
            <div class="card-content">
                <div class="card-content-inner">
                    @if($user->is_super == 1)
                        <button class="button button-big button-fill button-danger at-once start-activity">开启活动</button>
                    @else
                        <button class="button disabled button-big button-fill button-danger at-once">活动尚未开启</button>
                    @endif
                </div>
            </div>
            <div valign="bottom" class="card-header color-white no-border no-padding">
                <img class='card-cover' src="{{ $goods['img'] }}" alt="商品图片">
            </div>
            <div class="card-footer">
                <button class="button disabled button-big button-fill button-danger at-once atonce-buy">立即抢购</button>
            </div>

            <!-- 抢到人的名单 -->
            <div class="card-footer">
                <a href="#" class="button button-fill look-prize">中奖用户名单</a>
            </div>
            <div class="list-block prize">
                <ul>
                    <p class="no-user-data">暂无用户数据</p>
                    {{--<li class="item-content">--}}
                        {{--<div class="item-inner">--}}
                            {{--<div class="item-title">起风了</div>--}}
                            {{--<div class="item-after">x 1</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="item-content">--}}
                        {{--<div class="item-inner">--}}
                            {{--<div class="item-title">test</div>--}}
                            {{--<div class="item-after">x 1</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="item-content">--}}
                        {{--<div class="item-inner">--}}
                            {{--<div class="item-title">宇哥啊</div>--}}
                            {{--<div class="item-after">x 1</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <!-- 说明 -->
    <div class="popup popup-desc">
        <h3 class="rule">规则说明</h3>
        <div class="content-block rule-desc">
            <p>
                1、库存表示该商品的总库存，当抢购完成时，显示剩余库存。
            </p>
            <br>
            <p>
                2、秒杀开启时，会有10秒准备倒计时，倒计时结束，表示秒杀活动开始了，这时候可以点击立即抢购抢商品了。
            </p>
            <br>
            <p>
                3、每次活动结束后需要超级管理员再次开启活动，再能继续体验。
            </p>
            <br>
            <p>
                4、如果需要体验该功能，请联系应用超级管理员开启该活动。
            </p>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/common.js') }}'></script>
    <script type='text/javascript' src='{{ asset('js/seckill.js') }}'></script>
@endsection