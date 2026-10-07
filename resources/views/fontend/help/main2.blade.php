@extends('layouts.temp_user')

@section('title'){{ $og_title }} |@endsection
@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('css')

 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
 <style>
	.justify-content-center {
		display: flex;
		justify-content: center;
	}
	.bootstrap-tagsinput {
        display: block;
		width: 100%;
		height: 38px;
		padding: 8px 14px;
		font-size: 15px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 2px solid #ddd;
		border-radius: 0 !important;
		-webkit-transition: border-color ease-in-out .15s;
		-o-transition: border-color ease-in-out .15s;
		transition: border-color ease-in-out .15s;
    }
	.bootstrap-tagsinput .tag{
		font-size: 14px;
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
            <h1 class="center">Open Ticket</h1>
            <hr/>
			<div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
            {{
                Form::open([
                    'novalidate',
                    'route' => 'fronend.help.crate2',
                    'id'=>'form-ticket',
                    'method' => 'post',
                    'files' => true
                ])
            }}
                <div class="">
                    <div class="col_full bottommargin-xs">
                        <label>ชื่อ<span class="span-danger">*</span></label>
                        <input type="text" placeholder="ชื่อ" id="name" name="name" @if(!empty($userdata['userName'])) value="{{ $userdata['userName'] }}" @else @if(!empty(old('name'))) value="{{ old('name') }}" @endif @endif class="sm-form-control">
                        @error('name')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
					<div class="col_full bottommargin-xs">
                        <label>ชื่อบริษัท <span class="span-danger">*</span></label>
                        <input type="text" placeholder="ชื่อบริษัท" id="company" name="company" @if(!empty($userdata['userCompanyMain'])) value="{{ $userdata['userCompanyMain'] }}" @else @if(!empty(old('company'))) value="{{ old('company') }}" @endif @endif class="sm-form-control">
                        @error('company')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
					<div class="col_full bottommargin-xs">
                        <label>เบอร์โทรศัพท์ <span class="span-danger">*</span></label>
                        <input type="text" placeholder="เบอร์โทรศัพท์" id="tel" name="tel" @if(!empty($userdata['userTelMain'])) value="{{ $userdata['userTelMain'] }}" @else @if(!empty(old('tel'))) value="{{ old('tel') }}" @endif @endif class="sm-form-control">
                        @error('tel')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                    <div class="col_full bottommargin-xs">
                        <label>Email <span class="span-danger">*</span></label>
                        <input type="email" placeholder="Email" id="email" name="email" @if(!empty($userdata['userEmail'])) value="{{ $userdata['userEmail'] }}" @else @if(!empty(old('email'))) value="{{ old('email') }}" @endif @endif class="sm-form-control">
                        @error('email')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                    <div class="col_full bottommargin-xs">
                        <label>โปรแกรมที่ขอใช้บริการ <span class="span-danger">*</span></label>
                        <select id="program[]" name="program[]" class="sm-form-control selectpicker" data-live-search="true" multiple>
                            @foreach ($programs as $program)
								@if($program->name != 'Other(อื่นๆ)')
                                <option value="{{ $program->name }}">{{ $program->name }}</option>
								@endif
                            @endforeach
                                <option value="Other(อื่นๆ)">Other(อื่นๆ)</option>
                        </select>
                        @error('program')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                    <div class="col_full bottommargin-xs">
                        <label>รายละเอียด <span class="span-danger">*</span></label>
                        <textarea id="editor" type="text" placeholder="รายละเอียด" name="message" class="sm-form-control">{{ old('displayname') }}</textarea>
                        @error('message')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
                    <div class="col_full bottommargin-sm">
                        
                        <div class="row child_div bottommargin-xs">
                            <div class="col-xs-11"><input type="file" accept="image/*" class="form-control" id="file" name="file[]"></div>
                            <div class="col-xs-1"><button onclick="deleteChild(this)" type="button" class="btn btn-danger btn-icon btn-sm"><i class="icon-trash2"></i></button></div>
                        </div>
                        <div id="fileForm"></div>
						
						<div class="row bottommargin-xs">
                            <div class="col-md-6"><button type="button" class="nomargin button button-rounded button-teal" id="addMoreFile"> + </button></div>
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
					<input type="hidden" placeholder="ชื่อเจ้าหน้าที่ฝ่ายขายที่ดูแล" id="sales_name" name="sales_name" @if(!empty($userdata['userStaffName'])) value="{{ $userdata['userStaffName'] }}" @else @if(!empty(old('sales_name'))) value="{{ old('sales_name') }}" @endif @endif class="sm-form-control">
					
					<div class="col_full bottommargin-xs" <?php echo $display_sales; ?>>
                        <label>Email CC</label>
                        <input type="email" id="email_cc" name="email_cc" @if(!empty($userdata['userStaffEmail'])) value="{{ $userdata['userStaffEmail'] }}" @else @if(!empty(old('email_cc'))) value="{{ old('email_cc') }}" @endif @endif class="sm-form-control">
                        @error('email_cc')<small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>@enderror
                    </div>
					<div class="col_full bottommargin-sm">
					<br>
								<script src="https://www.google.com/recaptcha/api.js"></script>
                                <button class="loadding button button-green btn-block g-recaptcha" data-sitekey="6Le53ssZAAAAAPL3FAcWOt6CxB-AKPe6xKovHqHD" data-callback='onSubmit' data-action='submit'>
                        ส่งข้อมูลแบบฟอร์มช่วยเหลือ</button>
                    </div>
                </div>
				</form>
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
   function onSubmit(token) {
     document.getElementById("form-ticket").submit();
   }
   $(document).ready(function() {
		$('#email_cc').tagsinput({
			trimValue: true,
			confirmKeys: [13, 44], // กด Enter หรือ Comma เพื่อเพิ่ม tag
		});

		// ตรวจสอบว่า Input เป็น Email เท่านั้น
		$('#email_cc').on('beforeItemAdd', function(event) {
			var email = event.item;
			var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!regex.test(email)) {
				event.cancel = true; // ยกเลิกการเพิ่มถ้าไม่ใช่อีเมล
				alert("กรุณากรอกอีเมลที่ถูกต้อง");
			}
		});
	});
 </script>
@endsection
