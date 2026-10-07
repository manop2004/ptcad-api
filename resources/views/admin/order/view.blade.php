@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
 </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="b_order">
                    <div class="right">
                        <span class="badge badge-pill" style="background: {{ $data->tb_setting_payment_status->status_color}}">{{ $data->tb_setting_payment_status->status_name}}</span>
                        <div>หมายเลขคำสั่งซื้อ :: {{ $data->orderNumber }}</div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ที่อยู่ในการจัดส่งสินค้า</strong><br/><br/>
                            @if(!empty($data->residence_name) && $data->residence_lastname){{ $data->residence_name }} {{ $data->residence_lastname }}@endif
                            @if(!empty($data->residence_tel))<br/>Tel. {{ $data->residence_tel }}@endif
                            @if(!empty($data->residence_address))<br/>{{ $data->residence_address }}<br/>@endif
                            @if(!empty($data->residence_district)){{ $data->tb_setting_district->dis_name_th }} @endif
                            @if(!empty($data->residence_amphures)){{ $data->tb_setting_amphure->amp_name_th }} @endif
                            @if(!empty($data->residence_province)){{ $data->tb_setting_province->prov_name_th }} @endif
                            @if(!empty($data->residence_zipcode)){{ $data->tb_setting_district->dis_code }}@endif
                            @if(!empty($data->residence_massage))<br/>Note. {{ $data->residence_massage }}@endif
                        </div>
                        @if($data->statusReceipts == 1)
                        <div class="col-md-6">
                            <strong>ที่อยู่ในการจัดส่งใบเสร็จรับเงิน</strong><br/><br/>
                            @if(!empty($data->receipt_tax))Tax. {{ $data->receipt_tax }}@endif
                            @if(!empty($data->receipt_company))<br/>บริษัท {{ $data->receipt_company }}@endif
                            @if(!empty($data->receipt_branch))<br/>สาขา {{ $data->receipt_branch }}@endif
                            @if(!empty($data->receipt_name) && $data->receipt_lastname)<br/>{{ $data->receipt_name }} {{ $data->receipt_lastname }}@endif
                            @if(!empty($data->receipt_tel))<br/>Tel. {{ $data->receipt_tel }}@endif
                            @if(!empty($data->receipt_address))<br/>{{ $data->receipt_address }}<br/>@endif
                            @if(!empty($data->receipt_district)){{ $data->tb_receipt_district->dis_name_th }} @endif
                            @if(!empty($data->receipt_amphures)){{ $data->tb_receipt_amphures->amp_name_th }} @endif
                            @if(!empty($data->receipt_province)){{ $data->tb_receipt_province->prov_name_th }} @endif
                            @if(!empty($data->receipt_zipcode)){{ $data->tb_receipt_district->dis_code }}@endif
							
							<br>
							@if(!empty($usersOrder->email))<br/>Email: <strong>{{ $usersOrder->email }}</strong>@endif
                        </div>
                        @endif
                    </div>
                    <hr/>
                    <br/>
                    @foreach ($data->tb_order_details as $detail)
                        <div class="b-order-detail">
                            <div class="row ">
                                <div class="col-md-2"><img src="{{ $detail->product_img }}" class="order-img-xs" /></div>
                                <div class="col-md-6">
                                    <small>SKU : {{ $detail->product_sku }}</small><br/>
									@if (!empty($detail->vendor_sku))
                                    <strong class="text-danger">Vendor SKU : {{ $detail->vendor_sku }}</strong><br/>
									@endif
                                    @if (!empty($detail->product_detail))
                                        @if ($detail->product_detail != 'null')
                                            {{ $detail->product_detail }}<br/>
                                        @else
                                            {{ $detail->product_name }}<br/>
                                        @endif
                                    @else
                                        {{ $detail->product_name }}<br/>
                                    @endif
                                    <small>X{{ $detail->product_unit}}</small>
									
									@if (!empty($detail->ref))
                                        <br/><small>Ref : <span class="badge badge-pill" style="background: #8AF0B7;">{{ $detail->ref }}</span></small>
                                    @endif
									
                                </div>
                                <div class="col-md-4 right cart-product-price">
                                    @if (!empty($detail->product_price_sale))
                                        <span class="amount-sale">{{ number_format($detail->product_price_sale) }}</span> {{ number_format($detail->product_price,2) }}
                                    @else
                                        {{ number_format($detail->product_price,2) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <br/>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">
                            ช่องทางการชำระเงิน : 
                            @if ($data->payment_type == 1)
                                โอนผ่านบัญชีธนาคาร
                            @elseif($data->payment_type == 2)
                                ผ่อนชำระ
							@elseif($data->payment_type == 3)
                                บัตรเครดิต
							@elseif($data->payment_type == 4)
                                พร้อมเพย์
							@elseif($data->payment_type == 5)
                                โมบายแบงก์กิ้ง
							@elseif($data->payment_type == 6)
                                ทรูมันนี่ วอลเล็ท
                            @else
                                บัตรเครดิต
                            @endif

                            @if(!empty($data->payment_massage))
                                <br/>
                                <br/>
                                <small><strong>รายละเอียดการชำระเงิน</strong></small><br/>
                                <small>{!! $data->payment_massage !!}</small>
                            @endif
                            @if(count($data->tb_order_payments) != 0)
                                @foreach ( $data->tb_order_payments as $payment)
                                    <br/>
                                    <a href="{{ asset('storage/orderSlip/'.$payment->payment_slip) }}" target="_bank"><small>สลิปการชำระเงิน</small></a>
                                @endforeach
                            @endif
                            @if (!empty($data->installmentType))
                                <br/>
                                @if ($data->installmentType == 'installment_bay' || $data->installmentType == 'mobile_banking_bay')
                                    <small>ธนาคารกรุงศรี</small>
                                @elseif ($data->installmentType == 'installment_bbl' || $data->installmentType == 'mobile_banking_bbl')
                                    <small>ธนาคารกรุงเทพ</small>
                                @elseif ($data->installmentType == 'installment_first_choice')
                                    <small>กรุงศรีเฟิร์สช้อยส์</small>
                                @elseif ($data->installmentType == 'installment_kbank' || $data->installmentType == 'mobile_banking_kbank')
                                    <small>ธนาคารกสิกร</small>
                                @elseif ($data->installmentType == 'installment_ktc' || $data->installmentType == 'mobile_banking_ktc')
                                    <small>ธนาคารกรุงไทย</small>
                                @elseif ($data->installmentType == 'installment_scb' || $data->installmentType == 'mobile_banking_scb')
                                    <small>ธนาคารไทยพาณิชย์</small>
                                @endif
                            @endif
                            @if(!empty($data->installmentTerm))
                            <small>/ {{ $data->installmentTerm }} เดือน</small>
                            @endif

                        </div>
                        <div class="col-md-6">
                            @if(!empty($data->subtotal))
                                <div class="row noleftmargin norightmargin bg_eee border-bottom">
                                    <div class="col-8 right padding-10">รวม</div>
                                    <div class="col-4 right padding-10">
                                        {{ number_format($data->subtotal,2) }}
                                    </div>
                                </div>
                            @endif
                            @if(!empty($data->conditionValue))
                                <div class="row noleftmargin norightmargin border-bottom">
                                    <div class="col-8 right padding-10"><strong>ส่วนลดรวม <br/><span class="co-f1c40f">{{ $data->conditionName }}</span></strong></div>
                                    <div class="col-4 right padding-10">
                                        @if ($data->conditionType == 1)
                                            <span class="amount-condition">{{ number_format($data->conditionValue,2) }}</span>
                                        @else
                                            <span class="amount-condition">{{ $data->conditionValue }}%</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if(!empty($data->totaldiscount))
                                @if(!empty($data->conditionValue) || $data->priceVAT != 0)
                                    <div class="row noleftmargin norightmargin border-bottom">
                                        <div class="col-8 right padding-10"><strong>ราคาสุทธิสินค้า</strong></div>
                                        <div class="col-4 right padding-10">
                                            <span id="sumTotal_n" class="amount">{{ number_format($data->totaldiscount,2) }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if(!empty($data->priceVAT))
                                @if($data->priceVAT != 0)
                                    <div class="row noleftmargin norightmargin border-bottom">
                                        <div class="col-8 right padding-10"><strong>ภาษีมูลค่าเพิ่ม</strong></div>
                                        <div class="col-4 right padding-10">
                                            <span id="cartVat" class="amount">{{ number_format($data->priceVAT,2) }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if(!empty($data->priceNettotal))
                                <div class="row noleftmargin norightmargin border-bottom">
                                    <div class="col-8 right padding-10"><strong>ยอดรวมสุทธิ</strong></div>
                                    <div class="col-4 right padding-10">
                                        <span id="cartNettotal" class="amount">{{ number_format($data->priceNettotal,2) }}</span>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($data->priceWithholding))
                                <div class="row noleftmargin norightmargin border-bottom">
                                    <div class="col-8 right padding-10"><strong>หัก ภาษี ณ ที่จ่าย</strong></div>
                                    <div class="col-4 right padding-10">
                                        <span id="cartWithholding" class="amount">{{ number_format($data->priceWithholding,2) }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="row noleftmargin norightmargin border-bottom">
                                <div class="col-8 right padding-10"><strong>การจัดส่ง</strong></div>
                                <div class="col-4 right padding-10">
                                    <span class="amount">จัดส่งฟรี</span>
                                </div>
                            </div>
                            <div class="row noleftmargin norightmargin bg_eee border-bottom">
                                <div class="col-8 right padding-10"><strong>จำนวนเงินที่ต้องชำระ</strong></div>
                                <div class="col-4 right padding-10">
                                    <span id="totalCart" class="amount color lead"><strong>{{ number_format($data->totalCart,2) }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('order.index')}}">
                                @include('layouts.admin._button.back')
                            </a>
                        </div>
                        <div class="col-md-8 right">
                            @include('layouts.admin._button.reloadForm')
                            <a href="{{ route('order.pdf',$data->id) }}">@include('layouts.admin._button.dowloadPDF')</a>
                        </div>
                    </div>
                </div>
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
                                {{$history->order_status}} @if(!empty($history->order_message))({{$history->order_message}})@endif<br/>
                                {{$history->updated_by}} {{$history->updated_at}}
                            </small>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="card">
            <div class="card-body">
                {{
                    Form::model($data, [
                        'novalidate',
                        'route' => ['order.update.staff.remark',[$data->id]],
                        'id'=>'customcode-form',
                        'method' => 'put',
                        'files' => true
                    ])
                }}
                    <p>เพิ่มเติม / Note.</p>
                    <textarea rows="3" style="padding: 10px;" name="staff_remark" id="staff_remark" class="form-control" >@if(!empty($data->staff_remark)){{ $data->staff_remark }}@endif</textarea>
                    <div class="right">
                        @include('layouts.admin._button.submit')
                    </div>
                </form>
            </div>
        </div>

        @if(empty($data->staffOf))
            <div class="card">
                <div class="card-body">
                    {{
                        Form::model($data, [
                            'novalidate',
                            'route' => ['order.update.staff',[$data->id]],
                            'id'=>'customcode-form',
                            'method' => 'put',
                            'files' => true
                        ])
                    }}
                        <p>พนักงานที่รับผิดชอบ</p>
                        <select id="staff" name="staff" class="form-control">
                            <option value="">--เลือกข้อมูล--</option>
                            @foreach ($users as $user )
                                <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastname }}</option>
                            @endforeach
                        </select>
                        @error('staff')<small class="error-danger-text">{{ $message }}</small> @enderror
                        <div class="right">
                            @include('layouts.admin._button.submit')
                        </div>
                    </form>
                </div>
            </div>
        @else

            @if (Auth::user()->level == 1 ||  Auth::user()->level == 3 ||  Auth::user()->level == 7)
                <div class="card">
                    <div class="card-body">
                        {{
                            Form::model($data, [
                                'novalidate',
                                'route' => ['order.update.staff',[$data->id]],
                                'id'=>'customcode-form',
                                'method' => 'put',
                                'files' => true
                            ])
                        }}
                            <p>พนักงานที่รับผิดชอบ</p>
                            <select id="staff" name="staff" class="form-control">
                                <option value="">--เลือกข้อมูล--</option>
                                @foreach ($users as $user )
                                    <option value="{{ $user->id }}" @if($user->id == $data->staffOf) selected @endif>{{ $user->name }} {{ $user->lastname }}</option>
                                @endforeach
                            </select>
                            @error('staff')<small class="error-danger-text">{{ $message }}</small> @enderror
                            <div class="right">
                                @include('layouts.admin._button.submit')
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <p>พนักงานที่รับผิดชอบ</p>
                        <select id="staff" name="staff" class="form-control" disabled>
                            <option value="">--เลือกข้อมูล--</option>
                            @foreach ($users as $user )
                                <option value="{{ $user->id }}" @if($user->id == $data->staffOf) selected @endif>{{ $user->name }} {{ $user->lastname }}</option>
                            @endforeach
                        </select>
                        @error('staff')<small class="error-danger-text">{{ $message }}</small> @enderror
                        <br/>
                    </div>
                </div>

            @endif
        @endif

        @if($data->payment_status == 1)
            <div class="card">
                <div class="card-body">
                    {{
                        Form::model($data, [
                            'novalidate',
                            'route' => ['order.update.status',[$data->id]],
                            'id'=>'customcode-form',
                            'method' => 'put',
                            'files' => true
                        ])
                    }}
                        <p>อัพเดตสถานะคำสั่งซื้อ</p>
                        <select id="status" name="status" class="form-control">
                            <option value="">--เลือกข้อมูล--</option>
                            @foreach ($orderStatus as $status )
                                <option value="{{ $status->id }}" @if($status->id == $data->payment_status) selected @endif>{{ $status->status_name }}</option>
                            @endforeach
                        </select>
                        @error('status')<small class="error-danger-text">{{ $message }}</small> @enderror
                        <div class="right">
                            @include('layouts.admin._button.submit')
                        </div>
                    </form>
                </div>
            </div>
        @else

            @if (Auth::user()->level == 1 ||  Auth::user()->level == 3 ||  Auth::user()->level == 7)

                <div class="card">
                    <div class="card-body">
                        {{
                            Form::model($data, [
                                'novalidate',
                                'route' => ['order.update.status',[$data->id]],
                                'id'=>'customcode-form',
                                'method' => 'put',
                                'files' => true
                            ])
                        }}
                            <p>อัพเดตสถานะคำสั่งซื้อ</p>
                            <select id="status" name="status" class="form-control">
                                <option value="">--เลือกข้อมูล--</option>
                                @foreach ($orderStatus as $status )
                                    <option value="{{ $status->id }}" @if($status->id == $data->payment_status) selected @endif>{{ $status->status_name }}</option>
                                @endforeach
                            </select>
                            @error('status')<small class="error-danger-text">{{ $message }}</small> @enderror
                            <div class="right">
                                @include('layouts.admin._button.submit')
                            </div>
                        </form>
                    </div>
                </div>
            
            @else

                <div class="card">
                    <div class="card-body">
                        <p>อัพเดตสถานะคำสั่งซื้อ</p>
                        <select id="status" name="status" class="form-control" disabled>
                            <option value="">--เลือกข้อมูล--</option>
                            @foreach ($orderStatus as $status )
                                <option value="{{ $status->id }}" @if($status->id == $data->payment_status) selected @endif>{{ $status->status_name }}</option>
                            @endforeach
                        </select>
                        @error('status')<small class="error-danger-text">{{ $message }}</small> @enderror
                        <br/>
                    </div>
                </div>

            @endif
        @endif

        @if($data->payment_status == 5 || $data->payment_status == 6 || $data->payment_status == 7)
            <div class="card">
                <div class="card-body">
                    {{
                        Form::model($data, [
                            'novalidate',
                            'route' => ['order.update.transport',[$data->id]],
                            'id'=>'customcode-form',
                            'method' => 'put',
                            'files' => true
                        ])
                    }}
                        <div class="form-group">
                            <p>ผู้ให้บริการขนส่ง</p>
                            <select id="transportId" name="transportId" class="form-control">
                                <option value="">--เลือกข้อมูล--</option>
                                @foreach ($orderTransport as $transport )
                                    <option value="{{ $transport->id }}" @if($transport->id == $data->transportId) selected @endif>{{ $transport->transport_name }}</option>
                                @endforeach
                            </select>
                            @error('transportId')<small class="error-danger-text">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <p>หมายเลขพัสดุ </p>
                            <input class="form-control" id="tracking" name="tracking" value="@if(!empty($data->tracking)){{ $data->tracking }}@endif" />
                            @error('tracking')<small class="error-danger-text">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <p>หมายเหตุ </p>
                            <input class="form-control" id="tracking_remark" name="tracking_remark" value="@if(!empty($data->tracking_remark)){{ $data->tracking_remark }}@endif" />
                            @error('tracking_remark')<small class="error-danger-text">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <small>
                                *หากเป็นการเข้ามารับสินค้าเองที่บริษัท & บริษัทเป็นผู้จัดจำหน่าย & ส่ง Certificate ให้ลูกค้าทางอีเมล ให้ใส่หมายเลขพัสดุเป็น -
                            </small>
                        </div>
                        <div class="form-group">
                            <div class="right">
                                @include('layouts.admin._button.submit')
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection

@section('js')

 <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
 <script src="{{ asset('vendor/select2-bootstrap4-theme/docs/script.js') }}"></script>

@endsection
