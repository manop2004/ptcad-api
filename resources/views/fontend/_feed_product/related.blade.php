@foreach ($data['pro_related'] as $related)
    <div class="clearfix related_product hidden-md hidden-sm hidden-xs">
        <div class="product_img">
            <a href="{{ route('fronend.product.content',['permalink'=>$related['permalink']]) }}">
            @isset($related['picture'])
                <img width="150" height="150" class="lazyload" loading="lazy" data-src="{{ asset('storage/product/'.$related['picture']) }}" alt="{{ $related['name'] }}" >
            @else
                <img width="150" height="150" class="lazyload" loading="lazy" data-src="{{ asset('images/default-img/no-img.jpg')}}" alt="{{ $related['name'] }}" >
            @endisset
            </a>
        </div>
        <div class="product_title">
            <a href="{{ route('fronend.product.content',['permalink'=>$related['permalink']]) }}">{{ $related['name'] }}</a>
        </div>
        <div class="product_price">{!! $related['price'] !!}</div>
        <div class="product_title_sub">ราคาไม่รวม VAT</div>
        <div class="product_button">
            @if ($related['contactSale'] == 1)
                <button id="b-quotation" class="button-cart"> ติดต่อสอบถามราคา </button>
            @else
                @if ($related['option'] == 1)
                    @if ($related['display'] == 1)
                        <button id="b-quotation" class="button-cart choose">
                            <img width="30" height="25" class="lazyload" loading="lazy" data-src="{{ asset('icon/ecom/document.png')}}" alt="quotation" > <span>ขอใบเสนอราคา</span>
                        </button>
                    @else
                        <button id="b-cart" class="button-cart choose b-cart-one" data-id="{{ $related['proId'] }}"></button>
                    @endif
                @else
                    <a href="{{ route('fronend.product.content',['permalink'=>$related['permalink']]) }}">
                        <button id="b-cart" class="button-model choose"></button>
                    </a>
                @endif
            @endif
        </div>
    </div>
@endforeach
<div id="oc-clients-full" class="owl-carousel owl-carousel-full image-carousel carousel-widget clearfix hidden-lg" data-margin="20" data-loop="false" data-nav="false" data-autoplay="5000" data-loop="true" data-pagi="true" data-items-xxs="1" data-items-xs="1" data-items-sm="1" data-items-md="3" data-items-lg="3">
    @foreach ($data['pro_related'] as $related_clients)
        <div class="oc-item">
            <div class="clearfix related_product">
                <div class="product_img">
                    <a href="{{ route('fronend.product.content',['permalink'=>$related_clients['permalink']]) }}">
                    @isset($related_clients['picture'])
                        <img width="150" height="150" class="lazyload" loading="lazy" data-src="{{ asset('storage/product/'.$related_clients['picture']) }}" alt="{{ $related_clients['name'] }}" >
                    @else
                        <img width="150" height="150" class="lazyload" loading="lazy" data-src="{{ asset('images/default-img/no-img.jpg')}}" alt="{{ $related_clients['name'] }}" >
                    @endisset
                    </a>
                </div>
                <div class="product_title">
                    <a href="{{ route('fronend.product.content',['permalink'=>$related_clients['permalink']]) }}">{{ $related_clients['name'] }}</a>
                </div>
                <div class="product_price">{!! $related_clients['price'] !!}</div>
                <div class="product_title_sub">ราคาไม่รวม VAT</div>
                <div class="product_button">
                    @if ($related_clients['contactSale'] == 1)
                        <button id="b-quotation" class="button-cart"> ติดต่อสอบถามราคา </button>
                    @else
                        @if ($related_clients['option'] == 1)
                            @if ($related_clients['display'] == 1)
                            <button id="b-quotation" class="button-model choose"></button>
                            @else
                                <button id="b-cart" class="button-cart choose b-cart-one" data-id="{{ $related_clients['proId'] }}"></button>
                            @endif
                        @else
                            <a href="{{ route('fronend.product.content',['permalink'=>$related_clients['permalink']]) }}">
                                <button id="b-cart" class="button-model choose"></button>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
