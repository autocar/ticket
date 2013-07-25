@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        <div class="pull-right">
            <a href="{{ URL::to('admin/customergroup/create') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> 创建客服组</a>
        </div>

        客服组
    </h2>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class="span2">客服组ID</th>
        <th class="span7">客服组名称</th>
        <th class="span3">操作</th>
    </tr>
    </thead>
    <tbody>

    @if ($cgroups->count() >= 1)
    @foreach ($cgroups as $cgroup)
    <tr>
        <td>{{ $cgroup->id }}</td>
        <td>{{ $cgroup->name }}</td>
        <td>
            <a href="{{ route('update/customergroup', $cgroup->id) }}" class="btn btn-mini">编辑</a>
            <a href="{{ route('bound/customergroup', $cgroup->id) }}" class="btn btn-mini btn-primary">绑定客服</a>
            <a href="{{ route('delete/customergroup', $cgroup->id) }}" class="btn btn-mini btn-danger">删除</a>
        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="3">没记录</td>
    </tr>
    @endif

    </tbody>
</table>

@stop
