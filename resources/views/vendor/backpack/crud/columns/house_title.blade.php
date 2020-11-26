{{-- image column type --}}
@php
    $value = data_get($entry, 'photo');

    if (is_array($value)) {
      $value = json_encode($value);
    }
@endphp

<span>
  @if( empty($value) )
        -
    @else
        <a
            href="{{ asset( (isset($column['prefix']) ? $column['prefix'] : '') . $value) }}"
            target="_blank"
        >
      <img
              src="{{ asset( (isset($column['prefix']) ? $column['prefix'] : '') . $value) }}"
              style="
                      max-height: {{ isset($column['height']) ? $column['height'] : "25px" }};
                      width: {{ isset($column['width']) ? $column['width'] : "auto" }};
                      border-radius: {{ isset($column['border-radius']) ? $column['border-radius'] : "3px" }};"
      />
    </a>
    @endif
</span>


<a style="margin-top: 2.25px;" href="{{backpack_url('house/'.$entry->getKey())}}">

    {{data_get($entry, $column['name'])}}

</a>
