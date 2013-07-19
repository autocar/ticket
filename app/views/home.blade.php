@extends('layouts.default')

@section('content')
<div class="hero-unit" style="margin-top: 30px;">
    <div class="page-header">
        <h1>ECDO在线工单系统 <small>alpha 1.0</small></h1>
    </div>

    <p>
        <a class="btn btn-primary" href="{{{ URL::to('ticket/create') }}}">
            提交工单
        </a>
    </p>
</div>
@stop
