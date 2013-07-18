@extends('admin.layouts')

{{-- Web site Title --}}
@section('title')
后台登陆 ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <div class="pull-right">
        <a href="{{ URL::to('/') }}" class="btn"><i class="icon-home"></i> 返回首页</a>
    </div>

	<h1>登陆</h1>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<input type="hidden" name="csrf_token" id="csrf_token" value="{{{ Session::getToken() }}}" />

	<!-- Email -->
	<div class="control-group {{{ $errors->has('username') ? 'error' : '' }}}">
		<label class="control-label" for="username">用户名</label>
		<div class="controls">
			<input type="text" name="username" id="username" value="{{{ Input::old('username') }}}" />
			{{{ $errors->first('username') }}}
		</div>
	</div>
	<!-- ./ email -->

	<!-- Password -->
	<div class="control-group {{{ $errors->has('password') ? 'error' : '' }}}">
		<label class="control-label" for="password">密码</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="" />
			{{{ $errors->first('password') }}}
		</div>
	</div>
	<!-- ./ password -->

	<!-- Login button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">登陆</button>
		</div>
	</div>
	<!-- ./ login button -->
</form>
@stop
