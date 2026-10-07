<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>elFinder CKEditor Integration</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('elfinder_2/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('elfinder_2/css/theme.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="{{ asset('elfinder_2/js/elfinder.min.js') }}"></script>
</head>
<body>
    <div id="elfinder"></div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#elfinder').elfinder({
                url: '{{ route("elfinder.connector") }}',
                // ฟังก์ชัน callback เมื่อเลือกไฟล์ (สำหรับ CKEditor)
                getFileCallback: function(file) {
                    // รับค่าฟังก์ชันจาก CKEditor ผ่าน query string ชื่อ CKEditorFuncNum
                    var funcNum = {{ request()->input('CKEditorFuncNum') ?? 1 }};
                    window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                    window.close();
                },
                resizable: false
            });
        });
    </script>
</body>
</html>
