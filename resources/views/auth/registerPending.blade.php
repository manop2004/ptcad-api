<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กรุณายืนยันอีเมล</title>
    <!-- ดึงเฉพาะ Google Fonts เพื่อความสวยงาม โดยไม่กระทบสคริปต์หน้าเว็บ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 20px;
            background: #f4f6f9;
            font-family: 'Kanit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-container {
            max-width: 500px;
            width: 100%;
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .max-logo {
            width: 100%;
            max-width: 160px;
            height: auto;
            margin-bottom: 24px;
            object-fit: contain;
        }
        .title {
            color: #1e293b;
            font-size: 22px;
            font-weight: 600;
            margin: 0 0 12px 0;
        }
        .description {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 24px 0;
        }
        .email-highlight {
            color: #0f172a;
            font-weight: 600;
        }
        .alert-success {
            color: #16a34a;
            background-color: #f0fdf4;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 16px;
        }
        .alert-error {
            color: #dc2626;
            background-color: #fef2f2;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 16px;
        }
        .btn-resend {
            background: #2563eb;
            color: #ffffff;
            border: none;
            width: 100%;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: inherit;
        }
        .btn-resend:hover {
            background: #1d4ed8;
        }
        .link-login {
            display: inline-block;
            margin-top: 20px;
            color: #64748b;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .link-login:hover {
            color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <img class="max-logo" src="{{ asset('/storage/setting/'.(\App\Models\TbSetting::first()->setting_logoWeb ?? '')) }}" alt="Logo" />
        
        <h3 class="title">กรุณายืนยันอีเมลของคุณ</h3>
        
        <p class="description">
            เราได้ส่งลิงก์ยืนยันตัวตนไปที่ <span class="email-highlight">{{ $email ?? '-' }}</span> แล้ว<br>
            กรุณาตรวจสอบกล่องจดหมาย (รวมถึงกล่อง Junk/Spam) เพื่อยืนยันการเข้าใช้งาน
        </p>

        @if(session('feedback'))
            <div class="alert-success">{{ session('feedback') }}</div>
        @endif
        @if(session('feedback-er'))
            <div class="alert-error">{{ session('feedback-er') }}</div>
        @endif

        <form method="POST" action="{{ route('fronend.register.resend') }}">
            @csrf
            <button type="submit" class="btn-resend">ส่งอีเมลยืนยันอีกครั้ง</button>
        </form>

        <a href="{{ route('login') }}" class="link-login">← กลับไปยังหน้าเข้าสู่ระบบ</a>
    </div>
</body>
</html>