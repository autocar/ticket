@extends('admin.layouts')

{{-- Content --}}
@section('content')
<div class="page-header">
    <h3>
        <div class="pull-right">
            <a href="{{ route('ticket') }}" class="btn btn-small btn-inverse"><i
                    class="icon-circle-arrow-left icon-white"></i> 返回</a>
        </div>

        分配客服: #{{ $job->title }}
    </h3>
</div>

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>


    <div class="control-group {{ $errors->has('operator_id') ? 'error' : '' }}">
        <label class="control-label" for="operator_id">客服</label>
        <div class="controls">
            <select name="operator_id" id="operator_id">
                @if ($operators->count() >= 1)
                @foreach ($operators as $operator)
                <option value="{{ $operator->id }}" {{ ($job->operator_id == $operator->id  ? ' selected="selected"' : '') }}>{{ $operator->name }}</option>
                @endforeach
                @else
                <option value="0">请先添加客服</option>
                @endif
            </select>
            {{ $errors->first('operator_id', '<span class="help-inline">:message</span>') }}
        </div>
    </div>

    <input type="hidden" id="job_id" name="job_id" value="{{ Input::old('job_id', $job->id) }}" />

    <!-- Form Actions -->
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-success">分配客服</button>
            <button type="reset" class="btn">重置</button>
            <a class="btn btn-link" href="{{ route('ticket') }}">取消</a>
        </div>
    </div>
</form>
@stop
