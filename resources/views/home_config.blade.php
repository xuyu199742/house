@extends('layouts.admin')

@php
@endphp

@section('header')
    <section class="content-header">
        <h1>
            首页配置 <a class="btn btn-default" href="{{backpack_url('homeconfigcategory')}}" target="_blank">  类型管理 <i class="fa fa-arrow-right"></i></a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">首页配置</li>
        </ol>
    </section>
@endsection

@section('content')
@foreach(\App\Models\HomeconfigCategory::all() as $category)
    @if($loop->index % 4 == 0)
    <div class="row ">
    @endif
    <div class="col-md-3">
        <div class="box">
            <div class="box-header with-border">
                <span class="box-title">{{$category->name}}</span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="todo-list" data-category="{{$category->id}}">
                    @foreach(\App\Models\Homeconfig::ofCategory($category->id)->get() as $homeconfig)
                        <li data-house_id="{{$homeconfig->house_id}}" style="cursor: move;">
                            <a target="_blank" href="{{route('crud.house.show', $homeconfig->house_id)}}" class="text">
                                <image style="width: 30px; height: 24px; border-radius: 3px; box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, .1);" src="{{$homeconfig->house->photo}}"></image>
                                {{$homeconfig->house->name}}
                            </a>
                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <i class="fa fa-trash-o" onclick="removeHomeConfig({{$homeconfig->id}})"></i>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="input-group">
                    <select id="house_id_{{$category->id}}" class="js-data-example-ajax form-control select2_field" href="/api/house_quicksearch" style="width:100%" inputMessage="请输入楼盘编号(可部分匹配)">
                    </select>
                    <a href="javascript:;" class="input-group-addon" onclick="addHomeConfig('{{$category->id}}')"><i
                                class="fa fa-plus"></i> 添加</a>
                </div>

            </div>
        </div>
    </div>
    @if($loop->index && ($loop->index % 3 == 0))
        </div>
    @endif
@endforeach
</div>
@endsection

@push('after_scripts')
    <link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

    <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/i18n/zh-CN.js') }}"></script>
    <script src="/vendor/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script>

      $(function() {
        $("select.js-data-example-ajax").each(
          function() {
            var $this = $(this);
            $this.select2({
              language : "zh-CN",// 指定语言为中文，国际化才起效
              inputMessage : $this.attr("inputMessage"),// 添加默认参数
              ajax : {
                url : $this.attr("href"),
                dataType : 'json',
                delay : 250,// 延迟显示
                data : function(params) {
                  return {
                    keyword : params.term, // 搜索框内输入的内容，传递到Java后端的parameter为username
                    page : params.page,// 第几页，分页哦
                    per_page : 5// 每页显示多少行
                  };
                },
                // 分页
                processResults : function(data, params) {
                  params.page = params.page || 1;

                  return {
                    results : data.data,// 后台返回的数据集
                    pagination : {
                      more : params.to < data.total// 总页数为10，那么1-9页的时候都可以下拉刷新
                    }
                  };
                },
                cache : false
              },

              escapeMarkup : function(markup) {
                return markup;
              }, // let our custom formatter work
              minimumInputLength : 1,// 最少输入一个字符才开始检索
              templateResult : function(repo) {// 显示的结果集格式，这里需要自己写css样式，可参照demo
                // 正在检索
                if (repo.loading)
                  return repo.text;

                var markup = "<div><img src='"
                  + repo.photo + "' style='display: inline-block;width: 30px; height: 24px; margin-right: 5px;'/>"
                  + "<span>" + repo.name + "</span></div>";

                return markup;
              },
              templateSelection : function(repo) {
                return repo.id;
              }// 列表中选择某一项后显示到文本框的内容
            });
          });
      });


      function addHomeConfig(category) {
        let house_id = $("#house_id_" + category).val();
        if (!house_id) {
          alert('请填写楼盘id');
          return;
        }

        $.ajax({
          url: '{{backpack_url('homeconfig/add')}}',
          method: 'post',
          data: {
            category: category,
            house_id: house_id
          },
          success: function () {
            location.reload();
          },
          error: function(res) {
            swal(res.responseJSON.message, '', 'error');
          }
        })
      }

      function removeHomeConfig(homeconfig_id) {
        $.ajax({
          url: '{{backpack_url('homeconfig/remove')}}/'+homeconfig_id ,
          method: 'post',
          success: function () {
            location.reload();
          }
        })
      }

      $('.todo-list').sortable({
        update: function( event, ui ) {
          var category_id = $(event.target).data('category');
          console.log(category_id);
          var house_ids = [];
          $.each(event.target.children, function( index, value ) {
            house_ids.push( $(value).data('house_id') );
          });
          console.log(house_ids);

          $.ajax({
            url:'/admin/homeconfig/sort',
            method:'post',
            data: {
              category_id: category_id,
              house_ids: house_ids
            },
            success: function(res) {
                console.log(res);
                location.reload();
            },
            error: function(res) {
              console.log(res);
            }
          })
        }
      });
    </script>
@endpush