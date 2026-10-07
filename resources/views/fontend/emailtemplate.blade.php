<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Document Title
	============================================= -->
	<title>{{ $data->email_title }} - 8BAHT.COM</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index, follow" />
	<meta http-equiv="Content-Language" content="th">
	<meta name="author" content="{{ $data->email_title }} - 8BAHT.COM" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />

	<meta property="og:site_name" content="{{ $data->email_title }} - 8BAHT.COM"/>
	<meta name="keywords" content="{{ $data->email_title }}">
	<meta name="description" content="{{ $data->email_title }} | Email Template">
	<meta name="language" content="TH">
	<meta name="revisit-after" content="1 day" />
	<meta name='copyright' content='8BAHT.COM'>

    <style>
        body{
            margin-left: 0px!important;
            margin-top: 20px!important;
            margin-right: 0px!important;
            margin-bottom: 20px!important;
        }
        table{
            max-width: 800px !important;
            width: 100% !important;
        }
    </style>
</head>

<body>
    {!! $data->email_content !!}
</body>
</html>
