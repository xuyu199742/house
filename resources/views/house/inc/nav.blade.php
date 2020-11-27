<ul class="nav nav-tabs">
    <li class="{{ $active=='info' ? 'active':'' }}"><a href="{{backpack_url('/house/'.$house->id)}}">基本信息</a></li>
    <li class="{{ $active=='housetype' ? 'active':'' }}"><a href="{{backpack_url('/house/'.$house->id.'/housetype')}}">户型 ({{$house->housetypes()->count()}})</a></li>
    <li class="{{ $active=='photo' ? 'active':'' }}"><a href="{{backpack_url('/house/'.$house->id.'/photo')}}">图片 ({{$house->photos()->count()}})</a></li>
{{--    <li class="{{ $active=='information' ? 'active':'' }}"><a href="{{backpack_url('/house/'.$house->id.'/information')}}">动态 ({{$house->informations()->count()}})</a></li>--}}
</ul>
