<div class="card">
    <div class="card-header">
      <h5>รายละเอียดสินค้า</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="nav-tabs-navigation verical-navs">
                    <div class="nav-tabs-wrapper">
                    <ul class="nav nav-tabs flex-column nav-stacked" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link active" href="#highlight" role="tab" data-toggle="tab">Highlight</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#contentpro" role="tab" data-toggle="tab">รายละเอียดสินค้า</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#feature" role="tab" data-toggle="tab">คุณสมบัติ</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#gift" role="tab" data-toggle="tab">ของแถมและสิทธิพิเศษ</a>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-md-8 nopadding-verical-navs">
                {{
                    Form::model($data, [
                        'novalidate',
                        'route' => ['product.update.content',[$data->id]],
                        'id'=>'data-form',
                        'method' => 'put',
                        'files' => true
                    ])
                }}
                    <div class="tab-content">
                        <div class="tab-pane active" id="highlight">
                            <textarea id="editor_highlight" name="pro_highlight">@if(!empty($data->pro_highlight)){{ $data->pro_highlight }}@else{{ old('pro_highlight') }}@endif</textarea>
                        </div>
                        <div class="tab-pane" id="contentpro">
                            <textarea id="editor_contentpro" name="pro_content">@if(!empty($data->pro_content)){{ $data->pro_content }}@else{{ old('pro_content') }}@endif</textarea>
                        </div>
                        <div class="tab-pane" id="feature">
                            <textarea id="editor_feature" name="pro_feature">@if(!empty($data->pro_feature)){{ $data->pro_feature }}@else{{ old('pro_feature') }}@endif</textarea>
                        </div>
                        <div class="tab-pane" id="gift">
                            <textarea id="editor_gift" name="pro_gift">@if(!empty($data->pro_gift)){{ $data->pro_gift }}@else{{ old('pro_gift') }}@endif</textarea>
                        </div>
                    </div>
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
                </form>
            </div>
        </div>
    </div>
</div>