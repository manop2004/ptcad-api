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
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="title">ข้อมูลผู้แนะนำสมาชิกใหม่ (MEMBER GET MEMBER)</h5>
                <div class="badge_status_getmembr">
                    @if($userGetmember->status == 1)
                        <span class="badge badge-success ">จัดส่งของขวัญแล้ว</span>
                    @else
                        <span class="badge badge-danger ">ยังไม่มีการจัดส่งของขวัญ</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ชื่อ</label>
                            <input class="form-control" value="@if(!empty($data->name)){{ $data->name }}@endif" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>นามสกุล</label>
                            <input class="form-control" value="@if(!empty($data->lastname)){{ $data->lastname }}@endif" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>email</label>
                            <input class="form-control" value="@if(!empty($data->email)){{ $data->email }}@endif" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เบอร์โทรศัพท์</label>
                            <input class="form-control" value="@if(!empty($data->tel)){{ $data->tel }}@endif" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ประเภท</label>
                            <select class="form-control" disabled>
                                <option value="1" @if(!empty($data->user_type)) @if($data->user_type == 1 ) selected @endif @endif>บุคคลธรรมดา</option>
                                <option value="2" @if(!empty($data->user_type)) @if($data->user_type == 2 ) selected @endif @endif>บริษัท/สำนักงาน/องค์กร</option>
                            </select>
                        </div>
                    </div>
                    @if(!empty($data->company_name))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>บริษัท </label>
                                <input  class="form-control" value="{{ $data->company_name }}" disabled>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>วัน/เดือน/ปีเกิด</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="hbd_day" name="hbd_day" data-placeholder="วันที่" class="form-control" disabled>
                                <option></option>
                                <option value="01" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '01') selected @endif @endif>01</option>
                                <option value="02" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '02') selected @endif @endif>02</option>
                                <option value="03" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '03') selected @endif @endif>03</option>
                                <option value="04" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '04') selected @endif @endif>04</option>
                                <option value="05" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '05') selected @endif @endif>05</option>
                                <option value="06" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '06') selected @endif @endif>06</option>
                                <option value="07" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '07') selected @endif @endif>07</option>
                                <option value="08" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '08') selected @endif @endif>08</option>
                                <option value="09" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '09') selected @endif @endif>09</option>
                                <option value="10" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '10') selected @endif @endif>10</option>
                                <option value="11" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '11') selected @endif @endif>11</option>
                                <option value="12" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '12') selected @endif @endif>12</option>
                                <option value="13" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '13') selected @endif @endif>13</option>
                                <option value="14" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '14') selected @endif @endif>14</option>
                                <option value="15" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '15') selected @endif @endif>15</option>
                                <option value="16" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '16') selected @endif @endif>16</option>
                                <option value="17" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '17') selected @endif @endif>17</option>
                                <option value="18" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '18') selected @endif @endif>18</option>
                                <option value="19" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '19') selected @endif @endif>19</option>
                                <option value="20" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '20') selected @endif @endif>20</option>
                                <option value="21" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '21') selected @endif @endif>21</option>
                                <option value="22" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '22') selected @endif @endif>22</option>
                                <option value="23" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '23') selected @endif @endif>23</option>
                                <option value="24" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '24') selected @endif @endif>24</option>
                                <option value="25" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '25') selected @endif @endif>25</option>
                                <option value="26" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '26') selected @endif @endif>26</option>
                                <option value="27" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '27') selected @endif @endif>27</option>
                                <option value="28" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '28') selected @endif @endif>28</option>
                                <option value="29" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '29') selected @endif @endif>29</option>
                                <option value="30" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '30') selected @endif @endif>30</option>
                                <option value="31" @if(!empty($data->hbd_day)) @if( $data->hbd_day == '31') selected @endif @endif>31</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="hbd_month" name="hbd_month" class="form-control" data-placeholder="เดือน" disabled>
                                <option></option>
                                @foreach ( $months as $month)
                                    <option value="{{ $month->month_no }}" @if(!empty($data->hbd_month)) @if($data->hbd_month == $month->month_no ) selected @endif @else @if(old('hbd_month') == $month->month_no ) selected @endif @endif>{{ $month->month_name_th  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="hbd_year" name="hbd_year"  data-placeholder="ปี พ.ศ." class="form-control" disabled>
                                <option></option>
                                @if(!empty($data->hbd_year))
                                    @php
                                        $firstYear = (int)date('Y')-80;
                                        $lastYear = date('Y')+543;
                                        for($i=$firstYear;$i<=$lastYear;$i++)
                                        {
                                            if($data->hbd_year == $i){
                                                $selectedYear = 'selected';
                                            }else{
                                                $selectedYear = ' ';
                                            }
                                            echo '<option '.$selectedYear.' value='.$i.' >'.($i).'</option>';
                                        }
                                    @endphp
                                @else
                                    @php
                                        $firstYear = (int)date('Y')-80;
                                        $lastYear = date('Y')+543;
                                        for($i=$firstYear;$i<=$lastYear;$i++)
                                        {
                                            echo '<option value='.$i.' >'.($i).'</option>';
                                        }
                                    @endphp
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <br/>
                        <div class="form-group">
                            <div class="form-check-radio display-inline-block">
                                <label class="form-check-label">
                                <input disabled class="form-check-input" type="radio" name="sex" id="sex1" value="1"  @if(!empty($data->sex)) @if($data->sex == 1) checked @endif @endif> ผู้ชาย
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                            <div class="form-check-radio display-inline-block">
                                <label class="form-check-label">
                                  <input disabled class="form-check-input" type="radio" name="sex" id="sex2" value="2" @if(!empty($data->sex)) @if($data->sex == 2) checked @endif @endif> ผู้หญิง
                                  <span class="form-check-sign"></span>
                                </label>
                            </div>
                            <div class="form-check-radio display-inline-block">
                                <label class="form-check-label">
                                  <input disabled class="form-check-input" type="radio" name="sex" id="sex3" value="3"  @if(!empty($data->sex)) @if($data->sex == 3) checked @endif @else checked @endif> ไม่ระบุ
                                  <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
              <h5>ที่อยู่สำหรับจัดส่งสินค้า</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ชื่อ <span class="text-danger">*</span></label>
                            <input id="name" name="name" type="text" class="form-control" placeholder="" value="@if(!empty($address->name)){{ $address->name }}@endif" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>สกุล <span class="text-danger">*</span></label>
                            <input id="lastname" name="lastname" type="text" class="form-control" value="@if(!empty($address->lastname)){{ $address->lastname }}@endif" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                            <input id="tel" name="tel" type="text" class="form-control" value="@if(!empty($address->tel)){{ $address->tel }}@endif" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>บ้านเลขที่ ถนน ซอย <span class="text-danger">*</span></label>
                            <textarea type="text" class="form-control" disabled >@if(!empty($address->address)){{ $address->address }}@endif</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>จังหวัด <span class="text-danger">*</span></label>
                            <select class="form-control" disabled>
                                @foreach ( $provinces as $province)
                                    <option value="{{ $province->id }}" @if(!empty($address->province)) @if($address->province == $province->id ) selected @endif @endif>{{ $province->prov_name_th  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เขต/อำเภอ <span class="text-danger">*</span></label>
                            <select class="form-control" disabled>
                                @foreach ( $amphures as $amphure)
                                    <option value="{{ $amphure->id }}" @if(!empty($address->amphures)) @if($address->amphures == $amphure->id ) selected @endif @endif>{{ $amphure->amp_name_th  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>แขวง / ตำบล <span class="text-danger">*</span></label>
                            <select id="district" name="district" data-placeholder="กรุณาเลือกแขวง / ตำบล" class="form-control" disabled>
                                @foreach ( $districts as $district)
                                    <option value="{{ $district->id }}" @if(!empty($address->district)) @if($address->district == $district->id ) selected @endif @endif>{{ $district->dis_name_th  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                            <input id="zipcode" name="zipcode" placeholder="กรุณากรอกรหัสไปรษณีย์" class="form-control" value="@if(!empty($address->zipcode)){{ $address->zipcode }}@endif" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ข้อความถึงผู้ขาย </label>
                            <textarea id="message" name="message" type="text" class="form-control" disabled >@if(!empty($address->message)){{ $address->message }}@endif</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="card">
            <div class="card-header">
                <h5 class="title">รายละเอียดเงื่อนไขข้อกำหนด</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <strong>สิ่งที่ผู้แนะนำจะได้รับ</strong>
                        <ul>
                            @if ($settingGetmember->getmember_ref_type == 2)
                                <li>คูปอง</li>
                            @else
                                <li>Cash Card</li>
                            @endif
                        </ul>
                        @if(!empty($settingGetmember->getmember_ref_detail))
                            <strong>รายละเอียดเพิ่มเติม :</strong>
                            <br/>
                            {{ $settingGetmember->getmember_ref_detail}}
                            <br/>
                            <br/>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                {{
                    Form::model($userGetmember, [
                        'novalidate',
                        'route' => ['getmember.update.status',[$userGetmember->id]],
                        'id'=>'customcode-form',
                        'method' => 'put',
                        'files' => true
                    ])
                }}
                    <p>อัพเดตสถานะการจัดส่งของขวัญ</p>
                    <select id="status" name="status" class="form-control">
                        <option value="1" @if($userGetmember->status == 1) selected @endif>จัดส่งของขวัญแล้ว</option>
                        <option value="2" @if($userGetmember->status == 2) selected @endif>ยังไม่มีการจัดส่งของขวัญ</option>
                    </select>
                    <br/>
                    <p>รายละเอียดเพิ่มเติม / Note.</p>
                    <textarea id="remark" name="remark" class="form-control"  >@if(!empty($userGetmember->remark)){{ $userGetmember->remark }}@endif</textarea>
                    <small>* หากมีการอัพเดตสถานะ ระบบจะส่งอีเมลไปยังลูกค้า เพื่อแจ้งว่าจะได้รับของขวัญตามเงื่อนไขที่กำหนดไว้</small>
                    <br/>

                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('getmember.index')}}">
                                @include('layouts.admin._button.back')
                            </a>
                        </div>
                        <div class="col-6 right">
                            @include('layouts.admin._button.submit')
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <p>ประวัติการอัพเดตข้อมูล</p>
                <hr/>
                <ul>
                    @foreach ($historys as $history)
                        <li>
                            <small>
                                {{$history->status}} @if(!empty($history->remark))({{$history->remark}})@endif<br/>
                                {{$history->created_by}} {{$history->created_at}}
                            </small>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>


    </div>
</div>

@endsection

@section('js')

<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

@endsection
