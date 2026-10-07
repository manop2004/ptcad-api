@if(empty($data))
    {{
        Form::open([
            'novalidate',
            'route' => 'product.crate',
            'id'=>'data-form',
            'method' => 'post',
            'files' => true
        ])
    }}
@else
    {{
        Form::model($data, [
            'novalidate',
            'route' => ['product.update',[$data->id]],
            'id'=>'data-form',
            'method' => 'put',
            'files' => true
        ])
    }}
@endif
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h5>ข้อมูลทั่วไปของสินค้า</h5>
                <hr/>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="form-check-radio display-inline-block">
                                <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="pro_option" id="pro_option1" value="1" @if(!empty($data->pro_option)) @if($data->pro_option == 1) checked @endif @else checked @endif> สินค้ารูปแบบเดียว
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                            <div class="form-check-radio display-inline-block">
                                <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="pro_option" id="pro_option2" value="2" @if(!empty($data->pro_option)) @if($data->pro_option == 2) checked @endif @endif> สินค้าหลายรูปแบบ
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                            <br/>
                            <small class="error-danger-text">* หากสินค้ามีหลายตัวเลือกเช่น สีแดง, สีเขียว, สีเหลือง ให้เลือกที่ "สินค้าหลายรูปแบบ"</small><br/>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label>ชื่อสินค้า<span class="text-danger">*</span></label>
                            <input class="form-control" id="pro_name" name="pro_name" value="@if(!empty($data->pro_name)){{ $data->pro_name }}@else{{ old('pro_name') }}@endif" />
                            @error('pro_name')<small class="error-danger-text">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Permalink<span class="text-danger">*</span></label>
                            <input class="form-control" id="pro_permalink" name="pro_permalink" value="@if(!empty($data->pro_permalink)){{ $data->pro_permalink }}@else{{ old('pro_permalink') }}@endif" />
                            @if(!empty($data->pro_permalink))<a href="{{ route('fronend.product.content',$data->pro_permalink) }}" target="_bank">{{ route('fronend.product.content',$data->pro_permalink) }}</a><br/>@endif
                            @error('pro_permalink')<small class="error-danger-text">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Keyword</label>
                            <input data-role="tagsinput"  type="text" name="pro_keyword[]" id="pro_keyword" class="form-control form-tag" value="@if(!empty($data->pro_keyword)){{ $data->pro_keyword }}@else{{ old('old_pro_keyword') }}@endif"/>
                        </div>
                        <div >
                            <label>ภาพสินค้า</label>
                            <input type="file" accept="image/*" class="form-control" id="pro_thumb" name="pro_thumb" onchange="readURL1(this);">
                            <br/>
                        </div>
                        <div class="form-group">
                            <label>SEO Description</label>
                            <textarea onkeyup="ChkLength();" rows="3" id="remainLength" name="pro_seo_detail" rows="4" class="form-control" placeholder="อธิบายเกี่ยวกับบทความไม่เกิน 150 - 170 ตัวอักษร" maxlength="170" >@if(!empty($data->pro_seo_detail)){{ $data->pro_seo_detail }}@else{{ old('pro_seo_detail') }}@endif</textarea>
                            <small><p id="showNumber_ChkLength" class="error-danger-text"></p></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if(!empty($coverThumb))
                        <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteThump_pro" onclick="deleteModal4(this)" href="#" data-id="{{ $coverThumb->id }}" data-name="{{ $coverThumb->picture_name }}">
                            <button class="btn btn-icon btn-round btn-google" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </a>
                        @endisset
                        <div class="text-align-center">
                            @isset($coverThumb)
                                <input type="hidden" class="form-control" id="pro_thumb_old" name="pro_thumb_old" value="{{ $coverThumb->picture_name }}">
                                <img id="blah1" src="{{ asset('storage/product/'.$coverThumb->picture_name) }}" alt="" class="full-width" rel="nofollow">
                            @else
                                <img id="blah1" src="{{ asset('images/default-img/no-img.jpg')}}" alt="..." class="full-width" rel="nofollow">
                            @endisset
                        </div>
                        <p></p><small>ขนาดภาพแนะนำ 350 X 350 PX</small><br/>
                        <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small><br/>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>สินค้าที่เกี่ยวข้อง</label>
                            @if (!empty($data->pro_related))
                                @php
                                    $proRelated = explode(",",$data->pro_related);
                                @endphp
                                <select id="pro_related" name="pro_related[]" class="form-control select-multiple" multiple="multiple" >
                                    @foreach ( $productMultiple as $proMultiple)
                                    <option value="{{ $proMultiple->id }}"@foreach ( $proRelated as $key => $related) @if($proMultiple->id == $related) selected @endif  @endforeach >{{ $proMultiple->pro_name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select id="pro_related" name="pro_related[]" class="form-control select-multiple" multiple="multiple" >
                                    @foreach ( $productMultiple as $proMultiple)
                                        <option value="{{ $proMultiple->id }}">{{ $proMultiple->pro_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>แบรนด์สินค้า</label>
                            <select id="pro_brand" name="pro_brand" class="form-control" >
                                <option value="">กรุณาเลือกข้อมูล</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @if(!empty($data->pro_brand)) @if($data->pro_brand == $brand->id) selected @endif @endif>{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ประเภทสินค้า</label>
                            <select id="pro_type" name="pro_type" class="form-control" >
                                <option value="">กรุณาเลือกข้อมูล</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" @if(!empty($data->pro_type)) @if($data->pro_type == $type->id) selected @endif @endif>{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>หมวดหมู่หลัก<span class="text-danger">*</span></label>
                            <select id="pro_catId" name="pro_catId" class="form-control" onchange="getSubcat(this)" data-url="{{ route('product.jsonCatsub')}}"  data-placeholder="กรุณาเลือกข้อมูล" >
                                <option></option>
                                @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}" @if(!empty($data->pro_catId)) @if($data->pro_catId == $category->id) selected @endif @endif>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            @error('pro_catId')<small class="error-danger-text">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>หมวดหมู่ย่อย</label>
                            <select id="pro_catsubId" name="pro_catsubId" class="form-control"  data-placeholder="กรุณาเลือกข้อมูล" ></select>
                            <input type="hidden" id="hidden_pro_catsubId" name="hidden_pro_catsubId" value="@if(!empty($data->pro_catsubId)){{ $data->pro_catsubId }}@endif">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <label>ไฟล์ติดตั้งโปรแกรม (Installer)</label>
                            <input type="file" class="form-control" id="pro_installer" name="pro_installer">
                            <small class="text-muted">จะโชว์เป็นหัวข้อ "Installer" ในหน้า "My Products" ของลูกค้า</small>
                            @if(!empty($data->pro_installer))
                                <br/>
                                <a href="{{ asset('storage/product_dowloads/'.$data->pro_installer)}}" download="">{{$data->pro_installer}}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <label>คู่มือการ Activation (PDF)</label>
                            <input type="file" class="form-control" id="pro_activation_guide" name="pro_activation_guide">
                            <small class="text-muted">จะโชว์เป็นหัวข้อ "Offline Activation Guide" ในหน้า "My Products" ของลูกค้า</small>
                            @if(!empty($data->pro_activation_guide))
                                <br/>
                                <a href="{{ asset('storage/product_dowloads/'.$data->pro_activation_guide)}}" download="">{{$data->pro_activation_guide}}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ลิงก์ Release Notes / ประวัติเวอร์ชัน</label>
                            <input type="text" class="form-control" id="pro_release_notes" name="pro_release_notes" placeholder="https://..." value="@if(!empty($data->pro_release_notes)){{ $data->pro_release_notes }}@else{{ old('pro_release_notes') }}@endif">
                            <small class="text-muted">ใส่เป็นลิงก์ (เช่น Google Doc/หน้าเว็บ Changelog) ไม่ต้องอัปโหลดไฟล์ จะโชว์เป็นหัวข้อ "Release Notes"</small>
                        </div>
                    </div>
                    <div class="col-md-12"><hr/></div>
                    <div class="col-md-6">
                        <div class="">
                            <label>เอกสารดาวน์โหลด/โบรชัว</label>
                            <input type="file" class="form-control" id="pro_download" name="pro_download">
                            @if(!empty($data->pro_download))
                                <a href="{{ asset('storage/product_dowloads/'.$data->pro_download)}}" download="">{{$data->pro_download}}</a>
                                <br/>
                                <a href="#" data-toggle="modal" data-target="#deleteFile" onclick="deleteModal2(this)" class="text-danger" data-id="{{ $data->id }}" data-name="{{ $data->pro_download }}"><i class="fa fa-times"></i> ลบไฟล์</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>FREE TRIAL</label>
                            <input type="text" class="form-control" id="pro_free_trial" name="pro_free_trial" placeholder="url download" value="@if(!empty($data->pro_free_trial)){{ $data->pro_free_trial }}@else{{ old('pro_free_trial') }}@endif">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="line"></div>
                        <div class="form-group has-label">
                            @if(!empty($data->created_by))<label>เพิ่มข้อมูลโดย :: {{ $data->created_by}} :: {{ $data->created_at}} </label>@endif
                            @if(!empty($data->updated_by))<br/><label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>@endif
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
                    <input name="pro_show" id="pro_show" class="bootstrap-switch" type="checkbox" data-toggle="switch" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="success" data-off-color="success"
                    @if(!empty($data->pro_show))
                        @if($data->pro_show == 1) checked @endif
                    @else checked @endif
                    />
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="jumbotron">
                    เงื่อนไขการบริการ
                </div>
                @if(!empty($data->pro_codition))
                    @php
                        $Procoditions = explode(",",$data->pro_codition);
                        asort($Procoditions);
                    @endphp
                @endif
                @foreach ($conditions as $key=> $condition)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input name="pro_codition[]" class="form-check-input" type="checkbox" value="{{$condition->id}}" @if(!empty($data->pro_codition)) @foreach ($Procoditions as $pro_codition) @if($condition->id == $pro_codition) checked @endif @endforeach  @endif>
                            <span class="form-check-sign"></span>
                            {{$condition->condition_name}}
                            @if(!empty($condition->condition_des)) ({{ $condition->condition_des }}) @endif
                        </label>
                    </div>
                @endforeach     
                @error('pro_codition')<small class="error-danger-text">{{ $message }}</small> <br/>@enderror
                <small class="error-danger-text">* กำหนดให้เลือกได้ไม่เกิน 3 ตัวเลือก</small>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('product.index')}}">
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