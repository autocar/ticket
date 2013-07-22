@extends('layouts.default')

{{-- styles--}}
@section('styles')
@parent
.o_content { margin-left: 80px; background: #FAFAD2;}
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        <div class="pull-right">
            @if ($job->status == 1)<a href="{{{ URL::to('ticket/close/'. $job->id) }}}" class="btn btn-danger">关闭工单</a>@endif

            <a href="{{{ URL::to('ticket/view/'. $job->id) }}}" class="btn btn-primary">查看工单详情</a>
        </div>
        追加工单问题描述
    </h2>
</div>

<div class="t_content well well-small" id="j_{{ $job->id }}">
    <h3>标题：{{ $job->title }}</h3>
    <p>
        &nbsp;
        提交时间：<span class="label">{{ $job->start_time }}</span>
    </p>
    <p>
        <i class="icon-comment"></i>
        &nbsp;
        {{ $job->content }}
    </p>

    <!-- 追加 -->
    @if (count($job->projects()->where('append', '=', '1')->get()))
    <hr />
    @foreach ($job->projects()->where('append', '=', '1')->get() as $project)
    <p>
        <i class="icon-share"></i>
        &nbsp;
        {{ $project->content }}
    </p>
    @endforeach
    @endif
</div>

@if ($job->status == 0 || $job->status == 1)
<form method="post" action="" class="form-horizontal">
    <!-- CSRF Token -->
    {{ Form::token() }}

    <legend>追加工单描述</legend>
    <div class="control-group {{{ $errors->has('content') ? 'error' : '' }}}">
        <label class="control-label" for="content">描述内容</label>

        <div class="controls">
            <textarea class="full-width span6" name="content" value="{{{ Request::old('content') }}}" rows="6"
                      placeholder="请输入内容">{{{ Input::old('content')}}}</textarea>
            {{ $errors->first('content') }}
        </div>
    </div>

    <!-- 工单ID -->
    <input type="hidden" id="job_id" name="job_id" value="{{ Input::old('job_id', $job->id) }}" />

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn">追加</button>
        </div>
    </div>
</form>
@endif

@stop