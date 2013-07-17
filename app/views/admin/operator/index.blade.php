@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        <div class="pull-right">
            <a href="{{ URL::to('admin/operator/create') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> 创建用户</a>
        </div>

        用户管理
    </h2>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class="span1">用户ID</th>
        <th class="span2">员工号 / 用户名</th>
        <th class="span2">姓名</th>
        <th class="span2">邮箱</th>
        <th class="span2">手机</th>
        <th class="span1">权限</th>
        <th class="span2">操作</th>
    </tr>
    </thead>
    <tbody>
    @if ($operators->count() >= 1)
    @foreach ($operators as $operator)
    <tr>
        <td>{{ $operator->id }}</td>
        <td>{{ $operator->username }}</td>
        <td>{{ $operator->name }}</td>
        <td>{{ $operator->email }}</td>
        <td>{{ $operator->mobile }}</td>
        <td>
            @if ($operator->lv == 0)
                客服
            @else
                @if ($operator->lv == 1)
                    管理
                @else
                    超管
                @endif
            @endif
        </td>
        <td>
            @if ((Auth::user()->lv > $operator->lv) && (Auth::user()->id <> $operator->id))
            <a href="{{ route('update/operator', $operator->id) }}" class="btn btn-mini">编辑</a>

            <a href="{{ route('delete/operator', $operator->id) }}" class="btn btn-mini btn-danger">删除</a>
            @endif
        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="6">没记录</td>
    </tr>
    @endif

    </tbody>
</table>

@stop