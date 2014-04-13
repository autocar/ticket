@extends('layouts.default')

@section('content')
<div class="hero-unit" style="margin-top: 30px;">
    <div class="page-header">
        <h1>卡卡罗特支持系统 <small>beta 1.0</small></h1>
    </div>

    <p>
        <a class="btn btn-primary" href="{{{ URL::to('ticket/create') }}}">
            提交工单
        </a>
    </p>
</div>
@stop
