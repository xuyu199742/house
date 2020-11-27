<div class="btn-group" role="group" aria-label="...">
    <a href="javascript:void(0)" onclick="bulkPublishEntries(this, 'publish')"
       class="btn btn-default bulk-button"
    >
        <i class="fa fa-arrow-up"></i> 上架
    </a>

    <a href="javascript:void(0)" onclick="bulkPublishEntries(this, 'unpublish')"
       class="btn btn-default bulk-button"
    >
        <i class="fa fa-arrow-down"></i> 下架
    </a>
</div>

@push('after_scripts')
    <script>
        if (typeof bulkPublishEntries != 'function') {
            function bulkPublishEntries(button, action) {

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
                let api_path = '';
                if(action == 'publish') {
                    message = "确定要上架这 :number 个房源吗?";
                    api_path = 'bulk-publish';
                } else {
                    message = "确定要下架这 :number 个房源吗?";
                    api_path = 'bulk-unpublish';
                }

                message = message.replace(":number", crud.checkedItems.length);

                swal({
                    title: message,
                    icon: "info",
                    buttons: ['取消', '确定'],
                }).then( function(confirmed) {
                    if (!confirmed) {
                        return;
                    }
                    var ajax_calls = [];
                    var clone_route = "{{ url($crud->route) }}/" + api_path;
                    $.ajax({
                        url: clone_route,
                        type: 'POST',
                        data: { entries: crud.checkedItems },
                        success: function(result) {
                            swal({
                                title: "操作成功",
                                text: crud.checkedItems.length+" 条房源已上架或下架.",
                                icon: "success",
                                button: "好的",
                            });
                            crud.checkedItems = [];
                            crud.table.ajax.reload();
                        },
                        error: function(result) {
                            swal({
                                title: "操作失败",
                                text: crud.checkedItems.length+" 条房源未能上架或下架.",
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
