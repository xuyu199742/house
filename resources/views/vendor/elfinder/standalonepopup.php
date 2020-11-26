<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>文件管理</title>

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="/vendor/adminlte/bower_components/jquery-ui/themes/smoothness/jquery-ui.css">
    <script src="/vendor/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/vendor/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/elfinder.min.css') ?>">
    <!-- <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/theme.css') ?>"> -->
    <link rel="stylesheet" type="text/css" href="<?= asset('vendor/backpack/elfinder/theme/css/theme-light.css') ?>">

    <!-- elFinder JS (REQUIRED) -->
    <script src="<?= asset($dir.'/js/elfinder.min.js') ?>"></script>
    <script src="<?= asset($dir."/js/i18n/elfinder.zh_CN.js") ?>"></script>

    <script type="text/javascript">
        $().ready(function () {
            var elf = $('#elfinder').elfinder({
                lang: 'zh_CN',
                customData: {
                    _token: '<?= csrf_token() ?>'
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
                url: '<?= route('elfinder.connector') ?>',  // connector URL
                dialog: {width: 900, modal: true, title: 'Select a file'},
                resizable: false,
                commandsOptions: {
                    getfile: {
                        oncomplete: 'destroy'
                    }
                },
                getFileCallback: function (file) {
                    window.parent.processSelectedFile(file.path, '<?= $input_id?>');
                    parent.jQuery.colorbox.close();
                }
            }).elfinder('instance');

          setTimeout(function () {
            $('#elfinder').show();
            var h = ($(window).height());
            if($('#elfinder').height() != h){
              $('#elfinder').height(h-30).resize();
            }
          }, 100);

        });

        $(window).resize(function(){
            var h = ($(window).height());
            if($('#elfinder').height() != h){
                $('#elfinder').height(h-30).resize();
            }
        });

    </script>

</head>
<body class="elfinder">
<!-- Element where elFinder will be created (REQUIRED) -->
<div id="elfinder" style="display: none;"></div>

</body>
</html>
