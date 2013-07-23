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

        </div>
        查看工单
    </h2>
</div>

<p class="well well-small">
    问题类型：
    <span class="label label-info">{{ $job->trouble->name }}</span>
    &nbsp; / &nbsp;

    处理等级：
    @if ($job->level == 0)
    <span class="label">一般</span>
    @elseif ($job->level == 1)
    <span class="label label-info">中等</span>
    @else
    <span class="label label-important">紧急</span>
    @endif

    &nbsp; / &nbsp;
    工单状态：
    @if ($job->status == 0)
    <span class="label label-success">处理中</span>
    @elseif ($job->status == 1)
    <span class="label badge-warning">已处理</span>
    @elseif ($job->status == 2)
    <span class="label label-info">已完成</span>
    @else
    <span class="label">已作废</span>
    @endif

    @if (count($job->JP))
    &nbsp; / &nbsp;
    相关产品：
    @foreach ($job->JP as $product)
    <span class="label label-inverse">{{ $product->product->name }}</span>
    @endforeach
    @endif
</p>

<div class="t_content well well-small" id="j_{{ $job->id }}">
    <h4>标题：{{ $job->title }} @if ($job->status == 0 || $job->status == 1) <a href="{{{ URL::to('ticket/append/'. $job->id) }}}" class="btn btn-inverse btn-mini">追加问题描述</a> @endif</h4>
    <p>
        <i class="icon-user"></i>
        &nbsp;
        提交人：<span class="label label-info">{{ Auth::user()->name }}</span>
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

@if ($count = count($jobs = $job->projects()->where('append', '=', '0')->get()))
@foreach ($jobs as $key=>$project)

@if ($key == 0 || ($project->type != $jobs[$key-1]->type))
<div class="@if ($project->operator_id) o_content @endif well well-small">

    <p id="c_{{ $project->id }}">
        @if ($project->operator_id)
        <i class="icon-user"></i>
        &nbsp;
        <span class="label label-inverse">{{ $project->operator->name }}</span>
        &nbsp;
        <span class="label">{{ $project->reply_time }}</span>
        @else
        <span class="label label-info">{{ $project->member->name }}</span>
        &nbsp;
        <span class="label">{{ $project->reply_time }}</span>
        @endif
    </p>
@endif

    <p>
        <i class="icon-comment"></i>
        &nbsp;
        {{ $project->content }}
    </p>

    @if ($key == $count-1)
    </div>
    @else
        @if ($key == 0 && isset($jobs[$key+1]->type) )
            @if ( $jobs[$key+1]->type != $project->type )
            </div>
            @endif
        @elseif (($project->type == $jobs[$key-1]->type) && ($jobs[$key+1]->type != $jobs[$key-1]->type) || ($project->type != $jobs[$key-1]->type) && ($jobs[$key+1]->type == $jobs[$key-1]->type))
            </div>
        @endif
    @endif

@endforeach
@endif

@if ($job->status == 0 || $job->status == 1)
<form method="post" action="" class="form-horizontal">
    <!-- CSRF Token -->
    {{ Form::token() }}

    <hr />

    <div class="control-group {{{ $errors->has('content') ? 'error' : '' }}}">
        <label class="control-label" for="content">回复内容</label>

        <div class="controls">
            <textarea class="full-width span6" name="content" value="{{{ Request::old('content') }}}" rows="6"
                      placeholder="请输入回复内容">{{{ Input::old('content')}}}</textarea>
            {{ $errors->first('content') }}
        </div>
    </div>

    <!-- 工单ID -->
    <input type="hidden" id="job_id" name="job_id" value="{{ Input::old('job_id', $job->id) }}" />

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn">回复</button>
        </div>
    </div>
</form>
@endif

@stop