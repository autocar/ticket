<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8"/>
    <title>
        @section('title')
        ECDO - 在线工单系统 :: 管理后台
        @show
    </title>

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS
    ================================================== -->
    <link href="{{{ asset('assets/css/bootstrap.css') }}}" rel="stylesheet">
    <!--<link href="{{{ asset('assets/css/bootstrap-responsive.css') }}}" rel="stylesheet">-->

    @yield('styles_src')

    <style>
        @section('styles')
			body {
				padding: 50px 0;
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


                    <!--工单-->
                    @if (Auth::check())
                    <li {{{ (Request::is('admin/ticket') ? 'class=active' : '') }}}><a href="{{{ URL::to('admin/ticket') }}}"><i class="icon-th-list icon-white"></i> 工单管理</a></li>
                        @if (Auth::user()->lv > 0)
                        <li {{{ (Request::is('admin/member') ? 'class=active' : '') }}}><a href="{{{ URL::to('admin/member') }}}"><i class="icon-user icon-white"></i> 客户管理</a></li>
                        <li {{{ (Request::is('admin/operator') ? 'class=active' : '') }}}><a href="{{{ URL::to('admin/operator') }}}"><i class="icon-list-alt icon-white"></i> 用户管理</a></li>
                        <li {{{ (Request::is('admin/product') ? 'class=active' : '') }}}><a href="{{{ URL::to('admin/product') }}}"><i class="icon-align-justify icon-white"></i> 产品管理</a></li>
                        <li {{{ (Request::is('admin/type') ? 'class=active' : '') }}}><a href="{{{ URL::to('admin/type') }}}"><i class="icon-globe icon-white"></i> 问题类型</a></li>
                        @endif
                    @endif
                </ul>

                <ul class="nav pull-right">
                    @if (Auth::check())
                    <li class="navbar-text">您好， {{{ Auth::user()->username }}}</li>
                    <li class="divider-vertical"></li>
                    <li><a href="{{{ URL::to('/') }}}"><i class="icon-home icon-white"></i> 首页</a></li>
                    <li {{{ (Request::is('admin/account') ? 'class=active' : '') }}}><a href="{{{ URL::to('admin/account') }}}"><i class="icon-user icon-white"></i> 个人资料</a></li>
                    <li><a href="{{{ URL::to('admin/logout') }}}"><i class="icon-off icon-white"></i> 退出</a></li>
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
</div>
<!-- ./ container -->

<!-- Javascripts
================================================== -->
<script src="{{{ asset('assets/js/jquery.v1.8.3.min.js') }}}"></script>
<script src="{{{ asset('assets/js/bootstrap/bootstrap.min.js') }}}"></script>

@section('script')
<script type="text/javascript">

</script>
@show
</body>
</html>