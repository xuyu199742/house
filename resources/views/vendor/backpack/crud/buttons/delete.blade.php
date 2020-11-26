@if ($crud->hasAccess('delete'))
	@if( method_exists( $entry, 'trashed') && $entry->trashed() )
		<a href="javascript:void(0)" onclick="restoreEntry(this)" data-route="{{ url($crud->route.'/'.$entry->getKey()).'/restore' }}" class="btn btn-xs btn-default" data-button-type="restore"><i class="fa fa-history"></i> 恢复</a>
	@else
		<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> {{ trans('backpack::crud.delete') }}</a>
	@endif
@endif

<script>
	if (typeof deleteEntry != 'function') {
	  $("[data-button-type=delete]").unbind('click');

	  function deleteEntry(button) {
	      // ask for confirmation before deleting an item
	      // e.preventDefault();
	      var button = $(button);
	      var route = button.attr('data-route');
	      var row = $("#crudTable a[data-route='"+route+"']").closest('tr');

		  swal({
			  text: "{{ trans('backpack::crud.delete_confirm') }}",
			  icon: "info",
			  buttons: ['取消', '确定'],
			  dangerMode: true,
		  }).then( function(confirmed) {
			  if(!confirmed) {
				  return;
			  }
	          $.ajax({
	              url: route,
	              type: 'DELETE',
	              success: function(result) {
		              if (result != 1) {
						  swal({
							  title: "操作失败",
							  text: "删除这条记录时遇到了一些问题, 请联系系统管理员",
							  icon: "error",
							  button: "好的",
						  });
		              } else {
						  swal({
							  title: "操作成功",
							  text: "记录删除成功",
							  icon: "success",
							  button: "好的",
						  });
						  crud.table.ajax.reload();
		              }
	              },
	              error: function(result) {
	                  // Show an alert with the result
					  swal({
						  title: "操作失败",
						  text: "删除这条记录时遇到了一些问题, 请联系系统管理员",
						  icon: "error",
						  button: "好的",
					  });
	              }
	          });
	      });
      }
	}

	if (typeof restoreEntry != 'function') {
		$("[data-button-type=restore]").unbind('click');

		function restoreEntry(button) {
			// ask for confirmation before deleting an item
			// e.preventDefault();
			var button = $(button);
			var route = button.attr('data-route');
			var row = $("#crudTable a[data-route='"+route+"']").closest('tr');
			swal({
				text: "确定要恢复这条记录吗?",
				icon: "info",
				buttons: ['取消', '确定'],
			}).then( function(confirmed) {
				if(!confirmed) {
					return;
				}
				$.ajax({
					url: route,
					type: 'POST',
					success: function(result) {
						if (result != 1) {
							swal({
								title: "操作失败",
								text: "恢复这条记录时遇到了一些问题, 请联系系统管理员",
								icon: "error",
								button: "好的",
							});
						} else {
							// Show a success alert with the result
							swal({
								title: "操作成功",
								text: "记录恢复成功",
								icon: "success",
								button: "好的",
							});
							crud.table.ajax.reload();
						}
					},
					error: function(result) {
						swal({
							title: "操作失败",
							text: "恢复这条记录时遇到了一些问题, 请联系系统管理员",
							icon: "error",
							button: "好的",
						});
					}
				}); // end of ajax
			}); //  end of swal
		}
	}
</script>
