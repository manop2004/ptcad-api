@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <link href="{{ asset('assets/backend/css/paper-dashboard.css') }}" rel="stylesheet" />

 <style>
    .card-user .image { height: 80px; }
 </style>
@endsection

@section('js')

@endsection
@section('content')

<div class="row">
    <div class="col-md-12">

            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['user.levelupdate', $data->id],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}


            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <div class="card card-user card-wizard active">
                        <div class="image"></div>
                        <div class="card-body">
                            <div class="author">
                                <div class="picture-container">
                                    <div class="picture">
                                        @isset($data->img)
                                            <img class="picture-src" src="{{ asset('storage/avatar/'.$data->img) }}" alt="..." id="wizardPicturePreview"  />
                                        @else
                                            <img class="picture-src" src="{{ asset('images/default-img/default-avatar.png') }}" alt="..." id="wizardPicturePreview"  />
                                        @endisset
                                    </div>
                                </div>
                                <a href="#" style="text-decoration: none">
                                    <h5 class="title">
                                        @if(!empty($data->displayname)){{ $data->displayname }} @else ชื่อที่แสดง @endif
                                    </h5>
                                </a>
                            </div>
                        </div>
                        <div class="card-footer">
                          <hr>
                            <div class="button-container">
                                <div class="row">
                                    <div class="col-lg-12 ml-auto">
                                        {{ $data->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
				
					
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">สิทธิ์การใช้งาน : {{ $level->name}}</h5>
                            <div class="card-header">
    <h5 class="title">สิทธิ์การใช้งาน : {{ $level->name}}</h5>
    @if(!empty($levelTemplate))
    <button type="button" class="btn btn-warning btn-sm" onclick="loadFromRole()">
        <i class="nc-icon nc-settings-gear-65"></i> โหลดค่าเริ่มต้นจาก Role
    </button>
    <small class="text-muted d-block mt-1">ติ๊กให้อัตโนมัติเฉยๆ ยังไม่บันทึก ต้องกด "บันทึก" ด้านล่างเองอีกที</small>
    @endif
</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 checkbox-radios">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_artlicle" id="l_artlicle" @if(!empty($userLevel)) @if($userLevel->l_artlicle == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            บทความ
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_page" id="l_page" @if(!empty($userLevel)) @if($userLevel->l_page == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            หน้าเพจ
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_banner" id="l_banner" @if(!empty($userLevel)) @if($userLevel->l_banner == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            แบรนเนอร์
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_promotion" id="l_promotion" @if(!empty($userLevel)) @if($userLevel->l_promotion == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            โปรโมชั่น
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_software" id="l_software" @if(!empty($userLevel)) @if($userLevel->l_software == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            ซอฟต์แวร์
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_program" id="l_program" @if(!empty($userLevel)) @if($userLevel->l_program == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            โปรแกรมติดตั้ง
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1"  class="form-check-input" type="checkbox" name="l_bank" id="l_bank" @if(!empty($userLevel)) @if($userLevel->l_bank == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            ตั้งค่าการชำระเงิน
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1"  class="form-check-input" type="checkbox" name="l_membergetmember" id="l_membergetmember" @if(!empty($userLevel)) @if($userLevel->l_membergetmember == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            ระบบแนะนำสมาชิก
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1"  class="form-check-input" type="checkbox" name="l_membergetmember_setting" id="l_membergetmember_setting" @if(!empty($userLevel)) @if($userLevel->l_membergetmember_setting == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            ตั้งค่าระบบแนะนำสมาชิก
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_recommend" id="l_recommend" @if(!empty($userLevel)) @if($userLevel->l_recommend == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            ตั้งค่ารายการแนะนำ
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1"  class="form-check-input" type="checkbox" name="l_setting" id="l_setting" @if(!empty($userLevel)) @if($userLevel->l_setting == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            ตั้งค่าเว็บไซต์
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_customcode" id="l_customcode" @if(!empty($userLevel)) @if($userLevel->l_customcode == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            CUSTOM CODE
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 checkbox-radios">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_quotation_setting" id="l_quotation_setting" @if(!empty($userLevel)) @if($userLevel->l_quotation_setting == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            ตั้งค่าใบเสนอราคา
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_quotation" id="l_quotation" @if(!empty($userLevel)) @if($userLevel->l_quotation == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            ใบเสนอราคา
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_product" id="l_product" @if(!empty($userLevel)) @if($userLevel->l_product == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            ข้อมูลสินค้า
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_product_Import" id="l_product_Import" @if(!empty($userLevel)) @if($userLevel->l_product_Import == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            Import ข้อมูลสินค้า
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_product_Export" id="l_product_Export" @if(!empty($userLevel)) @if($userLevel->l_product_Export == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            Export ข้อมูลสินค้า
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input value="1" class="form-check-input" type="checkbox" name="l_product_Action" id="l_product_Action" @if(!empty($userLevel)) @if($userLevel->l_product_Action == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            เพิ่ม/ลบ/แก้ไข ข้อมูลสินค้า
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input  value="1"  class="form-check-input" type="checkbox" name="l_user" id="l_user" @if(!empty($userLevel)) @if($userLevel->l_user == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            บัญชีผู้ใช้
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input  value="1"  class="form-check-input" type="checkbox" name="l_user_Action" id="l_user_Action" @if(!empty($userLevel)) @if($userLevel->l_user_Action == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            เพิ่ม/ลบ/แก้ไข บัญชีผู้ใช้
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input  value="1"  class="form-check-input" type="checkbox" name="l_user_staff_Action" id="l_user_staff_Action" @if(!empty($userLevel)) @if($userLevel->l_user_staff_Action == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            อัพเดตชื่อพนักงานที่รับผิดชอบดูแลลูกค้า
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input  value="1"  class="form-check-input" type="checkbox" name="l_ticket" id="l_ticket" @if(!empty($userLevel)) @if($userLevel->l_ticket == 1)checked @endif @endif>
                                            <span class="form-check-sign"></span>
                                            บริการลูกค้า
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="card">
						<div class="card-header">
							<h5 class="title mb-0">พื้นที่การเข้าถึง Brand</h5>
							<small class="text-muted">
								เลือก Brand ที่ผู้ใช้นี้สามารถเข้าถึงหลังบ้านได้
							</small>
						</div>

						<div class="card-body">
							<div class="form-group">
								<label>Brand ที่เข้าถึงได้</label>

								<div class="row">
									@foreach($brands as $brand)
										<div class="col-md-6 checkbox-radios">
											<div class="form-check">
												<label class="form-check-label">
													<input
														type="checkbox"
														name="access_brand_id[]"
														value="{{ $brand->id }}"
														class="form-check-input"
														@if(in_array((int) $brand->id, $selectedBrandIds ?? [])) checked @endif
													>
													<span class="form-check-sign"></span>
													{{ $brand->brand_name }}
												</label>
											</div>
										</div>
									@endforeach
								</div>

								@if($brands->count() == 0)
									<small class="text-muted">ยังไม่มี Brand ที่เปิดใช้งาน</small>
								@endif
							</div>
						</div>
					</div>
					
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('user.edit',['id' => $data->id]) }}">
                                        @include('layouts.admin._button.back')
                                    </a>
                                </div>
                                <div class="col-6 right">
                                    @include('layouts.admin._button.submit')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>

        </form>
    </div>
</div>
@section('js')
@if(!empty($levelTemplate))
<script>
    function loadFromRole() {
        const template = @json($levelTemplate);
        const fields = [
            'l_artlicle','l_promotion','l_software','l_program','l_banner',
            'l_page','l_customcode','l_setting','l_recommend',
            'l_user','l_user_Action','l_user_staff_Action','l_bank',
            'l_membergetmember','l_membergetmember_setting',
            'l_quotation','l_quotation_setting',
            'l_product','l_product_Import','l_product_Export','l_product_Action',
            'l_ticket'
        ];
        fields.forEach(function(field) {
            const checkbox = document.getElementById(field);
            if (checkbox) {
                checkbox.checked = (template[field] == 1);
            }
        });
        alert('โหลดค่าจาก Role "{{ $level->name }}" แล้ว — อย่าลืมกด "บันทึก" ด้านล่างเพื่อยืนยันการเปลี่ยนแปลง');
    }
</script>
@endif
@endsection
@endsection
