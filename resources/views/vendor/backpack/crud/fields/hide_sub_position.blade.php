@push('after_scripts')
    <script>
        toggleSubPosition();
        $('select[name=position]').on('change', function(e){
          console.log($('select[name=position]').val());
          toggleSubPosition();
        });

        function toggleSubPosition() {
            if( '{{\App\Models\Sponsor::POSITION_TAPES}}' == $('select[name=position]').val()) {
              $('select[name=sub_position]').parent().show();
              $('input[name=title]').parent().removeClass('col-md-9');
              $('input[name=title]').parent().addClass('col-md-6');
            } else {
              $('select[name=sub_position]').parent().hide();
              $('input[name=title]').parent().addClass('col-md-9');
              $('input[name=title]').parent().removeClass('col-md-6');
            }
        }
    </script>
@endpush