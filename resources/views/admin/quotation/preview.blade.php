@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')
 <!-- select2 -->
 <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
 <!-- select2-bootstrap4-theme -->
 <link href="{{ asset('vendor/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

 <style>
    .jumbotron { padding: 1rem; margin-bottom: 1rem; }
    .blockquote {font-size: 0.8em; border-color: #f1926e; color: #f1926e}
 </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">

        <div class="card shadow mb-4">
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width:120px">
                                                <img style="width: 120px" src="{{ asset("storage/setting/".$setting->logo_company) }}" alt="logo" />
                                            </td>
                                            <td>
                                                <strong>{{ $setting->company_name}}</strong><br/>
                                                <small><b>Tax ID :</b> {{ $setting->tax_id}}</small><br/>
                                                <small>{{ $setting->company_address}}</small><br/>
                                                <small><b>Tel.</b> {{ $setting->company_tel}}, Fax.{{ $setting->company_fax}}</small>
                                            </td>
                                        <tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width: 260px">
                                <h1>Quotation</h1>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <small><b>To :</b> {{ $data->name}} {{ $data->lastname}}</small><br/>
                                <small><b>Tax Id :</b> {{ $data->tax}}</small><br/>
                                @if (!empty($data->company))
                                <small><b>Company :</b> {{ $data->company}}</small><br/>
                                @endif
                                <small><b>Addr :</b> {{ $data->address}} {{ $district }} {{ $amphoes }} {{ $provinces }} {{ $data->zipcode}}</small><br/>
                                <small><b>Tel :</b> {{ $data->tel}}</small>
                            </td>
                            <td>
                                <small><b>Date :</b> {{ $data->quotationDate }}</small><br/>
                                <small><b>Quotation No :</b> {{ $data->quotationNumber}}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if(!empty($data->productName))
                    <div style="padding-left: 10px; padding-right:10px">
                        <div style="margin-bottom: 15px">
                            <small>
                                We, Applicad Public Company Limited are pleased to propose our price schedule as follows.
                            </small>
                        </div>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 10%; border:1px solid #e6e6e6"><small><b>No.</b></small></th>
                                    <th style="border:1px solid #e6e6e6; max-width: 40%;"><small><b>Description</b></small></th>
                                    <th style="text-align: right; width: 15%;border:1px solid #e6e6e6"><small><b>Unit Price</b></small></th>
                                    <th style="text-align: center; width: 10%;border:1px solid #e6e6e6"><small><b>Quantity</b></small></th>
                                    <th style="text-align: right; width: 15%;border:1px solid #e6e6e6"><small><b>Amount</b></small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center; border:1px solid #e6e6e6"><small>1</small></td>
                                    <td style="text-align: left; border:1px solid #e6e6e6; min-height:130px;">
                                        <small>SKU : {{ $data->productSku }}</small><br/>
                                        @if(!empty($data->productVendorSku))<small class="text-danger">SKU Vendor : {{ $data->productVendorSku }}</small><br/>@endif
                                        <small>{{ $data->productName }}</small>
                                        @if(!empty($data->productDetail))<small>{{ $data->productDetail }}</small>@endif
                                        @if(!empty($data->quotation_messenger))
                                            <br/><br/>
                                            <small style="word-wrap: break-word; width:100%">
                                                <b>Note.</b> <br/>{{ $data->message }}
                                            </small>
                                            <br/>
                                        @endif
                                    </td>
                                    <td style="text-align: right; border:1px solid #e6e6e6">
                                        @if (!empty($data->productPricesale))
                                            <span class="amount-sale">{{ number_format($data->productPrice) }}</span> {{ number_format($data->productPricesale,2) }}
                                        @else
                                            @if(!empty($data->productPrice))
                                                {{ number_format($data->productPrice,2) }}
                                            @else
                                            0.-
                                            @endif
                                        @endif
                                    </td>
                                    <td style="text-align: center;border:1px solid #e6e6e6"><small>{{ $data->productUnit }}</small></td>
                                    <td style="text-align: right;border:1px solid #e6e6e6"><small>{{ number_format($data->productTotal,2) }}</small></td>
                                </tr>
                                <!-- รวมราคาสินค้า -->
                                <tr>
                                    <td colspan="2" rowspan="4" align="left" valign="top">
                                        <div>
                                            @if(!empty($setting->quotation_note))
                                            <small style="word-wrap: break-word; width:100%">{{ $setting->quotation_note }}</small><br/>
                                            @endif
                                            @if(!empty($data->productPricesale))
                                            <small style="word-wrap: break-word; width:100%">Discount Products From: {{ number_format($data->productPricesale,2) }} Baht.</small><br/>
                                            @endif
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align: right; border:1px solid #e6e6e6; padding-top:20px"><small><b>Subtotal</b></small></td>
                                    <td style="text-align: right; border:1px solid #e6e6e6"><small>{{ number_format($data->productTotal,2) }}</small></td>
                                </tr>
                                @if (!empty($setting->company_vat))
                                    <!-- ภาษีมูลค่าเพิ่ม -->
                                    <tr>
                                        <td colspan="2" style="text-align: right; border:1px solid #e6e6e6; padding-top:22px"><small><b>VAT {{ $setting->company_vat }}%</b></small></td>
                                        <td style="text-align: right; border:1px solid #e6e6e6">
                                            <small>
                                                @php
                                                    $q_vat = ($data->productTotal * $setting->company_vat)/100;
                                                @endphp
                                                {{ number_format($q_vat,2) }}
                                            </small>
                                        </td>
                                    </tr>
                                @endif
                                @if (!empty($setting->company_withheld))
                                    <!-- หัก ณ ที่จ่าย -->
                                    <tr>
                                        <td colspan="2" style="text-align: right; border:1px solid #e6e6e6; padding-top:22px"><small><b>Tax Withheld {{ $setting->company_withheld }}%</b></small></td>
                                        <td style="text-align: right; border:1px solid #e6e6e6">
                                            <small>
                                                @php
            
                                                    $q_withheld = ($data->productTotal * $setting->company_withheld)/100;
            
                                                @endphp
            
                                                {{ number_format($q_withheld,2) }}
                                            </small>
                                        </td>
                                    </tr>
                                @endif
            
                                <!-- ราคารวมทั้งสิ้น -->
                                <tr>
                                    <td colspan="2" style="text-align: right; border:1px solid #e6e6e6; padding-top:22px"><small><b>Grand Total</b></small></td>
                                    <td style="text-align: right; border:1px solid #e6e6e6">
                                        <small>
                                            @php
            
                                                if(!empty($setting->company_vat) && !empty($setting->company_withheld)){
                                                    $q_total = ($data->productTotal + $q_vat)-$q_withheld;
                                                }else if(!empty($setting->company_vat) && empty($setting->company_withheld)){
                                                    $q_total = ($data->productTotal + $q_vat);
                                                }else if(empty($setting->company_vat) && !empty($setting->company_withheld)){
                                                    $q_total = $data->productTotal -$q_withheld;
                                                }else if(empty($setting->company_vat) && empty($setting->company_withheld)){
                                                    $q_total = $data->productTotal;
                                                }
            
                                            @endphp
                                            {{ number_format($q_total,2) }}
                                        </small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <small>
                                            <b>Terms and Conditions</b><br/>
                                            @if(!empty($setting->quotation_note))
                                                Remarks : {{ $setting->quotation_note }}<br/>
                                            @endif
                                            @if(!empty($setting->quotation_transfer))
                                                Delivery Time : {{ $setting->quotation_transfer }}<br/>
                                            @endif
                                            @if(!empty($setting->quotation_payment))
                                                Term of Payment : {{ $setting->quotation_payment }}<br/>
                                            @endif
                                            @if(!empty($data->quotationDateExp))
                                                Quotation valid until : {{ $data->quotationDateExp }}<br/>
                                            @endif
            
                                        </small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="margin-bottom: 15px">
                            <small>
                                We hope our offer will meet your requirement and look forward to serving you our best soon.<br/>
                                <b>Best Regards,</b>
                            </small>
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <small>
                                            To accept this quotation and confirm an order on these terms on behalf of the purchaser, please sign and company stamp here and return to us via fax number (+66) 0-2744-9602. ___________________ date______/______/______
                                        </small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <br/>
                    <hr/>
                    <blockquote>
                        <div class="blockquote">
                            <span data-notify="icon" class="nc-icon nc-bell-55"></span> <span data-notify="message">ต้องการให้ติดต่อกลับ.</span>
                            @if(!empty($data->message))
                                <br/>
                                <b>Note.</b>  :: {{ $data->message }}
                            @endif
                        </div>
                    </blockquote>
                    <br/>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="card">
            <div class="card-body">
                <div>
                    <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" disabled @if ($data->pdpa_news == 1)checked @endif>
                          <span class="form-check-sign"></span>
                          รับข้อมูลข่าวสารและประชาสัมพันธ์ทางอีเมล
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" disabled @if ($data->pdpa_article == 1)checked @endif>
                          <span class="form-check-sign"></span>
                          รับข้อมูลบทความ สาระความรู้จากเราทางอีเมล
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" disabled @if ($data->pdpa_product == 1)checked @endif>
                          <span class="form-check-sign"></span>
                          รับข้อมูลข่าวสารผลิตภัณฑ์ที่เกี่ยวข้องของบริษัท
                        </label>
                    </div>
                </div>
                <hr/>
                @if(!empty($data->history_quotations ))
                    @foreach ($data->history_quotations as $file)
                        <a href="{{ asset('storage/pdfQuotation/'.$file->name_file) }}" download="">
                            <i class="nc-icon nc-cloud-download-93"></i> ดาวน์โหลดเอกสาร PDF
                        </a>
                        <hr/>
                    @endforeach
                @endif
				@if(!empty($data->ref))
                    <div class="form-group">
                        <label>Ref :: <span class="badge badge-pill" style="background: #8AF0B7;">{{ $data->ref }}</span> </label>
                    </div>
                @endif
                @if(!empty($data->created_by))
                    <div class="form-group">
                        <label>อัพเดตข้อมูลโดย :: {{ $data->created_by}} :: {{ $data->created_at}} </label>
                    </div>
                @endif
                <a href="{{ route('quotation.index')}}">
                    @include('layouts.admin._button.back')
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                {{
                    Form::model($data, [
                        'novalidate',
                        'route' => ['quotation.update.staff',[$data->id]],
                        'id'=>'customcode-form',
                        'method' => 'put',
                        'files' => true
                    ])
                }}
                    <p>พนักงานที่รับผิดชอบ</p>
                    <select id="staff" name="staff" class="form-control">
                        <option value="">--เลือกข้อมูล--</option>
                        @foreach ($users as $user )
                            <option value="{{ $user->id }}" @if($user->id == $data->staffId) selected @endif>{{ $user->name }} {{ $user->lastname }}</option>
                        @endforeach
                    </select>
                    @error('staff')<small class="error-danger-text">{{ $message }}</small> @enderror
                    <div class="right">
                        @include('layouts.admin._button.submit')
                    </div>
                </form>
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
