@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <link href="{{ asset('assets/backend/css/paper-dashboard.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

 <style>
    .card-user .image { height: 80px; }
 </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(empty($data))
            {{
                Form::open([
                    'novalidate',
                    'route' => 'user.crate',
                    'id'=>'data-form',
                    'method' => 'post',
                    'files' => true
                ])
            }}
        @else

            @if($UserLevel->l_user_Action == 1)
                {{
                    Form::model($data, [
                        'novalidate',
                        'route' => ['user.update',[$data->id]],
                        'id'=>'data-form',
                        'method' => 'put',
                        'files' => true
                    ])
                }}
            @else
                {{
                    Form::model($data, [
                        'novalidate',
                        'route' => ['user.staff.update',[$data->id]],
                        'id'=>'data-form',
                        'method' => 'put',
                        'files' => true
                    ])
                }}
            @endif
        @endif


            <div class="row">
                <div class="col-md-4">
                    <div class="card card-user card-wizard active">
                        <div class="image"></div>
                        <div class="card-body">
                            <div class="author">
                                <div class="picture-container">
                                    <div class="picture">
                                        @isset($data->img)
                                            <input type="hidden" class="form-control" id="img_old" name="img_old" value="{{ $data->img }}">
                                            <img class="picture-src" src="{{ asset('storage/avatar/'.$data->img) }}" alt="..." id="wizardPicturePreview"  />
                                        @else
                                            <img class="picture-src" src="{{ asset('images/default-img/default-avatar.png') }}" alt="..." id="wizardPicturePreview"  />
                                        @endisset
                                        <input accept="image/*" type="file" name="img" id="wizard-picture" value=""  />
                                    </div>
                                </div>
                                <a href="#" style="text-decoration: none">
                                    <h5 class="title">
                                        @if(!empty($data->displayname)){{ $data->displayname }} @else ชื่อที่จะแสดง @endif
                                    </h5>
                                </a>
                            </div>
                        </div>
                        <div class="card-footer">
                            <hr>
                            <div class="button-container">
                            <div class="row">
                                <div class="@if(!empty($data)) col-lg-4 @else col-lg-12 @endif ml-auto">
                                @if(!empty($data)) 
                                    @if($data->level != 6 )
                                        <h5>@if(!empty($articleCount)){{ number_format($articleCount) }}@else 0 @endif
                                            <br>
                                            <small>บทความ</small>
                                        </h5>
                                    @else
                                        <h5>@if(!empty($articleCount)){{ number_format($articleCount) }}@else 0 @endif
                                            <br>
                                            <small>คำสั่งซื้อ</small>
                                        </h5>
                                    @endif
                                @endif
                                </div>

                                @if(!empty($data))
                                    @if($UserLevel->l_user_Action == 1)
                                        <div class="col-lg-4 ml-auto">
                                            <h5>
                                                <i class="nc-icon nc-lock-circle-open"></i>
                                                <br>
                                                <a href="{{ route('user.changpassword', ['id'=> $data->id]) }}" style="text-decoration: none">
                                                    <small>รหัสผ่าน</small>
                                                </a>
                                            </h5>
                                        </div>
                                        <div class="col-lg-4 ml-auto">
                                            <h5 >
                                                <i class="nc-icon nc-settings-gear-65"></i>
                                                <br>
                                                <a style="text-decoration: none" href="{{ route('user.level',['id'=>$data->id]) }}">
                                                    <small>สิทธิ์ใช้งาน</small>
                                                </a>
                                            </h5>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($data))
                        @if($UserLevel->l_user_Action == 1)
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-full-width table-responsive">
                                        <table class="table nomargin">
                                            <tbody>
                                                <tr>
                                                    <td class="text-left noborder">ข้อมูลส่วนตัว</td>
                                                    <td class="td-actions text-right noborder">
                                                        <a href="{{ route('user.edit',$data->id) }}">
                                                            <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="อัพเดตข้อมูล">
                                                            <i class="nc-icon nc-ruler-pencil"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">ที่อยู่สำหรับจัดส่งสินค้า</td>
                                                    <td class="td-actions text-right">
                                                        <a href="{{ route('user.address',$data->id) }}">
                                                            <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="อัพเดตข้อมูล">
                                                            <i class="nc-icon nc-ruler-pencil"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">ที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน</td>
                                                    <td class="td-actions text-right">
                                                        <a href="{{ route('user.receipt',$data->id) }}">
                                                            <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="อัพเดตข้อมูล">
                                                            <i class="nc-icon nc-ruler-pencil"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if($history_penname != 0 and !empty($data))
                    <div class="card">
                        <div class="card-body">
                            <div class="title">ประวัติการเปลี่ยน "นามปากกา"</div>
                            <hr/>
                            <table id="datatable" class="table table-striped table-bordered" data-href="{{ route('user.json.penname',$data->id)}}" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th style="width: 15px" class="disabled-sorting">#</th>
                                    <th style="width: 200px" class="disabled-sorting">นามปากกาเดิม</th>
                                    <th style="width: 120px" class="disabled-sorting text-right">บทความ</th>
                                  </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">ข้อมูลผู้ใช้</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>สิทธิ์การใช้งาน</label>
                                        <select id="level" name="level" type="text" class="form-control" @if($UserLevel->l_user_Action == 2) disabled @endif>
                                            @foreach ( $levels as $level)
                                                <option value="{{ $level->id }}" @if(!empty($data->level)) @if($data->level == $level->id ) selected @endif @else @if(old('level') == $level->id ) selected @endif @endif>{{ $level->name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($data->user_code_friend))
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>รหัสผู้ใช้ที่แนะนำสมาชิก <span class="text-danger">*</span></label>
                                        <input type="text"class="form-control" @if(!empty($data)) disabled @endif value="{{ $data->user_code_friend }}">
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>รหัสผู้ใช้ <span class="text-danger">*</span></label>
                                        <input type="text"class="form-control" @if(!empty($data)) disabled @endif value="@if(!empty($data->user_code)){{ $data->user_code }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>พนักงานที่รับผิดชอบ</label>
                                    <select id="staffId" name="staffId" class="form-control">
                                        <option value="">--เลือกข้อมูล--</option>
                                        @foreach ($users as $user )
                                            <option value="{{ $user->id }}" @if(!empty($data->staffId)) @if($user->id == $data->staffId) selected @endif @endif>{{ $user->name }} {{ $user->lastname }}</option>
                                        @endforeach
                                    </select>
                                    @error('staffId')<small class="error-danger-text">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ชื่อที่จะแสดง <span class="text-danger">*</span></label>
                                        <input @if($UserLevel->l_user_Action == 2) disabled @endif id="displayname" name="displayname" type="text" class="form-control" placeholder="" value="@if(!empty($data->displayname)){{ $data->displayname }}@else{{ old('displayname') }}@endif">
                                        <input id="displayname_old" name="displayname_old" type="hidden" value="@if(!empty($data->displayname)){{ $data->displayname }}@else{{ old('displayname') }}@endif">
                                        @error('displayname')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>email <span class="text-danger">*</span></label>
                                        <input @if($UserLevel->l_user_Action == 2) disabled @endif id="email" name="email" type="email" class="form-control" placeholder="email@yourname.com" value="@if(!empty($data->email)){{ $data->email }}@else{{ old('email') }}@endif">
                                        @error('email')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            @if(empty($data))
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>รหัสผ่าน <span class="text-danger">*</span></label>
                                            <input @if($UserLevel->l_user_Action == 2) disabled @endif id="password" name="password" type="text" class="form-control" placeholder="" value="{{ old('password') }}">
                                            @error('password')<small class="error-danger-text">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>สุ่มรหัสผ่าน</label>
                                            <input onclick="generateCodeCoupon()" type="button" class="btn btn-primary input-btn"  value="Gen password">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ชื่อ <span class="text-danger">*</span></label>
                                        <input @if($UserLevel->l_user_Action == 2) disabled @endif id="name" name="name" type="text" class="form-control" placeholder="" value="@if(!empty($data->name)){{ $data->name }}@else{{ old('name') }}@endif">
                                        @error('name')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>นามสกุล <span class="text-danger">*</span></label>
                                        <input @if($UserLevel->l_user_Action == 2) disabled @endif id="lastname" name="lastname" type="text" class="form-control" placeholder="" value="@if(!empty($data->lastname)){{ $data->lastname }}@else{{ old('lastname') }}@endif">
                                        @error('lastname')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์</label>
                                        <input @if($UserLevel->l_user_Action == 2) disabled @endif id="tel" name="tel" type="text" class="form-control" placeholder="" value="@if(!empty($data->tel)){{ $data->tel }}@else{{ old('tel') }}@endif">
                                        @error('tel')<small class="error-danger-text">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ประเภท</label>
                                        <select id="user_type" name="user_type" type="text" class="form-control" @if($UserLevel->l_user_Action == 2) disabled @endif>
                                            <option value="1" @if(!empty($data->user_type)) @if($data->user_type == 1 ) selected @endif @else @if(old('user_type') == 1 ) selected @endif @endif>บุคคลธรรมดา</option>
                                            <option value="2" @if(!empty($data->user_type)) @if($data->user_type == 2 ) selected @endif @else @if(old('user_type') == 2 ) selected @endif @endif>บริษัท/สำนักงาน/องค์กร</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>วัน/เดือน/ปีเกิด</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="hbd_day" name="hbd_day" data-placeholder="วันที่" class="form-control" @if($UserLevel->l_user_Action == 2) disabled @endif>
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
                                        <select id="hbd_month" name="hbd_month" class="form-control" data-placeholder="เดือน" @if($UserLevel->l_user_Action == 2) disabled @endif>
                                            <option></option>
                                            @foreach ( $months as $month)
                                                <option value="{{ $month->month_no }}" @if(!empty($data->hbd_month)) @if($data->hbd_month == $month->month_no ) selected @endif @else @if(old('hbd_month') == $month->month_no ) selected @endif @endif>{{ $month->month_name_th  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="hbd_year" name="hbd_year"  data-placeholder="ปี พ.ศ." class="form-control" @if($UserLevel->l_user_Action == 2) disabled @endif>
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
                                            <input @if($UserLevel->l_user_Action == 2) disabled @endif class="form-check-input" type="radio" name="sex" id="sex1" value="1"  @if(!empty($data->sex)) @if($data->sex == 1) checked @endif @endif> ผู้ชาย
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-radio display-inline-block">
                                            <label class="form-check-label">
                                              <input @if($UserLevel->l_user_Action == 2) disabled @endif class="form-check-input" type="radio" name="sex" id="sex2" value="2" @if(!empty($data->sex)) @if($data->sex == 2) checked @endif @endif> ผู้หญิง
                                              <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-radio display-inline-block">
                                            <label class="form-check-label">
                                              <input @if($UserLevel->l_user_Action == 2) disabled @endif class="form-check-input" type="radio" name="sex" id="sex3" value="3"  @if(!empty($data->sex)) @if($data->sex == 3) checked @endif @else checked @endif> ไม่ระบุ
                                              <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($data->lastlogin))
                                <label>เข้าใช้งานล่าสุด :: {{ $data->lastlogin }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check">
                                <label class="form-check-label">
                                  <input @if($UserLevel->l_user_Action == 2) disabled @endif class="form-check-input" type="checkbox" name="pdpa_news" id="pdpa_news" value="1" @if(!empty($data->pdpa_news)) @if($data->pdpa_news == 1) checked @endif @endif >
                                  <span class="form-check-sign"></span>
                                  รับข้อมูลข่าวสารและประชาสัมพันธ์ทางอีเมล
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                  <input @if($UserLevel->l_user_Action == 2) disabled @endif class="form-check-input" type="checkbox" name="pdpa_article" id="pdpa_article" value="1" @if(!empty($data->pdpa_article)) @if($data->pdpa_article == 1) checked @endif @endif>
                                  <span class="form-check-sign"></span>
                                  รับข้อมูลบทความ สาระความรู้จากเราทางอีเมล
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                  <input @if($UserLevel->l_user_Action == 2) disabled @endif class="form-check-input" type="checkbox" name="pdpa_product" id="pdpa_product" value="1" @if(!empty($data->pdpa_product)) @if($data->pdpa_product == 1) checked @endif @endif>
                                  <span class="form-check-sign"></span>
                                  รับข้อมูลข่าวสารผลิตภัณฑ์ที่เกี่ยวข้องของบริษัท
                                </label>
                            </div>
                        </div>
                    </div>

                    @if(!empty($data->update_by))
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group has-label">
                                <label>อัพเดตข้อมูลโดย :: {{ $data->update_by}} :: {{ $data->updated_at}} </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('user.index')}}">
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
            </div>

        </form>
    </div>
</div>

@endsection

@section('js')

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>

<!-- select2 -->
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<!-- select2-bootstrap4-theme -->
<script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

<script>
    function generateCodeCoupon(length = 8) {
        var result           = [];
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
        result.push(characters.charAt(Math.floor(Math.random() * charactersLength)));
        }

        $("#password").val(result.join(''));

    }
</script>

<script>
    $(document).ready(function () {

        $('#datatable').DataTable({
            autoWidth: false,
            lengthChange: false,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            paging: true,
            pageLength: 10,
            searching: false,
            language: {
                search: 'ค้นหา',
                processing: '<i class="fa fa-spinner fa-spin fa-lg"></i><span class="ml-2">กำลังโหลดข้อมูล...</span> ',
                info: "แสดง หน้า _PAGE_ จาก _PAGES_",
                infoEmpty: "",
                zeroRecords: "ไม่พบข้อมูล",
                infoFiltered: "(ค้นหา จาก _MAX_ รายการ)",
                paginate: {
                    first: 'หน้าแรก',
                    last: 'หน้าสุดท้าย',
                    next: 'ต่อไป',
                    previous: 'ก่อนหน้า'
                },
            },
            ajax: {
                url: $('#datatable').attr('data-href'),
            },
            columnDefs: [
                {
                    'targets': [0],
                    'className': 'text-center',
                },
                {
                    'targets': [2],
                    'className': 'text-right',
                },
            ],
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'author_old'},
                {data: 'count'},
            ]
        });
    });

</script>

@endsection
