@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        @if (isset($member)) 客户：{{ $member->name }} @endif 工单列表
    </h2>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class="span1"><a href="{{ URL::to('admin/ticket?sort=id'.$querystr) }}">编号</a></th>
        <th class="span1"><a href="{{ URL::to('admin/ticket?sort=level'.$querystr) }}">请求</a></th>
        <th class="span2">类型</th>
        <th class="span3"><a href="{{ URL::to('admin/ticket?sort=title'.$querystr) }}">标题</a></th>
        <th class="span1"><a href="{{ URL::to('admin/ticket?sort=status'.$querystr) }}">状态</a></th>
        <th class="span2"><a href="{{ URL::to('admin/ticket?sort=start_time'.$querystr) }}">提交时间</a></th>
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
            <a href="{{ route('view/ticket', $job->id) }}" class="btn btn-mini">查看</a>

            @if ($job->invalid == 0)
                @if ($job->status == 0 && Auth::user()->lv == 0 && $job->operator_id != Auth::user()->id)
                    <a href="{{ route('view/apply', $job->id) }}" class="btn btn-mini btn-primary">申请</a>
                @endif

                @if (Auth::user()->lv > 0)
                <a href="{{ route('view/close', $job->id) }}" class="btn btn-mini btn-danger">关闭</a>
                <a href="{{ route('view/assign', $job->id) }}" class="btn btn-mini btn-primary">分配客服</a>
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
