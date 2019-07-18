@extends('frontend.layouts.main')

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/set-seckill.js') }}'></script>
@endsection

@section('head')
    <!-- 标题栏 -->
    <header class="bar bar-nav">
        <a href="{{ route('index') }}" class="icon icon-left pull-left external"></a>
        <h1 class="title">秒杀 -- 配置</h1>
    </header>
@endsection

@section('content')
    <div class="content">
        <div class="list-block">
            <ul>
                <!-- Text inputs -->
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">队列允许人数</div>
                            <div class="item-input">
                                <input type="number" id="redis-max-user" min="1" value="{{ $goods->redis_max_user }}" placeholder="redis max user">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">开始时间</div>
                            <div class="item-input">
                                <input type="text" value="{{ $goods->start_time }}" id='datetime-picker-start' placeholder="start time" />
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">结束时间</div>
                            <div class="item-input">
                                <input type="text" value="{{ $goods->end_time }}" id='datetime-picker-end' placeholder="end time" />
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">库存</div>
                            <div class="item-input">
                                <input type="number" id="repertory" min="1" value="{{ $goods->repertory }}" placeholder="repertory">
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Switch (Checkbox) -->
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">是否开启</div>
                            <div class="item-input">
                                <label class="label-switch">
                                    <input id="status" value="0" type="checkbox">
                                    <div class="checkbox"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="content-block">
            <div class="row">
                <div class="col-100"><a href="javascript:;" class="button button-big button-fill button-success seckill-submit">提交</a></div>
            </div>
        </div>
    </div>
@endsection