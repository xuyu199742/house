<!-- This file is used to store topbar (left) items -->
{{--
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-cogs"></i> 快捷入口<span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li class="">
            <a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">
                <i class="fa fa-list"></i> Dropdown Item
            </a>
        </li>
        <li class="">
            <a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">
                <i class="fa fa-list"></i> Dropdown Item
            </a>
        </li>
    </ul>
</li>
--}}

<li class="hide">
    <a href="{{ backpack_url('house/create') }}">
        <i class="fa fa-building-o m-r-5"> </i> 新增楼盘
    </a>
</li>
