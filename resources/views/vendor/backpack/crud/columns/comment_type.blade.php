{{-- regular object attribute --}}
@php
    $comment_type   = data_get($entry, 'commentable_type');
    $comment_id     = data_get($entry, 'commentable_id');

    switch ($comment_type) {
        case \App\Models\House::class:
            $label =  '[房源] '. \App\Models\House::find($comment_id)->name;
            $link = backpack_url('house/'.$comment_id);
            break;
        case \App\Models\Article::class:
            $label =  '[文章] '. \App\Models\Article::find($comment_id)->name;
            $link = backpack_url('article/'.$comment_id);
            break;
        default:
            $label = '-';
            $link = '#';
            break;
    }
@endphp

<span>
    <a href="{{$link}}" target="_blank"> {{$label}} </a>
</span>
