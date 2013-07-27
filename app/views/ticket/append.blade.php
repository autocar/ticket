@extends('layouts.default')

{{-- styles_src --}}
@section('styles_src')
<link href="{{{ asset('assets/css/jquery.lighter.css') }}}" rel="stylesheet">
@stop

{{-- script --}}
@section('script')
<script src="{{{ asset('assets/js/jquery.lighter.js') }}}"></script>
<script type="text/javascript">

</script>
@stop

{{-- styles--}}
@section('styles')
@parent
.j_title { background: #e7e7e7; padding: 5px; border-radius: 5px; -webkit-border-radius: 5px; margin-bottom: 20px; }
.j_title_inner { background: #fff; border: 1px solid #ddd; padding: 15px; }
.o_title, .m_title { padding:5px 15px; }
.o_title { background: #e0f1f8; }
.m_title { background: #f1f1f1; }
.a_content { margin-top: 20px; }
.p_content { padding: 10px; }
.a_title { padding:10px 10px 10px 20px; background: #fffff9; border-left:3px solid #fefbc1; }
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        <div class="pull-right">
            <a href="{{{ URL::to('ticket/view/'. $job->id) }}}" class="btn btn-primary">查看工单详情</a>
        </div>
        追加工单问题描述 #{{ $job->id }}
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
    <span class="label label-warning">已处理</span>
    @elseif ($job->status == 2)
    <span class="label label-info">已关闭</span>
    @elseif ($job->status == 3)
    <span class="label label-info">已完成</span>
    @endif

    @if ($job->invalid)
    <span class="label">挂起</span>
    @endif

    @if (count($job->products))
    &nbsp; / &nbsp;
    相关产品：
    @foreach ($job->products as $product)
    <span class="label label-inverse">{{ $product->name }}</span>
    @endforeach
    @endif
</p>

<div class="j_title" id="j_{{ $job->id }}">
    <div class="j_title_inner">
        <h3>标题：{{ $job->title }}</h3>
        <p>
            <i class="icon-user"></i> <b>{{ $job->member->name }}</b> 发表于 {{ $job->start_time }}
        </p>
        <hr />
        <p>
            {{ $job->content }}
        </p>

        @if ($job->image)
        <p>
            <a href="{{{ asset($job->image->url) }}}"  data-lighter title="点击查看大图"><img  class="img-polaroid" src="{{{ asset($job->image->url) }}}" alt="点击查看大图" width="150" /></a>
        </p>
        @endif

        <!-- 追加 -->
        @if (count($job->projects()->where('append', '=', '1')->get()))
        <div class="clearfix"></div>
        <div class="a_content">
            @foreach ($job->projects()->where('append', '=', '1')->get() as $key=>$project)
            <p class="a_title">
                第 {{ $key + 1 }} 条附言  ·  {{ $project->reply_time }}
                <br /><br />
                {{ $project->content }}
            </p>
            @endforeach
        </div>
        @endif

        <div class="clearfix"></div>

        @if ($job->status == 0 || $job->status == 1)
        <form method="post" action="" class="form-horizontal">
            <!-- CSRF Token -->
            {{ Form::token() }}

            <hr />

            <div class="control-group {{{ $errors->has('content') ? 'error' : '' }}}">
                <label class="control-label" for="content">追加内容</label>

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

    </div>
    <div class="clearfix"></div>
</div>

@stop