@extends('admin.layouts')

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
.j_title,.c_info { background: #e7e7e7; padding: 5px; border-radius: 5px; -webkit-border-radius: 5px; margin-bottom: 20px; }
.j_title_inner,.c_info_inner { background: #fff; border: 1px solid #ddd; padding: 15px; }
.c_info_inner { padding: 10px; }
.o_title, .m_title { padding:5px 15px; }
.o_title { background: #e0f1f8; }
.m_title { background: #f1f1f1; }
.a_content { margin-top: 20px; }
.p_content { padding: 10px; }
.a_title { padding:10px 10px 10px 20px; background: #fffff9; border-left:3px solid #fefbc1; }
.job_image img {width: 200px;height: 150px;}
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>
        <div class="pull-right">

        </div>
        查看工单 #{{ $job->id }}
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
    <span class="label badge-warning">待处理</span>
    @elseif ($job->status == 1)
    <span class="label label-success">已处理</span>
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

<div class="row-fluid">
    <div class="span9">

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

            @if (count($job->images))
            <hr />
            <p class="job_image">
                @foreach ($job->images as $image)
                <a href="{{{ asset($image->url) }}}"  data-lighter title="点击查看大图">
                    <img  class="img-polaroid" src="{{{ asset($image->url) }}}" alt="点击查看大图" />
                </a>
                @endforeach
            </p>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>

    @if ($count = count($jobs = $job->projects()->where('append', '=', '0')->get()))
    @foreach ($jobs as $key=>$project)
    <div class="@if ($project->operator_id)o_title @else m_title @endif" >
        <div class="pull-right" id="c_{{ $project->id }}">
            #{{ $key + 1 }}
        </div>
        @if ($project->operator_id)
        <b>{{ $project->operator->name }}</b>  ·  {{ $project->reply_time }}
        @else
        <b>{{ $project->member->name }}</b>  ·  {{ $project->reply_time }}
        @endif
    </div>

    <p class="p_content">
        {{ $project->content }}
    </p>

    @if ($project->image)
    <p class="p_content job_image">
        <a href="{{{ asset($project->image->url) }}}"  data-lighter title="点击查看大图"><img  class="img-polaroid" src="{{{ asset($project->image->url) }}}" alt="点击查看大图" width="150" /></a>
    </p>
    @endif

    @endforeach
    @endif

    </div>

    <div class="span3">
        <div class="c_info">
            <div class="c_info_inner">
                <h4>客户信息</h4>

                <hr />

                <img src="{{{ asset('assets/img/customer.png') }}}" title="{{ $job->member->name }}" alt="{{ $job->member->name }}" />

                <hr />

                <table class="table table-striped">
                    <tr>
                        <td><b>姓名：</b></td>
                    </tr>
                    <tr>
                        <td>{{ $job->member->name }}</td>
                    </tr>
                    <tr>
                        <td><b>手机号码：</b></td>
                    </tr>
                    <tr>
                        <td>{{ $job->member->mobile }}</td>
                    </tr>
                    <tr>
                        <td><b>公司名称：</b></td>
                    </tr>
                    <tr>
                        <td>{{ $job->member->company }} </td>
                    </tr>
                    <tr>
                        <td><b>服务产品：</b></td>
                    </tr>
                    <tr>
                        <td>@foreach ($job->member->products as $product) <span class="label label-inverse"> {{ $product->name }} </span> @endforeach</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@if ($job->invalid == 0 && ($job->status == 0 || $job->status == 1) && ($job->operator_id == Auth::user()->id || Auth::user()->lv > 0) )
<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
    <!-- CSRF Token -->
    {{ Form::token() }}

    <hr />

    <div class="control-group {{{ $errors->has('content') ? 'error' : '' }}}">
        <label class="control-label" for="content">回复内容</label>
        <div class="controls">
            <textarea class="full-width span6" name="content" value="{{{ Request::old('content') }}}" rows="6"
                      placeholder="请输入工单回复内容">{{{ Input::old('content')}}}</textarea>
            {{ $errors->first('content') }}
        </div>
    </div>

    <div class="control-group {{{ $errors->has('file') ? 'error' : '' }}}">
        <label class="control-label" for="file">图片附件</label>
        <div class="controls">
            <input type="file" name="file" id="file" value="" />
            {{ $errors->first('file') }}
        </div>
        <div class="controls">
            图片附件请控制在1M以内！
        </div>
    </div>

    <!-- 工单ID -->
    <input type="hidden" id="job_id" name="job_id" value="{{ Input::old('job_id', $job->id) }}" />

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn">回复工单</button>
        </div>
    </div>
</form>
@endif

@stop