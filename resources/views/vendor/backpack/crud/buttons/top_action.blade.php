@if(!$entry->trashed())
    @if($entry->is_top)
    <a href="{{backpack_url('house/'.$entry->id.'/untop')}}"
       class="btn btn-xs btn-default"
    >
        取消置顶
    </a>
    @else
    <a href="{{backpack_url('house/'.$entry->id.'/top')}}"
       class="btn btn-xs btn-default"
    >
        置顶
    </a>
    @endif
@endif
