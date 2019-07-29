@extends('admin.layout.main')

@section('title', '后台首页')

@section('css')
    @parent
    <link href="{{ asset('css/admin/index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="wrap-container welcome-container">
        <div class="row">
            <div class="welcome-left-container col-lg-9">
                <div class="data-show">
                    <ul class="clearfix">
                        <li class="col-sm-12 col-md-4 col-xs-12">
                            <a href="javascript:;" class="clearfix">
                                <div class="icon-bg bg-org f-l">
                                    <span class="iconfont">&#xe606;</span>
                                </div>
                                <div class="right-text-con">
                                    <p class="name">会员数</p>
                                    <p><span class="color-org">89</span>数据<span class="iconfont">&#xe628;</span></p>
                                </div>
                            </a>
                        </li>
                        <li class="col-sm-12 col-md-4 col-xs-12">
                            <a href="javascript:;" class="clearfix">
                                <div class="icon-bg bg-blue f-l">
                                    <span class="iconfont">&#xe602;</span>
                                </div>
                                <div class="right-text-con">
                                    <p class="name">文章数</p>
                                    <p><span class="color-blue">189</span>数据<span class="iconfont">&#xe628;</span></p>
                                </div>
                            </a>
                        </li>
                        <li class="col-sm-12 col-md-4 col-xs-12">
                            <a href="javascript:;" class="clearfix">
                                <div class="icon-bg bg-green f-l">
                                    <span class="iconfont">&#xe605;</span>
                                </div>
                                <div class="right-text-con">
                                    <p class="name">评论数</p>
                                    <p><span class="color-green">221</span>数据<span class="iconfont">&#xe60f;</span></p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <!--图表-->
                <div class="chart-panel panel panel-default">
                    <div class="panel-body" id="chart" style="height: 376px;">
                    </div>
                </div>
                <!--服务器信息-->
                <div class="server-panel panel panel-default">
                    <div class="panel-header">服务器信息</div>
                    <div class="panel-body clearfix">
                        <div class="col-md-2">
                            <p class="title">服务器环境</p>
                            <span class="info">Apache/2.4.4 (Win32) PHP/5.4.16</span>
                        </div>
                        <div class="col-md-2">
                            <p class="title">服务器IP地址</p>
                            <span class="info">127.0.0.1   </span>
                        </div>
                        <div class="col-md-2">
                            <p class="title">服务器域名</p>
                            <span class="info">localhost </span>
                        </div>
                        <div class="col-md-2">
                            <p class="title"> PHP版本</p>
                            <span class="info">5.4.16</span>
                        </div>
                        <div class="col-md-2">
                            <p class="title">数据库信息</p>
                            <span class="info">5.6.12-log </span>
                        </div>
                        <div class="col-md-2">
                            <p class="title">服务器当前时间</p>
                            <span class="info">2016-06-22 11:37:35</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="welcome-edge col-lg-3">
                <!--最新留言-->
                <div class="panel panel-default comment-panel">
                    <div class="panel-header">最新留言</div>
                    <div class="panel-body">
                        <div class="commentbox">
                            <ul class="commentList">
                                <li class="item cl"> <a href="#"><i class="avatar size-L radius"><img alt="" src="{{ asset('/img/admin/comment-avatar-default.jpg') }}"></i></a>
                                    <div class="comment-main">
                                        <header class="comment-header">
                                            <div class="comment-meta"><a class="comment-author" href="#">慕枫</a> 评论于
                                                <time title="2014年8月31日 下午3:20" datetime="2014-08-31T03:54:20">2014-8-31 15:20</time>
                                            </div>
                                        </header>
                                        <div class="comment-body">
                                            <p><a href="#">@某人</a> 系统真不错！！！</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item cl"> <a href="#"><i class="avatar size-L radius"><img alt="" src="{{ asset('/img/admin/comment-avatar-default.jpg') }}"></i></a>
                                    <div class="comment-main">
                                        <header class="comment-header">
                                            <div class="comment-meta"><a class="comment-author" href="#">慕枫</a> 评论于
                                                <time title="2014年8月31日 下午3:20" datetime="2014-08-31T03:54:20">2014-8-31 15:20</time>
                                            </div>
                                        </header>
                                        <div class="comment-body">
                                            <p><a href="#">@某人</a> 系统真不错！！！</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item cl"> <a href="#"><i class="avatar size-L radius"><img alt="" src="{{ asset('/img/admin/comment-avatar-default.jpg') }}"></i></a>
                                    <div class="comment-main">
                                        <header class="comment-header">
                                            <div class="comment-meta"><a class="comment-author" href="#">慕枫</a> 评论于
                                                <time title="2014年8月31日 下午3:20" datetime="2014-08-31T03:54:20">2014-8-31 15:20</time>
                                            </div>
                                        </header>
                                        <div class="comment-body">
                                            <p><a href="#">@某人</a> 系统真不错！！！</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item cl"> <a href="#"><i class="avatar size-L radius"><img alt="" src="{{ asset('/img/admin/comment-avatar-default.jpg') }}"></i></a>
                                    <div class="comment-main">
                                        <header class="comment-header">
                                            <div class="comment-meta"><a class="comment-author" href="#">慕枫</a> 评论于
                                                <time title="2014年8月31日 下午3:20" datetime="2014-08-31T03:54:20">2014-8-31 15:20</time>
                                            </div>
                                        </header>
                                        <div class="comment-body">
                                            <p><a href="#">@某人</a> 系统真不错！！！</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div id="pagesbox" style="text-align: center;padding-top: 5px;">

                        </div>
                    </div>
                </div>
                <!--联系-->
                <div class="panel panel-default contact-panel">
                    <div class="panel-header">联系我们</div>
                    <div class="panel-body">
                        <p>QQ：1465465646</p>
                        <p>E-mail:4565564@qq.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type='text/javascript' src='{{ asset('js/admin/lib/echarts/echarts.js') }}'></script>
    <script type='text/javascript' src='{{ asset('js/admin/dashboard.js') }}'></script>
@endsection