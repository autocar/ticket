<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8"/>
    <title>
        @section('title')
        ECDO - 在线工单系统
        @show
    </title>
    <meta name="keywords" content="ecdo" />
    <meta name="author" content="cooper" />
    <meta name="description" content="" />

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS
    ================================================== -->
    <link href="{{{ asset('assets/css/bootstrap.css') }}}" rel="stylesheet">

    <style>
        @section('styles')
			body {
				padding-top: 60px;
			}
        @show
    </style>

    <link href="{{{ asset('assets/css/bootstrap-responsive.css') }}}" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Favicons
    ================================================== -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
    <link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
    <link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
</head>

<body>

<!-- Navbar -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li {{{ (Request::is('/') ? 'class=active' : '') }}}><a href="{{{ URL::to('') }}}"><i class="icon-home icon-white"></i> 首页</a></li>

                    <!--工单-->
                    @if (Auth::check())
                    <li><a href="{{{ URL::to('') }}}"><i class="icon-check icon-white"></i> 提交工单</a></li>
                    <li><a href="{{{ URL::to('') }}}"><i class="icon-th-list icon-white"></i> 工单列表</a></li>
                    @endif

                    <li {{ (Request::is('help') ? 'class=active' : '') }}><a href="{{ URL::to('') }}"><i class="icon-file icon-white"></i> 帮助文档</a></li>
                </ul>

                <ul class="nav pull-right">
                    @if (Auth::check())
                    <li class="navbar-text">您好， {{{ Auth::user()->name }}}</li>
                    <li class="divider-vertical"></li>
                    <li
                    {{{ (Request::is('account') ? 'class="active"' : '') }}}><a href="{{{ URL::to('account') }}}">个人资料</a></li>
                    <li><a href="{{{ URL::to('account/logout') }}}">退出</a></li>
                    @else
                    <li
                    {{{ (Request::is('account/login') ? 'class="active"' : '') }}}><a
                        href="{{{ URL::to('account/login') }}}">登陆</a></li>
                    <li
                    @endif
                </ul>
            </div>
            <!-- ./ nav-collapse -->
        </div>
    </div>
</div>
<!-- ./ navbar -->

<!-- Container -->
<div class="container">
    <!-- Notifications -->
    @include('notifications')
    <!-- ./ notifications -->

    <!-- Content -->
    @yield('content')
    <!-- ./ content -->

    <p>
        <hr />
        在线工单平台 &copy; ecdo.cc 2013
    </p>
</div>
<!-- ./ container -->

<!-- Javascripts
================================================== -->
<script src="{{{ asset('assets/js/jquery.v1.8.3.min.js') }}}"></script>
<script src="{{{ asset('assets/js/bootstrap/bootstrap.min.js') }}}"></script>
</body>
</html>