@if (!empty($data->pro_option == 1))
{{-- สินค้ารูปแบบเดียว --}}

@if(empty($detail))
    {{
        Form::open([
            'novalidate',
            'route' => 'product.detail.crate',
            'id'=>'data-form',
            'method' => 'post',
            'files' => true
        ])
    }}
@else
    {{
        Form::model($detail, [
            'novalidate',
            'route' => ['product.detail.update',[$detail->id]],
            'id'=>'data-form',
            'method' => 'put',
            'files' => true
        ])
    }}
@endif

<div class="row">
    @include('admin.product.model-content.content')
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
    <div class="col-md-3"></div>
</div>
</form>
@else
{{-- สินค้าหลายรูปแบบ --}}

@include('admin.product.model-content.main')

@endif