@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
<!-- select2 -->
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('user.dashboard') }}">
                <button class="btn">
                    รายงานข้อมูลผู้ใช้
                    <span class="btn-label btn-label-right ">
                      <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-mg">
            <div class="card ">
                <div class="card-header">
                    <h5 class="card-title">จำนวนสมาชิกจาก 5 ปีที่ผ่านมา</h5>
                    <p class="card-category">(จำนวนสมาชิกทั้งหมด {{ $memberTotal }} คน :: ไม่นับรวมพนักงาน)</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <canvas id="my_year"></canvas>
                    </div>
                </div>
            </div>
            <br/>

        </div>
        <div class="col-xl-3 col-lg-12 col-mg">
            <div class="card ">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>เดือน</th>
                                <th class="right" style="width: 10%">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td ><div id="display-01" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-01" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-02" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-02" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-03" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-03" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-04" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-04" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-05" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-05" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-06" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-06" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-07" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-07" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-08" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-08" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-09" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-09" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-10" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-10" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-11" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-11" style="margin-right: 5px"></div> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-12" class="display-inline"></div></td>
                                <td class="right display-inline"><div id="number-12" style="margin-right: 5px"></div> คน</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr/>
                    <div id="display-total"></div><br/>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-12 col-mg">
            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-4 col-md-3 col-mg">
                            @include('layouts.admin._button.reload')
                        </div>
                        <div class="col-xl-6 col-lg-8 col-md-9 col-mg">
                            <div class="form-group">
                                <div class="form-group">
                                    <select id="year" name="year" class="form-control" onchange="getYear(this)" data-link="{{ route('user.jsonaverage') }}">
                                        @php
                                            $firstYear = (int)date('Y')-2;
                                            $lastYear = date('Y');
                                            for($i=$firstYear;$i<=$lastYear;$i++)
                                            {
                                                if($i == $lastYear){ $select = 'selected';}else{ $select = '';}
                                                echo '<option value='.$i.' '.$select.'>ประจำปี '.($i).'</option>';
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card ">
                <div class="card-body">
                    <h5>จำนวนสมาชิกต่อเดือน</h5>
                    <hr/>
                    <div class="form-group">
                        <canvas id="my_month"></canvas>
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
    <script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('assets/backend/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/backend/demo/demo.js') }}"></script>
    @include('admin.user.report.Chart.averageYear')
    @include('admin.user.report.Chart.jsonaverage')
@endsection