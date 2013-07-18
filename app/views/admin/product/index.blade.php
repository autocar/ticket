@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        <div class="pull-right">
            <a href="{{ URL::to('admin/product/create') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> 创建产品</a>
        </div>

        产品管理
    </h2>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class="span2">产品ID</th>
        <th class="span8">产品名称</th>
        <th class="span2">操作</th>
    </tr>
    </thead>
    <tbody>

    @if ($products->count() >= 1)
    @foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        <td>
            <a href="{{ route('update/product', $product->id) }}" class="btn btn-mini">编辑</a>
            <a href="{{ route('delete/product', $product->id) }}" class="btn btn-mini btn-danger">删除</a>
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
