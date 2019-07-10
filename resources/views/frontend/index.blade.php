@extends('frontend.layouts.main')

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/index.js') }}'></script>
@endsection

@section('head')
    <!-- 标题栏 -->
    <header class="bar bar-nav">
        <a class="icon icon-me pull-left open-panel"></a>
        <h1 class="title">应用中心</h1>
    </header>
@endsection

@section('nav')
    <!-- 工具栏 -->
    <nav class="bar bar-tab">
        <a class="tab-item external index-nav-a active" href="#">
            <span class="icon icon-home"></span>
            <span class="tab-label index-function">功能</span>
        </a>
        <a class="tab-item index-nav-a external" href="#">
            <span class="icon icon-edit"></span>
            <span class="tab-label index-function">反馈</span>
        </a>
    </nav>
@endsection

@section('content')
<div class="content">
    @if(! empty($modules))
        @foreach($modules as $module)
            <div class="card more-card">
                <a href="{{ route($module['url']) }}" class="external">
                    <div class="card-header chat-title">{{ $module['title'] }}</div>
                    <div class="card-content">
                        <div class="list-block media-list">
                            <ul>
                                <li class="item-content">
                                    <div class="item-media">
                                        <img src="{{ $module['img'] }}" width="44">
                                    </div>
                                    <div class="item-inner">
                                        <p class="p_intro">{{ $module['desc'] }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <label class="like {{ $module['is_like'] }}" attr-mid="{{ $module['id'] }}">&#10084; <span class="like-num">{{ $module['like_num'] }}</span></label>
                    <a href="{{ route('comment.index', ['m_id' => $module['id']]) }}" class="link external">
                        <span class="icon icon-message"> {{ $module['comments_num'] }}</span>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@section('sidebar')
    <!-- popup, panel 等放在这里 -->
    <div class="panel-overlay"></div>
    <!-- Left Panel with Reveal effect -->
    <div class="panel panel-left panel-reveal">
        <div class="content-block index-container">
            <div class="index-sidebar">
                <h3>{{ $user->name }}</h3>
                <div class="index-sidebar-content">
                    后续完善...
                </div>
                <a id="logout" href="{{ route('site.logout') }}" class="button button-fill button-danger external">退出登录</a>
            </div>
        </div>
    </div>
@endsection
