@extends('errors.layout')

@php
  $error_number = 404;
@endphp

@section('title')
  出错了
@endsection

@section('description')
  @php
    $default_error_message = "内容不存在或者已经被删除";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
@endsection
