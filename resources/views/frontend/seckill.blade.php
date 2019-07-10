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
                <div class="facebook-avatar"><img src="{{ $goods['img'] }}" width="34" height="34"></div>
                <div class="facebook-name">{{ $goods['name'] }}</div>
                <div class="facebook-date">库存：{{ $goods['repertory'] }}</div>
            </div>
            <div class="card-content">
                <div class="card-content-inner">
                    <a href="javascript:;" class="button button-big button-round seckilling">抢购中，距结束 <b class="seckill-time">60</b></a>
                </div>
            </div>
            <div valign="bottom" class="card-header color-white no-border no-padding">
                <img class='card-cover' src="{{ $goods['img'] }}" alt="商品图片">
            </div>
            <div class="card-footer">
                <a href="javascript:;" class="button disabled button-big button-fill button-danger at-once external">立即抢购</a>
                <a href="javascript:;" class="button disabled button-big button-fill button-danger at-once external">准备中，离下次开启还剩 <b class="seckill-time">60</b></a>
            </div>

            <!-- 抢到人的名单 -->
            <div class="card-footer">
                <a href="#" class="button button-fill look-prize">Fill Button </a>
            </div>
            <div class="list-block prize">
                <ul>
                    <li class="item-content">
                        <div class="item-media"><i class="icon icon-f7"></i></div>
                        <div class="item-inner">
                            <div class="item-title">商品名称</div>
                            <div class="item-after">杜蕾斯</div>
                        </div>
                    </li>
                    <li class="item-content">
                        <div class="item-media"><i class="icon icon-f7"></i></div>
                        <div class="item-inner">
                            <div class="item-title">型号</div>
                            <div class="item-after">极致超薄型</div>
                        </div>
                    </li>
                    <li class="item-content">
                        <div class="item-media"><i class="icon icon-f7"></i></div>
                        <div class="item-inner">
                            <div class="item-title">型号</div>
                            <div class="item-after">极致超薄型</div>
                        </div>
                    </li>
                    <li class="item-content">
                        <div class="item-media"><i class="icon icon-f7"></i></div>
                        <div class="item-inner">
                            <div class="item-title">型号</div>
                            <div class="item-after">极致超薄型</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/seckill.js') }}'></script>
@endsection