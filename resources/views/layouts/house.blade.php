@extends('layouts.admin')

@section('content')
    <div>
        <a href="{{backpack_url('house')}}" class="btn btn-default btn-sm m-b-10"><i class="fa fa-arrow-left"></i> 返回所有房源</a>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{$house->name}}
            </h3>
            @if(\App\Models\House::STATUS_DRAFT == $house->status)
                <label for="" class="label label-warning label-sm">未发布</label>
            @endif

            @foreach($house->property_types as $property_type)
            <label class="label label-default label-sm"> {{$property_type->name}}</label>
            @endforeach

            @if($house->is_new)
                <label class="label label-info label-sm"> 新盘</label>
            @endif

            @if($house->is_hot)
                <label class="label label-danger label-sm"> 热销</label>
            @endif

            <label class="label label-default label-sm"> {{$house->sale_status}}</label>

            <div class="box-tools">
                <a class="btn btn-sm btn-default" href="{{route('crud.house.edit', $house->id)}}"><i class="fa fa-pencil"></i> 编辑</a>

                @if(\App\Models\House::STATUS_DRAFT == $house->status)
                    <a class="btn btn-sm btn-success" href="{{route('crud.house.publish', $house->id)}}"><i class="fa fa-arrow-up"></i> 发布</a>
                @endif

                @if(\App\Models\House::STATUS_DOWN == $house->status)
                    <a class="btn btn-sm btn-success" href="{{route('crud.house.publish', $house->id)}}"><i class="fa fa-arrow-up"></i> 上架</a>
                @endif

                @if(\App\Models\House::STATUS_PUBLISH == $house->status)
                    <a class="btn btn-sm btn-default" href="{{route('crud.house.unpublish', $house->id)}}"><i class="fa fa-arrow-down"></i> 下架</a>
                @endif

            </div>
        </div>
        <div class="box-body">
            <div class="pull-right">
                <a href="{{url($house->photo)}}" target="_blank"><image class="" src="{{url($house->photo)}}" height="40"></image></a>
            </div>
            <small><i class="fa fa-location-arrow"></i> {{$house->full_location}} - {{$house->address}}</small>
            @if($house->tags)
                <div class="m-t-10">
                    @foreach($house->tags as $tag)
                    <label class="label label-sm" style="background: {{$tag->color}};">{{$tag->name}}</label>
                    @endforeach
                </div>
            @endif
        </div>
{{--        <div class="box-footer">--}}
{{--            <small>--}}
{{--                <i class="fa fa-eye"></i> 浏览: <span class="text-bold">{{number_format($house->total_view)}}</span>--}}
{{--                <i class="fa fa-heart-o m-l-10"></i> 关注: <span class="text-bold">{{number_format($house->total_favor)}}</span>--}}
{{--                <i class="fa fa-comment-o m-l-10"></i> 评论: <span class="text-bold">{{number_format($house->comments()->count())}}</span>--}}
{{--            </small>--}}
{{--        </div>--}}
    </div>

    @yield('house_content')
@endsection
