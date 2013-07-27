@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>系统参数配置</h1>
</div>

<form method="post" action="" class="form-horizontal">

	<!-- CSRF Token -->
	{{ Form::token() }}

    <legend>自动关闭工单</legend>

    <div class="control-group {{{ $errors->has('auto_close') ? 'error' : '' }}}">
        <label class="control-label" for="auto_close">是否开启</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="auto_close" id="auto_close_1" value="1" @if ($auto_close) checked @endif > 是
            </label>

            <label class="radio">
                <input type="radio" name="auto_close" id="auto_close_0" value="0"  @if ($auto_close == 0) checked @endif > 否
            </label>
            {{ $errors->first('auto_close') }}
        </div>
    </div>

    <div class="control-group {{{ $errors->has('auto_close_time') ? 'error' : '' }}}">
        <label class="control-label" for="auto_close_time">关闭周期</label>
        <div class="controls">
            <input type="text" name="auto_close_time" id="auto_close_time" value="{{{ Request::old('auto_close_time', $auto_close_time) }}}" />
            {{ $errors->first('auto_close_time') }}
        </div>
        <div class="controls">
            以小时为单位
        </div>
    </div>

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">配置</button>
		</div>
	</div>
</form>
@stop
