@extends('frontend.layouts.main')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('head')
    <!-- 标题栏 -->
    <header class="bar bar-nav">
        <a href="{{ route('index') }}" class="icon icon-left pull-left external"></a>
        <a class="icon icon-friends pull-right open-panel"></a>
        <h1 class="title">聊天室</h1>
    </header>
@endsection

@section('content')
    <div class="chat-content" data-id="{{ $user->id }}">
        <ul class="chart-list">

        </ul>
    </div>
    <div class="input-content">
        <div class="input-say">
            <input type="text" id="input-say" class="input-item" placeholder="请输入需要说的话~">
        </div>
        <div class="chat-button">
            <button class="button button-big button-fill button-success button-send">发送</button>
        </div>
    </div>
@endsection

@section('sidebar')
    <div class="panel-overlay"></div>
    <!-- Left Panel with Reveal effect -->
    <div class="panel panel-right panel-reveal">
        <div class="content-block">
            <h4 class="chat_right_h4">在线成员列表</h4>
            <div class="list-group">
                <ul class="user-list">

                </ul>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/websocket.js') }}"></script>
@endsection