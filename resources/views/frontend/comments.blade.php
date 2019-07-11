@extends('frontend.layouts.main')

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/comment.js') }}'></script>
@endsection

@section('head')
<!-- 标题栏 -->
<header class="bar bar-nav">
    <a href="{{ route('index') }}" class="icon icon-left pull-left external"></a>
    <h1 class="title">{{ $module_name }}</h1>
</header>
@endsection

@section('content')
<div class="content infinite-scroll" data-distance="0">
    <div class="comment-send">
        <div class="send-textarea">
            <textarea class="comment-textarea" placeholder="文明上网，理性发言"></textarea>
        </div>
        <div class="send-button">
            <button attr-id="{{ $m_id }}" class="button-success comment-button">发送</button>
        </div>
    </div>
    <div class="list-block comment-list-div media-list">
        <ul class="comment-list">
            @if(!empty($list))
                @foreach($list as $item)
                    <li>
                        <div class="item-inner">
                            <div class="item-title-row">
                                <div class="item-title comment-username">{{ $item->name }}</div>
                                <div class="item-after time-color">{{ $item->ctime }}</div>
                            </div>
                            <div class="item-text comment-content">{{ $item->content }}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    <!-- 加载提示符 -->
    <div class="infinite-scroll-preloader"></div>
    <div class="page-bottom"></div>
</div>
@endsection