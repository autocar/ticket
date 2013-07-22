@extends('admin.layouts')

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
        <td><a href="{{ route('view/ticket', $job->id) }}">#{{ $job->id }}</a></td>
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
        <td><a href="{{ route('view/ticket', $job->id) }}">{{ $job->title }}</a></td>
        <td>
            @if ($job->status == 0)
            <span class="label badge-warning">待处理</span>
            @elseif ($job->status == 1)
            <span class="label label-success">已处理</span>
            @elseif ($job->status == 2)
            <span class="label label-info">已完成</span>
            @else
            <span class="label">已作废</span>
            @endif
        </td>
        <td>{{ $job->start_time }}</td>
        <td>
            <a href="{{ route('view/ticket', $job->id) }}" class="btn btn-mini">查看</a>

            <a href="{{ route('view/close', $job->id) }}" class="btn btn-mini btn-danger">关闭</a>

            @if (Auth::user()->lv > 0)
            <a href="{{ route('view/assign', $job->id) }}" class="btn btn-mini btn-primary">分配客服</a>
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
