@extends('admin.layouts')

{{-- Web site Title --}}
@section('title')
个人信息 - @parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>更改个人资料</h1>
</div>

<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">

	<!-- CSRF Token -->
	{{ Form::token() }}

    <legend>基本信息</legend>

    <!-- Name -->
    <div class="control-group {{{ $errors->has('username') ? 'error' : '' }}}">
        <label class="control-label" for="name">用户名</label>
        <div class="controls">
            <input type="text" name="username" id="username" value="{{{ Request::old('username', $user->username) }}}" disabled />
            {{ $errors->first('username') }}
        </div>
    </div>

    <!-- Name -->
    <div class="control-group {{{ $errors->has('name') ? 'error' : '' }}}">
        <label class="control-label" for="name">姓名</label>
        <div class="controls">
            <input type="text" name="name" id="name" value="{{{ Request::old('name', $user->name) }}}" />
            {{ $errors->first('name') }}
        </div>
    </div>

    <div class="control-group {{{ $errors->has('email') ? 'error' : '' }}}">
        <label class="control-label" for="email">邮箱</label>
        <div class="controls">
            <input type="text" name="email" id="email" value="{{{ Request::old('email', $user->email) }}}" />
            {{ $errors->first('email') }}
        </div>
    </div>

    <div class="control-group {{{ $errors->has('mobile') ? 'error' : '' }}}">
        <label class="control-label" for="mobile">手机号码</label>
        <div class="controls">
            <input type="text" name="mobile" id="mobile" value="{{{ Request::old('mobile', $user->mobile) }}}" />
            {{ $errors->first('mobile') }}
        </div>
    </div>

    <div class="control-group {{{ $errors->has('file') ? 'error' : '' }}}">
        <label class="control-label" for="file">头像</label>
        <div class="controls">
            <input type="file" name="file" id="file" value="" />
            {{ $errors->first('file') }}
        </div>

        <div class="controls">

            @if ($user->image_id)

                <?php $image = Image::find($user->image_id) ?>

                <img src="{{{ asset($image['url']) }}}"  width="100" height="100"  class="img-circle" />
            @else
                <img src="{{{ asset('assets/img/engineer.png') }}}" width="100" height="100" />
            @endif

            <br />

            图片附件请控制在100k以内！
        </div>
    </div>

    <legend>修改密码 <small>不修改请为空</small></legend>

	<div class="control-group {{{ $errors->has('password') ? 'error' : '' }}}">
		<label class="control-label" for="password">密码</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="" />
			{{ $errors->first('password') }}
		</div>
	</div>

	<div class="control-group {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
		<label class="control-label" for="password_confirmation">确认密码</label>
		<div class="controls">
			<input type="password" name="password_confirmation" id="password_confirmation" value="" />
			{{ $errors->first('password_confirmation') }}
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">更新</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@stop
