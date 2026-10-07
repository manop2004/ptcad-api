@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('content')

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        {{
            Form::model($menuData ?? null, [
                'novalidate',
                'route' => ['levelmenu.update', $levelData->id],
                'id'=>'data-form',
                'method' => 'put',
            ])
        }}

        <div class="card">
            <div class="card-header">
                <h5 class="title">สิทธิ์เริ่มต้นของ Role : {{ $levelData->name }}</h5>
                <p class="text-muted mb-0">ตั้งค่านี้เป็นแค่ "แม่แบบ" — ไม่กระทบสิทธิ์ที่ผู้ใช้แต่ละคนตั้งไว้แล้ว จนกว่าจะไปกด "โหลดจาก Role" ในหน้าผู้ใช้คนนั้นเอง</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 checkbox-radios">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_artlicle" id="l_artlicle" @if(!empty($menuData)) @if($menuData->l_artlicle == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                บทความ
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_page" id="l_page" @if(!empty($menuData)) @if($menuData->l_page == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                หน้าเพจ
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_category" id="l_category" @if(!empty($menuData)) @if($menuData->l_category == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                หมวดหมู่
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_banner" id="l_banner" @if(!empty($menuData)) @if($menuData->l_banner == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                แบรนเนอร์
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_promotion" id="l_promotion" @if(!empty($menuData)) @if($menuData->l_promotion == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                โปรโมชั่น
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_software" id="l_software" @if(!empty($menuData)) @if($menuData->l_software == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ซอฟต์แวร์
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_program" id="l_program" @if(!empty($menuData)) @if($menuData->l_program == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                โปรแกรมติดตั้ง
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_bank" id="l_bank" @if(!empty($menuData)) @if($menuData->l_bank == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ตั้งค่าการชำระเงิน
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_membergetmember" id="l_membergetmember" @if(!empty($menuData)) @if($menuData->l_membergetmember == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ระบบแนะนำสมาชิก
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_membergetmember_setting" id="l_membergetmember_setting" @if(!empty($menuData)) @if($menuData->l_membergetmember_setting == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ตั้งค่าระบบแนะนำสมาชิก
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_recommend" id="l_recommend" @if(!empty($menuData)) @if($menuData->l_recommend == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ตั้งค่ารายการแนะนำ
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_setting" id="l_setting" @if(!empty($menuData)) @if($menuData->l_setting == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ตั้งค่าเว็บไซต์
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_customcode" id="l_customcode" @if(!empty($menuData)) @if($menuData->l_customcode == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                CUSTOM CODE
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 checkbox-radios">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_quotation_setting" id="l_quotation_setting" @if(!empty($menuData)) @if($menuData->l_quotation_setting == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ตั้งค่าใบเสนอราคา
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_quotation" id="l_quotation" @if(!empty($menuData)) @if($menuData->l_quotation == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ใบเสนอราคา
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_product" id="l_product" @if(!empty($menuData)) @if($menuData->l_product == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ข้อมูลสินค้า
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_product_Import" id="l_product_Import" @if(!empty($menuData)) @if($menuData->l_product_Import == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                Import ข้อมูลสินค้า
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_product_Export" id="l_product_Export" @if(!empty($menuData)) @if($menuData->l_product_Export == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                Export ข้อมูลสินค้า
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_product_Action" id="l_product_Action" @if(!empty($menuData)) @if($menuData->l_product_Action == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                เพิ่ม/ลบ/แก้ไข ข้อมูลสินค้า
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_user" id="l_user" @if(!empty($menuData)) @if($menuData->l_user == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                บัญชีผู้ใช้
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_user_Action" id="l_user_Action" @if(!empty($menuData)) @if($menuData->l_user_Action == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                เพิ่ม/ลบ/แก้ไข บัญชีผู้ใช้
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_user_staff_Action" id="l_user_staff_Action" @if(!empty($menuData)) @if($menuData->l_user_staff_Action == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                อัพเดตชื่อพนักงานที่รับผิดชอบดูแลลูกค้า
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input value="1" class="form-check-input" type="checkbox" name="l_ticket" id="l_ticket" @if(!empty($menuData)) @if($menuData->l_ticket == 1)checked @endif @endif>
                                <span class="form-check-sign"></span>
                                บริการลูกค้า
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('levelmenu.index') }}">
                            @include('layouts.admin._button.back')
                        </a>
                    </div>
                    <div class="col-6 right">
                        @include('layouts.admin._button.submit')
                    </div>
                </div>
            </div>
        </div>

        {{ Form::close() }}

    </div>
    <div class="col-md-1"></div>
</div>

@endsection