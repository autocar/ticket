@extends('layouts.default')

{{-- styles_src --}}
@section('styles_src')
<link href="{{{ asset('assets/css/jquery.lighter.css') }}}" rel="stylesheet">
@stop

{{-- script --}}
@section('script')
<script src="{{{ asset('assets/js/jquery.lighter.js') }}}"></script>
<script src="{{{ asset('assets/js/jquery.raty.min.js') }}}"></script>
<script type="text/javascript">

    @if ($job->operator_id)
    var pscore = {{ $job->operator->score }};
    var phints = ['一星', '二星', '三星', '四星', '五星'];

    $.fn.raty.defaults.path = "{{{ asset('assets/img') }}}";

    $('#star').raty({ readOnly: true, score: pscore, hints: phints });
    $('#star1').raty({ readOnly: true, score: 1, hints: phints });
    $('#star2').raty({ readOnly: true, score: 2, hints: phints });
    $('#star3').raty({ readOnly: true, score: 3, hints: phints });
    $('#star4').raty({ readOnly: true, score: 4, hints: phints });
    $('#star5').raty({ readOnly: true, score: 5, hints: phints });
    @endif

</script>
@stop

{{-- styles--}}
@section('styles')
@parent
.j_title,.p_info { background: #e7e7e7; padding: 5px; border-radius: 5px; -webkit-border-radius: 5px; margin-bottom: 20px; }
.j_title_inner,.p_info_inner { background: #fff; border: 1px solid #ddd; padding: 15px; }
.p_info_inner { padding: 10px; }
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

    @if (count($job->products))
    &nbsp; / &nbsp;
    相关产品：
    @foreach ($job->products as $product)
    <span class="label label-inverse">{{ $product->name }}</span>
    @endforeach
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

    -

    @if ( $job->invalid == 0 && ($job->status == 0 || $job->status == 1))<a href="{{{ URL::to('ticket/append/'. $job->id) }}}" class="btn btn-inverse btn-mini">追加问题描述</a> @endif

    @if ($job->status == 0 && $job->invalid == 0)<a href="{{{ URL::to('ticket/close/'. $job->id) }}}" class="btn btn-success btn-mini">工单关闭</a>@endif
    @if ($job->status == 1 && $job->invalid == 0)<a href="{{{ URL::to('ticket/over/'. $job->id) }}}" class="btn btn-success btn-mini">工单完成</a>@endif

    @if ($job->invalid)
    <a href="{{{ URL::to('ticket/reinvalid/'. $job->id) }}}" class="btn btn-info btn-mini">工单恢复</a>
    @else
    <a href="{{{ URL::to('ticket/invalid/'. $job->id) }}}" class="btn btn-warning btn-mini">工单挂起</a>
    @endif

</p>

@if ($job->operator_id)
<div class="row-fluid">
    <div class="span9">
@endif
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

@if ($job->operator_id)
    </div>

    <div class="span3">
        <div class="p_info">
            <div class="p_info_inner">
                <h4>服务工程师</h4>
                <hr />

                <img src="{{{ asset('assets/img/engineer.png') }}}" title=""   />

                <hr />

                <table class="table table-striped">
                    <tr>
                        <td><b>工号 / 昵称：</b></td>
                    </tr>
                    <tr>
                        <td>{{ $job->operator->username }}</td>
                    </tr>
                    <tr>
                        <td><b>服务级别：</b></td>
                    </tr>
                    <tr>
                        <td>
                            @if ($job->operator->level == 1)
                            初级工程师
                            @endif
                            @if ($job->operator->level == 2)
                            中级工程师
                            @endif
                            @if ($job->operator->level == 3)
                            高级工程师
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>擅长领域：</b></td>
                    </tr>
                    <tr>
                        <td>{{ $job->operator->territory }} </td>
                    </tr>
                    <tr>
                        <td><b>好评指数：</b></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="star"></div>
                        </td>
                    </tr>
                </table>

                @if (!$job->assess)
                <form method="post" action="" class="form-horizontal">
                <table class="table table-bordered">
                    <tr>
                        <td><b>评分：</b></td>
                    </tr>
                    <tr>
                        <td>
                            <label class="radio">
                                <input type="radio" name="assess" id="assess_1" value="1" > <span id="star1"></span>
                            </label>
                            <label class="radio">
                                <input type="radio" name="assess" id="assess_2" value="2" > <span id="star2"></span>
                            </label>
                            <label class="radio">
                                <input type="radio" name="assess" id="assess_3" value="3" > <span id="star3"></span>
                            </label>
                            <label class="radio">
                                <input type="radio" name="assess" id="assess_4" value="4" > <span id="star4"></span>
                            </label>
                            <label class="radio">
                                <input type="radio" name="assess" id="assess_5" value="5" checked > <span id="star5"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit" class="btn">评分</button>
                        </td>
                    </tr>
                </table>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@if ( $job->invalid == 0 && ($job->status == 0 || $job->status == 1))
<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
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
            <button type="submit" class="btn">回复</button>
        </div>
    </div>
</form>
@endif

@stop