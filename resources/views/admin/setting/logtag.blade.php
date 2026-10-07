@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<link href="{{ asset('vendor/Bootstrap-4-Tag-Input/tagsinput.css') }}" rel="stylesheet">

@endsection

@section('content')

    @if(!empty($logtags))
        {{
            Form::model($logtags,[
                'novalidate',
                'route' => ['setting.logtagUpdate'],
                'id'=>'data-form',
                'method' => 'put',
                'files' => true
            ])
        }}

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <input data-role="tagsinput"  type="text" name="logTag" id="logTag" class="form-control" value="{{ $tag }}"/>
                            @if(!empty($logtags->updated_by))
                            <div class="line"></div>
                            <div class="form-group has-label">
                                <label>อัพเดตข้อมูลโดย :: {{ $logtags->updated_by}} :: {{ $logtags->updated_at}} </label>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-footer">
                            <div class="right">
                                @include('layouts.admin._button.submit')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @else

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                       <br/>
                       <br/>
                       <h4>ไม่พบข้อมูล</h4>
                       <br/>
                       <br/>
                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection


@section('js')

<script src="{{ asset('assets/backend/js/plugins/bootstrap-tagsinput.js') }}"></script>

<script>

</script>
@endsection
