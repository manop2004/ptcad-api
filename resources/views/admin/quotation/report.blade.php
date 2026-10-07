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
        <div class="col-lg-7 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-6 col-xs-12">
                    <a href="{{ route('quotation.report.product') }}">
                        <button class="btn">
                            รายงานสินค้าที่ถูกขอใบเสนอราคา
                            <span class="btn-label btn-label-right ">
                              <i class="nc-icon nc-minimal-right"></i>
                            </span>
                        </button>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-box text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">ครั้ง</p>
                                        <p class="card-title">{{ number_format($count) }}<p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="nc-icon nc-tv-2"></i> จำนวนการขอใบเสนอราคาทั้งหมดบน website
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-info">
                                        <i class="nc-icon nc-bullet-list-67 text-info"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">ครั้ง</p>
                                        <p class="card-title"><span id="year-totalMonth">{{ number_format($totalMonth) }}</span><p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="nc-icon nc-tv-2"></i> จำนวนการขอใบเสนอราคาทั้งหมดในเดือน
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-danger">
                                        <i class="nc-icon nc-email-85 text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">ครั้ง</p>
                                        <p class="card-title"><span id="year-contact">{{ number_format($contact) }}</span><p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="nc-icon nc-tv-2"></i> ขอใบเสนอราคาผ่านปุ่ม request a quote
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-paper text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">ครั้ง</p>
                                        <p class="card-title"><span id="year-dowload">{{ number_format($dowload) }}</span><p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="nc-icon nc-tv-2"></i> ดาวน์โหลดใบเสนอราคาผ่านหน้าสินค้า
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-xs-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-title">ประเภทของใบเสนอราคา</h5>
                    <p class="card-category">(คำนวณจากการขอใบเสนอราคาทั้งหมดในปี <span id="display-year-type"></span> <span id="display-total-type"></span> ครั้ง)</p>
                </div>
                <div class="card-body">
                    <input type="hidden"  class="form-control" id="Type1" name="Type1" value="{{ $Type1 }}">
                    <input type="hidden"  class="form-control" id="Type2" name="Type2" value="{{ $Type2 }}">

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row font-size-small mb-b-10">
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background : #058DC7"></div> บุคคลธรรมดา :&nbsp; <span id="display-type1"></span>&nbsp;ครั้ง</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background :#50B432"></div> บริษัท/สำนักงาน/องค์กร :&nbsp; <span id="display-type2"></span>&nbsp;ครั้ง</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <canvas id="groupType"></canvas>
                        </div>
                    </div>
                </div>
            </div>
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
                                <td class="right"><span id="number-01"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-02" class="display-inline"></div></td>
                                <td class="right"><span id="number-02"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-03" class="display-inline"></div></td>
                                <td class="right"><span id="number-03"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-04" class="display-inline"></div></td>
                                <td class="right"><span id="number-04"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-05" class="display-inline"></div></td>
                                <td class="right"><span id="number-05"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-06" class="display-inline"></div></td>
                                <td class="right"><span id="number-06"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-07" class="display-inline"></div></td>
                                <td class="right"><span id="number-07"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-08" class="display-inline"></div></td>
                                <td class="right"><span id="number-08"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-09" class="display-inline"></div></td>
                                <td class="right"><span id="number-09"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-10" class="display-inline"></div></td>
                                <td class="right"><span id="number-10"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-11" class="display-inline"></div></td>
                                <td class="right"><span id="number-11"></span> คน</td>
                            </tr>
                            <tr>
                                <td ><div id="display-12" class="display-inline"></div></td>
                                <td class="right"><span id="number-12"></span> คน</td>
                            </tr>
                        </tbody>
                    </table>
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
							<div class="form-group d-flex flex-row align-items-center">
								<!-- Filter เดือน -->
								@php
									$thaiMonths = [
										'01' => 'มกราคม',
										'02' => 'กุมภาพันธ์',
										'03' => 'มีนาคม',
										'04' => 'เมษายน',
										'05' => 'พฤษภาคม',
										'06' => 'มิถุนายน',
										'07' => 'กรกฎาคม',
										'08' => 'สิงหาคม',
										'09' => 'กันยายน',
										'10' => 'ตุลาคม',
										'11' => 'พฤศจิกายน',
										'12' => 'ธันวาคม'
									];
								@endphp
								<select id="month" name="month" class="form-control mr-2" style="max-width:100px;" onchange="getYearQuotation(this)" data-link="{{ route('quotation.jsonaverage') }}">
									<option value="">ทุกเดือน</option>
									@foreach($thaiMonths as $num => $txt)
										<option value="{{ $num }}">{{ $txt }}</option>
									@endforeach
								</select>

								<!-- Filter ปี -->
								<select id="year" name="year" class="form-control" onchange="getYearQuotation(this)" data-link="{{ route('quotation.jsonaverage') }}">
									@php
										$firstYear = (int)date('Y')-4;
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
            <div class="card ">
                <div class="card-body">
                    <h5>(จำนวนการขอใบเสนอราคาทั้งหมดในปี <span id="display-year"></span> <span id="display-total"></span> ครั้ง)</h5>
                    <hr/>
                    <div class="form-group">
                        <div id="chart-wrapper" style="height: 350px; width: 100%;">
							<canvas id="my_month" height="350"></canvas>
						</div>
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
    @include('admin.quotation.Chart.jsonaverage')
    @include('admin.quotation.Chart.groupType')
@endsection