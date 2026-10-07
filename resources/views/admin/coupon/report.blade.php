@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <br/>
                    <b>รายละเอียดคูปอง</b>
                    <hr/>
                    <div class="row">
                        <div class="col-12">
                            @isset($data->coupon_img)
                                <img id="blah1" src="{{ asset('storage/coupon/'.$data->coupon_img) }}" alt="" class="bottommargin-xs full-width-coupon" rel="nofollow">
                            @else
                                <img id="blah1" src="{{ asset('images/default-img/default-banner-900-1050.jpg')}}" alt="..." class="bottommargin-xs full-width-coupo" rel="nofollow">
                            @endisset
                        </div>
                        <div class="col-12">
                            <p>รหัสคูปอง : {{ $data->coupon_code }}</p>
                            <p>ชื่อคูปอง : {{ $data->coupon_name }}</p>
                            @if(!empty($data->coupon_date_exp))
                                <p>คูปองหมดอายุ : <span class="text-danger">{{ $data->coupon_date_exp }}</span></p>
                            @endif
                            @if(!empty($data->coupon_detail))
                                <p>* {{ $data->coupon_detail }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <h4 class="card-title transform-capitalize">{{ $data->coupon_name}} (<span id="countTotal">{{ $totalCoupon }}</span>)</h4>
                    <div class="row">
                        <div class="col-xl-6 col-lg-12 col-md-12 vertical-bottom">
                            <a href="{{ route('promotion.coupon.index')}}">
                                @include('layouts.admin._button.backMain')
                            </a>
                            @include('layouts.admin._button.reloadMain')
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6"></div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="form-group">
                                <select id="yearReportCoupon" name="yearReportCoupon" class="form-control" onchange="getCodeCount(this.value)">
                                    <option value="">-- เลือกปี --</option>
                                    @php
                                        $firstYear = (int)date('Y')-4;
                                        $lastYear = date('Y');
                                        for($i=$firstYear;$i<=$lastYear;$i++)
                                        {
                                            if(date('Y') == $i){ $selected = 'selected'; }else{ $selected = '';}

                                            echo '<option value="'.$i.'" '.$selected.' >'.($i).'</option>';
                                        }
                                    @endphp
                                </select>
                                <input type="hidden" name="coupon_code" id="coupon_code" value="{{ $data->coupon_code}}" />
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 60px; text-align:center">#</th>
                                <th>เดือน</th>
                                <th style="width: 150px; text-align:right">จำนวนการใช้งาน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($months as $month)
                                <tr>
                                    <td style="text-align:center">{{ $month->month_no }}</td>
                                    <td>{{ $month->month_name_th }}</td>
                                    <td style="text-align:right"><div id="use_{{ $month->month_no }}">0</div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
