<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5>ภาพสินค้า</h5>
                <hr/>
            </div>
            <div class="card-body">
                {{
                    Form::open([
                        'novalidate',
                        'route' => 'product.crateProductimg',
                        'class' => ($errors->any()) ? 'was-validated form-horizontal' : 'needs-validation form-horizontal',
                        'id'=>'product-form-tab3',
                        'method' => 'post',
                        'files' => true
                    ])
                }}
                    @error('pro_thumb')<small class="error-danger-text">{{ $message }}</small> <br/>@enderror
                    <input type="hidden" id="proId" name="proId" value="{{$id}}" />
                    <input type="file" accept="image/*" class="form-control" id="pro_thumb" name="pro_thumb[]" multiple>
                    @include('layouts.admin._button.upload')
                    <br/>
                    <small class="label-yellow">(ขนาดภาพแนะนำ 300 X 300 PX)</small><br/>
                    <small class="label-yellow">สามารถอัพโหลดภาพพร้อมกันได้หลายไฟล์</small><br/>
                    <small class="error-danger-text">* หากไฟล์ภาพมีขนาดไม่เท่ากับที่กำหนด ไฟล์จะบีบอัดอัตโนมัติเพื่อให้ได้ขนาดที่ต้องการ (อาจทำให้ภาพยืดหรือหดได้)</small>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        @if (!empty($pictureProduct))
            <div class="row">
                @foreach ($pictureProduct as $picture)
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                        <a href="#" class="remove-logo" data-toggle="modal" data-target="#deleteThump_detail" onclick="deleteModal5(this)" href="#" data-id="{{ $picture->id }}" data-name="{{ $picture->picture_name }}">
                                            <button class="btn btn-icon btn-round btn-google" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </a>
                                    <div class="text-align-center">
                                        <img src="{{ asset('storage/product/'.$picture->picture_name) }}" alt="" class="full-width" rel="nofollow">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>