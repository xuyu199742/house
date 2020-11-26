<!-- browse server input -->

<div @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <div class="input-group">
        <input
                type="text"
                id="{{ $field['name'] }}-filemanager"

                name="{{ $field['name'] }}"
                value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
                @include('crud::inc.field_attributes')

                {{ empty($field['readonly']) ? '':'readonly' }}
        >
        <span class="input-group-addon">
            <a href="javascript:;" type="button" data-inputid="{{ $field['name'] }}-filemanager"
               class="popup_selector plain">
                <i class="fa fa-cloud-upload"></i> 选择文件
            </a>
		</span>
        <span class="input-group-addon">
            <a href="javascript:;" data-inputid="{{ $field['name'] }}-filemanager"
               class="clear_elfinder_picker">
                <i class="fa fa-trash"></i> 清空
            </a>
        </span>
    </div>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif


</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include browse server css -->
        <link href="{{ asset('vendor/backpack/colorbox/example2/colorbox.css') }}" rel="stylesheet" type="text/css"/>
        <style>
            #cboxContent, #cboxLoadedContent, .cboxIframe {
                background: transparent;
            }

            #cboxOverlay {
                background: rgba(0,0,0,0.6);
                opacity: 0.6;
                filter: alpha(opacity=60);
            }

            #cboxClose {
                top: 10px;
                right:10px;
                padding: 5px;
                border-radius: 15px;
                border: 4px solid #555;
                width: 30px;
                height: 30px;
                background-color: white;
                background-image: url(/images/close.png);
                background-size: cover;
                background-position:0 0;
            }

            #cboxClose:hover {
                border: 4px solid #111;
                background-position:0 0;
                background-image: url(/images/close_active.png);
            }
        </style>
    @endpush

    @push('crud_fields_scripts')
        <!-- include browse server js -->
        <script src="{{ asset('vendor/backpack/colorbox/jquery.colorbox-min.js') }}"></script>
    @endpush

@endif

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
    <script>
      $(document).on('click', '.popup_selector[data-inputid={{ $field['name'] }}-filemanager]', function (event) {
        event.preventDefault();

        // trigger the reveal modal with elfinder inside
        var triggerUrl = "{{ url(config('elfinder.route.prefix').'/popup/'.$field['name']."-filemanager") }}";
        $.colorbox({
          href: triggerUrl,
          fastIframe: true,
          iframe: true,
          width: '80%',
          height: '80%'
        });
      });

      // function to update the file selected by elfinder
      function processSelectedFile(filePath, requestingField) {
        $('#' + requestingField).val(filePath.replace(/\\/g, "/"));
      }

      $(document).on('click', '.clear_elfinder_picker[data-inputid={{ $field['name'] }}-filemanager]', function (event) {
        event.preventDefault();
        var updateID = $(this).attr('data-inputid'); // Btn id clicked
        $("#" + updateID).val("");
      });
    </script>
@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}