@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

@endsection

@section('content')

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('user.average') }}">
                <button class="btn">
                    รายงานอัตราการเติบโตของสมาชิก
                    <span class="btn-label btn-label-right ">
                      <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-vector text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">คน</p>
                                <p class="card-title">{{ number_format($userTotal) }}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="nc-icon nc-tv-2"></i> จำนวนสมาชิกทั้งหมด
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-single-02 text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">คน</p>
                                <p class="card-title">{{ number_format($personTotal) }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="nc-icon nc-tv-2"></i> บุคคลธรรมดา
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-istanbul text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">คน</p>
                                <p class="card-title">{{ number_format($companyTotal) }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="nc-icon nc-tv-2"></i> บริษัท/สำนักงาน/องค์กร
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="nc-icon nc-badge text-primary"></i>
                        </div>
                        </div>
                        <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">คน</p>
                            <p class="card-title">{{ number_format($staffTotal) }}
                            <p>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="nc-icon nc-tv-2"></i> พนักงาน
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-title">จำแนกตามภูมิภาค</h5>
                    <p class="card-category">(คิดเป็นเปอร์เซ็นต์จากจำนวนทั้งหมด {{ $memberTotal }} คน :: ไม่นับรวมพนักงาน)</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-8">
                            <canvas id="chartStock"></canvas>
                        </div>
                        <div class="col-xl-4">
                            @php
                                $North = number_format(($geographiesNorth * 100)/$memberTotal,2);
                                $Central = number_format(($geographiesCentral * 100)/$memberTotal,2);
                                $Northeast = number_format(($geographiesNortheast * 100)/$memberTotal,2);
                                $Western = number_format(($geographiesWestern * 100)/$memberTotal,2);
                                $Eastern = number_format(($geographiesEastern * 100)/$memberTotal,2);
                                $South = number_format(($geographiesSouth * 100)/$memberTotal,2);
                            @endphp
                            <input type="hidden"  class="form-control" id="North" name="North" value="{{ $North }}">
                            <input type="hidden"  class="form-control" id="Central" name="Central" value="{{ $Central }}">
                            <input type="hidden"  class="form-control" id="Northeast" name="Northeast" value="{{ $Northeast }}">
                            <input type="hidden"  class="form-control" id="Western" name="Western" value="{{ $Western }}">
                            <input type="hidden"  class="form-control" id="Eastern" name="Eastern" value="{{ $Eastern }}">
                            <input type="hidden"  class="form-control" id="South" name="South" value="{{ $South }}">
                            <div class="row font-size-small">
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background : #48dbfb"></div> ภาคเหนือ : {{ $North }} %</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background :#feca57"></div> ภาคตะวันออก : {{ $Eastern }} %</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background :#B53471"></div> ภาคตะวันออกเฉียงเหนือ : {{ $Northeast }} %</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background :#c8d6e5"></div> ภาคกลาง : {{ $Central }} %</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background :#a55eea"></div> ภาคตะวันตก : {{ $Western }} %</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background :#50B432"></div> ภาคใต้ : {{ $South }} %</div>
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-title">จำแนกสมาชิกตามเพศ</h5>
                    <p class="card-category">(คิดเป็นเปอร์เซ็นต์จากจำนวนทั้งหมด {{ $memberTotal }} คน :: ไม่นับรวมพนักงาน)</p>
                </div>
                <div class="card-body">
                    @php
                        $male = number_format(($userGender1 * 100)/$memberTotal,2);
                        $female = number_format(($userGender2 * 100)/$memberTotal,2);
                        $alternativeSex = number_format(($userGender3 * 100)/$memberTotal,2);
                    @endphp
                    <input type="hidden"  class="form-control" id="male" name="male" value="{{ $male }}">
                    <input type="hidden"  class="form-control" id="female" name="female" value="{{ $female }}">
                    <input type="hidden"  class="form-control" id="alternativeSex" name="alternativeSex" value="{{ $alternativeSex }}">

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row font-size-small mb-b-10">
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background : #058DC7"></div> ชาย : {{ $male }} %</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background :#50B432"></div> หญิง : {{ $female}} %</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="display-inline"><div class="wh-15" style="background :#B53471"></div> ไม่ระบุ : {{ $alternativeSex}} %</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <canvas id="memberSex"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-5">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-title">10 อันดับ จังหวัดที่มีสมาชิกอยู่มากที่สุด</h5>
                    <p class="card-category">(นับจากจำนวนสมาชิกที่ทำการลงทะเบียน {{ $memberAddressTotal }} คน :: ไม่นับรวมพนักงาน)</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable dtr-inline" id="tableProvince" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>จังหวัด</th>
                                <th>จำนวน/คน</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="card card-chart">
                <div class="card-body">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                        <ul id="tabs" class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-business" role="tab" aria-expanded="true">ประเภทธุรกิจ</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-position" role="tab" aria-expanded="false">ตำแหน่ง/อาชีพ</a>
                            </li>
                        </ul>
                        </div>
                    </div>
                    <div id="my-tab-content" class="tab-content">
                        <div class="tab-pane active" id="tab-business" role="tabpanel" aria-expanded="true">
                            <h5 class="card-title">จำแนกตามประเภทธุรกิจ</h5>
                            <p class="card-category">(คำนวณจากจำนวนรวมของแต่ละประเภท ที่มีการลงทะเบียนไว้)</p>
                            <br/>
                            <div class="row">
                                <div class="col-xl-12">
                                    <canvas id="business"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-position" role="tabpanel" aria-expanded="false">
                            <h5 class="card-title">จำแนกตามตำแหน่ง/อาชีพ</h5>
                            <p class="card-category">(คำนวณจากจำนวนรวมของแต่ละตำแหน่ง/อาชีพ ที่มีการลงทะเบียนไว้)</p>
                            <br/>
                            <div class="row">
                                <div class="col-xl-12">
                                    <canvas id="position"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('assets/backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/dataTables.buttons.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('assets/backend/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/backend/demo/demo.js') }}"></script>
    @include('admin.user.report.Chart.geographie')
    @include('admin.user.report.Chart.memberSex')
    @include('admin.user.report.Chart.province')
    @include('admin.user.report.Chart.business')
    @include('admin.user.report.Chart.position')
@endsection