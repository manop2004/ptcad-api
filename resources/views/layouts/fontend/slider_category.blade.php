@php
    $banners_desktop = App\Models\TbBanner::where('banner_show',1)->where('banner_link',$_SERVER["REQUEST_URI"])->whereDate('banner_start_date', '<=', now())->whereDate('banner_end_date', '>=', now())->orderBy('banner_sort','desc')->get();
    $dateToday = date('Y-m-d');
@endphp
@if(!empty($banners_desktop))
	@if(isset($banners_desktop[0]))
<section id="slider" class="slider-desktop bottommargin-sm" data-autoplay="7000" data-speed="650" data-loop="true">
    <div class="clearfix">
        <div class="fslider" data-easing="easeInQuad">
            <div class="flexslider">
                <div class="slider-wrap">
                    @foreach ($banners_desktop as $banner_dt )
                        @if (!empty($banner_dt->banner_start_date) && !empty($banner_dt->banner_end_date))

                            @php
                                $startdate = compareDate($dateToday, $banner_dt->banner_start_date);
                                $enddate = compareDate($dateToday, $banner_dt->banner_end_date);
                            @endphp

                            @if ($startdate != 2 && $enddate != 0)
                                <div class="slide">
                                    @if(!empty($banner_dt->banner_link))
                                        <a href="{{ $banner_dt->banner_link }}">
                                    @endif
                                        <img width="1619" height="464" class="full-width lazyload"  src="{{ asset('storage/banner/'.$banner_dt->banner_img_desktop) }}" alt="Slide">
                                    @if(!empty($banner_dt->banner_link))
                                        </a>
                                    @endif
                                </div>
                            @endif

                        @elseif (!empty($banner_dt->banner_start_date) && empty($banner_dt->banner_end_date))

                            @php
                                $startdate = compareDate($dateToday, $banner_dt->banner_start_date);
                            @endphp

                            @if ($startdate != 2)
                                <div class="slide">
                                    @if(!empty($banner_dt->banner_link))
                                        <a href="{{ $banner_dt->banner_link }}">
                                    @endif
                                        <img width="1619" height="464" class="full-width lazyload"  data- src="{{ asset('storage/banner/'.$banner_dt->banner_img_desktop) }}" alt="Slide">
                                    @if(!empty($banner_dt->banner_link))
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @elseif (empty($banner_dt->banner_start_date) && !empty($banner_dt->banner_end_date))
                            @php
                                $enddate = compareDate($dateToday, $banner_dt->banner_end_date);
                            @endphp

                            @if ($enddate != 0)
                                <div class="slide">
                                    @if(!empty($banner_dt->banner_link))
                                        <a href="{{ $banner_dt->banner_link }}">
                                    @endif
                                        <img width="1619" height="464" class="full-width lazyload"  data- src="{{ asset('storage/banner/'.$banner_dt->banner_img_desktop) }}" alt="Slide">
                                    @if(!empty($banner_dt->banner_link))
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="slide">
                                @if(!empty($banner_dt->banner_link))
                                    <a href="{{ $banner_dt->banner_link }}">
                                @endif
                                    <img width="1619" height="464" class="full-width lazyload"  src="{{ asset('storage/banner/'.$banner_dt->banner_img_desktop) }}" alt="Slide">
                                @if(!empty($banner_dt->banner_link))
                                    </a>
                                @endif
                            </div>
                        @endif

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section id="slider" class="slider-mobile bottommargin-sm" data-autoplay="7000" data-speed="650" data-loop="true">
    <div class=" clearfix">
        <div class="fslider" data-easing="easeInQuad">
            <div class="flexslider">
                <div class="slider-wrap">
                    @foreach ($banners_desktop as $banner_dt )
                        @if (!empty($banner_dt->banner_start_date) && !empty($banner_dt->banner_end_date))

                            @php
                                $startdate = compareDate($dateToday, $banner_dt->banner_start_date);
                                $enddate = compareDate($dateToday, $banner_dt->banner_end_date);
                            @endphp

                            @if ($startdate != 2 && $enddate != 0)
                                <div class="slide">
                                    @if(!empty($banner_dt->banner_link))
                                        <a href="{{ $banner_dt->banner_link }}">
                                    @endif
                                        <img width="768" height="896" class="full-width lazyload"  src="{{ asset('storage/banner/'.$banner_dt->banner_img_mobile) }}" width="768" height="896" alt="Slide">
                                    @if(!empty($banner_dt->banner_link))
                                        </a>
                                    @endif
                                </div>
                            @endif

                        @elseif (!empty($banner_dt->banner_start_date) && empty($banner_dt->banner_end_date))

                            @php
                                $startdate = compareDate($dateToday, $banner_dt->banner_start_date);
                            @endphp

                            @if ($startdate != 2)
                                <div class="slide">
                                    @if(!empty($banner_dt->banner_link))
                                        <a href="{{ $banner_dt->banner_link }}">
                                    @endif
                                        <img width="768" height="896" class="full-width lazyload"  src="{{ asset('storage/banner/'.$banner_dt->banner_img_mobile) }}" width="768" height="896"  alt="Slide">
                                    @if(!empty($banner_dt->banner_link))
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @elseif (empty($banner_dt->banner_start_date) && !empty($banner_dt->banner_end_date))
                            @php
                                $enddate = compareDate($dateToday, $banner_dt->banner_end_date);
                            @endphp

                            @if ($enddate != 0)
                                <div class="slide">
                                    @if(!empty($banner_dt->banner_link))
                                        <a href="{{ $banner_dt->banner_link }}">
                                    @endif
                                        <img width="768" height="896" class="full-width lazyload"  src="{{ asset('storage/banner/'.$banner_dt->banner_img_mobile) }}" width="768" height="896"  alt="Slide">
                                    @if(!empty($banner_dt->banner_link))
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="slide">
                                @if(!empty($banner_dt->banner_link))
                                    <a href="{{ $banner_dt->banner_link }}">
                                @endif
                                    <img width="768" height="896" class="full-width lazyload"  src="{{ asset('storage/banner/'.$banner_dt->banner_img_mobile) }}" width="768" height="896"  alt="Slide">
                                @if(!empty($banner_dt->banner_link))
                                    </a>
                                @endif
                            </div>
                        @endif

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
	@endif
@endif
