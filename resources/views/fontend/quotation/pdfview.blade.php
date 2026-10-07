<!DOCTYPE html>
<html lang="th">
<head>
  <title>{{ $items->quotationNumber }}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <style>
    @font-face {
        font-family: 'Sukhumvit Set';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('fonts/SukhumvitSet-Text.ttf') }}") format('truetype');
        font-size: 14px;
    }
    body{
        font-family: 'Sukhumvit Set' !important;
        line-height: 0.8;
    }
    small strong {
        font-weight: 900 !important;
    }
    .page-size{

    }
    .img-dratf{
        width: 100%;
        position: absolute;
        margin: auto
    }

  </style>

</head>
<body>

    <img class="img-dratf" style="width: 100%;" src="{{ asset('images/pdf-draft.png') }}" alt="draft" />

    @php
        $q_vat = 0;
        $q_withheld = 0;

        if (!empty($items->productVat) && $items->productVat != 0) {
            $q_vat = ($items->productTotal * $items->productVat) / 100;
        }

        if (!empty($items->productTax) && $items->productTax != 0) {
            $q_withheld = ($items->productTotal * $items->productTax) / 100;
        }

        $q_total = $items->productTotal + $q_vat - $q_withheld;
    @endphp

    <div class="page-size">
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="width:120px">
                                        <img style="width: 120px" src="{{ asset("storage/setting/".$quotationsetting->logo_company) }}" alt="logo" />
                                    </td>
                                    <td>
                                        <strong>{{ $quotationsetting->company_name}}</strong><br/>
                                        <small><b>Tax ID :</b> {{ $quotationsetting->tax_id}}</small><br/>
                                        <small>{{ $quotationsetting->company_address}}</small><br/>
                                        <small><b>Tel.</b> {{ $quotationsetting->company_tel}}, Fax.{{ $quotationsetting->company_fax}}</small>
                                    </td>
                                <tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 190px">
                        <h1>Quotation</h1>
                    </td>
                </tr>
                <tr>
                    <td >
                        <small><b>To :</b> {{ $items->name}} {{ $items->lastname}}</small><br/>
                        <!--small><b>Tax Id :</b> {{ $items->tax}}</small><br/-->
                        @if (!empty($items->company))
                        <small><b>Company :</b> {{ $items->company}}</small><br/>
                        @endif
                        <small><b>Addr :</b> {{ $items->address}} {{ $district }} {{ $amphoes }} {{ $provinces }} {{ $items->zipcode}}</small><br/>
                        <small><b>Tel :</b> {{ $items->tel}}</small>
                    </td>
                    <td>
                        <small><b>Date :</b> {{ $items->quotationDate }}</small><br/>
                        <small><b>Quotation No :</b> {{ $items->quotationNumber}}</small>
                    </td>
                </tr>
            </tbody>
        </table>
		
		@if(!empty($items->productName))
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
                            <small>SKU : {{ $items->productSku }}</small><br/>
                            <small>{{ $items->productName }}</small>
                            @if(!empty($items->productDetail))<small>{{ $items->productDetail }}</small>@endif
                            @if(!empty($items->quotation_messenger))
                                <br/><br/>
                                <small style="word-wrap: break-word; width:100%">
                                    <b>Note.</b> <br/>{{ $items->message }}
                                </small>
                                <br/>
                            @endif
                        </td>
                        <td style="text-align: right; border:1px solid #e6e6e6">
                            @if (!empty($items->productPricesale))
                                <span style="font-size:10px">(Sale .{{ number_format($items->productPrice) }})</span> {{ number_format($items->productPricesale,2) }}
                            @else
                                @if(!empty($items->productPrice))
                                    {{ number_format($items->productPrice,2) }}
                                @else
                                0.-
                                @endif
                            @endif
                        </td>
                        <td style="text-align: center;border:1px solid #e6e6e6"><small>{{ $items->productUnit }}</small></td>
                        <td style="text-align: right;border:1px solid #e6e6e6"><small>{{ number_format($items->productTotal,2) }}</small></td>
                    </tr>
                    <!-- รวมราคาสินค้า -->
                    <tr>
                        <td colspan="2" rowspan="4" align="left" valign="top">
                            <div>
                                @if(!empty($quotationsetting->quotation_note))
                                <small style="word-wrap: break-word; width:100%">{{ $quotationsetting->quotation_note }}</small><br/>
                                @endif
                                @if(!empty($items->productPricesale))
                                <small style="word-wrap: break-word; width:100%">Discount Products From: {{ number_format($items->productPrice,2) }} Baht.</small><br/>
                                @endif
                            </div>
                        </td>
                        <td colspan="2" style="text-align: right; border:1px solid #e6e6e6; padding-top:20px"><small><b>Subtotal</b></small></td>
                        <td style="text-align: right; border:1px solid #e6e6e6"><small>{{ number_format($items->productTotal,2) }}</small></td>
                    </tr>
                    @if ($items->productVat != 0)
                        <!-- ภาษีมูลค่าเพิ่ม -->
                        <tr>
                            <td colspan="2" style="text-align: right; border:1px solid #e6e6e6; padding-top:22px"><small><b>VAT {{ $items->productVat }}%</b></small></td>
                            <td style="text-align: right; border:1px solid #e6e6e6">
                                <small>{{ number_format($q_vat,2) }}</small>
                            </td>
                        </tr>
                    @endif
                    @if ($items->productTax != 0)
                        <!-- หัก ณ ที่จ่าย -->
                        <tr>
                            <td colspan="2" style="text-align: right; border:1px solid #e6e6e6; padding-top:22px"><small><b>Tax Withheld {{ $items->productTax }}%</b></small></td>
                            <td style="text-align: right; border:1px solid #e6e6e6">
                                <small>{{ number_format($q_withheld,2) }}</small>
                            </td>
                        </tr>
                    @endif

                    <!-- ราคารวมทั้งสิ้น -->
                    <tr>
                        <td colspan="2" style="text-align: right; border:1px solid #e6e6e6; padding-top:22px"><small><b>Grand Total</b></small></td>
                        <td style="text-align: right; border:1px solid #e6e6e6">
                            <small>{{ number_format($q_total,2) }}</small>
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
                                @if(!empty($quotationsetting->quotation_note))
                                    Remarks : {{ $quotationsetting->quotation_note }}<br/>
                                @endif
                                @if(!empty($quotationsetting->quotation_transfer))
                                    Delivery Time : {{ $quotationsetting->quotation_transfer }}<br/>
                                @endif
                                @if(!empty($quotationsetting->quotation_payment))
                                    Term of Payment : {{ $quotationsetting->quotation_payment }}<br/>
                                @endif
                                @if(!empty($items->quotationDateExp))
                                    Quotation valid until : {{ $items->quotationDateExp }}<br/>
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
					<span data-notify="icon" class="nc-icon nc-bell-55"></span> <span data-notify="message">เจ้าหน้าที่ได้รับข้อมูลการขอใบเสนอราคาเรียบร้อยแล้วค่ะ โปรดรอการติดต่อกลับ.</span>
					@if(!empty($items->message))
						<br/>
						<b>Note.</b>  :: {{ $items->message }}
					@endif
				</div>
			</blockquote>
			<br/>
		@endif
    </div>

</body>
</html>