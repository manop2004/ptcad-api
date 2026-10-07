@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">

<style>
:root {
  --navy: #12358f;
  --blue: #1765ff;
  --ink: #0b1f4d;
  --muted: #667085;
  --line: #e6edf8;
  --soft-blue: #f4f9ff;
  --danger: #dc3545;
}

.justify-content-center {
  display: flex;
  justify-content: center;
}

.form-scope .fl-group { 
  position: relative !important; 
  margin-bottom: 22px !important; 
}

.form-scope .fl-group input,
.form-scope .fl-group select,
.form-scope .fl-group textarea {
  width: 100% !important;
  border: 1.5px solid var(--line) !important; 
  border-radius: 12px !important;
  padding: 22px 16px 8px !important; 
  background: #ffffff !important; 
  font-size: 14.5px !important;
  color: var(--ink) !important;
  font-weight: 500 !important;
  box-sizing: border-box !important;
  transition: all .2s ease !important;
  box-shadow: none !important;
  height: 56px !important;
}

.form-scope .fl-group select[multiple],
.form-scope .fl-group select {
  height: auto !important;
  min-height: 56px !important;
  padding: 22px 16px 8px !important;
  display: block !important;
}

.form-scope .fl-group label {
  position: absolute !important; 
  top: 50% !important; 
  left: 16px !important; 
  transform: translateY(-50%) !important;
  font-size: 14.5px !important; 
  color: var(--muted) !important;
  pointer-events: none !important; 
  transition: all .2s cubic-bezier(0.4, 0, 0.2, 1) !important; 
  margin: 0 !important;
  font-weight: 500 !important;
  z-index: 5 !important;
}

.form-scope .fl-group:focus-within label,
.form-scope .fl-group input:not(:placeholder-shown) ~ label,
.form-scope .fl-group select:focus ~ label,
.form-scope .fl-group select:not([value=""]) ~ label,
.form-scope .fl-group .bootstrap-tagsinput-focus ~ label {
  top: 14px !important;
  transform: translateY(-50%) scale(.85) !important;
  transform-origin: left top !important;
  color: var(--blue) !important;
  font-weight: 700 !important;
}

.form-scope .fl-group select ~ label {
  top: 14px !important;
  transform: translateY(-50%) scale(.85) !important;
  transform-origin: left top !important;
}

.form-scope .fl-group input:focus,
.form-scope .fl-group select:focus {
  border-color: var(--blue) !important;
  outline: none !important;
  box-shadow: 0 0 0 4px rgba(23,101,255,.08) !important;
}

.form-scope .editor-title {
  font-size: 14.5px;
  font-weight: 700;
  color: var(--ink);
  margin-bottom: 8px;
  display: block;
}
.form-scope .editor-title span {
  color: var(--danger);
}

.form-scope .bootstrap-tagsinput {
  display: block !important;
  width: 100% !important;
  height: auto !important;
  min-height: 56px !important;
  padding: 24px 16px 6px !important;
  background-color: #fff !important;
  border: 1.5px solid var(--line) !important;
  border-radius: 12px !important;
  box-shadow: none !important;
  transition: all .2s ease !important;
}

.form-scope .bootstrap-tagsinput:focus-within {
  border-color: var(--blue) !important;
  box-shadow: 0 0 0 4px rgba(23,101,255,.08) !important;
}

.form-scope .bootstrap-tagsinput .tag {
  background: var(--soft-blue) !important;
  color: var(--navy) !important;
  border: 1px solid rgba(23,101,255,.2) !important;
  padding: 4px 10px !important;
  border-radius: 6px !important;
  font-size: 13px !important;
  font-weight: 600 !important;
  margin-right: 5px !important;
  margin-bottom: 5px !important;
  display: inline-block !important;
}

.form-scope .bootstrap-tagsinput .tag [data-role="remove"] {
  margin-left: 6px !important;
  color: var(--danger) !important;
  font-weight: 700 !important;
}

.form-scope .bootstrap-tagsinput input {
  height: auto !important;
  padding: 0 !important;
  margin-bottom: 6px !important;
  border: none !important;
  background: transparent !important;
  color: var(--ink) !important;
  width: auto !important;
}
.form-scope .bootstrap-tagsinput input:focus {
  box-shadow: none !important;
}

