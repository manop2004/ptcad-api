<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <table data-url="{{ route('product.spec.json', $id)}}" id="datatable_spec" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 230px" class="disabled-sorting">ข้อมูลสเปกสินค้า</th>
                        <th class="disabled-sorting text-right"></th>
                        <th style="width: 50px" class="disabled-sorting text-right"></th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        {{
            Form::open([
                'novalidate',
                'route' => 'product.spec.crate',
                'id'=>'data-form',
                'method' => 'post',
                'files' => true
            ])
        }}
            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        ข้อมูลสเปกสินค้า
                    </div>
                    <div class="form-group">
                        <label>หัวข้อ <span class="text-danger">*</span></label>
                        <input class="form-control" id="spec_name" name="spec_name"  />
                        <input type="hidden" id="spec_proId" name="spec_proId" value="@if(!empty($id)){{ $id }}@endif" />
                        @error('spec_name')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>รายละเอียด/คำอธิบาย </label>
                        <textarea class="form-control" id="spec_detail" name="spec_detail" ></textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <a data-toggle="modal" data-target="#deleteSpecAll" onclick="deleteModal3(this)" href="#" data-id="{{ $id }}" data-name="ลบข้อมูลสเปกสินค้าทั้งหมด">@include('layouts.admin._button.deleteAll')</a>
                            </div>
                            <div class="col-6">@include('layouts.admin._button.submit')</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>