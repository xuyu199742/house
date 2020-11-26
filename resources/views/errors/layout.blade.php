@extends('backpack::layout_guest')
{{-- show error using sidebar layout if looged in AND on an admin page; otherwise use a blank page --}}

@php
  $title = '出错了 '.$error_number;
@endphp

@section('content')
  <section class="content">
    <div class="error-page">
      <h2 class="headline text-yellow"> {{ $error_number }}</h2>
      <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> @yield('title') </h3>
        @yield('description')
        <p class="m-t-40">
          请 <a href='javascript:history.back()'>返回上一页 </a>, 或者 <a href="{{backpack_url('/')}}">回到首页</a>
        </p>

        @if(backpack_auth()->check())
          <a class="btn btn-xs btn-default" href="{{backpack_url('logout')}}">重新登录</a>
        @endif
      </div>
      <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
  </section>
@endsection
