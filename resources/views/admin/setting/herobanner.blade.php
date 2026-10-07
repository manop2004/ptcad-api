@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }

    /* ===================================================================
       LIVE PREVIEW: ก็อปปี้ CSS จาก resources/views/fontend/main.blade.php
       (section .pt-hero) มาไว้ในนี้ ใช้ prefix .pt-preview-wrap แทน .pt-wrap
       กันชนกับ CSS เดิมของ Admin theme — ห้ามลบ prefix นี้ทิ้งเด็ดขาด
    =================================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap');

    .pt-preview-wrap{
        --navy:#12358f; --blue:#1765ff; --blue-2:#3d8cff; --sky:#8fd3ff;
        --ink:#0b1f4d; --muted:#667085; --line:#e6edf8; --soft:#f6f9ff;
        font-family:'Poppins','Noto Sans Thai',system-ui,sans-serif;
        color:var(--ink);
        width:100%;
        box-sizing:border-box;
    }
    .pt-preview-wrap *{box-sizing:border-box}
    .pt-preview-wrap a{text-decoration:none;color:inherit}
    .pt-preview-wrap .pt-hero{
        position:relative; display:grid; grid-template-columns:minmax(0,1fr) minmax(0,.94fr); min-height:380px;
        background:radial-gradient(circle at 80% 42%,rgba(143,211,255,.55),transparent 30%),
                   linear-gradient(105deg,#ffffff 0%,#f3f8ff 52%,#dbefff 100%);
        overflow:hidden; border-radius:24px;
    }
    .pt-preview-wrap .pt-hero:after{
        content:"";position:absolute;right:-90px;bottom:-130px;width:520px;height:320px;
        background:linear-gradient(145deg,rgba(23,101,255,.08),rgba(143,211,255,.35));
        border-radius:55% 45% 0 0;transform:rotate(-8deg);
    }
    .pt-preview-wrap .pt-hero-left{position:relative;z-index:2;padding:44px 36px 40px 44px}
    .pt-preview-wrap .pt-eyebrow{display:inline-flex;align-items:center;gap:8px;color:var(--blue);font-weight:800;font-size:12px;margin-bottom:16px}
    .pt-preview-wrap .pt-h1{font-size:34px;line-height:1.15;margin:0 0 10px;color:var(--navy);letter-spacing:-1px;font-weight:800;word-break:break-word}
    .pt-preview-wrap .pt-price-line{font-size:15px;font-weight:700;color:#163a90;margin:6px 0 20px}
    .pt-preview-wrap .pt-price-line strong{font-size:22px;color:var(--blue);letter-spacing:-1px}
    .pt-preview-wrap .pt-bullets{display:grid;grid-template-columns:repeat(2,minmax(140px,1fr));gap:10px 20px;margin:0 0 24px;max-width:520px}
    .pt-preview-wrap .pt-bullet{display:flex;align-items:center;gap:8px;color:#344054;font-weight:600;font-size:13px}
    .pt-preview-wrap .pt-check{width:18px;height:18px;border-radius:50%;display:grid;place-items:center;background:var(--blue);color:#fff;flex:none;font-size:10px}
    .pt-preview-wrap .pt-hero-actions{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
    .pt-preview-wrap .pt-primary-btn{
        height:40px;padding:0 22px;border-radius:10px;border:none;
        background:linear-gradient(135deg,var(--blue),#0d57df);color:white;font-weight:800;font-size:13.5px;
        display:inline-flex;align-items:center;justify-content:center;gap:8px;
        box-shadow:0 10px 20px rgba(23,101,255,.24);
    }
    .pt-preview-wrap .pt-secondary-btn{
        height:40px;padding:0 22px;border-radius:10px;border:1.5px solid var(--blue);
        background:#fff;color:var(--blue);font-weight:800;font-size:13.5px;
        display:inline-flex;align-items:center;justify-content:center;gap:8px;
    }
    .pt-preview-wrap .pt-hero-art{position:relative;z-index:2;display:flex;align-items:center;justify-content:center;padding:24px 30px;overflow:hidden}
    .pt-preview-wrap .pt-mockup{position:relative;width:100%;max-width:380px;height:230px}
    .pt-preview-wrap .pt-box{
        position:absolute;left:0;bottom:8px;width:120px;height:170px;border-radius:14px;
        background:linear-gradient(160deg,#fff 0%,#edf6ff 40%,#0f3d9c 41%,#1765ff 100%);
        box-shadow:0 18px 36px rgba(12,45,126,.18);
        display:flex;flex-direction:column;justify-content:flex-end;padding:16px;color:white;overflow:hidden;
    }
    .pt-preview-wrap .pt-box b{font-size:16px;line-height:1.15;z-index:1;letter-spacing:-.5px}
    .pt-preview-wrap .pt-box span{font-size:9px;opacity:.8;z-index:1;margin-top:4px}
    .pt-preview-wrap .pt-laptop{
        position:absolute;right:0;bottom:0;width:310px;height:200px;border-radius:14px 14px 6px 6px;
        background:#1c2433;padding:8px 8px 18px;box-shadow:0 20px 44px rgba(10,31,77,.24);
    }
    .pt-preview-wrap .pt-screen{height:160px;border-radius:8px;background:#f8fbff;overflow:hidden;border:1px solid #d9e3f2;position:relative}
    .pt-preview-wrap .pt-screen:before{content:"";display:block;height:16px;background:#eef3fb;border-bottom:1px solid #d9e3f2}
    .pt-preview-wrap .pt-cad-lines{position:absolute;inset:26px 22px 18px;border:2px solid #a8b5c9;background:linear-gradient(90deg,transparent 49%,#d8e0ea 50%,transparent 51%),linear-gradient(0deg,transparent 49%,#d8e0ea 50%,transparent 51%);background-size:32px 32px}
    .pt-preview-wrap .pt-base{position:absolute;left:30px;right:26px;bottom:-14px;height:16px;border-radius:0 0 18px 18px;background:#b8c3d4}
    .pt-preview-wrap .pt-hero-art img{max-width:100%;max-height:280px;object-fit:contain}

    .pt-preview-badge{
        display:inline-flex;align-items:center;gap:6px;background:#eef6ff;color:var(--blue,#1765ff);
        font-weight:700;font-size:12px;padding:4px 12px;border-radius:999px;margin-bottom:10px;
    }
    .pt-preview-note{font-size:12px;color:#94a3b8;margin-top:10px}

    .pt-img-preview-box{
        margin-top:10px;height:140px;border:2px dashed #d1d5db;border-radius:8px;
        display:flex;align-items:center;justify-content:center;background:#f9fafb;overflow:hidden;
    }
    .pt-img-preview-box i{font-size:36px;color:#9ca3af}
    .pt-img-preview-box img{max-width:100%;max-height:100%;object-fit:contain}

    @media (max-width:900px){
        .pt-preview-wrap .pt-hero{grid-template-columns:1fr}
        .pt-preview-wrap .pt-hero-art{display:none}
    }

    /* ===== เลือกโหมด Hero Banner ===== */
    .pt-mode-option{
        display:flex;gap:10px;align-items:flex-start;border:1.5px solid #e2e8f0;border-radius:12px;
        padding:14px 16px;cursor:pointer;transition:.15s ease;margin:0;
    }
    .pt-mode-option:hover{border-color:#94a3b8}
    .pt-mode-option input[type="radio"]{margin-top:3px;flex:none}
    .pt-mode-option:has(input:checked){border-color:#1765ff;background:#eef6ff}

    /* ===== Preview โหมดรูปเดียว (คลุมทับพื้นที่ Hero ทั้งหมดตอนเลือกโหมด 2) ===== */
    .pt-preview-full-overlay{
        position:absolute;inset:0;z-index:5;display:flex;align-items:center;justify-content:center;
        background:#eef2f7;border-radius:24px;overflow:hidden;
    }
    .pt-preview-full-overlay img{width:100%;height:100%;object-fit:cover}
    .pt-preview-full-overlay .empty-hint{color:#94a3b8;font-size:13px;text-align:center;padding:20px}
</style>
@endsection

@section('content')

{{
    Form::model($data, [
        'novalidate',
        'route' => ['setting.herobanner.update', $data->id],
        'id'=>'data-form',
        'method' => 'put',
        'files' => true
    ])
}}

    {{-- ===================================================================
         LIVE PREVIEW — จำลองหน้า Hero Banner จริงบนหน้าแรก อัปเดตสดตามฟอร์ม
    =================================================================== --}}
    <div class="card">
        <div class="card-header"><h5>รูปแบบ Hero Banner</h5></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="pt-mode-option">
                        <input type="radio" name="hero_mode" value="1" id="heroModeText"
                            @if(empty($data->hero_mode) || $data->hero_mode == 1) checked @endif>
                        <div>
                            <strong>โหมดข้อความ (ปกติ)</strong>
                            <p class="text-muted" style="margin:4px 0 0;font-size:12.5px">หัวข้อ + ราคา + Bullet + ปุ่ม + รูปฝั่งขวา — แบบที่ตั้งค่าด้านล่างทั้งหมด</p>
                        </div>
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="pt-mode-option">
                        <input type="radio" name="hero_mode" value="2" id="heroModeImage"
                            @if(!empty($data->hero_mode) && $data->hero_mode == 2) checked @endif>
                        <div>
                            <strong>โหมดรูปเดียว/หลายรูป (แบนเนอร์เต็มพื้นที่)</strong>
                            <p class="text-muted" style="margin:4px 0 0;font-size:12.5px">ใช้ระบบ "แบรนเนอร์" ที่มีอยู่แล้ว — อัปโหลดได้หลายรูป มีลิงก์+วันหมดอายุ+เลื่อนสไลด์อัตโนมัติ</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card" id="heroLivePreviewCard" style="{{ (!empty($data->hero_mode) && $data->hero_mode == 2) ? 'display:none' : '' }}">
        <div class="card-body">
            <span class="pt-preview-badge"><i class="fa fa-eye"></i> พรีวิวแบบสด (Live Preview)</span>
            <div class="pt-preview-wrap">
                <section class="pt-hero" id="ptPreviewHero">
                    <div class="pt-preview-full-overlay" id="ptPreviewFullOverlay" style="{{ (!empty($data->hero_mode) && $data->hero_mode == 2) ? '' : 'display:none' }}">
                        <div class="empty-hint">
                            <i class="fa fa-images" style="font-size:28px;margin-bottom:8px;display:block"></i>
                            โหมดนี้แสดงผลจริงจากหน้า "แบรนเนอร์"<br>ดูตัวอย่างสไลด์จริงได้ที่หน้าแรกของเว็บหลังบันทึก
                        </div>
                    </div>
                    <div class="pt-hero-left" id="ptPreviewTextModeLeft" style="{{ (!empty($data->hero_mode) && $data->hero_mode == 2) ? 'visibility:hidden' : '' }}">
                        <div class="pt-eyebrow">
                            <i class="fa fa-check-circle"></i> CAD ถูกลิขสิทธิ์ ซื้อออนไลน์ได้ทันที
                        </div>
                        <h1 class="pt-h1" id="ptPrevTitle">{{ !empty($data->hero_title) ? $data->hero_title : 'PTCAD โปรแกรมเขียนแบบ 2D' }}</h1>
                        <p class="pt-price-line" id="ptPrevPriceLine" style="{{ empty($data->hero_price) ? 'display:none' : '' }}">
                            เริ่มต้นเพียง <strong id="ptPrevPrice">{{ $data->hero_price }}</strong> <span id="ptPrevPriceUnit">{{ $data->hero_price_unit }}</span>
                        </p>
                        <div class="pt-bullets" id="ptPrevBullets">
                            @for($i=1;$i<=4;$i++)
                            <div class="pt-bullet" id="ptPrevBulletRow{{ $i }}" style="{{ empty($data->{'hero_bullet'.$i}) ? 'display:none' : '' }}">
                                <span class="pt-check"><i class="fa fa-check"></i></span>
                                <span id="ptPrevBullet{{ $i }}">{{ $data->{'hero_bullet'.$i} }}</span>
                            </div>
                            @endfor
                        </div>
                        <div class="pt-hero-actions">
                            <a class="pt-primary-btn" id="ptPrevBtn1" href="javascript:void(0)"
                               style="{{ (!empty($data->hero_btn1_status) && $data->hero_btn1_status != 1) ? 'display:none' : '' }}">
                                <span id="ptPrevBtn1Text">{{ !empty($data->hero_btn1_text) ? $data->hero_btn1_text : 'ซื้อเลย' }}</span>
                            </a>
                            <a class="pt-secondary-btn" id="ptPrevBtn2" href="javascript:void(0)"
                               style="{{ (!empty($data->hero_btn2_status) && $data->hero_btn2_status != 1) ? 'display:none' : '' }}">
                                <span id="ptPrevBtn2Text">{{ !empty($data->hero_btn2_text) ? $data->hero_btn2_text : 'ทดลองใช้ฟรี' }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="pt-hero-art" id="ptPrevArt" style="{{ (!empty($data->hero_mode) && $data->hero_mode == 2) ? 'visibility:hidden' : '' }}">
                        @if(!empty($data->hero_image))
                            <img id="ptPrevHeroImage" src="{{ asset('storage/setting/'.$data->hero_image) }}">
                        @else
                        <div class="pt-mockup" id="ptPrevMockup">
                            <div class="pt-box"><b>PTCAD</b><span>SOFTWARE STORE</span></div>
                            <div class="pt-laptop">
                                <div class="pt-screen"><div class="pt-cad-lines"></div></div>
                                <div class="pt-base"></div>
                            </div>
                        </div>
                        <img id="ptPrevHeroImage" src="" style="display:none">
                        @endif
                    </div>
                </section>
            </div>
            <p class="pt-preview-note">
                * พรีวิวนี้จำลองหน้าจริงเท่าที่ทำได้ — สีสัน/ระยะห่างอาจต่างจากหน้าเว็บจริงเล็กน้อยเนื่องจากย่อขนาดลงมาแสดงในหน้า Admin
            </p>
        </div>
    </div>

    <div class="row" id="heroModeTextRow" style="{{ (!empty($data->hero_mode) && $data->hero_mode == 2) ? 'display:none' : '' }}">
        <div class="col-md-9">

            <div class="card">
                <div class="card-header"><h5>ข้อความหลัก</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group has-label">
                                <label>หัวข้อ / ชื่อสินค้า<span class="text-danger">*</span></label>
                                <input class="form-control" name="hero_title" id="hero_title" value="{{ old('hero_title', $data->hero_title) }}" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group has-label">
                                <label>ราคา</label>
                                <input class="form-control" name="hero_price" id="hero_price" value="{{ old('hero_price', $data->hero_price) }}" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group has-label">
                                <label>หน่วยราคา</label>
                                <input class="form-control" name="hero_price_unit" id="hero_price_unit" value="{{ old('hero_price_unit', $data->hero_price_unit) }}" placeholder="เช่น บาท/ปี" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5>Bullet คุณสมบัติ (4 ข้อ)</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>ข้อที่ 1</label>
                                <input class="form-control" name="hero_bullet1" id="hero_bullet1" value="{{ old('hero_bullet1', $data->hero_bullet1) }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>ข้อที่ 2</label>
                                <input class="form-control" name="hero_bullet2" id="hero_bullet2" value="{{ old('hero_bullet2', $data->hero_bullet2) }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>ข้อที่ 3</label>
                                <input class="form-control" name="hero_bullet3" id="hero_bullet3" value="{{ old('hero_bullet3', $data->hero_bullet3) }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-label">
                                <label>ข้อที่ 4</label>
                                <input class="form-control" name="hero_bullet4" id="hero_bullet4" value="{{ old('hero_bullet4', $data->hero_bullet4) }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5>ปุ่มที่ 1 (หลัก เช่น "ซื้อเลย")</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group has-label">
                                <label>ข้อความปุ่ม</label>
                                <input class="form-control" name="hero_btn1_text" id="hero_btn1_text" value="{{ old('hero_btn1_text', $data->hero_btn1_text) }}" />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group has-label">
                                <label>ลิงก์ปุ่ม</label>
                                <input class="form-control" name="hero_btn1_link" value="{{ old('hero_btn1_link', $data->hero_btn1_link) }}" placeholder="เช่น /category หรือ https://..." />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group has-label">
                                <label>เปิด/ปิดปุ่ม</label><br>
                                <input name="hero_btn1_status" id="hero_btn1_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="เปิด" data-off-label="ปิด" data-on-color="success" data-off-color="danger"
                                    @if(!empty($data->hero_btn1_status)) @if($data->hero_btn1_status == 1) checked @endif @else checked @endif
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5>ปุ่มที่ 2 (รอง เช่น "ทดลองใช้ฟรี")</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group has-label">
                                <label>ข้อความปุ่ม</label>
                                <input class="form-control" name="hero_btn2_text" id="hero_btn2_text" value="{{ old('hero_btn2_text', $data->hero_btn2_text) }}" />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group has-label">
                                <label>ลิงก์ปุ่ม</label>
                                <input class="form-control" name="hero_btn2_link" value="{{ old('hero_btn2_link', $data->hero_btn2_link) }}" placeholder="เช่น /help หรือ https://..." />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group has-label">
                                <label>เปิด/ปิดปุ่ม</label><br>
                                <input name="hero_btn2_status" id="hero_btn2_status" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="เปิด" data-off-label="ปิด" data-on-color="success" data-off-color="danger"
                                    @if(!empty($data->hero_btn2_status)) @if($data->hero_btn2_status == 1) checked @endif @else checked @endif
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5>ลิงก์ปุ่มอื่นๆ ในหน้าแรก</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-label">
                                <label>ปุ่ม "สมัครสมาชิกเพื่อดูวิดีโอ" (MEMBER ACCESS)</label>
                                <input class="form-control" name="member_access_link" value="{{ old('member_access_link', $data->member_access_link) }}" placeholder="ค่าเดิม: หน้าล็อกอิน" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-label">
                                <label>ปุ่ม "ดาวน์โหลด Trial" (FAQ & DOWNLOAD)</label>
                                <input class="form-control" name="trial_download_link" value="{{ old('trial_download_link', $data->trial_download_link) }}" placeholder="ค่าเดิม: หน้าช่วยเหลือ" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-label">
                                <label>ปุ่ม "ขอใบเสนอราคา" (FOR BUSINESS)</label>
                                <input class="form-control" name="business_quote_link" value="{{ old('business_quote_link', $data->business_quote_link) }}" placeholder="ค่าเดิม: หน้าขอใบเสนอราคา" />
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">ถ้าไม่กรอก ระบบจะใช้ลิงก์เดิมของหน้านั้นๆ ตามปกติ (ไม่มีผลถ้าเว้นว่างไว้)</small>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        พื้นหลังทั้งหมดของ Hero (แทนพื้นฟ้าไล่เฉด)
                    </div>
                    @if(!empty($data->hero_bg_image))
                        <div class="mb-3">
                            <img src="{{ asset('storage/setting/'.$data->hero_bg_image) }}" style="max-height:160px;border:1px solid #eee;border-radius:8px;padding:4px" />
                            <input type="hidden" name="hero_bg_image_old" value="{{ $data->hero_bg_image }}">
                            <br>
                            <button type="button" class="btn btn-sm btn-danger" style="margin-top:8px" onclick="ptDeleteHeroImage('bg')">
                                <i class="fa fa-trash"></i> ลบรูปนี้
                            </button>
                        </div>
                    @endif
                    <input type="file" accept="image/*" class="form-control" id="hero_bg_image" name="hero_bg_image" />
                    <button type="button" class="btn btn-sm btn-secondary" id="cancelHeroBgFile" style="display:none;margin-top:8px">
                        <i class="fa fa-times"></i> ยกเลิกไฟล์นี้
                    </button>
                    <p></p>
                    <small class="text-muted">อัปโหลดรูปใหม่เพื่อแทนพื้นหลังไล่เฉดสีฟ้าทั้งกล่อง Hero (ถ้าไม่อัปโหลด จะใช้พื้นหลังไล่เฉดแบบเดิม) แนะนำรูปแนวนอน ขนาดไม่เกิน 2MB — พรีวิวด้านบนจะอัปเดตทันทีที่เลือกไฟล์</small>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        รูปภาพฝั่งขวา (แทนกล่อง Mockup)
                    </div>
                    @if(!empty($data->hero_image))
                        <div class="mb-3">
                            <img src="{{ asset('storage/setting/'.$data->hero_image) }}" style="max-height:160px;border:1px solid #eee;border-radius:8px;padding:4px" />
                            <input type="hidden" name="hero_image_old" value="{{ $data->hero_image }}">
                            <br>
                            <button type="button" class="btn btn-sm btn-danger" style="margin-top:8px" onclick="ptDeleteHeroImage('main')">
                                <i class="fa fa-trash"></i> ลบรูปนี้
                            </button>
                        </div>
                    @endif
                    <input type="file" accept="image/*" class="form-control" id="hero_image" name="hero_image" />
                    <button type="button" class="btn btn-sm btn-secondary" id="cancelHeroImageFile" style="display:none;margin-top:8px">
                        <i class="fa fa-times"></i> ยกเลิกไฟล์นี้
                    </button>
                    <p></p>
                    <small class="text-muted">อัปโหลดรูปใหม่ (ถ้าไม่อัปโหลด จะใช้กล่อง Mockup แบบเดิม) แนะนำไฟล์แนวตั้ง/สี่เหลี่ยม พื้นหลังโปร่งใส (PNG) ขนาดไม่เกิน 2MB — พรีวิวด้านบนจะอัปเดตทันทีที่เลือกไฟล์</small>
                </div>
            </div>

        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-footer">
                    @include('layouts.admin._button.submit')
                </div>
            </div>
            @if(!empty($data->updated_by))
            <div class="card">
                <div class="card-body">
                    <small>อัพเดตข้อมูลโดย :: {{ $data->updated_by }} :: {{ $data->updated_at }}</small>
                </div>
            </div>
            @endif
        </div>
    </div>
</form>

    <div class="card" id="heroModeImageCard" style="{{ (!empty($data->hero_mode) && $data->hero_mode == 2) ? '' : 'display:none' }}">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h5 style="margin:0">รูปแบนเนอร์ที่มีอยู่ ({{ count($banners) }})</h5>
            <input type="text" class="form-control" id="bannerSearchBox" placeholder="ค้นหา" style="max-width:220px">
        </div>
        <div class="card-body">
            <p class="text-muted" style="font-size:12.5px">
                รูปทั้งหมดที่ "เปิดใช้งาน" ด้านล่างนี้จะไปโชว์เป็น slide บนหน้าแรก (เลื่อนอัตโนมัติทุก 10 วินาที ถ้ามีมากกว่า 1 รูป)
                — จัดการเพิ่ม/แก้/ลบรูปได้จากตรงนี้เลย ไม่ต้องออกจากหน้านี้
            </p>

            <table class="table table-bordered" id="bannerListTable" style="margin-top:12px">
                <thead>
                    <tr>
                        <th style="width:110px">Desktop</th>
                        <th style="width:90px">Mobile</th>
                        <th>คำอธิบาย / ลิงก์</th>
                        <th style="width:120px">วันที่โปรโมท</th>
                        <th style="width:70px">ลำดับ</th>
                        <th style="width:110px">สถานะ</th>
                        <th style="width:110px">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $b)
                    <tr>
                        <td>
                            @if(!empty($b->banner_img_desktop))
                                <img src="{{ asset('storage/banner/'.$b->banner_img_desktop) }}" style="width:100px">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if(!empty($b->banner_img_mobile))
                                <img src="{{ asset('storage/banner/'.$b->banner_img_mobile) }}" style="width:70px">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            {{ $b->banner_note }}
                            @if(!empty($b->banner_link))<br><small class="text-muted">{{ $b->banner_link }}</small>@endif
                        </td>
                        <td style="font-size:12px">
                            @if(!empty($b->banner_start_date))เริ่ม {{ date('d-m-Y', strtotime($b->banner_start_date)) }}<br>@endif
                            @if(!empty($b->banner_end_date))หมด {{ date('d-m-Y', strtotime($b->banner_end_date)) }}@endif
                            @if(empty($b->banner_start_date) && empty($b->banner_end_date))<span class="text-muted">ไม่จำกัด</span>@endif
                        </td>
                        <td>{{ $b->banner_sort }}</td>
                        <td>
                            @if($b->banner_show == 1)
                                <span class="badge" style="background:#20b26b;color:#fff;padding:6px 12px;border-radius:999px;font-size:12px">เปิดใช้งาน</span>
                            @else
                                <span class="badge" style="background:#ef4444;color:#fff;padding:6px 12px;border-radius:999px;font-size:12px">ปิดใช้งาน</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('banner.status', $b->id) }}" class="btn btn-sm btn-outline-primary" title="เปิด/ปิดการแสดงผล">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('setting.herobanner') }}?edit_id={{ $b->id }}#addBannerFullForm" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('banner.delete') }}" method="POST" style="display:inline" onsubmit="return confirm('ลบรูปนี้ถาวร แน่ใจไหม?')">
    @csrf
    @method('DELETE')
    <input type="hidden" name="deleteId" value="{{ $b->id }}">
    <input type="hidden" name="return_to" value="{{ url()->current() }}">
    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
