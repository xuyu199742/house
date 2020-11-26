
{{-- regular object attribute --}}
@php
    $user_id        = data_get($entry, $column['user_id'] ?? 'user_id');
    $user = \App\User::find($user_id);
@endphp
@if($user)
<span>
    <img src="{{$user->avatar_url}}" alt="{{$user_id}}" class="img-circle" height="16">
    [{{$user->id}}] {{$user->name}}
</span>
@else
-
@endif
