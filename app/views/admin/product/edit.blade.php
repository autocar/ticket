@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h3>
        <div class="pull-right">
            <a href="{{ route('product') }}" class="btn btn-small btn-inverse"><i
                    class="icon-circle-arrow-left icon-white"></i> 返回</a>
        </div>

        修改产品信息
    </h3>
</div>

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    <!-- Name -->
    <div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
        <label class="control-label" for="name">产品名称</label>

        <div class="controls">
            <input type="text" name="name" id="name" value="{{ Input::old('name', $product->name) }}"/>
            {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
        </div>
    </div>

    <!-- Form Actions -->
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-success">更新</button>
            <button type="reset" class="btn">重置</button>
            <a class="btn btn-link" href="{{ route('product') }}">取消</a>
        </div>
    </div>
</form>
@stop
