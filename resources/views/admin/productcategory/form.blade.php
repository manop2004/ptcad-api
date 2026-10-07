@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('content')

{{
    Form::model($data, [
        'novalidate',
        'route' => !empty($data->id) ? ['productcategory.update', $data->id] : 'productcategory.store',
        'method' => !empty($data->id) ? 'put' : 'post',
        'files' => true
    ])
}}

    <div class="row">
        <div class="col-md-9">

            <div class="card">
                <div class="card-header"><h5>ข้อมูลการ์ด</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group has-label">
                                <label>ชื่อสินค้า <span class="text-danger">*</span></label>
                                <input class="form-control" name="title" value="{{ old('title', $data->title) }}" placeholder="เช่น PTCAD 2026 Standard" />
                                @error('title')<small class="error-danger-text">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-label">
                                <label>ป้าย Badge (ไม่บังคับ)</label>
                                <input class="form-control" name="badge_text" value="{{ old('badge_text', $data->badge_text) }}" placeholder="เช่น ขายดีที่สุด" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group has-label">
                        <label>คำอธิบายสั้น</label>
                        <input class="form-control" name="subtitle" value="{{ old('subtitle', $data->subtitle) }}" placeholder="เช่น CAD 2D/3D ฟีเจอร์ครบพร้อมทดแทน" />
                    </div>
                    <div class="form-group has-label">
                        <label>ข้อความ Highlight</label>
                        <input class="form-control" name="highlight" value="{{ old('highlight', $data->highlight) }}" placeholder="เช่น 2D/3D DWG / ใช้แทน ACAD ได้ทันที" />
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5>Bullet คุณสมบัติ (3 ข้อ)</h5></div>
                <div class="card-body">
                    <div class="form-group has-label">
                        <label>ข้อที่ 1</label>
                        <input class="form-control" name="feature1" value="{{ old('feature1', $data->feature1) }}" />
                    </div>
                    <div class="form-group has-label">
                        <label>ข้อที่ 2</label>
                        <input class="form-control" name="feature2" value="{{ old('feature2', $data->feature2) }}" />
                    </div>
                    <div class="form-group has-label">
                        <label>ข้อที่ 3</label>
                        <input class="form-control" name="feature3" value="{{ old('feature3', $data->feature3) }}" />
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5>ราคา + ปุ่ม</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group has-label">
                                <label>ราคา</label>
                                <input class="form-control" name="price" value="{{ old('price', $data->price) }}" placeholder="เช่น 4,990" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-label">
                                <label>หน่วยราคา</label>
                                <input class="form-control" name="price_unit" value="{{ old('price_unit', $data->price_unit) }}" placeholder="เช่น บาท/ปี" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-label">
                                <label>ข้อความปุ่ม</label>
                                <input class="form-control" name="button_text" value="{{ old('button_text', $data->button_text ?? 'ดูรายละเอียด') }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-label">
                                <label>ลิงก์ปุ่ม</label>
                                <input class="form-control" name="link" value="{{ old('link', $data->link) }}" placeholder="เช่น /category" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5>รูปไอคอน/โลโก้สินค้า</h5></div>
                <div class="card-body">
                    @if(!empty($data->image))
                        <div class="mb-3">
                            <img src="{{ asset('storage/setting/'.$data->image) }}" style="max-height:120px;border:1px solid #eee;border-radius:8px;padding:4px" />
                            <input type="hidden" name="image_old" value="{{ $data->image }}">
                        </div>
                    @endif
                    <input type="file" accept="image/*" class="form-control" name="image" />
                    <p></p>
                    <small class="text-muted">แนะนำรูปพื้นหลังโปร่งใส (PNG) ขนาดไม่เกิน 2MB</small>
                </div>
            </div>

        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-group has-label">
                        <label>ลำดับการโชว์</label>
                        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $data->sort_order ?? 0) }}" />
                        <small class="text-muted">เลขน้อย = โชว์ก่อน</small>
                    </div>
                    <div class="form-group has-label">
                        <label>
                            <input type="checkbox" name="is_featured" value="1" @if(!empty($data->is_featured) && $data->is_featured == 1) checked @endif>
                            การ์ดเด่น (เส้นขอบสีน้ำเงิน)
                        </label>
                    </div>
                    <div class="form-group has-label">
                        <label>
                            <input type="checkbox" name="status" value="1" @if(empty($data->id) || $data->status == 1) checked @endif>
                            เปิดใช้งาน (โชว์บนหน้าแรก)
                        </label>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">บันทึก</button>
                    <a href="{{ route('productcategory.index') }}" class="btn btn-secondary btn-block">ยกเลิก</a>
                </div>
            </div>
            @if(!empty($data->updated_by))
            <div class="card">
                <div class="card-body">
                    <small>อัพเดตข้อมูลโดย :: {{ $data->updated_by }} :: {{ $data->updated_at }}</small>
                </div>
            </div>
            @endif
        </div>
    </div>
</form>

@endsection
