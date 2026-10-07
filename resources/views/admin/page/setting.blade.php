@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
 </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(empty($data))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'page.setting.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['page.setting.update',[$data->id]],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
        @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>ตั้งค่าหน้าเพจ</h4>
                            <label>เลือกหน้าเพจที่ต้องการเพื่อเชื่อมต่อไปยังหน้าเว็บไซต์</label>
                            <hr/>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    เกี่ยวกับเรา
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="page_about" name="page_about" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_about)
                                                <option @if(!empty($data)) @if($page_about->id == $data->page_about) selected @endif @endif value="{{ $page_about->id }}" >{{ $page_about->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    นโยบายความเป็นส่วนตัว
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="page_privacy_policy" name="page_privacy_policy" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_privacy_policy)
                                                <option @if(!empty($data)) @if($page_privacy_policy->id == $data->page_privacy_policy) selected @endif @endif value="{{ $page_privacy_policy->id }}" >{{ $page_privacy_policy->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    นโยบายทางธุรกิจ
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="page_business_policy" name="page_business_policy" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_business_policy)
                                                <option @if(!empty($data)) @if($page_business_policy->id == $data->page_business_policy) selected @endif @endif value="{{ $page_business_policy->id }}" >{{ $page_business_policy->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    นโยบายการคืนสินค้า
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="page_refund_policy" name="page_refund_policy" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_refund_policy)
                                                <option @if(!empty($data)) @if($page_refund_policy->id == $data->page_refund_policy) selected @endif @endif value="{{ $page_refund_policy->id }}" >{{ $page_refund_policy->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    นโยบายการคืนเงิน
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="page_return_policy" name="page_return_policy" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_return_policy)
                                                <option @if(!empty($data)) @if($page_return_policy->id == $data->page_return_policy) selected @endif @endif value="{{ $page_return_policy->id }}" >{{ $page_return_policy->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    นโยบายการรับประกันสินค้า
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="page_warranty_policy" name="page_warranty_policy" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_warranty_policy)
                                                <option @if(!empty($data)) @if($page_warranty_policy->id == $data->page_warranty_policy) selected @endif @endif value="{{ $page_warranty_policy->id }}" >{{ $page_warranty_policy->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    ตรวจสอบสถานะจัดส่ง
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="pages_check_delivery" name="pages_check_delivery" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_howto_shopping)
                                                <option @if(!empty($data)) @if($page_howto_shopping->id == $data->pages_check_delivery) selected @endif @endif value="{{ $page_howto_shopping->id }}" >{{ $page_howto_shopping->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    วิธีการสั่งซื้อ
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="page_howto_shopping" name="page_howto_shopping" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_howto_shopping)
                                                <option @if(!empty($data)) @if($page_howto_shopping->id == $data->page_howto_shopping) selected @endif @endif value="{{ $page_howto_shopping->id }}" >{{ $page_howto_shopping->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    วิธีการสมัครสมาชิก
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="page_howto_register" name="page_howto_register" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_howto_register)
                                                <option @if(!empty($data)) @if($page_howto_register->id == $data->page_howto_register) selected @endif @endif value="{{ $page_howto_register->id }}" >{{ $page_howto_register->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    สิทธิประโยชน์ของสมาชิก
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="page_membership" name="page_membership" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_membership)
                                                <option @if(!empty($data)) @if($page_membership->id == $data->page_membership) selected @endif @endif value="{{ $page_membership->id }}" >{{ $page_membership->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    ติดต่อทีมงานซัพพอร์ต
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="pages_contact_support" name="pages_contact_support" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_howto_register)
                                                <option @if(!empty($data)) @if($page_howto_register->id == $data->pages_contact_support) selected @endif @endif value="{{ $page_howto_register->id }}" >{{ $page_howto_register->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    ช่องทางการชำระเงิน/แจ้งชำระเงิน
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="form-group has-label">
                                        <select id="pages_payment" name="pages_payment" class="form-control" >
                                            <option value="">กรุณาเลือกหน้าเพจ</option>
                                            @foreach ( $pages as $page_howto_register)
                                                <option @if(!empty($data)) @if($page_howto_register->id == $data->pages_payment) selected @endif @endif value="{{ $page_howto_register->id }}" >{{ $page_howto_register->pages_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="line"></div>
                            <div class="form-group has-label">
                                @if(!empty($data->created_by))<label>เพิ่มข้อมูลโดย :: {{ $data->created_by}} :: {{ $data->created_at}} </label>@endif
                                @if(!empty($data->updated_by))<br/><label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>@endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-6 right">
                                    @include('layouts.admin._button.submit')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection


@section('js')
    <!-- select2 -->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <!-- select2-bootstrap4-theme -->
    <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

@endsection
