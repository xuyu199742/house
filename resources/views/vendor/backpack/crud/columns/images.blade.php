{{-- image column type --}}
@php
  $values = data_get($entry, $column['name']);
@endphp

<span>
  @if( empty($values) )
    -
  @else
    @foreach($values as $value)
    <a
      href="{{ asset( (isset($column['prefix']) ? $column['prefix'] : '') . $value) }}"
      target="_blank"
    >
      <img
        src="{{ asset( (isset($column['prefix']) ? $column['prefix'] : '') . $value) }}"
        style="
          max-height: {{ isset($column['height']) ? $column['height'] : "25px" }};
          width: {{ isset($column['width']) ? $column['width'] : "auto" }};
          border-radius: 3px;"
      />
    </a>
    @endforeach
  @endif
</span>
