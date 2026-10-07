<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>จังหวัด <span class="text-danger">*</span></label>
            <select id="province" name="province" data-placeholder="กรุณาเลือกจังหวัด" class="form-control" onchange="amphuresChange()">
                <option></option>
                @foreach ( $provinces as $province)
                    <option value="{{ $province->id }}" @if(!empty($data->province)) @if($data->province == $province->id ) selected @endif @else @if(old('province') == $province->id ) selected @endif @endif>{{ $province->prov_name_th  }}</option>
                @endforeach
            </select>
            @error('province')<small class="error-danger-text">{{ $message }}</small> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>เขต/อำเภอ <span class="text-danger">*</span></label>
            <select id="amphures" name="amphures" data-placeholder="กรุณาเลือกเขต/อำเภอ" class="form-control" onchange="districtChange()">
                <option></option>
            </select>
            @error('amphures')<small class="error-danger-text">{{ $message }}</small> @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>แขวง / ตำบล <span class="text-danger">*</span></label>
            <select id="district" name="district" data-placeholder="กรุณาเลือกแขวง / ตำบล" class="form-control" onchange="zipcodeChange()">
                <option></option>
            </select>
            @error('district')<small class="error-danger-text">{{ $message }}</small> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>รหัสไปรษณีย์ <span class="text-danger">*</span></label>
            <input id="zipcode" name="zipcode" placeholder="กรุณากรอกรหัสไปรษณีย์" class="form-control" value="" />
            @error('zipcode')<small class="error-danger-text">{{ $message }}</small> @enderror
        </div>
    </div>
</div>