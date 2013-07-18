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

<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	{{ Form::token() }}

    <!-- Name -->
    <div class="control-group {{{ $errors->has('title') ? 'error' : '' }}}">
        <label class="control-label" for="title">工单标题</label>
        <div class="controls">
            <input type="text" name="title" id="title" value="{{{ Request::old('title') }}}" placeholder="请输入工单标题" />
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
            <option value="{{ $trouble->id }}" >{{ $trouble->name }}</option>
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

    <div class="control-group {{{ $errors->has('content') ? 'error' : '' }}}">
        <label class="control-label" for="content">工单内容</label>
        <div class="controls">
            <textarea class="full-width span8" name="content" value="{{{ Request::old('content') }}}" rows="10" placeholder="请输入工单内容">{{{ Input::old('content')}}}</textarea>
            {{ $errors->first('content') }}
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
