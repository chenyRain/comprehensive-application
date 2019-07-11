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
    <div class="content">
        <div class="card demo-card-header-pic">
            <div class="card-header no-border">
                <div class="facebook-avatar"><a href="javascript:;" class="open-popup" data-popup=".popup-desc">说明</a></div>
                <div class="facebook-name">{{ $goods['name'] }}</div>
                <div class="facebook-date">库存：{{ $goods['repertory'] }}</div>
            </div>
            <div class="card-content">
                <div class="card-content-inner">
                    <button class="button disabled button-big button-fill button-danger at-once">活动尚未开启</button>
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
                1、库存表示该商品有多少库存，当抢购完成时，为 0。
            </p>
            <br>
            <p>
                2、当点立即开始时，表示秒杀活动开始了，这时候可以点击立即抢购抢商品了。
            </p>
            <br>
            <p>
                3、每次活动结束后有30分钟冷却时间，冷却时间过了之后才能继续开始活动。
            </p>
            <br>
            <p>
                4、如果需要体验该功能，请联系应用管理员开启该应用。
            </p>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/seckill.js') }}'></script>
@endsection