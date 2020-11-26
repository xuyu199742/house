@extends('layouts.admin')


@section('header')
    <section class="content-header">
        <h1>
            图片规则说明
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">图片规则说明</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box">
        <div class="box-body no-padding">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>页面</th>
                    <th>宽度 (px)</th>
                    <th>高度 (px)</th>
                </tr>
                </thead>
                <tbody>
                @foreach(config('images') as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item[0]}}</td>
                        <td>{{$item[1]}}</td>
                        <td>{{$item[2]}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <p>注: 为在大屏幕手机上取得更好的显示效果，可以根据比例使用更大分辨率图片</p>
@endsection
