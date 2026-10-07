@php
    $setting = App\Models\TbSetting::first();
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(!empty($setting->setting_iconWeb))
        <link rel="icon" href="{{ asset('storage/setting/'.$setting->setting_iconWeb) }}" type="image/x-icon">
    @endif

    @if(!empty($setting->setting_nameWeb))
        <title>@yield('title') | {{ $setting->setting_nameWeb }}</title>
    @endif

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

    <!-- CSS Files -->
    <link href="{{ asset('assets/backend/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/backend/css/paper-dashboard.css?v=2') }}" rel="stylesheet" />

    <!-- SweetAlert2 CSS (จำเป็นสำหรับการคุม Layout ป๊อปอัปให้เป๊ะ) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/backend/css/custom.css?v=8') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/padding.css?v=10') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/fontend/css/margin.css?v=10') }}" type="text/css" />

    @yield('css')

    <style>
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(1.5em + .75rem + 6px) !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            line-height: calc(1.5em + 1rem) !important;
        }

        /* Adjust SweetAlert2 Size - Medium Scale */
        .swal2-popup {
            width: 26em !important;
            padding: 1.25rem !important;
            font-size: 0.9rem !important;
            border-radius: 12px !important;
        }

        .swal2-icon {
            width: 4em !important;
            height: 4em !important;
            margin: 0.8em auto 0.6em !important;
            border-width: 3px !important;
        }

        .swal2-icon .swal2-icon-content {
            font-size: 2.5em !important;
        }

        .swal2-title {
            font-size: 1.2rem !important;
            padding: 0.3em 0 0 !important;
        }

        .swal2-html-container {
            margin-top: 0.6em !important;
            font-size: 0.95rem !important;
        }

        .swal2-actions {
            margin-top: 1.2em !important;
        }
    </style>
</head>
<body @yield('bodyeditor')>

    <!-- Loading Screen -->
    <div id="displayLoagging" class="display-none">
        <div id="containerLoadding">
            <div class="divider" aria-hidden="true"></div>
            <p class="loading-text" aria-label="Loading">
                <span class="letter" aria-hidden="true">L</span>
                <span class="letter" aria-hidden="true">o</span>
                <span class="letter" aria-hidden="true">a</span>
                <span class="letter" aria-hidden="true">d</span>
                <span class="letter" aria-hidden="true">i</span>
                <span class="letter" aria-hidden="true">n</span>
                <span class="letter" aria-hidden="true">g</span>
            </p>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="wrapper">
        @include('layouts.admin._temp.sidebar')

        <div class="main-panel">
            @include('layouts.admin._temp.navbar')

            <div class="content">
                @yield('content')
            </div>

            @include('layouts.admin._temp.footer')
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('assets/backend/js/core/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/js/plugins/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/js/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/js/paper-dashboard.min.js') }}" type="text/javascript"></script>

    <!-- Plugins -->
    <script src="{{ asset('assets/backend/js/plugins/bootstrap-selectpicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/js/plugins/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/bootstrap-switch.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

    <!-- Custom System JS -->
    <script src="{{ asset('assets/backend/js/custom.js?v=12') }}"></script>
    <script src="{{ asset('assets/backend/js/notiticket.js?v=1') }}"></script>

    <!-- Global SweetAlert2 Overrides & Helpers -->
    <script>
        // แทนที่ alert() เดิมด้วย Popup สไตล์พอดีคำ
        window.alert = function (message) {
            Swal.fire({
                icon: 'info',
                title: 'แจ้งเตือนระบบ',
                text: message,
                confirmButtonText: 'ตกลง',
                customClass: {
                    confirmButton: 'btn btn-info'
                },
                buttonsStyling: false
            });
        };

        // Helper สำหรับ Confirmation Popup
        window.confirmAction = function (options = {}) {
            return Swal.fire({
                title: options.title || 'คุณแน่ใจหรือไม่?',
                text: options.text || 'การดำเนินการนี้ไม่สามารถย้อนกลับได้!',
                icon: options.icon || 'warning',
                showCancelButton: true,
                confirmButtonText: options.confirmText || 'ยืนยัน',
                cancelButtonText: options.cancelText || 'ยกเลิก',
                customClass: {
                    confirmButton: 'btn btn-danger mr-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            });
        };
    </script>

    @yield('js')

    <!-- Flash Message Notification (Success) -->
    @if(session('feedback'))
        <script>
            Swal.fire({
                title: "{{ session('feedback') }}",
                icon: 'success',
                confirmButtonText: 'ตกลง',
                timer: 2000,
                timerProgressBar: true,
                customClass: {
                    confirmButton: 'btn btn-success'
                },
                buttonsStyling: false
            });
        </script>
    @endif

    <!-- Flash Message Notification (Error) -->
    @if(session('feedback-er'))
        <script>
            Swal.fire({
                title: "{{ session('feedback-er') }}",
                text: "{{ session('text-er') }}",
                icon: 'error',
                confirmButtonText: 'ตกลง',
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });
        </script>
    @endif

</body>
</html>