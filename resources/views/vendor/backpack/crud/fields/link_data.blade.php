<!-- text input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
        <input
                type="text"
                name="{{ $field['name'] }}"
                value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
                @include('crud::inc.field_attributes')
        >
        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif
        @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    <p class="help-block">请填写 网页url 或
        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#linkList">
            小程序页面路径
        </button>
    </p>
</div>

<div class="modal fade" id="linkList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">小程序页面列表</h4>
            </div>
            <div class="modal-body p-t-0  p-b-0 p-l-10 p-r-10">
                <div class="box m-b-0">
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
                                            <a href="javascript:;" onclick="copyPath({{$loop->iteration}})" class="input-group-addon btn-copy">使用</a>
                                        </div>
                                    <td>{{$item[2] ?? '-'}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    @push('crud_fields_scripts')
        <script>
          function copyPath(iteration) {
            const input = document.querySelector('#link_'+iteration);
            $('input[name={{$field['name']}}]').val(input.value);
            $('#linkList').modal('hide');
          }
        </script>
    @endpush
@endif