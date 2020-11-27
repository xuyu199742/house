<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>系统概览</span></a></li>
{{--@can('物业管理')--}}
    <li><a href="{{ backpack_url('properties') }}"><i class="fa fa-yelp"></i> <span>物业管理</span></a></li>
{{--@endcan--}}

{{--@can('房源管理')--}}
<li><a href="{{ backpack_url('house') }}"><i class="fa fa-building"></i> <span>房源管理</span></a></li>
<li><a href="{{ backpack_url('residential') }}"><i class="fa fa-building"></i> <span>小区管理</span></a></li>
{{--@endcan--}}

{{--@can('资讯管理')--}}
{{--<li><a href="{{ backpack_url('article') }}"><i class="fa fa-newspaper-o"></i> <span>房源资讯</span></a></li>--}}
{{--<li><a href="{{ backpack_url('page') }}"><i class="fa fa-file"></i> <span>页面管理</span></a></li>--}}
{{--@endcan--}}

{{--@can('答疑管理')--}}
{{--<li><a href="{{ backpack_url('question') }}"><i class="fa fa-question-circle-o"></i>--}}
{{--        <span>答疑模块</span>--}}
{{--    @if($pending_question = \App\Models\Question::notAnswered()->count())--}}
{{--        <span class="pull-right-container">--}}
{{--          <span class="label label-warning pull-right">{{$pending_question}}</span>--}}
{{--        </span>--}}
{{--    @endif--}}
{{--    </a>--}}
{{--</li>--}}
{{--@endcan--}}

{{--@can('评论管理')--}}
{{--<li><a href="{{ backpack_url('comment') }}"><i class="fa fa-comment-o"></i> <span>评论管理</span></a></li>--}}
{{--@endcan--}}

{{--@can('交易数据')--}}
{{--<li><a href="{{ backpack_url('transaction') }}"><i class="fa fa-bar-chart"></i> <span>交易数据</span></a></li>--}}
{{--@endcan--}}

{{--@can('用户行为')--}}
{{--<li><a href="{{ backpack_url('tracker') }}"><i class="fa fa-hand-pointer-o"></i> <span>用户行为</span></a></li>--}}
{{--@endcan--}}

{{--@can('数据配置')--}}
<li class="treeview">
    <a href="#">
        <i class="fa fa-database"></i> <span>数据配置</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
{{--        <li><a href="{{ backpack_url('homeconfig') }}"><i class="fa fa-home"></i> <span> 首页配置</span></a></li>--}}
{{--        <li><a href="{{ backpack_url('hotsearch') }}"><i class="fa fa-search"></i> <span> 热搜关键词</span></a></li>--}}
{{--        <li><a href="{{ backpack_url('sponsor') }}"><i class="fa fa-bullhorn"></i> <span>广告位</span></a></li>--}}
{{--        <li><a href="{{ backpack_url('shortcut') }}"><i class="fa fa-link"></i> <span> 快捷入口</span></a></li>--}}
{{--        <li><a href="{{ backpack_url('tab') }}"><i class="fa fa-navicon"></i> <span> 底部导航</span></a></li>--}}
        <li><a href="{{ backpack_url('tag') }}"><i class="fa fa-tags"></i> <span> 标签管理</span></a></li>
        <li><a href="{{ backpack_url('district') }}"><i class="fa fa-map"></i> <span> 行政区属</span></a></li>
{{--        <li><a href="{{ backpack_url('media') }}"><i class="fa fa-pencil"></i> <span> 来源平台</span></a></li>--}}
{{--        <li><a href="{{ backpack_url('article_category') }}"><i class="fa fa-tasks"></i> <span> 资讯类型</span></a></li>--}}
    </ul>
</li>
{{--@endcan--}}

{{--@can('系统管理')--}}
{{--<li class="treeview">--}}
{{--    <a href="#">--}}
{{--        <i class="fa fa-gears"></i> <span>系统管理</span>--}}
{{--        <span class="pull-right-container">--}}
{{--          <i class="fa fa-angle-left pull-right"></i>--}}
{{--        </span>--}}
{{--    </a>--}}
{{--    <ul class="treeview-menu">--}}
{{--        <li><a href="{{ backpack_url('users') }}"><i class="fa fa-address-card"></i> <span> 用户管理</span></a></li>--}}
{{--        <li><a href="{{ backpack_url('message') }}"><i class="fa fa-envelope-o"></i> <span> 消息通知</span></a></li>--}}
{{--        <li><a href="{{ backpack_url('sensitive') }}"><i class="fa fa-commenting-o"></i> <span> 禁发词</span></a></li>--}}
{{--        <li><a href="{{ backpack_url('blacklist') }}"><i class="fa fa-ban"></i> <span> 黑名单</span></a></li>--}}
{{--        <li><a href='{{ backpack_url('setting') }}'><i class='fa fa-gear'></i> <span> 系统设置</span></a></li>--}}
{{--        <li><a href='{{ route("log-viewer::logs.list") }}'><i class='fa fa-history'></i> <span> 系统日志</span></a></li>--}}
{{--        <li><a href='{{ backpack_url('systemlog') }}'><i class='fa fa-file-text-o'></i> <span> 访问记录</span></a></li>--}}
{{--        <li><a href='{{ backpack_url('backup') }}'><i class='fa fa-hdd-o'></i> <span>系统备份</span></a></li>--}}
{{--    </ul>--}}
{{--</li>--}}
{{--@endcan--}}


