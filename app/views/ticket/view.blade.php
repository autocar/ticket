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
    @if (is_array($job->JP))
    &nbsp; / &nbsp;
    相关产品：
    @foreach ($job->JP as $product) <span class="label label-inverse">{{ $product->product->name }}</span> @endforeach
    @endif
</p>

@foreach ($job->titles as $title)
<div class="t_content well" id="t_{{ $title->id }}">
    @if( $title->title )
    <h4>标题：{{ $title->title }}</h4>
    @endif
    <p>
        提交人：<span class="label label-info">{{ Auth::user()->name }}</span>
        &nbsp; / &nbsp;
        提交时间：<span class="label">{{ $title->start_time }}</span>
        <hr />
    </p>
    <p>
        <i class="icon-comment"></i>
        工单内容：

        {{ $title->content }}
    </p>
</div>
@foreach ($title->projects as $project)
<div class="o_content well">
    <p id="c_{{ $project->id }}">
        回复客服 : <span class="label label-info">{{ $project->operator->name }}</span>
        &nbsp; / &nbsp;
        回复时间 : <span class="label">{{ $project->end_time }}</span>
        <hr />
    </p>
    <p>
        <i class="icon-check"></i>
        回复内容：
        {{ $project->content }}
    </p>
</div>
@endforeach
@endforeach

@if ($job->status == 0 || $job->status == 1)
<form method="post" action="" class="form-horizontal">
    <!-- CSRF Token -->
    {{ Form::token() }}

    <legend>继续提交内容</legend>

    <div class="control-group {{{ $errors->has('content') ? 'error' : '' }}}">
        <label class="control-label" for="content">工单内容</label>

        <div class="controls">
            <textarea class="full-width span8" name="content" value="{{{ Request::old('content') }}}" rows="10"
                      placeholder="请输入工单内容">{{{ Input::old('content')}}}</textarea>
            {{ $errors->first('content') }}
        </div>
    </div>

    <!-- 工单ID -->
    <input type="hidden" id="job_id" name="job_id" value="{{ Input::old('job_id', $job->id) }}" />

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn">追加工单</button>
        </div>
    </div>
</form>
@endif

@stop