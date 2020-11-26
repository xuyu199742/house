@extends('errors.layout')

@php
  $error_number = 503;
@endphp

@section('title')
  网站正在维护
@endsection

@section('description')
  @php
    $default_error_message = "网站暂时不能访问，请稍后重试或联系管理员";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
@endsection
