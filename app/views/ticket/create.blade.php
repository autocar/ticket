@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
提交工单 - @parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>提交工单</h1>
</div>

<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
	<!-- CSRF Token -->
	{{ Form::token() }}

    <!-- Name -->
    <div class="control-group {{{ $errors->has('title') ? 'error' : '' }}}">
        <label class="control-label" for="title">工单标题</label>
        <div class="controls">
            <input type="text" name="title" id="title" value="{{{ Input::old('title') }}}" placeholder="请输入工单标题" />
            {{ $errors->first('title') }}
        </div>
    </div>

    <!-- Name -->
    <div class="control-group {{{ $errors->has('trouble_id') ? 'error' : '' }}}">
        <label class="control-label" for="trouble_id">问题类型</label>
        <div class="controls">
            <select name="trouble_id" id="trouble_id">
            @if ($troubles->count() >= 1)
            @foreach ($troubles as $trouble)
            <option value="{{ $trouble->id }}" {{ (Auth::user()->trouble_id == $trouble->id  ? ' selected="selected"' : '') }} >{{ $trouble->name }}</option>
            @endforeach
            @else
            <option value="">请先添加问题类型</option>
            @endif
            </select>
            {{ $errors->first('trouble_id') }}
        </div>
    </div>

    <div class="control-group {{{ $errors->has('level') ? 'error' : '' }}}">
        <label class="control-label" for="level">请求级别</label>
        <div class="controls">
            <select name="level" id="level">
                <option value="0" selected>一般</option>
                <option value="1">中等</option>
                <option value="2">紧急</option>
            </select>
            {{ $errors->first('level') }}
        </div>
    </div>

    <div class="control-group {{ $errors->has('product') ? 'error' : '' }}">
        <label class="control-label" for="product">相关产品</label>
        <div class="controls">
            @if (Auth::user()->products->count() >= 1)
            @foreach (Auth::user()->products as $product)
            <label class="checkbox inline">
                <input type="checkbox" name="product[]" id="product_{{ $product->id }}" value="{{ $product->id }}"> {{ $product->name }}
            </label>
            @endforeach
            @endif
            {{ $errors->first('product') }}
        </div>
    </div>

    <div class="control-group {{{ $errors->has('content') ? 'error' : '' }}}">
        <label class="control-label" for="content">工单内容</label>
        <div class="controls">
            <textarea class="full-width span6" name="content" value="{{{ Input::old('content') }}}" rows="6" placeholder="请输入工单内容">{{{ Input::old('content') }}}</textarea>
            {{ $errors->first('content') }}
        </div>
    </div>

    <div class="control-group {{{ $errors->has('file') ? 'error' : '' }}}">
        <label class="control-label" for="file">图片附件</label>
        <div class="controls">
            <input type="file" name="file[]" id="file_1" value="" />
        </div>
        <div class="controls">
            <input type="file" name="file[]" id="file_2" value="" />
        </div>
        <div class="controls">
            <input type="file" name="file[]" id="file_3" value="" />
        </div>
        <div class="controls">
            图片附件请控制在1M以内！
        </div>
    </div>

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">提交工单</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@stop
