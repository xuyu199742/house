@php
$multiple = array_get($field, 'multiple', true);
$value = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';

if (!$multiple && is_array($value)) {
    $value = array_first($value);
}
@endphp

<div @include('crud::inc.field_wrapper_attributes') >

    <div><label>{!! $field['label'] !!}</label></div>
    @include('crud::inc.field_translatable_icon')
    @if ($multiple)
        @foreach((array)$value as $v)
            @if ($v)
                <div class="input-group input-group-sm">
                    <input type="text" name="{{ $field['name'] }}[]" value="{{ $v }}" @include('crud::inc.field_attributes') readonly>
                    <div class="input-group-btn">
                        <button type="button" class="browse_{{ $field['name'] }} remove btn btn-default">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <input type="text" name="{{ $field['name'] }}" value="{{ $value }}" @include('crud::inc.field_attributes') readonly>
    @endif

    <div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
        <button type="button" class="browse_{{ $field['name'] }} popup btn btn-default">
            <i class="fa fa-cloud-upload"></i>
            {{ trans('backpack::crud.browse_uploads') }}
        </button>
        <button type="button" class="browse_{{ $field['name'] }} clear btn btn-default">
            <i class="fa fa-eraser"></i>
            {{ trans('backpack::crud.clear') }}
        </button>
    </div>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

</div>

<script type="text/html" id="browse_multiple_template_{{ $field['name'] }}">
    <div class="input-group input-group-sm">
        <input type="text" name="{{ $field['name'] }}[]" @include('crud::inc.field_attributes') readonly>
        <div class="input-group-btn">
            <button type="button" class="browse_{{ $field['name'] }} remove btn btn-default">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </div>
</script>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field))
    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include browse server css-->
        <link rel="stylesheet" type="text/css"
              href="/vendor/adminlte/bower_components/jquery-ui/themes/smoothness/jquery-ui.min.css">

        <link rel="stylesheet" type="text/css" href="{{ asset('packages/barryvdh/elfinder/css/elfinder.min.css') }}">
        <link rel="stylesheet" type="text/css" href="<?= asset('vendor/backpack/elfinder/theme/css/theme-light.css') ?>">

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
                top: 3px;
                right: 3px;
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
        <script src="/vendor/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script src="{{ asset('vendor/backpack/colorbox/jquery.colorbox-min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/barryvdh/elfinder/js/elfinder.min.js') }}"></script>
        {{-- <script type="text/javascript" src="{{ asset('packages/barryvdh/elfinder/js/extras/editors.default.min.js') }}"></script> --}}
        <script type="text/javascript" src="{{ asset("packages/barryvdh/elfinder/js/i18n/elfinder.zh_CN.js") }}"></script>
    @endpush
@endif

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
    <script>
        $(function () {
            var template = document.getElementById('browse_multiple_template_{{ $field['name'] }}').innerHTML;

            $(document).on('click', '.popup.browse_{{ $field['name'] }}', function (event) {
                event.preventDefault();

                var element = $(this);
                var height = ($(window).height())*0.8-35;
                var div = $('<div>');
                div.elfinder({
                    lang: 'zh_CN',
                    customData: {
                        _token: '{{ csrf_token() }}'
                    },
                  uiOptions: {
                    toolbar : [
                      ['open'],
                      ['back', 'forward'],
                      ['reload'],
                      ['home', 'up'],
                      ['mkdir', 'upload'],
                      ['rm'],
                      ['rename'],
                      ['view'],
                    ]
                  },
                    url: '{{ route("elfinder.connector") }}',
                    soundPath: '{{ asset('/packages/barryvdh/elfinder/sounds') }}',
                    height:height,
                    dialog: {
                        modal: true,
                        @if ($multiple)
                        title: '{{ trans('backpack::crud.select_files') }}',
                        @else
                        title: '{{ trans('backpack::crud.select_file') }}',
                        @endif
                    },
                    resizable: false,
                    @if ($mimes = array_get($field, 'mime_types'))
                    onlyMimes: {!! json_encode($mimes) !!},
                    @endif
                    commandsOptions: {
                        getfile: {
                            @if ($multiple)
                            multiple: true,
                            @endif
                            oncomplete: 'destroy'
                        }
                    },
                    getFileCallback: function (files) {
                        @if ($multiple)
                        files.forEach(function (file) {
                            var input = $(template);
                            input.find('input').val(file.path);
                            element.parent().before(input);
                        });
                        @else
                        $('input[name=\'{{ $field['name'] }}\']').val(files.path);
                        @endif
                        $.colorbox.close();
                    }
                }).elfinder('instance');

                // trigger the reveal modal with elfinder inside
                $.colorbox({
                    href: div,
                    inline: true,
                    width: '80%',
                    height: '80%'
                });
            });

            $(document).on('click', '.clear.browse_{{ $field['name'] }}', function (event) {
                event.preventDefault();

                @if ($multiple)
                $('input[name=\'{{ $field['name'] }}[]\']').parents('.input-group').remove();
                @else
                $('input[name=\'{{ $field['name'] }}\']').val('');
                @endif
            });

            @if ($multiple)
            $(document).on('click', '.remove.browse_{{ $field['name'] }}', function (event) {
                event.preventDefault();
                $(this).parents('.input-group').remove();
            });
            @endif
        });
    </script>
@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
