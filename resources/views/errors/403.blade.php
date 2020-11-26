@extends('errors.layout')

@php
  $error_number = 403;
@endphp

@section('title')
  没有权限.
@endsection

@section('description')
  @php
    $default_error_message = "请和管理员确认您是否有权限进行此操作";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
@endsection
