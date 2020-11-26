@if(!$entry->trashed())

@if($entry->status == \App\Models\House::STATUS_DRAFT)
     <a href="{{backpack_url('house/'.$entry->id.'/publish')}}"
        class="btn btn-xs btn-default"
     >
          发布
     </a>
@elseif($entry->status == \App\Models\House::STATUS_DOWN)
     <a href="{{backpack_url('house/'.$entry->id.'/publish')}}"
        class="btn btn-xs btn-default"
     >
          上架
     </a>
@else
     <a href="{{backpack_url('house/'.$entry->id.'/unpublish')}}"
        class="btn btn-xs btn-default"
     >
          下架
     </a>
@endif

@endif
