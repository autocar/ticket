@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h3>
        <div class="pull-right">
            <a href="{{ route('operator') }}" class="btn btn-small btn-inverse"><i
                    class="icon-circle-arrow-left icon-white"></i> 返回</a>
        </div>

        修改用户信息
    </h3>
</div>

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    <legend>基本信息</legend>

    <div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
        <label class="control-label" for="username">用户名 / 员工号</label>
        <div class="controls">
            <input type="text" name="username" id="username" value="{{ Input::old('username', $operator->username) }}"/>
            {{ $errors->first('username', '<span class="help-inline">:message</span>') }}
        </div>
    </div>

    <div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
        <label class="control-label" for="name">姓名</label>

        <div class="controls">
            <input type="text" name="name" id="name" value="{{ Input::old('name', $operator->name) }}"/>
            {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
        </div>
    </div>

    <div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
        <label class="control-label" for="email">邮箱</label>
        <div class="controls">
            <input type="text" name="email" id="email" value="{{ Input::old('email', $operator->email) }}"/>
            {{ $errors->first('email', '<span class="help-inline">:message</span>') }}
        </div>
    </div>

    <div class="control-group {{ $errors->has('mobile') ? 'error' : '' }}">
        <label class="control-label" for="mobile">手机号码</label>
        <div class="controls">
            <input type="text" name="mobile" id="mobile" value="{{ Input::old('mobile', $operator->mobile) }}"/>
            {{ $errors->first('mobile', '<span class="help-inline">:message</span>') }}
        </div>
    </div>

    @if ($operator->lv < 2)
    <div class="control-group {{{ $errors->has('lv') ? 'error' : '' }}}">
        <label class="control-label" for="lv">权限</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="lv" id="lv0" value="0"
                @if ($operator->lv == 0)
                checked
                @endif
                >客服
            </label>
            <label class="radio">
                <input type="radio" name="lv" id="lv1" value="1"
                @if ($operator->lv == 1)
                checked
                @endif
                >管理
            </label>
            {{ $errors->first('lv', '<span class="help-inline">:message</span>') }}
        </div>
    </div>
    @endif

    <legend>修改密码 <small>不修改请为空</small></legend>

    <div class="control-group {{{ $errors->has('password') ? 'error' : '' }}}">
        <label class="control-label" for="password">密码</label>
        <div class="controls">
            <input type="password" name="password" id="password" value="" />
            {{ $errors->first('password', '<span class="help-inline">:message</span>') }}
        </div>
    </div>

    <div class="control-group {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
        <label class="control-label" for="password_confirmation">确认密码</label>
        <div class="controls">
            <input type="password" name="password_confirmation" id="password_confirmation" value="" />
            {{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
        </div>
    </div>


    <!-- Form Actions -->
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-success">更新</button>
            <button type="reset" class="btn">重置</button>
            <a class="btn btn-link" href="{{ route('operator') }}">取消</a>
        </div>
    </div>
</form>
@stop
