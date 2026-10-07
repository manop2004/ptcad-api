<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ส่งอีเมลตั้งรหัสผ่านใหม่สำเร็จ</title>
    <!-- Google Fonts: Kanit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            max-width: 480px;
            width: 100%;
            background: #ffffff;
            padding: 40px 32px;
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
        .icon-box {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: #f0fdf4;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
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
            margin: 0 0 28px 0;
        }
        .btn-login {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 48px;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            font-weight: 500;
            font-size: 15px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }
        .btn-login:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <!-- Logo -->
        <img class="max-logo" src="{{ asset('/storage/setting/'.(\App\Models\TbSetting::first()->setting_logoWeb ?? '')) }}" alt="Logo" />
        
        <!-- Icon -->
        <div class="icon-box">
            &#9993;
        </div>

        <!-- Content -->
        <h3 class="title">ส่งอีเมลตั้งรหัสผ่านใหม่สำเร็จ!</h3>
        
        <p class="description">
            เราได้ส่งลิงก์สำหรับรีเซ็ตรหัสผ่านไปที่อีเมลของคุณแล้ว<br>
            กรุณาตรวจสอบกล่องจดหมาย (รวมถึงกล่อง Junk/Spam)
        </p>

        <!-- Button -->
        <a href="{{ route('login') }}" class="btn-login">
            ← กลับไปหน้าเข้าสู่ระบบ
        </a>
    </div>
</body>
</html>