@extends('layouts.default')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        工单列表
    </h2>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class="span1">编号</th>
        <th class="span1">等级</th>
        <th class="span2">类型</th>
        <th class="span3">标题</th>
        <th class="span1">状态</th>
        <th class="span2">提交时间</th>
        <th class="span2">操作</th>
    </tr>
    </thead>
    <tbody>
    @if ($jobs->count() >= 1)
    @foreach ($jobs as $job)
    <tr>
        <td><a href="{{{ URL::to('ticket/view/'. $job->id) }}}" >#{{ $job->id }}</a></td>
        <td>
            @if ($job->level == 0)
            <span class="label">一般</span>
            @elseif ($job->level == 1)
            <span class="label label-info">中等</span>
            @else
            <span class="label label-important">紧急</span>
            @endif
        </td>
        <td>{{ $job->trouble->name }}</td>
        <td>
            <a href="{{{ URL::to('ticket/view/'. $job->id) }}}" >{{ $job->title }}</a>
        </td>
        <td>
            @if ($job->status == 0)
            <span class="label label-success">处理中</span>
            @elseif ($job->status == 1)
            <span class="label label-warning">已处理</span>
            @elseif ($job->status == 2)
            <span class="label label-info">已关闭</span>
            @elseif ($job->status == 3)
            <span class="label label-info">已完成</span>
            @elseif ($job->status == 4)
            <span class="label">挂起</span>
            @endif
        </td>
        <td>{{ $job->start_time }}</td>
        <td>
            <a href="{{{ URL::to('ticket/view/'. $job->id) }}}" class="btn btn-mini">查看</a>

            @if ($job->status == 1)
            <a href="{{{ URL::to('ticket/close/'. $job->id) }}}" class="btn btn-mini btn-danger">关闭</a>
            <a href="{{{ URL::to('ticket/over/'. $job->id) }}}" class="btn btn-mini btn-success">完成</a>
            @endif

            @if ($job->status == 0 || $job->status == 1)
            <a href="{{{ URL::to('ticket/invalid/'. $job->id) }}}" class="btn btn-mini btn-warning">挂起</a>
            @endif

            @if ($job->status == 4)
            <a href="{{{ URL::to('ticket/reinvalid/'. $job->id) }}}" class="btn btn-mini btn-info">恢复</a>
            @endif
        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="7">没工单记录</td>
    </tr>
    @endif
    </tbody>
</table>

{{ $jobs->links() }}

@stop