</form>
                        </td>
                    </tr>

                    {{-- Modal แก้ไขของแถวนี้ --}}
                    @empty
                    <tr><td colspan="7" class="text-center text-muted">ยังไม่มีรูปแบนเนอร์ — กด "เพิ่มรูปแบนเนอร์" เพื่อเริ่ม</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="addBannerFullForm" style="{{ (!empty($data->hero_mode) && $data->hero_mode == 2) ? '' : 'display:none' }}">

        @if(empty($editingBanner))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'banner.crate',
                    'id'=>'banner-data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($editingBanner, [
                    'novalidate',
                    'route' => ['banner.update',[$editingBanner->id]],
                    'id'=>'banner-data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif
        <input type="hidden" name="return_to" value="{{ route('setting.herobanner') }}">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5 style="margin:0">{{ !empty($editingBanner) ? 'แก้ไขแบนเนอร์ #'.$editingBanner->id : 'เพิ่มแบนเนอร์ใหม่' }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-label">
                                    <label>Link url</label>
                                    <input class="form-control no-max-height" id="banner_link" name="banner_link" value="@if(!empty($editingBanner->banner_link)){{ $editingBanner->banner_link }}@else{{ old('banner_link') }}@endif" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group has-label">
                                    <label>คำอธิบายภาพ <span class="text-danger">*</span></label>
                                    <input class="form-control no-max-height" id="banner_note" name="banner_note" value="@if(!empty($editingBanner->banner_note)){{ $editingBanner->banner_note }}@else{{ old('banner_note') }}@endif" />
                                    @error('banner_note')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-label">
                                    <label>วันที่เริ่มโปรโมท</label>
                                    <input class="form-control no-max-height" id="banner_start_date" name="banner_start_date" placeholder="เว้นว่าง = ไม่จำกัด" value="@if(!empty($editingBanner->banner_start_date)){{ date("d-m-Y",strtotime($editingBanner->banner_start_date)) }}@else{{ old('banner_start_date') }}@endif" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-label">
                                    <label>วันที่สิ้นสุดการโปรโมท</label>
                                    <input class="form-control no-max-height" id="banner_end_date" name="banner_end_date" placeholder="เว้นว่าง = ไม่จำกัด" value="@if(!empty($editingBanner->banner_end_date)){{ date("d-m-Y",strtotime($editingBanner->banner_end_date)) }}@else{{ old('banner_end_date') }}@endif" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="has-label">
                                    <label>รูปภาพสำหรับ (Desktop) <span class="text-danger">*</span></label>
                                    <input type="file" accept="image/*" class="form-control" id="banner_img_desktop" name="banner_img_desktop" onchange="readURL1(this);">
                                    @error('banner_img_desktop')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    <small>ขนาดไฟล์ คือ 2048 X 587 PX</small><br/>
                                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>
                                    <br/><br/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="has-label">
                                    <label>รูปภาพสำหรับ (Mobile) <span class="text-danger">*</span></label>
                                    <input type="file" accept="image/*" class="form-control" id="banner_img_mobile" name="banner_img_mobile" onchange="readURL2(this);">
                                    @error('banner_img_mobile')<small class="error-danger-text">{{ $message }}</small><br/>@enderror
                                    <small>ขนาดไฟล์ คือ 900 X 1050 PX</small><br/>
                                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>
                                    <br/><br/>
                                </div>
                            </div>
                            @if(!empty($editingBanner->updated_by))
                            <div class="col-md-12">
                                <div class="line"></div>
                                <div class="form-group has-label">
                                    <label>อัพเดตข้อมูลโดย :: {{ $editingBanner->updated_by }} :: {{ $editingBanner->updated_at }} </label>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="jumbotron">
                            บันทึกแบบร่าง / เผยแพร่
                        </div>
                        <div class="form-group">
                            <input name="banner_show" id="banner_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                            @if(!empty($editingBanner->banner_show))
                                @if($editingBanner->banner_show == 1) checked @endif
                            @else checked @endif
                            />
                        </div>
                        <hr/>
                        <div class="jumbotron">
                            ลำดับการแสดงผล
                        </div>
                        <div class="form-group">
                            <input class="form-control no-max-height" id="banner_sort" name="banner_sort" placeholder="0" value="@if(!empty($editingBanner->banner_sort)){{ $editingBanner->banner_sort }}@else @if(!empty(old('banner_sort'))) {{ old('banner_sort') }} @else @if(!empty($sort)) {{ $sort->banner_sort+1 }} @else 1 @endif @endif @endif" />
                            <p><small class="error-danger-text">* เรียงลำดับโดยตัวเลขมากที่สุดขึ้นก่อน</small></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                @if(!empty($editingBanner))
                                <a href="{{ route('setting.herobanner') }}" class="btn btn-outline-secondary">ยกเลิกการแก้ไข</a>
                                @endif
                            </div>
                            <div class="col-6 right">
                                @include('layouts.admin._button.submit')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group text-align-center">
                                    @if(!empty($editingBanner->banner_img_desktop))
                                    <button type="button" class="btn btn-icon btn-round btn-google pt-remove-existing-img" data-type="desktop" data-id="{{ $editingBanner->id }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <input type="hidden" class="form-control" id="banner_img_desktop_old" name="banner_img_desktop_old" value="{{ $editingBanner->banner_img_desktop }}">
                                    <img id="blah1" src="{{ asset('storage/banner/'.$editingBanner->banner_img_desktop) }}" alt="" class="full-width border_img" rel="nofollow">
                                    @else
                                    <img id="blah1" src="{{ asset('images/default-img/default-banner_2048_587.jpg') }}" alt="..." class="full-width border_img" rel="nofollow">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group text-align-center">
                                    @if(!empty($editingBanner->banner_img_mobile))
                                    <button type="button" class="btn btn-icon btn-round btn-google pt-remove-existing-img" data-type="mobile" data-id="{{ $editingBanner->id }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <input type="hidden" class="form-control" id="banner_img_mobile_old" name="banner_img_mobile_old" value="{{ $editingBanner->banner_img_mobile }}">
                                    <img id="blah2" src="{{ asset('storage/banner/'.$editingBanner->banner_img_mobile) }}" alt="" class="full-width border_img" rel="nofollow">
                                    @else
                                    <img id="blah2" src="{{ asset('images/default-img/default-banner-900-1050.jpg') }}" alt="..." class="full-width border_img" rel="nofollow">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </form>
    </div>



@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== สลับโหมด Hero Banner (ข้อความ / รูปเดียว) — บันทึกทันทีอัตโนมัติ ไม่ต้องกดปุ่มบันทึกซ้ำ =====
    var modeTextRadio  = document.getElementById('heroModeText');
    var modeImageRadio = document.getElementById('heroModeImage');

    function saveHeroModeThenReload(modeValue){
        fetch('{{ route("setting.herobanner.updateMode", $data->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': ptCsrfToken,
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'hero_mode=' + modeValue
        }).then(function(res){
            if (res.ok) {
                // รีเฟรชหน้าทันที กันจุดอื่นๆที่ render ตาม hero_mode ตอนโหลดหน้า
                // (เช่น Live Preview, badge ต่างๆ) ค้างสถานะเก่าไม่ตรงกับโหมดที่เพิ่งสลับ
                window.location.reload();
            } else {
                alert('บันทึกโหมดไม่สำเร็จ ลองใหม่อีกครั้ง');
            }
        }).catch(function(err){
            alert('เกิดข้อผิดพลาด: ' + err);
        });
    }

    modeTextRadio.addEventListener('change', function(){ if (this.checked) saveHeroModeThenReload(1); });
    modeImageRadio.addEventListener('change', function(){ if (this.checked) saveHeroModeThenReload(2); });

    // ===== ข้อความหลัก + ราคา =====
    var titleInput = document.getElementById('hero_title');
    var prevTitle  = document.getElementById('ptPrevTitle');
    titleInput.addEventListener('input', function(){
        prevTitle.textContent = this.value.trim() !== '' ? this.value : 'PTCAD โปรแกรมเขียนแบบ 2D';
    });

    var priceInput   = document.getElementById('hero_price');
    var priceUnitInput = document.getElementById('hero_price_unit');
    var prevPriceLine = document.getElementById('ptPrevPriceLine');
    var prevPrice     = document.getElementById('ptPrevPrice');
    var prevPriceUnit = document.getElementById('ptPrevPriceUnit');

    function updatePriceLine(){
        if (priceInput.value.trim() !== '') {
            prevPriceLine.style.display = '';
            prevPrice.textContent = priceInput.value;
            prevPriceUnit.textContent = priceUnitInput.value;
        } else {
            prevPriceLine.style.display = 'none';
        }
    }
    priceInput.addEventListener('input', updatePriceLine);
    priceUnitInput.addEventListener('input', updatePriceLine);

    // ===== Bullet 4 ข้อ =====
    for (var i = 1; i <= 4; i++) {
        (function(idx){
            var input = document.getElementById('hero_bullet' + idx);
            var row = document.getElementById('ptPrevBulletRow' + idx);
            var span = document.getElementById('ptPrevBullet' + idx);
            input.addEventListener('input', function(){
                if (this.value.trim() !== '') {
                    row.style.display = '';
                    span.textContent = this.value;
                } else {
                    row.style.display = 'none';
                }
            });
        })(i);
    }

    // ===== ปุ่มที่ 1 =====
    var btn1TextInput = document.getElementById('hero_btn1_text');
    var prevBtn1Text  = document.getElementById('ptPrevBtn1Text');
    var prevBtn1      = document.getElementById('ptPrevBtn1');
    var btn1Status    = document.getElementById('hero_btn1_status');

    btn1TextInput.addEventListener('input', function(){
        prevBtn1Text.textContent = this.value.trim() !== '' ? this.value : 'ซื้อเลย';
    });
    btn1Status.addEventListener('change', function(){
        prevBtn1.style.display = this.checked ? '' : 'none';
    });

    // ===== ปุ่มที่ 2 =====
    var btn2TextInput = document.getElementById('hero_btn2_text');
    var prevBtn2Text  = document.getElementById('ptPrevBtn2Text');
    var prevBtn2      = document.getElementById('ptPrevBtn2');
    var btn2Status    = document.getElementById('hero_btn2_status');

    btn2TextInput.addEventListener('input', function(){
        prevBtn2Text.textContent = this.value.trim() !== '' ? this.value : 'ทดลองใช้ฟรี';
    });
    btn2Status.addEventListener('change', function(){
        prevBtn2.style.display = this.checked ? '' : 'none';
    });

    // ===== รูปภาพฝั่งขวา (แทนกล่อง Mockup) — พรีวิวทันทีที่เลือกไฟล์ =====
    var heroImageInput = document.getElementById('hero_image');
    var prevHeroImage  = document.getElementById('ptPrevHeroImage');
    var prevMockup      = document.getElementById('ptPrevMockup');
    var cancelHeroImageBtn = document.getElementById('cancelHeroImageFile');

    // เก็บค่าดั้งเดิมไว้ก่อน เผื่อผู้ใช้กด "ยกเลิกไฟล์นี้"
    var originalHeroImageSrc = prevHeroImage.src;
    var originalMockupDisplay = prevMockup ? prevMockup.style.display : null;

    heroImageInput.addEventListener('change', function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                prevHeroImage.src = e.target.result;
                prevHeroImage.style.display = '';
                if (prevMockup) { prevMockup.style.display = 'none'; }
                cancelHeroImageBtn.style.display = '';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    cancelHeroImageBtn.addEventListener('click', function(){
        heroImageInput.value = ''; // เคลียร์ไฟล์ที่เลือกในฟอร์ม กันไม่ให้อัปโหลดตอนกด submit
        prevHeroImage.src = originalHeroImageSrc;
        prevHeroImage.style.display = originalHeroImageSrc ? '' : 'none';
        if (prevMockup) { prevMockup.style.display = originalMockupDisplay; }
        this.style.display = 'none';
    });

    // ===== พื้นหลังทั้งกล่อง Hero — พรีวิวทันทีที่เลือกไฟล์ =====
    var heroBgInput = document.getElementById('hero_bg_image');
    var prevHeroBox = document.getElementById('ptPreviewHero');
    var cancelHeroBgBtn = document.getElementById('cancelHeroBgFile');
    var originalHeroBgStyle = prevHeroBox.getAttribute('style') || '';

    heroBgInput.addEventListener('change', function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                prevHeroBox.style.background = 'url(' + e.target.result + ') center/cover no-repeat';
                cancelHeroBgBtn.style.display = '';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    cancelHeroBgBtn.addEventListener('click', function(){
        heroBgInput.value = ''; // เคลียร์ไฟล์ที่เลือกในฟอร์ม กันไม่ให้อัปโหลดตอนกด submit
        prevHeroBox.setAttribute('style', originalHeroBgStyle);
        this.style.display = 'none';
    });

    // ===== bootstrap-switch ครอบ checkbox ไว้ ต้อง sync สถานะหลังปลั๊กอิน init เสร็จอีกรอบ =====
    // (เผื่อปลั๊กอิน bootstrap-switch re-render checkbox ใหม่ ทำให้ event listener เดิมหลุด)
    setTimeout(function(){
        var b1 = document.getElementById('hero_btn1_status');
        var b2 = document.getElementById('hero_btn2_status');
        if (b1) b1.addEventListener('switchChange.bootstrapSwitch', function(e, state){
            document.getElementById('ptPrevBtn1').style.display = state ? '' : 'none';
        });
        if (b2) b2.addEventListener('switchChange.bootstrapSwitch', function(e, state){
            document.getElementById('ptPrevBtn2').style.display = state ? '' : 'none';
        });
    }, 500);

    // ===== ลบรูป (bg_image / hero_image) แบบ fetch ไม่ใช้ nested form กันฟอร์มพัง =====
    var ptCsrfToken = '{{ csrf_token() }}';

    window.ptDeleteHeroImage = function(type){
        var msg = 'ลบรูปนี้และกลับไปใช้ค่าเดิม?';
        if (type === 'bg') msg = 'ลบรูปนี้และกลับไปใช้พื้นหลังไล่เฉดสีฟ้าแบบเดิม?';
        if (type === 'main') msg = 'ลบรูปนี้และกลับไปใช้กล่อง Mockup แบบเดิม?';
        if (type === 'full') msg = 'ลบรูปแบนเนอร์เต็มพื้นที่นี้?';
        if (!confirm(msg)) return;

        var url = '{{ route('setting.herobanner.deleteImage') }}';
        if (type === 'bg') url = '{{ route('setting.herobanner.deleteBgImage') }}';
        if (type === 'full') url = '{{ route('setting.herobanner.deleteFullImage') }}';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': ptCsrfToken,
                'Accept': 'application/json'
            }
        }).then(function(res){
            if (res.ok) {
                window.location.reload();
            } else {
                alert('ลบไม่สำเร็จ (สถานะ ' + res.status + ') กรุณาลองใหม่ หรือแจ้งทีมพัฒนา');
            }
        }).catch(function(err){
            alert('เกิดข้อผิดพลาดตอนลบรูป: ' + err);
        });
    };

    // ===== พรีวิวรูปหลังเลือกไฟล์ (ใช้ร่วมกันทุกช่องอัปโหลดแบนเนอร์) =====
    document.querySelectorAll('.pt-img-input').forEach(function(input){
        input.addEventListener('change', function(){
            var previewBox = document.getElementById(this.dataset.preview);
            if (!previewBox) return;
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e){
                    previewBox.innerHTML = '<img src="' + e.target.result + '">';
                    previewBox.style.display = '';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // ===== ค้นหาในตารางแบนเนอร์ (ค้นจากคำอธิบายภาพ) =====
    var bannerSearchBox = document.getElementById('bannerSearchBox');
    if (bannerSearchBox) {
        bannerSearchBox.addEventListener('keyup', function(){
            var keyword = this.value.toLowerCase();
            document.querySelectorAll('#bannerListTable tbody tr').forEach(function(row){
                var text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(keyword) !== -1 ? '' : 'none';
            });
        });
    }

    // ===== ลบรูปเดิม (ปุ่ม X บนรูปที่มีอยู่แล้วในฟอร์มแก้ไขแบนเนอร์) =====
    document.querySelectorAll('.pt-remove-existing-img').forEach(function(btn){
        btn.addEventListener('click', function(){
            if (!confirm('ลบรูปนี้?')) return;
            var type = this.dataset.type; // 'desktop' หรือ 'mobile'
            var id = this.dataset.id;
            var url = type === 'desktop'
                ? '{{ route("banner.deleteDesktop") }}'
                : '{{ route("banner.deleteMobile") }}';
            var idField = type === 'desktop' ? 'deleteId' : 'deleteId2';

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = url;

            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = ptCsrfToken;
            form.appendChild(csrfInput);

            var idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = idField;
            idInput.value = id;
            form.appendChild(idInput);

            document.body.appendChild(form);
            form.submit();
        });
    });

});

// ===== พรีวิวรูปที่เลือกใหม่ในฟอร์มแบนเนอร์ (Desktop/Mobile) — ต้องอยู่นอก DOMContentLoaded
//       เพราะฟอร์มเดิมเรียกผ่าน onchange="readURL1(this)" ตรงๆ ในแท็ก HTML =====
function readURL1(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('blah1').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readURL2(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('blah2').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection