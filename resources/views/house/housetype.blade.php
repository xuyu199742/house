@extends('layouts.house')

@section('house_content')
    <div class="nav-tabs-custom">
        @include('house.inc.nav', [ 'active' => 'housetype' ])
        <div class="tab-content">
            @include('backpack::crud.list_content')
        </div>
    </div>
@endsection

