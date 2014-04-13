<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8"/>
    <title>
        @section('title')
        卡卡罗特支持系统
        @show
    </title>
    <meta name="keywords" content="KK" />
    <meta name="description" content="卡卡罗特支持系统" />

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- baidu css cdn -->
    <link href="http://libs.baidu.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS
    ================================================== -->
    <!--<link href="{{{ asset('assets/css/bootstrap.min.css') }}}" rel="stylesheet">-->
    <!--<link href="{{{ asset('assets/css/bootstrap-responsive.css') }}}" rel="stylesheet">-->

    <!-- google style -->
    <!--<link href="{{{ asset('http://todc.github.io/todc-bootstrap/assets/css/todc-bootstrap.css') }}}" rel="stylesheet">-->

    @yield('styles_src')

    <style>
        @section('styles')
			body {
				padding: 50px 0 30px 0;
			}
        @show
    </style>

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
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><a href="{{{ URL::to('/') }}}"><i class="icon-home"></i> 首页</a></li>

                    <!--工单-->
                    @if (Auth::check())
                    <li {{ (Request::is('ticket/create') ? 'class=active' : '') }}><a href="{{{ URL::to('ticket/create') }}}"><i class="icon-check"></i> 提交工单</a></li>
                    <li {{ (Request::is('ticket') ? 'class=active' : '') }}><a href="{{{ URL::to('ticket') }}}"><i class="icon-th-list"></i> 工单列表</a></li>
                    @endif

<!--                    <li {{ (Request::is('help') ? 'class=active' : '') }}><a href="{{ URL::to('') }}"><i class="icon-file"></i> 帮助文档</a></li>-->
                </ul>

                <ul class="nav pull-right">
                    @if (Auth::check())
                    <li class="navbar-text">您好， {{{ Auth::user()->name }}} </li>
<!--                    <li> <span class="badge badge-important">6</span> </li>-->
                    <li class="divider-vertical"></li>
                    <li
                    {{{ (Request::is('account') ? 'class=active' : '') }}}><a href="{{{ URL::to('account') }}}"><i class="icon-user"></i> 个人资料</a></li>
                    <li><a href="{{{ URL::to('account/logout') }}}"><i class="icon-off"></i> 退出</a></li>
                    @else
                    <li><a
                        href="{{{ URL::to('account/login') }}}"><i class="icon-info-sign"></i> 登陆</a></li>
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
     &copy; <a href="http://www.lapland.name" target="_blank">卡卡罗特</a> 2013 - 2014  当前呈现版本 beta 4.13
    </p>
</div>
<!-- ./ container -->

<!-- Javascripts
================================================== -->
<!--<script src="{{{ asset('assets/js/jquery.v1.8.3.min.js') }}}"></script>-->
<!--<script src="{{{ asset('assets/js/bootstrap/bootstrap.min.js') }}}"></script>-->

<!-- baidu js cdn-->
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<script src="http://libs.baidu.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>

@section('script')
<script type="text/javascript">

</script>
@show

</body>
</html>
