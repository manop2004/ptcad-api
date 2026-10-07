@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

 <style>
    .jumbotron {
        padding: 1rem;
        margin-bottom: 1rem;
    }
 </style>

@endsection

@section('content')

{{
    Form::model($data, [
        'novalidate',
        'route' => ['setting.updateContact',$data->id],
        'id'=>'data-form',
        'method' => 'put',
        'files' => true
    ])
}}

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <strong class="mg-b-10">Tel Contact </strong>
                        <input class="form-control" id="setting_telContact" name="setting_telContact" value="@isset($data->setting_telContact){{ $data->setting_telContact }}@endisset" />
                        @error('setting_telContact')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <hr/>
                    <div class="form-group">
                        <strong class="mg-b-10">Hot Line Contact </strong>
                        <input class="form-control" id="setting_hotlineContact" name="setting_hotlineContact" value="@isset($data->setting_hotlineContact){{ $data->setting_hotlineContact }}@endisset" />
                        @error('setting_hotlineContact')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <hr/>
                    <div class="form-group">
                        <strong class="mg-b-10">Fax Contact </strong>
                        <input class="form-control" id="setting_faxContact" name="setting_faxContact" value="@isset($data->setting_faxContact){{ $data->setting_faxContact }}@endisset" />
                        @error('setting_faxContact')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <hr/>
                    <div class="form-group">
                        <strong class="mg-b-10">Email Contact </strong>
                        <input class="form-control" id="setting_emailContact" name="setting_emailContact" value="@isset($data->setting_emailContact){{ $data->setting_emailContact }}@endisset" placeholder="email@youremail.com" />
                        @error('setting_emailContact')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <hr/>
                    <div class="form-group">
                        <strong class="mg-b-10">LINK ID LINE </strong>
                        <input class="form-control" id="setting_idLine" name="setting_idLine" value="@isset($data->setting_idLine){{ $data->setting_idLine }}@endisset" placeholder="https://line.me/ti/p/~" />
                        @error('setting_idLine')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <hr/>
                    <div class="form-group">
                        <strong class="mg-b-10">ลิงก์ Remote (สำหรับปุ่ม "Remote" หน้าแรก) </strong>
                        <input class="form-control" id="setting_remoteLink" name="setting_remoteLink" value="@isset($data->setting_remoteLink){{ $data->setting_remoteLink }}@endisset" placeholder="https://..." />
                        @error('setting_remoteLink')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <strong class="mg-b-10">Link Youtube </strong>
                        <input class="form-control" id="setting_LinkYoutube" name="setting_LinkYoutube" value="@isset($data->setting_LinkYoutube){{ $data->setting_LinkYoutube }}@endisset" placeholder="https://www.youtube.com/yourpage" />
                        @error('setting_LinkYoutube')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <hr/>
                    <div class="form-group">
                        <strong class="mg-b-10">Link Twitter </strong>
                        <input class="form-control" id="setting_LinkTwitter" name="setting_LinkTwitter" value="@isset($data->setting_LinkTwitter){{ $data->setting_LinkTwitter }}@endisset" placeholder="https://twitter.com/yourpage" />
                        @error('setting_LinkTwitter')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <hr/>
                    <div class="form-group">
                        <strong class="mg-b-10">Link Instagram </strong>
                        <input class="form-control" id="setting_LinkInstagram" name="setting_LinkInstagram" value="@isset($data->setting_LinkInstagram){{ $data->setting_LinkInstagram }}@endisset" placeholder="https://www.instagram.com/yourpage"/>
                        @error('setting_LinkInstagram')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                    <hr/>
                    <div class="form-group">
                        <strong class="mg-b-10">Link Facebook </strong>
                        <input class="form-control" id="setting_LinkFacebook" name="setting_LinkFacebook" value="@isset($data->setting_LinkFacebook){{ $data->setting_LinkFacebook }}@endisset" placeholder="https://www.facebook.com/yourpage" />
                        @error('setting_LinkFacebook')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        ที่อยู่บริษัท
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="setting_address" name="setting_address" value="@isset($data->setting_address){{ $data->setting_address }}@endisset" />
                        @error('setting_address')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        เวลาทำการบริษัท
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="setting_companyTime" name="setting_companyTime" value="@isset($data->setting_companyTime){{ $data->setting_companyTime }}@endisset" />
                        @error('setting_companyTime')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        เวลาทำการช่องทางออนไลน์
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="setting_websiteTime" name="setting_websiteTime" value="@isset($data->setting_websiteTime){{ $data->setting_websiteTime }}@endisset" />
                        @error('setting_websiteTime')<small class="error-danger-text">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($data->updated_by))
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <label>อัพเดตข้อมูลโดย :: {{ $data->updated_by}} :: {{ $data->updated_at}} </label>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-12">
            <div class="card">
                <div class="card-footer">
                    <div class="right">
                        @include('layouts.admin._button.submit')
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection

@section('js')


@endsection