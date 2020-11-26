@if($entry->start && ($entry->start > \Carbon\Carbon::now()) )
    <label class="label label-warning">未开始</label>
@elseif($entry->end && ($entry->end < \Carbon\Carbon::now()) )
    <label class="label label-danger">结束</label>
@else
    <label class="label label-success">生效</label>
@endif
