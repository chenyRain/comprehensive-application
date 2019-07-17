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
    <div data-status="{{ $goods->status }}" data-start="{{ $goods->start_time }}" data-end="{{ $goods->end_time }}" class="content">
        <div class="card demo-card-header-pic">
            <div class="card-header no-border">
                <div class="facebook-avatar"><a href="javascript:;" class="open-popup" data-popup=".popup-desc">说明</a></div>
                <div class="facebook-name">{{ $goods->name }}</div>
                <div class="facebook-date">剩余库存：<span class="repertory">{{ $goods->repertory }}</span></div>
            </div>
            <div class="card-content">
                <div class="card-content-inner">
                    <div class="empty-div"></div>
                </div>
            </div>
            <div valign="bottom" class="card-header color-white no-border no-padding">
                <img class='card-cover' src="{{ $goods->img }}" alt="商品图片">
            </div>
            <div class="card-footer">
                <button class="button disabled button-big button-fill button-danger at-once">立即抢购</button>
            </div>

            <!-- 抢到人的名单 -->
            <div class="card-footer">
                <a href="#" class="button button-fill look-prize">中奖用户名单</a>
            </div>
            <div class="list-block prize">
                <ul class="seckill-result">
                    <p class="no-user-data">暂无用户数据</p>
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
                2、每次活动结束后需要超级管理员再次开启活动，才能继续体验。
            </p>
            <br>
            <p>
                3、如果需要体验该功能，请联系应用超级管理员开启该活动。
            </p>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/seckill.js') }}'></script>
@endsection