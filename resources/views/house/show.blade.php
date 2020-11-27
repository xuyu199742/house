@extends('layouts.house')

@section('house_content')
    <div class="nav-tabs-custom">
        @include('house.inc.nav', [ 'active' => 'info' ])
        <div class="tab-content">
            <table class="table table-hover table-bordered">
                <tr>
                    <td class="bg-gray-light" style="width: 120px;">名称</td>
                    <td>{{$house->name}}</td>
                </tr>
                <tr>
                    <td class="bg-gray-light">地址</td>
                    <td>{{$house->address}}</td>
                </tr>
                <tr>
                    <td class="bg-gray-light">挂牌时间</td>
                    <td>{{$house->open_at}}</td>
                </tr>
                <tr>
                    <td class="bg-gray-light">占地面积</td>
                    <td>{{$house->area}} ㎡</td>
                </tr>
                <tr>
                    <td class="bg-gray-light">开发商</td>
                    <td>{{$house->developer}}</td>
                </tr>
                <tr>
                    <td class="bg-gray-light">物业类型</td>
                    <td>{{$house->property_type}}</td>
                </tr>

                <tr>
                    <td class="bg-gray-light">评论</td>
                    <td>{{$house->commentable?'打开':'关闭'}}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
