@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
          {{ trans('backpack::base.dashboard') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row ">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua ">
                <div class="inner">
                    <h3>{{\App\Models\House::count()}}</h3>
                    <p>房源数量</p>
                </div>
                <div class="icon">
                    <i class="fa fa-building-o"></i>
                </div>
                <a href="{{backpack_url('house')}}" class="small-box-footer"> 查看 <i class="fa fa-arrow-circle-right"></i> </a>
            </div>
        </div>
        <!-- ./col -->
{{--        <div class="col-lg-3 col-xs-6">--}}
{{--            <!-- small box -->--}}
{{--            <div class="small-box bg-green">--}}
{{--                <div class="inner">--}}
{{--                    <h3>{{\App\User::count()}}--}}
{{--                        <sup style="font-size: 12px">昨日: {{\App\User::where('created_at', '>', date('Y-m-d 00:00:00', strtotime('-1 day')))->where('created_at', '<', date('Y-m-d 23:59:59', strtotime('-1 day')))->count()}}</sup>--}}
{{--                    </h3>--}}
{{--                    <p>用户数量</p>--}}
{{--                </div>--}}
{{--                <div class="icon">--}}
{{--                    <i class="fa fa-address-card-o"></i>--}}
{{--                </div>--}}
{{--                <a href="{{backpack_url('users')}}" class="small-box-footer"> 查看 <i class="fa fa-arrow-circle-right"></i></a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- ./col -->--}}
{{--        <div class="col-lg-3 col-xs-6">--}}
{{--            <!-- small box -->--}}
{{--            <div class="small-box bg-yellow">--}}
{{--                <div class="inner">--}}
{{--                    <h3>{{\App\Models\Article::count()}}</h3>--}}
{{--                    <p>文章数量</p>--}}
{{--                </div>--}}
{{--                <div class="icon">--}}
{{--                    <i class="fa fa-newspaper-o"></i>--}}
{{--                </div>--}}
{{--                <a href="{{backpack_url('article')}}" class="small-box-footer"> 查看 <i class="fa fa-arrow-circle-right"></i></a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- ./col -->--}}
{{--        <div class="col-lg-3 col-xs-6">--}}
{{--            <!-- small box -->--}}
{{--            <div class="small-box bg-red">--}}
{{--                <div class="inner">--}}
{{--                    <h3>{{\App\Models\Question::notAnswered()->count()}}</h3>--}}
{{--                    <p>待回答问题</p>--}}
{{--                </div>--}}
{{--                <div class="icon">--}}
{{--                    <i class="fa fa-question-circle-o"></i>--}}
{{--                </div>--}}
{{--                <a href="{{backpack_url('question?not_answered=true')}}" class="small-box-footer"> 查看 <i class="fa fa-arrow-circle-right"></i></a>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- ./col -->
    </div>

{{--    <div class="row hide">--}}
{{--        <div class="col-md-6">--}}
{{--            <div class="box box-success">--}}
{{--                <div class="box-header with-border">--}}
{{--                    <h3 class="box-title">最新评论</h3>--}}
{{--                    <div class="box-tools">--}}
{{--                        <a class="btn btn-xs" href="{{backpack_url('comment')}}">查看全部 <i class="fa fa-arrow-circle-right"></i></a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="box-body no-padding ">--}}
{{--                    <table class="table table-hover">--}}
{{--                        <thead style="white-space: nowrap;">--}}
{{--                        <tr>--}}
{{--                            <th>评论内容</th>--}}
{{--                            <th>评论源</th>--}}
{{--                            <th>发表时间</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @foreach(\App\Models\Comment::orderBy('created_at', 'desc')->take(10)->get() as $comment)--}}
{{--                            <tr>--}}
{{--                                <td>{{str_limit($comment->content)}}</td>--}}
{{--                                <td>{{$comment->commentable_title}}</td>--}}
{{--                                <td>{{$comment->created_at}}</td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
@endsection
