<!-- text input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>地址</label>
    <input
            type="text"
            name="{{ $field['name'] }}"
            value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
            @include('crud::inc.field_attributes')
    >
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

    @if($crud->actionIs('edit'))
        <p class="help-block location_tips">经度:{{$entry->longitude}}  纬度: {{$entry->latitude}}</p>
    @else
        <p class="help-block location_tips"></p>
    @endif
</div>

<div class="form-group col-xs-12 shadow-lg">
    <iframe id="mapPage" width="100%" height="360" frameborder=0
            src="https://apis.map.qq.com/tools/locpicker?search=1&type=1&key=KKKBZ-CPAWG-SA2QV-I45PG-IBUPZ-SPF2T&referer=myapp">
    </iframe>
</div>
@if($crud->actionIs('edit'))
    <input type="hidden" name="latitude" value="{{$entry->latitude}}">
    <input type="hidden" name="longitude" value="{{$entry->longitude}}">
@else
    <input type="hidden" name="latitude">
    <input type="hidden" name="longitude">
@endif
@push('after_styles')
    <style>
        .map_container {
            padding: 0 15px 0 15px;
            border: 1px solid black;
        }
    </style>
@endpush

@push('after_scripts')
    <script>
        window.addEventListener('message', function(event) {
            var loc = event.data;
            if (loc && loc.module == 'locationPicker') {
                $('input[name={{$field['name']}}]').val(loc.poiaddress);
                $('input[name=latitude]').val(loc.latlng.lat);
                $('input[name=longitude]').val(loc.latlng.lng);
                $('p.location_tips').text('经度: ' + loc.latlng.lng + '   纬度: '+ loc.latlng.lat );
            }
        }, false);
    </script>
@endpush
