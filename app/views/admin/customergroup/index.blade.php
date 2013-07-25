@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        <div class="pull-right">
            <a href="{{ URL::to('admin/type/create') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> 创建问题类型</a>
        </div>

        问题类型
    </h2>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class="span2">类型ID</th>
        <th class="span8">问题类型</th>
        <th class="span2">操作</th>
    </tr>
    </thead>
    <tbody>

    @if ($troubles->count() >= 1)
    @foreach ($troubles as $trouble)
    <tr>
        <td>{{ $trouble->id }}</td>
        <td>{{ $trouble->name }}</td>
        <td>
            <a href="{{ route('update/type', $trouble->id) }}" class="btn btn-mini">编辑</a>
            <a href="{{ route('delete/type', $trouble->id) }}" class="btn btn-mini btn-danger">删除</a>
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
