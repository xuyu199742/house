<div class="btn-group" role="group" aria-label="...">
    <a href="javascript:void(0)" onclick="bulkCommentAction(this, 'elite', '加精')"
       class="btn btn-default bulk-button"
    >
        <i class="fa fa-arrow-up"></i> 加精
    </a>

    <a href="javascript:void(0)" onclick="bulkCommentAction(this, 'unelite', '取消加精')"
       class="btn btn-default bulk-button"
    >
        <i class="fa fa-arrow-down"></i> 取消加精
    </a>

    <a href="javascript:void(0)" onclick="bulkCommentAction(this, 'approve', '通过审核')"
       class="btn btn-default bulk-button"
    >
        <i class="fa fa-check"></i> 审核通过
    </a>

    <a href="javascript:void(0)" onclick="bulkCommentAction(this, 'reject', '取消审核')"
       class="btn btn-default bulk-button"
    >
        <i class="fa fa-times"></i> 审核不通过
    </a>

    <a href="javascript:void(0)" onclick="bulkCommentAction(this, 'ban_ip', '封IP')"
       class="btn btn-default bulk-button hide"
    >
        <i class="fa fa-ban"></i> 封IP
    </a>

    <a href="javascript:void(0)" onclick="bulkCommentAction(this, 'ban_user', '封用户')"
       class="btn btn-default bulk-button hide"
    >
        <i class="fa fa-ban"></i> 封用户
    </a>

    <a href="javascript:void(0)" onclick="bulkCommentAction(this, 'delete', '批量删除')"
       class="btn btn-default bulk-button hide"
    >
       <i class="fa fa-trash"></i> 删除
    </a>
</div>

@push('after_scripts')
    <script>
        if (typeof bulkCommentAction != 'function') {
            function bulkCommentAction(button, action, action_name) {

                if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0)
                {
                    new PNotify({
                        title: "{{ trans('backpack::crud.bulk_no_entries_selected_title') }}",
                        text: "{{ trans('backpack::crud.bulk_no_entries_selected_message') }}",
                        type: "warning"
                    });
                    return;
                }
                let message = '';

                message  = "确定对这 :number 条评论要执行"+action_name+"操作吗?";
                message = message.replace(":number", crud.checkedItems.length);

                swal({
                    text: message,
                    icon: "info",
                    buttons: ['取消', '确定'],
                }).then( function(confirmed) {
                    if (!confirmed) {
                        return;
                    }
                    var ajax_calls = [];
                    var clone_route = "{{ url($crud->route) }}/bulk-" + action;
                    $.ajax({
                        url: clone_route,
                        type: 'POST',
                        data: { entries: crud.checkedItems },
                        success: function(result) {
                            swal({
                                title: "操作成功",
                                text: crud.checkedItems.length+" 条评论"+action_name+"成功.",
                                icon: "success",
                                button: "好的",
                            });
                            crud.checkedItems = [];
                            crud.table.ajax.reload();
                        },
                        error: function(result) {
                            swal({
                                title: "操作失败",
                                text: crud.checkedItems.length+" 条评论未能执行"+action_name+"操作, 请联系系统管理员.",
                                icon: "error",
                                button: "好的",
                            });
                            crud.table.ajax.reload();
                        }
                    });// end of ajax
                }); // end of swal
            }
        }
    </script>
@endpush