.file-upload-box {
  background: #f8fafc !important;
  border: 1.5px dashed #cbd5e1 !important;
  border-radius: 12px !important;
  padding: 16px !important;
  margin-bottom: 20px !important;
}

.file-row-item {
  display: flex !important;
  align-items: center !important;
  gap: 12px !important;
  margin-bottom: 10px !important;
  width: 100% !important;
}
.file-row-item:last-child {
  margin-bottom: 0 !important;
}

.file-row-item .custom-file-input-wrap {
  flex-grow: 1 !important;
}

.file-row-item input[type="file"] {
  height: 44px !important;
  padding: 8px 12px !important;
  border: 1.5px solid var(--line) !important;
  border-radius: 8px !important;
  background: #fff !important;
  font-size: 13.5px !important;
  width: 100% !important;
  box-sizing: border-box !important;
}

.btn-delete-file {
  background: #fff5f5 !important;
  border: 1.5px solid #ffe3e3 !important;
  color: var(--danger) !important;
  border-radius: 8px !important;
  width: 44px !important;
  height: 44px !important;
  min-width: 44px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  transition: all 0.2s !important;
  padding: 0 !important;
  box-sizing: border-box !important;
}
.btn-delete-file:hover {
  background: var(--danger) !important;
  color: #fff !important;
  border-color: var(--danger) !important;
}

.btn-add-file {
  background: #fff !important;
  border: 1.5px solid var(--blue) !important;
  color: var(--blue) !important;
  font-weight: 600 !important;
  font-size: 13.5px !important;
  padding: 10px 20px !important;
  border-radius: 8px !important;
  transition: all 0.2s !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 6px !important;
  height: auto !important;
  width: auto !important;
  line-height: 1.2 !important;
  box-sizing: border-box !important;
}
.btn-add-file:hover {
  background: var(--soft-blue) !important;
  transform: translateY(-1px);
}

