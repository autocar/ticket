@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        <div class="pull-right">
            <a href="{{ URL::to('admin/member/create') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> 创建客户</a>
        </div>

        客户管理
    </h2>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class="span1">客户ID</th>
        <th class="span1">编号</th>
        <th class="span2">邮箱</th>
        <th class="span1">姓名</th>
        <th class="span2">手机</th>
        <th class="span2">服务产品</th>
        <th class="span1">服务开始</th>
        <th class="span1">服务结束</th>
        <th class="span1">操作</th>
    </tr>
    </thead>

    <tbody>

    @if ($members->count() >= 1)
    @foreach ($members as $member)
    <tr>
        <td><a href="{{ route('member/ticket', $member->id) }}">{{ $member->id }}</a></td>
        <td>{{ $member->bn }}</td>
        <td>{{ $member->email }}</td>
        <td>{{ $member->name }}</td>
        <td>{{ $member->mobile }}</td>
        <td>
            @foreach ($member->products as $product) <span class="label label-inverse">{{ $product->name }}</span> @endforeach
        </td>
        <td>{{ date("Y-m-d", strtotime($member->start_time)) }}</td>
        <td>{{ date("Y-m-d", strtotime($member->end_time)) }}</td>
        <td>
            <a href="{{ route('update/member', $member->id) }}" class="btn btn-mini">编辑</a>
<!--            <a href="{{ route('delete/member', $member->id) }}" class="btn btn-mini btn-danger">删除</a>-->
        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="9">没记录</td>
    </tr>
    @endif

    </tbody>
</table>

{{ $members->links() }}

@stop
