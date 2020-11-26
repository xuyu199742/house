@extends('layouts.admin')


@section('header')
    <section class="content-header">
        <h1>
            微信小程序链接路径列表
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">小程序链接路径列表</li>
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
                    <th>链接</th>
                    <th>参数说明</th>
                </tr>
                </thead>
                <tbody>
                @foreach(config('linklist') as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item[0]}}</td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" id="link_{{$loop->iteration}}"
                                       value="{{$item[1]}}">
                                <a href="javascript:;" onclick="copyPath({{$loop->iteration}})" class="input-group-addon btn-copy">复制</a>
                            </div>
                        <td>{{$item[2] ?? '-'}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <p>注: <> 内为参数, 请实际数据替换</p>
@endsection


@push('after_scripts')
    <script>
      function copyPath(iteration) {
        const input = document.querySelector('#link_'+iteration);
        input.select();
        if (document.execCommand('copy')) {
          document.execCommand('copy');
          console.log('复制成功');
          new PNotify({
            title: "复制成功",
            text: input.value,
            type: "success"
          });
          return;
        }
      }
    </script>
@endpush