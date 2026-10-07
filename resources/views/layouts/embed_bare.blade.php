<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
<meta name="robots" content="noindex, nofollow" {{-- หน้านี้มีไว้ฝังใน iframe ของ reseller ไม่ต้องให้ Google เก็บ index --}}>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>

<link rel="stylesheet" href="{{ asset('assets/fontend/css/bootstrap.min.css') }}" type="text/css" />

<style>
html, body{
    overflow-x: hidden !important;
    max-width: 100% !important;
    margin: 0;
    padding: 0;
    background: transparent; {{-- โปร่งใส เผื่อฝังใน iframe แล้วอยากให้กลืนกับพื้นหลังเว็บของ reseller --}}
}
</style>

@yield('css')
</head>
<body>

@yield('content')

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
</script>

@yield('js')

</body>
</html>