<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            <h5>ข้อมูลทั่วไปของสินค้า</h5>
            <hr/>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>รหัสสินค้า<span class="text-danger">*</span></label>
                        <input type="hidden" id="proId" name="proId" value="{{$id}}" />
                        <input class="form-control" id="detail_sku" name="detail_sku" value="@if(!empty($detail->detail_sku)){{ $detail->detail_sku }}@else{{ old('detail_sku') }}@endif" />
                        @error('detail_sku')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Vendor SKU</label>
                        <input class="form-control" id="vendor_sku" name="vendor_sku" value="@if(!empty($detail->vendor_sku)){{ $detail->vendor_sku }}@else{{ old('vendor_sku') }}@endif" />
                        @error('vendor_sku')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                @if(!empty($data->pro_option) == 1)
                    <input type="hidden" id="detail_name" name="detail_name" value="@if(!empty($data->pro_name)){{ $data->pro_name }}@endif" />
                    <input type="hidden" id="detail_other" name="detail_other" value="@if(!empty($data->detail_other)){{ $data->detail_other }}@endif" />
                @else
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ชื่อสินค้า <span class="text-danger">*</span></label>
                            <input class="form-control" id="detail_name" name="detail_name" value="@if(!empty($detail->detail_name)){{ $detail->detail_name }}@else{{ old('detail_name') }}@endif" />
                            @error('detail_name')<small class="error-danger-text">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>รายละเอียด</label>
                            <input class="form-control" id="detail_other" name="detail_other" value="@if(!empty($detail->detail_other)){{ $detail->detail_other }}@else{{ old('detail_other') }}@endif" />
                            @error('detail_other')<small class="error-danger-text">{{ $message }}</small> @enderror
                        </div>
                    </div>
                @endif
            </div>

            @if($productType == 1)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>สถานะสินค้า</label>
                        <select class="form-control" id="detail_status" name="detail_status" data-url="{{ route('product.status.json') }}" onchange="checkProduct_status(this)" >
                            @foreach ($pro_status as $status )
                                <option value="{{ $status->id }}" @if(!empty($detail->detail_status)) @if($detail->detail_status == $status->id) selected @endif @else @if(!empty(old('detail_status'))) @if(old('detail_status') == $status->id) selected @endif @endif @endif>{{ $status->stu_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="block_hidden" class="col-md-6 hidden">
                    <div class="form-group">
                        <label>จำนวนวันที่รอของพรีออเดอร์ / วัน</label>
                        <input class="form-control only-integer" inputmode="numeric" autocomplete="off" id="detail_preorder_day" name="detail_preorder_day" value="@if(!empty($detail->detail_preorder_day)){{ $detail->detail_preorder_day }}@else{{ old('detail_preorder_day') }}@endif" />
                    </div>
                </div>

                <div class="col-md-12">
                    <hr/>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>น้ำหนักสินค้า / KG</label>
                        <input class="form-control only-integer" inputmode="numeric" autocomplete="off" id="detail_product_weight" name="detail_product_weight" value="@if(!empty($detail->detail_product_weight)){{ $detail->detail_product_weight }}@else{{ old('detail_product_weight') }}@endif" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>กว้าง / CM</label>
                        <input class="form-control only-integer" inputmode="numeric" autocomplete="off" id="detail_product_wide" name="detail_product_wide" value="@if(!empty($detail->detail_product_wide)){{ $detail->detail_product_wide }}@else{{ old('detail_product_wide') }}@endif" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>ยาว / CM</label>
                        <input class="form-control only-integer" inputmode="numeric" autocomplete="off" id="detail_product_long" name="detail_product_long" value="@if(!empty($detail->detail_product_long)){{ $detail->detail_product_long }}@else{{ old('detail_product_long') }}@endif" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>สูง / CM</label>
                        <input class="form-control only-integer" inputmode="numeric" autocomplete="off" id="detail_product_high" name="detail_product_high" value="@if(!empty($detail->detail_product_high)){{ $detail->detail_product_high }}@else{{ old('detail_product_high') }}@endif" />
                    </div>
                </div>

                <div class="col-md-12"><br>
                    <div class="form-group ">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input onclick="checkBlockToggle(this)" data-block="product_stock_hidden" name="detail_check_stock_status" id="detail_check_stock_status" class="form-check-input" type="checkbox" value="1" @if(!empty($detail->detail_check_stock_status)) @if($detail->detail_check_stock_status == 1) checked @endif @else @if( old('detail_check_stock_status') == 1) checked @endif @endif>
                                <span class="form-check-sign"></span>
                                เช็คสต็อก
                            </label>
                        </div>
                    </div>
                </div>

                @php
                    $class_stock = 'hidden';
                    if(!empty($detail->detail_check_stock_status)){
                        if($detail->detail_check_stock_status == 1){
                            $class_stock = '';
                        }
                    }elseif(old('detail_check_stock_status') == 1){
                        $class_stock = '';
                    }
                @endphp

                <div class="col-md-3 {{ $class_stock }}" id="product_stock_hidden">
                    <div class="form-group">
                        <label>จำนวนสต็อก<span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light only-integer" inputmode="numeric" autocomplete="off" id="detail_stock" name="detail_stock" value="@if(!empty($detail->detail_stock)){{ $detail->detail_stock }}@else{{ old('detail_stock') }}@endif" />
                        @error('detail_stock')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>สั่งซื้อขั้นต่ำ</label>
                        <input type="text" class="form-control only-integer" inputmode="numeric" autocomplete="off" id="min_order" name="min_order"
                               value="@if(!empty($detail->min_order)){{ $detail->min_order }}@else{{ old('min_order') }}@endif" />
                        @error('min_order')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>ซื้อได้สูงสุด</label>
                        <input type="text" class="form-control only-integer" inputmode="numeric" autocomplete="off" id="max_order" name="max_order"
                               value="@if(!empty($detail->max_order)){{ $detail->max_order }}@else{{ old('max_order') }}@endif" />
                        @error('max_order')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <hr/>
                </div>

                <div class="col-md-12"><br>
                    <div class="form-group ">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input onclick="checkBlockToggle(this)" data-block="product_price_hidden" name="detail_product_contact_sale_status" id="detail_product_contact_sale_status" class="form-check-input" type="checkbox" value="1" @if(!empty($detail->detail_product_contact_sale_status)) @if($detail->detail_product_contact_sale_status == 1) checked @endif @else @if( old('detail_product_contact_sale_status') == 1) checked @endif @endif>
                                <span class="form-check-sign"></span>
                                ติดต่อสอบถามราคากับพนักงาน / ขอใบเสนอราคา
                            </label>
                        </div>
                    </div>
                </div>
				
				
            </div>

            <div id="product_price_hidden" @if(!empty($detail->detail_product_contact_sale_status)) @if($detail->detail_product_contact_sale_status == 1) class="hidden" @endif @else @if( old('detail_product_contact_sale_status') == 1) class="hidden" @endif @endif>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ราคาสินค้า/บาท<span class="text-danger">*</span></label>
                            <input class="form-control only-integer" inputmode="numeric" autocomplete="off" id="detail_price" name="detail_price" value="@if(!empty($detail->detail_price)){{ $detail->detail_price }}@else{{ old('detail_price') }}@endif" />
                            @error('detail_price')<small class="error-danger-text">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group ">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input onclick="checkBlockToggle(this)" data-block="product_price_sale_hidden" name="detail_price_sale_status" id="detail_price_sale_status" class="form-check-input" type="checkbox" value="1" @if(!empty($detail->detail_price_sale_status)) @if($detail->detail_price_sale_status == 1) checked @endif @else @if( old('detail_price_sale_status') == 1) checked @endif @endif>
                                    <span class="form-check-sign"></span>
                                    ลดราคาสินค้า
                                </label>
                            </div>
                        </div>
                    </div>
					
					
                </div>
				<div class="row">
					
				</div>
				

                <div id="product_price_sale_hidden" @if(!empty($detail->detail_price_sale_status)) @if($detail->detail_price_sale_status != 1) class="hidden" @endif @else @if(!empty(old('detail_price_sale_status'))) @if(old('detail_price_sale_status') != 1) class="hidden" @endif @else class="hidden"  @endif @endif>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ราคาสินค้าที่ลด/บาท<span class="text-danger">*</span></label>
                                <input class="form-control only-integer" inputmode="numeric" autocomplete="off" id="detail_price_sale" name="detail_price_sale" value="@if(!empty($detail->detail_price_sale)){{ $detail->detail_price_sale }}@else{{ old('detail_price_sale') }}@endif" />
                                @error('detail_price_sale')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ระยะเวลาการลดราคาสินค้า</label>
                                <div>
                                    <div class="form-check-radio display-inline-block">
                                        <label class="form-check-label">
                                            <input class="form-check-input" onclick="checkBlockHidden2(this)" data-block="product_price_sale_date_hidden" type="radio" name="detail_price_sale_status_date" id="detail_price_sale_status_date1" value="2" @if(!empty($detail->detail_price_sale_status_date)) @if($detail->detail_price_sale_status_date == 2) checked @endif @else @if( old('detail_price_sale_status_date') == 2) checked @else checked @endif @endif>
                                            ไม่กำหนดเวลา
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-radio display-inline-block">
                                        <label class="form-check-label">
                                            <input class="form-check-input" onclick="checkBlockHidden2(this)" data-block="product_price_sale_date_hidden" type="radio" name="detail_price_sale_status_date" id="detail_price_sale_status_date2" value="1" @if(!empty($detail->detail_price_sale_status_date)) @if($detail->detail_price_sale_status_date == 1) checked @endif @else @if( old('detail_price_sale_status_date') == 1) checked @endif @endif>
                                            กำหนดเวลา
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="product_price_sale_date_hidden" @if(!empty($detail->detail_price_sale_status_date)) @if($detail->detail_price_sale_status_date != 1) class="hidden" @endif @else @if(!empty(old('detail_price_sale_status_date'))) @if(old('detail_price_sale_status_date') != 1) class="hidden" @endif @else class="hidden"  @endif @endif>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>วันที่เริ่มลดราคา<span class="text-danger">*</span></label>
                                    <input class="form-control datepicker" id="detail_sale_date_start" name="detail_sale_date_start" value="@if(!empty($detail->detail_sale_date_start)){{ $detail->detail_sale_date_start }}@else{{ old('detail_sale_date_start') }}@endif" />
                                    @error('detail_sale_date_start')<small class="error-danger-text">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>วันที่สิ้นสุดการลดราคา<span class="text-danger">*</span></label>
                                    <input class="form-control datepicker" id="detail_sale_date_end" name="detail_sale_date_end" value="@if(!empty($detail->detail_sale_date_end)){{ $detail->detail_sale_date_end }}@else{{ old('detail_sale_date_end') }}@endif" />
                                    @error('detail_sale_date_end')<small class="error-danger-text">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
					
                    
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>&nbsp;</label>
								<div class="form-group m-0">
									<div class="form-check" style="padding-top:8px;">
										<label class="form-check-label text-danger">
											<input name="hide_addtocart_status" id="hide_addtocart_status" class="form-check-input" type="checkbox" value="1"
												@if(!empty($detail->hide_addtocart_status))
													@if($detail->hide_addtocart_status == 1) checked @endif
												@else
													@if(old('hide_addtocart_status') == 1) checked @endif
												@endif
											>
											<span class="form-check-sign"></span>
											ซ่อนปุ่ม Add to cart ในช่วงลดราคา
										</label>
									</div>
									@error('hide_addtocart_status')<small class="error-danger-text">{{ $message }}</small> @enderror
								</div>
							</div>
						</div>
					</div>
                </div>
				
				
            </div>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="jumbotron">
                บันทึกแบบร่าง / เผยแพร่
            </div>
            <div class="form-group">
                <input name="detail_show" id="detail_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                @if(!empty($detail->detail_show))
                    @if($detail->detail_show == 1)
                        checked
                    @endif
                @else
                    checked
                @endif
                 />
            </div>
            <hr/>
            <div class="jumbotron">
                ลำดับการแสดงผล
            </div>
            <div class="form-group">
                @if(!empty($detail->sort))
                    <input name="sort" id="sort" class="form-control no-max-height only-integer" inputmode="numeric" autocomplete="off" type="text" value="{{ $detail->sort }}"  />
                @else
                    @if(!empty(old('sort')))
                        <input name="sort" id="sort" class="form-control no-max-height only-integer" inputmode="numeric" autocomplete="off" type="text" value="{{ old('sort') }}"  />
                    @else
                        @if(!empty($sort))
                            <input name="sort" id="sort" class="form-control no-max-height only-integer" inputmode="numeric" autocomplete="off" type="text" value="{{ $sort+1 }}"   />
                        @else
                            <input name="sort" id="sort" class="form-control no-max-height only-integer" inputmode="numeric" autocomplete="off" type="text" value="1"   />
                        @endif
                    @endif
                @endif

                @error('sort')<small class="error-danger-text">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @php
                        if(!empty($detail->id)){
                            $detailThumb = App\Models\TbProductPicture::where('detailId',$detail->id)->first();
                        }else{
                            $detailThumb = '';
                        }
                    @endphp

                    @if(!empty($detailThumb))
                        <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteThump_detail" onclick="deleteModal5(this)" href="#" data-id="{{ $detailThumb->id }}" data-name="{{ $detailThumb->picture_name }}">
                            <button class="btn btn-icon btn-round btn-google" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </a>
                    @endif

                    <div class="text-align-center">
                        @if(!empty($detailThumb))
                            <input type="hidden" class="form-control" id="pro_thumb_old" name="pro_thumb_old" value="{{ $detailThumb->picture_name }}">
                            <img id="blah2" src="{{ asset('storage/product/' . $detailThumb->picture_name) }}" alt="" class="full-width" rel="nofollow">
                        @else
                            <img id="blah2" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                        @endif
                    </div>

                    <p></p><small>ขนาดภาพแนะนำ 300 X 300 PX</small><br/>
                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>
                    <br/>

                    <div>
                        <input type="file" accept="image/*" class="form-control" id="pro_thumb" name="pro_thumb" onchange="readURL2(this);">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>