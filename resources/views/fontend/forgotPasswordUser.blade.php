@extends('layouts.temp_user')

@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('title'){{ $og_title }} |@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700&display=swap');

/* ==========================================
   PTCAD GUEST FORGOT PASSWORD THEME
   ========================================== */
.ptcad-forgot-wrap {
    --ptcad-navy: #0a192f;
    --ptcad-blue: #2563eb;
    --ptcad-blue-hover: #1d4ed8;
    --ptcad-cyan: #06b6d4;
    --ptcad-ink: #0f172a;
    --ptcad-muted: #64748b;
    --ptcad-line: #e2e8f0;
    --ptcad-bg-soft: #f8fafc;
    --ptcad-red: #ef4444;
    --ptcad-shadow-lg: 0 20px 30px -10px rgba(15, 23, 42, 0.08), 0 8px 12px -6px rgba(15, 23, 42, 0.04);
    
    font-family: 'Plus Jakarta Sans', 'Noto Sans Thai', system-ui, -apple-system, sans-serif;
    color: var(--ptcad-ink);
    padding: 60px 15px;
    min-height: calc(80vh - 100px);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Container Box */
.ptcad-forgot-card {
    background: #ffffff;
    border: 1px solid var(--ptcad-line);
    border-radius: 24px;
    padding: 44px 36px;
    width: 100%;
    max-width: 480px;
    margin: 0 auto;
    box-shadow: var(--ptcad-shadow-lg);
    position: relative;
    overflow: hidden;
}

/* Top Decorative Bar */
.ptcad-forgot-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #2563eb, #06b6d4);
}

/* Icon Header Header */
.ptcad-icon-badge {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(6, 182, 212, 0.1));
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ptcad-blue);
    margin: 0 auto 20px;
}

.ptcad-forgot-card h3 {
    font-size: 24px;
    font-weight: 800;
    color: var(--ptcad-navy);
    margin: 0 0 10px;
    text-align: center;
    letter-spacing: -0.3px;
}

.ptcad-forgot-card p.desc {
    color: var(--ptcad-muted);
    font-size: 14px;
    line-height: 1.6;
    text-align: center;
    margin: 0 0 28px;
}

/* Form Styles */
.ptcad-forgot-card form .col_full {
    margin-bottom: 20px !important;
}

.ptcad-forgot-card label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--ptcad-ink);
    margin-bottom: 8px;
}

.ptcad-forgot-card .sm-form-control {
    border: 1.5px solid var(--ptcad-line);
    border-radius: 12px;
    height: 50px;
    padding: 0 18px;
    width: 100%;
    font-size: 14px;
    font-family: inherit;
    color: var(--ptcad-ink);
    transition: all 0.2s ease;
    background: var(--ptcad-bg-soft);
}

.ptcad-forgot-card .sm-form-control::placeholder {
    color: #94a3b8;
}

.ptcad-forgot-card .sm-form-control:focus {
    outline: none;
    border-color: var(--ptcad-blue);
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
}

.ptcad-forgot-card .invalid-feedback {
    color: var(--ptcad-red);
    font-size: 12.5px;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
    font-weight: 500;
}

/* Button Custom Overrides */
.ptcad-forgot-card button[type="submit"],
.ptcad-forgot-card input[type="submit"] {
    height: 50px !important;
    padding: 0 24px !important;
    border-radius: 12px !important;
    border: none !important;
    background: linear-gradient(135deg, var(--ptcad-blue), var(--ptcad-blue-hover)) !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    font-size: 15px !important;
    cursor: pointer;
    width: 100%;
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
    transition: all 0.2s ease !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.ptcad-forgot-card button[type="submit"]:hover,
.ptcad-forgot-card input[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #1d4ed8, #1e40af) !important;
}

.ptcad-forgot-card button[type="submit"]:active,
.ptcad-forgot-card input[type="submit"]:active {
    transform: translateY(0);
}

/* Breadcrumb Styling */
.ptcad-breadcrumb {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 0;
    margin: 0 0 24px;
    list-style: none;
    font-size: 13px;
    color: var(--ptcad-muted);
}
.ptcad-breadcrumb li a {
    color: var(--ptcad-muted);
    font-weight: 500;
    text-decoration: none;
    transition: color 0.2s;
}
.ptcad-breadcrumb li a:hover {
    color: var(--ptcad-blue);
}
.ptcad-breadcrumb li.active {
    color: var(--ptcad-ink);
    font-weight: 600;
}
.ptcad-breadcrumb li+li::before {
    content: "/";
    padding-right: 8px;
    color: var(--ptcad-line);
}

@media (max-width: 576px) {
    .ptcad-forgot-wrap {
        padding: 30px 15px;
    }
    .ptcad-forgot-card {
        padding: 32px 20px;
        border-radius: 18px;
    }
}
</style>
@endsection

@section('content')

<section id="content">
    <div class="ptcad-forgot-wrap">
        <div class="ptcad-forgot-card">
            
            @if (!empty($breadcrumb))
            <ul class="ptcad-breadcrumb">
                @foreach ($breadcrumb as $index => $item)
                    @if($index !== count($breadcrumb) - 1)
                        <li><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
                    @else
                        <li class="active">{{ $item['name'] }}</li>
                    @endif
                @endforeach
            </ul>
            @endif

            <!-- Lock Icon Badge -->
            <div class="ptcad-icon-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>

            <h3>{{ $og_title }}</h3>
            <p class="desc">กรุณากรอกอีเมลของคุณ ระบบจะส่งอีเมลเพื่อตั้งรหัสใหม่<br/>หากไม่ได้รับอีเมล กรุณาตรวจสอบที่โฟลเดอร์อีเมลขยะ (Spam)</p>

            {{
                Form::open([
                    'novalidate',
                    'route' => ['fronend.forgotpassword.sendmail'],
                    'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                    'id' => 'user-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
                
                <div class="col_full">
                    <label for="email">อีเมลของคุณ</label>
                    <input type="email" placeholder="you@example.com" id="email" name="email" class="sm-form-control" required>
                    @error('email')
                        <small class="invalid-feedback">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            {{ $message }}
                        </small> 
                    @enderror
                </div>

                <div class="col_full" style="margin-bottom: 0 !important;">
                    @include('layouts.fontend.button.forgotpassword')
                </div>
            </form>

        </div>
    </div>
</section>

@endsection