.btn-submit-ticket {
  background: linear-gradient(135deg, #1765ff, #12358f) !important;
  color: #ffffff !important;
  border: none !important;
  border-radius: 12px !important;
  height: 54px !important;
  width: 100% !important;
  font-weight: 700 !important;
  font-size: 16px !important;
  transition: all 0.25s ease !important;
  box-shadow: 0 10px 20px rgba(23, 101, 255, 0.15) !important;
  cursor: pointer !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

.btn-submit-ticket:hover {
  color: #ffffff !important;
  transform: translateY(-2px) !important;
  box-shadow: 0 14px 28px rgba(23, 101, 255, 0.25) !important;
}

.btn-submit-ticket.disabled {
  background: #cbd5e1 !important;
  box-shadow: none !important;
  cursor: not-allowed !important;
}

.program-checkbox-container {
  display: flex !important;
  flex-wrap: wrap !important;
  gap: 12px !important;
  background: #ffffff !important;
  border: 1.5px solid var(--line) !important;
  border-radius: 12px !important;
  padding: 14px 16px !important;
  min-height: 56px !important;
  align-items: center !important;
  box-sizing: border-box !important;
  width: 100% !important;
}

.checkbox-card {
  position: relative !important;
  display: inline-flex !important;
  align-items: center !important;
  background: transparent !important;
  border: none !important;
  border-radius: 6px !important;
  padding: 4px 8px !important;
  cursor: pointer !important;
  margin: 0 !important;
  transition: all 0.2s ease !important;
  user-select: none !important;
}

.checkbox-card input[type="checkbox"] {
  position: absolute !important;
  opacity: 0 !important;
  cursor: pointer !important;
  height: 0 !important;
  width: 0 !important;
}

.checkbox-custom {
  position: relative !important;
  height: 18px !important;
  width: 18px !important;
  background-color: #fff !important;
  border: 1.5px solid #cbd5e1 !important;
  border-radius: 4px !important;
  margin-right: 8px !important;
  transition: all 0.2s ease !important;
  display: inline-block !important;
}

.checkbox-label-text {
  font-size: 14.5px !important;
  font-weight: 500 !important;
  color: var(--ink) !important;
}

.checkbox-card input:checked ~ .checkbox-custom {
  background-color: var(--blue) !important;
  border-color: var(--blue) !important;
}

.checkbox-card input:checked ~ .checkbox-custom:after {
  content: "" !important;
  position: absolute !important;
  display: block !important;
  left: 5px !important;
  top: 1.5px !important;
  width: 5px !important;
  height: 9px !important;
  border: solid white !important;
  border-width: 0 2px 2px 0 !important;
  transform: rotate(45deg) !important;
}

.checkbox-card:hover .checkbox-label-text {
  color: var(--blue) !important;
}
.checkbox-card:hover .checkbox-custom {
  border-color: var(--blue) !important;
}
</style>
@endsection

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container">
            @if (!empty($breadcrumb))
                <section id="page-title" class="page-title-mini page-title-right">
                    <div class="clearfix">
                        <ol class="breadcrumb">
                            @foreach ($breadcrumb as $index => $item)
                                @if($index !== count($breadcrumb) -1 )
                                    <li><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
                                @else
                                    <li class="active">{{ $item['name'] }}</li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                </section>
            @endif
            
            <h1 class="center" style="color: var(--ink); font-weight: 700; margin-bottom: 10px;">Open Ticket</h1>
            <div class="text-center bottommargin-sm" style="color: var(--muted);">หากพบปัญหาการใช้งานโปรแกรม หรือต้องการความช่วยเหลือ กรุณากรอกแบบฟอร์มด้านล่าง</div>
            <hr style="border-top: 1px solid var(--line); margin-bottom: 30px;"/>
            
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="form-scope">
                        {{
                            Form::open([
                                'novalidate',
                                'route' => 'fronend.help.crate',
                                'id'=>'form-ticket',
                                'method' => 'post',
                                'files' => true
                            ])
                        }}
                        
                        <input type="hidden" name="idempotency_key" value="{{ (string) \Illuminate\Support\Str::uuid() }}">
                        <input type="hidden" name="request_channel" value="{{ old('request_channel', $request_channel ?? '') }}">
@if ($errors->has('recaptcha') || $errors->has('too_many'))
    <div class="col-12" style="margin-bottom: 20px;">
        <div style="background:#fff5f5; border:1.5px solid #ffe3e3; color:#dc3545; padding:14px 18px; border-radius:10px; font-size:14px; font-weight:600;">
            @error('recaptcha'){{ $message }}@enderror
            @error('too_many'){{ $message }}@enderror
        </div>
    </div>
@endif
                        <div class="row">
                            
                            {{-- ชื่อผู้ติดต่อ --}}
                            <div class="col-md-6">
                                <div class="fl-group @error('name') is-invalid @enderror">
                                    <input type="text" placeholder=" " id="name" name="name" @if(!empty($userdata['userName'])) value="{{ $userdata['userName'] }}" @else @if(!empty(old('name'))) value="{{ old('name') }}" @endif @endif>
                                    <label for="name">ชื่อผู้ติดต่อ <span style="color: var(--danger);">*</span></label>
                                </div>
                                @error('name')<small class="invalid-feedback" role="alert" style="display:block; margin-top:-15px; margin-bottom:15px;"><strong>{{ $message }}</strong></small>@enderror
                            </div>

                            {{-- ชื่อบริษัท --}}
                            <div class="col-md-6">
                                <div class="fl-group @error('company') is-invalid @enderror">
                                    <input type="text" placeholder=" " id="company" name="company" @if(!empty($userdata['userCompanyMain'])) value="{{ $userdata['userCompanyMain'] }}" @else @if(!empty(old('company'))) value="{{ old('company') }}" @endif @endif>
                                    <label for="company">ชื่อบริษัท / องค์กร <span style="color: var(--danger);">*</span></label>
                                </div>
                                @error('company')<small class="invalid-feedback" role="alert" style="display:block; margin-top:-15px; margin-bottom:15px;"><strong>{{ $message }}</strong></small>@enderror
                            </div>

                            {{-- เบอร์โทรศัพท์ --}}
                            <div class="col-md-6">
                                <div class="fl-group @error('tel') is-invalid @enderror">
                                    <input type="text" placeholder=" " id="tel" name="tel" @if(!empty($userdata['userTelMain'])) value="{{ $userdata['userTelMain'] }}" @else @if(!empty(old('tel'))) value="{{ old('tel') }}" @endif @endif>
                                    <label for="tel">เบอร์โทรศัพท์ <span style="color: var(--danger);">*</span></label>
                                </div>
                                @error('tel')<small class="invalid-feedback" role="alert" style="display:block; margin-top:-15px; margin-bottom:15px;"><strong>{{ $message }}</strong></small>@enderror
                            </div>

                            {{-- อีเมล --}}
                            <div class="col-md-6">
                                <div class="fl-group @error('email') is-invalid @enderror">
                                    <input type="email" placeholder=" " id="email" name="email" @if(!empty($userdata['userEmail'])) value="{{ $userdata['userEmail'] }}" @else @if(!empty(old('email'))) value="{{ old('email') }}" @endif @endif>
                                    <label for="email">อีเมล <span style="color: var(--danger);">*</span></label>
                                </div>
                                @error('email')<small class="invalid-feedback" role="alert" style="display:block; margin-top:-15px; margin-bottom:15px;"><strong>{{ $message }}</strong></small>@enderror
                            </div>

                                {{-- โปรแกรมที่ขอใช้บริการ เวอร์ชันแก้ทาง Select2/Selectpicker ซ้อนกัน เคลียร์หน้าจอให้คลีน --}}
<div class="col-12" style="margin-bottom: 22px;">
    <!-- ดึง Label ออกมาอยู่นอกกล่องแบบปกติ ไม่ต้อง absolute -->
    <label style="font-size: 14px; font-weight: 700; color: #12358f; margin-bottom: 8px; display: block;">
        โปรแกรมที่ขอใช้บริการ <span style="color: var(--danger);">*</span>
    </label>
    
    <!-- ใส่สไตล์ตรงๆ เพื่อบล็อกไม่ให้สคริปต์อื่นมาทำกล่องพัง -->
    <select id="program-select" name="program[]" multiple 
        style="width: 100% !important; display: block !important; background: #ffffff !important; border: 1.5px solid #e6edf8 !important; border-radius: 12px !important; padding: 12px 16px !important; min-height: 56px !important; font-size: 14.5px !important; color: #0b1f4d !important; font-weight: 500 !important; outline: none !important; box-shadow: none !important;">
        @foreach ($programs as $program)
            @if($program->name != 'Other(อื่นๆ)')
                <option value="{{ $program->name }}">{{ $program->name }}</option>
            @endif
        @endforeach
        <option value="Other(อื่นๆ)">Other (อื่นๆ)</option>
    </select>
    
    @error('program')<small class="invalid-feedback" role="alert" style="display:block; margin-top:5px;"><strong>{{ $message }}</strong></small>@enderror
</div>  

                            {{-- รายละเอียดสินค้า (CKEditor) --}}
                            <div class="col-12 bottommargin-sm">
                                <label class="editor-title" for="editor">รายละเอียดความต้องการ <span>*</span></label>
                                <textarea id="editor" placeholder="รายละเอียด" name="message">{{ old('displayname') }}</textarea>
                                @error('message')<small class="invalid-feedback" role="alert" style="display:block; margin-top:5px;"><strong>{{ $message }}</strong></small>@enderror
                            </div>

                            {{-- โซนแนบไฟล์ --}}
                            <div class="col-12">
                                <label class="editor-title" style="margin-bottom:6px;">แนบรูปภาพหรือไฟล์ประกอบ (ถ้ามี)</label>
                                <div class="file-upload-box">
                                    <div class="file-row-item child_div">
                                        <div class="custom-file-input-wrap">
                                            <input type="file" accept="image/*" class="form-control" id="file" name="file[]">
                                        </div>
                                        <div>
                                            <button onclick="deleteChild(this)" type="button" class="btn-delete-file" aria-label="ลบไฟล์"><i class="bi bi-trash3-fill"></i></button>
                                        </div>
                                    </div>
                                    <div id="fileForm"></div>
                                    
                                    <div style="margin-top: 15px; text-align: left;">
                                        <button type="button" class="btn-add-file" id="addMoreFile">
                                            <i class="bi bi-plus-circle-fill"></i> เพิ่มไฟล์แนบอีกช่อง
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <?php
                                $display_req = '';
                                $display_sales = '';
                                if($userdata['is_customer'] == 'yes'){
                                    $display_req = 'style="display: none;"';
                                    $display_sales = 'style="display: none;"';
                                }
                                if(empty($userdata['userLevel'])){
                                    $display_req = 'style="display: none;"';
                                    $display_sales = '';
                                }
                                $arr_request_channel = array('Line','Live Chat','Facebook','Phone','Website','Email');
                            ?>
                            
                            <input type="hidden" id="sales_id" name="sales_id" @if(!empty($userdata['userStaffId'])) value="{{ $userdata['userStaffId'] }}" @else @if(!empty(old('sales_id'))) value="{{ old('sales_id') }}" @endif @endif >
                            <input type="hidden" id="sales_name" name="sales_name" @if(!empty($userdata['userStaffName'])) value="{{ $userdata['userStaffName'] }}" @else @if(!empty(old('sales_name'))) value="{{ old('sales_name') }}" @endif @endif>
                            
                            {{-- Email CC --}}
                            <div class="col-12" <?php echo $display_sales; ?>>
                                <div class="fl-group @error('email_cc') is-invalid @enderror">
                                    <input type="email" id="email_cc" name="email_cc" placeholder=" " @if(!empty($userdata['userStaffEmail'])) value="{{ $userdata['userStaffEmail'] }}" @else @if(!empty(old('email_cc'))) value="{{ old('email_cc') }}" @endif @endif>
                                    <label for="email_cc">Email CC</label>
                                </div>
                                @error('email_cc')<small class="invalid-feedback" role="alert" style="display:block; margin-top:-15px; margin-bottom:15px;"><strong>{{ $message }}</strong></small>@enderror
                            </div>
                            
                            {{-- ปุ่ม Submit --}}
                            <div class="col-12 topmargin-xs">
                                <script src="https://www.google.com/recaptcha/api.js"></script>
                                <div class="g-recaptcha" data-sitekey="6Le8JlwtAAAAAAw3vNKIPT5NBN2rnggWybH1oZc9" style="margin-bottom: 16px;"></div>
                                <button type="submit" class="loadding btn-submit-ticket" id="submit-ticket-btn">
                                    ส่งข้อมูลแบบฟอร์มช่วยเหลือ
                                </button>
                            </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('vendor/ckeditor4_basic/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/ckeditor4_basic/samples/js/sample.js') }}"></script>
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script>
    initSample();
