<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>elFinder File Manager</title>
    <!-- นำเข้า CSS ของ elFinder -->
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
                // URL connector ที่เราได้กำหนดไว้ใน route
                url: '{{ route("elfinder.connector") }}'
            });
        });
    </script>
</body>
</html>
