@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h3>
        <div class="pull-right">
            <a href="{{ route('customergroup') }}" class="btn btn-small btn-inverse"><i
                    class="icon-circle-arrow-left icon-white"></i> 返回</a>
        </div>

        绑定客服 #{{ $cgroup->name }}
    </h3>
</div>

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    <!-- Name -->
    <div class="control-group {{ $errors->has('operators') ? 'error' : '' }}">
        <label class="control-label" for="operators">客服</label>
        <div class="controls">
            <select id="operators[]" name="operators[]" multiple="multiple">
                @foreach ($operators as $operator)
                <option value="{{ $operator->id }}"{{ (array_key_exists($operator->id, $ocGroups) ? ' selected="selected"' : '') }}>{{ $operator->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('operators', '<span class="help-inline">:message</span>') }}
        </div>
    </div>

    <input type="hidden" id="cgroup_id" name="cgroup_id" value="{{ Input::old('cgroup_id', $cgroup->id) }}" />

    <!-- Form Actions -->
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-success">绑定</button>
            <button type="reset" class="btn">重置</button>
            <a class="btn btn-link" href="{{ route('customergroup') }}">取消</a>
        </div>
    </div>
</form>
@stop
