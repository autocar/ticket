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
        <th class="span1"><a href="{{ URL::to('ticket?sort=id'.$querystr) }}">编号</a></th>
        <th class="span1"><a href="{{ URL::to('ticket?sort=level'.$querystr) }}">等级</a></th>
        <th class="span2">类型</th>
        <th class="span3"><a href="{{ URL::to('ticket?sort=title'.$querystr) }}">标题</a></th>
        <th class="span1"><a href="{{ URL::to('ticket?sort=status'.$querystr) }}">状态</a></th>
        <th class="span2"><a href="{{ URL::to('ticket?sort=start_time'.$querystr) }}">提交时间</a></th>
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
            @endif

            @if ($job->invalid)
            <span class="label">挂起</span>
            @endif
        </td>
        <td>{{ $job->start_time }}</td>
        <td>
            <a href="{{{ URL::to('ticket/view/'. $job->id) }}}" class="btn btn-mini">查看</a>

            @if ($job->status == 0 || $job->status == 1)

                @if ($job->status == 0 && $job->invalid == 0)
                <a href="{{{ URL::to('ticket/close/'. $job->id) }}}" class="btn btn-mini btn-danger">关闭</a>
                @endif

                @if ($job->status == 1 && $job->invalid == 0)
                <a href="{{{ URL::to('ticket/over/'. $job->id) }}}" class="btn btn-mini btn-success">完成</a>
                @endif

                @if ($job->invalid)
                <a href="{{{ URL::to('ticket/reinvalid/'. $job->id) }}}" class="btn btn-mini btn-info">恢复</a>
                @else
                <a href="{{{ URL::to('ticket/invalid/'. $job->id) }}}" class="btn btn-mini btn-warning">挂起</a>
                @endif

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

{{ $jobs->appends( array('sort' => Input::get('sort'), 'order' => Input::get('order')))->links() }}

@stop