</script>
<script>
    let submitting = false;
    document.getElementById('form-ticket').addEventListener('submit', function(e){
      if (submitting) {
        e.preventDefault();
        return;
      }
      var response = (typeof grecaptcha !== 'undefined') ? grecaptcha.getResponse() : '';
      if (!response || response.length === 0) {
        e.preventDefault();
        alert('กรุณายืนยันตัวตน (ติ๊กช่อง reCAPTCHA) ก่อนส่งข้อมูล');
        return;
      }
      submitting = true;
      const btn = document.getElementById('submit-ticket-btn');
      if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กำลังส่งข้อมูล...';
        btn.classList.add('disabled');
      }
      [...this.elements].forEach(el => el.readOnly = true);
    });

    $(document).ready(function() {
        $('#email_cc').tagsinput({
            trimValue: true,
            confirmKeys: [13, 44],
        });

        $('.bootstrap-tagsinput input').on('focus', function() {
            $(this).closest('.fl-group').addClass('bootstrap-tagsinput-focus');
        }).on('blur', function() {
            if($(this).val() === '' && $('#email_cc').val() === '') {
                $(this).closest('.fl-group').removeClass('bootstrap-tagsinput-focus');
            }
        });

        $('#email_cc').on('beforeItemAdd', function(event) {
            var email = event.item;
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(email)) {
                event.cancel = true;
                alert("กรุณากรอกอีเมลที่ถูกต้อง");
            }
        });
    });
</script>
@endsection