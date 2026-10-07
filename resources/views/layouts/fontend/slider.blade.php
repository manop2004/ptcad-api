<style>
  .custom-slider-wrap {
    position: relative;
    max-width: 100%;
    overflow: hidden;
	z-index: 0;
  }

  .custom-slider-container {
	  position: relative;
	  width: 100%;
	  height: auto;
	  aspect-ratio: 2048 / 587; /* สำหรับ desktop */
	}

  .custom-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    opacity: 0;
    transition: opacity 2s ease-in-out;
    z-index: 0;
  }

  .custom-slide img {
    width: 100%;
    height: auto;
    display: block;
    max-height: 587px;
  }

  .custom-slide.active {
    opacity: 1;
    z-index: 1;
  }

  .custom-mobile-slide {
    display: none;
  }

  @media (max-width: 768px) {
    .custom-desktop-slide {
      display: none;
    }

    .custom-mobile-slide img {
      max-height: 1050px;
    }

    .custom-mobile-slide {
      display: block;
    }

    .custom-desktop-slide {
      display: none !important;
    }
	
	.custom-slider-container {
		aspect-ratio: 900 / 1050; /* สำหรับ mobile */
	  }
  }

  .custom-prev-btn, .custom-next-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0,0,0,0.5);
    border: none;
    color: white;
    padding: 12px;
    cursor: pointer;
    z-index: 10;
  }

  .custom-prev-btn {
    left: 10px;
  }

  .custom-next-btn {
    right: 10px;
  }

  .custom-pagination {
    text-align: center;
    margin-top: 10px;
  }

  .custom-pagination span {
    display: inline-block;
    height: 12px;
    width: 12px;
    margin: 0 4px;
    background-color: #ccc;
    border-radius: 50%;
    cursor: pointer;
  }

  .custom-pagination .active {
    background-color: #00ae69;
  }
</style>

<div class="custom-slider-wrap">
	<div class="custom-slider-container">
		<!-- Slide Desktop -->
		@php
			$banners_desktop = App\Models\TbBanner::where('banner_show',1)->orderBy('banner_sort','desc')->get();
			$dateToday = date('Y-m-d');
		@endphp
		@if(!empty($banners_desktop))
			@foreach ($banners_desktop as $banner_dt )
				@if (!empty($banner_dt->banner_start_date) && !empty($banner_dt->banner_end_date))

					@php
						$startdate = compareDate($dateToday, $banner_dt->banner_start_date);
						$enddate = compareDate($dateToday, $banner_dt->banner_end_date);
					@endphp

					@if ($startdate != 2 && $enddate != 0)
						<div class="custom-slide custom-desktop-slide">
							@if(!empty($banner_dt->banner_link))
								<a href="{{ $banner_dt->banner_link }}">
							@endif
								<img src="{{ asset('storage/banner/'.$banner_dt->banner_img_desktop) }}" alt="{{ $banner_dt->banner_note }}">
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
						<div class="custom-slide custom-desktop-slide">
							@if(!empty($banner_dt->banner_link))
								<a href="{{ $banner_dt->banner_link }}">
							@endif
								<img src="{{ asset('storage/banner/'.$banner_dt->banner_img_desktop) }}" alt="{{ $banner_dt->banner_note }}">
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
						<div class="custom-slide custom-desktop-slide">
							@if(!empty($banner_dt->banner_link))
								<a href="{{ $banner_dt->banner_link }}">
							@endif
								<img src="{{ asset('storage/banner/'.$banner_dt->banner_img_desktop) }}" alt="{{ $banner_dt->banner_note }}">
							@if(!empty($banner_dt->banner_link))
								</a>
							@endif
						</div>
					@endif
				@else
						<div class="custom-slide custom-desktop-slide">
							@if(!empty($banner_dt->banner_link))
								<a href="{{ $banner_dt->banner_link }}">
							@endif
								<img src="{{ asset('storage/banner/'.$banner_dt->banner_img_desktop) }}" alt="{{ $banner_dt->banner_note }}">
							@if(!empty($banner_dt->banner_link))
								</a>
							@endif
						</div>
				@endif
			@endforeach
		@endif
		

		<!-- Slide Mobile -->
		@foreach ($banners_desktop as $banner_dt )
			@if (!empty($banner_dt->banner_start_date) && !empty($banner_dt->banner_end_date))

				@php
					$startdate = compareDate($dateToday, $banner_dt->banner_start_date);
					$enddate = compareDate($dateToday, $banner_dt->banner_end_date);
				@endphp

				@if ($startdate != 2 && $enddate != 0)
					<div class="custom-slide custom-mobile-slide">
						@if(!empty($banner_dt->banner_link))
							<a href="{{ $banner_dt->banner_link }}">
						@endif
							<img src="{{ asset('storage/banner/'.$banner_dt->banner_img_mobile) }}" alt="{{ $banner_dt->banner_note }}">
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
					<div class="custom-slide custom-mobile-slide">
						@if(!empty($banner_dt->banner_link))
							<a href="{{ $banner_dt->banner_link }}">
						@endif
							<img src="{{ asset('storage/banner/'.$banner_dt->banner_img_mobile) }}" alt="{{ $banner_dt->banner_note }}">
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
					<div class="custom-slide custom-mobile-slide">
						@if(!empty($banner_dt->banner_link))
							<a href="{{ $banner_dt->banner_link }}">
						@endif
							<img src="{{ asset('storage/banner/'.$banner_dt->banner_img_mobile) }}" alt="{{ $banner_dt->banner_note }}">
						@if(!empty($banner_dt->banner_link))
							</a>
						@endif
					</div>
				@endif
			@else
					<div class="custom-slide custom-mobile-slide">
						@if(!empty($banner_dt->banner_link))
							<a href="{{ $banner_dt->banner_link }}">
						@endif
							<img src="{{ asset('storage/banner/'.$banner_dt->banner_img_mobile) }}" alt="{{ $banner_dt->banner_note }}">
						@if(!empty($banner_dt->banner_link))
							</a>
						@endif
					</div>
			@endif

		@endforeach

		<!-- Navigation Buttons -->
		<button class="custom-prev-btn">&#10094;</button>
		<button class="custom-next-btn">&#10095;</button>
	</div>
	<div class="custom-pagination" id="custom-pagination"></div>
</div>

<script>
  let customSlideIndex = 0;
  let customSlides, customDots, isCustomMobile = false;
  let customSlideInterval;

  function initCustomSlider() {
    isCustomMobile = window.innerWidth <= 768;
    customSlides = document.querySelectorAll(isCustomMobile ? ".custom-mobile-slide" : ".custom-desktop-slide");

    customSlides.forEach(slide => slide.classList.remove("active"));
    if (customSlides.length > 0) customSlides[0].classList.add("active");

    customSlideIndex = 0;
    createCustomPagination();
    clearInterval(customSlideInterval);
    customSlideInterval = setInterval(() => {
      nextCustomSlide(1);
    }, 10000);
  }

  function showCustomSlide(n) {
    if (!customSlides.length) return;

    customSlides.forEach((slide, i) => {
      slide.classList.toggle("active", i === n);
    });

    customDots?.forEach((dot, i) => {
      dot.classList.toggle("active", i === n);
    });
  }

  function nextCustomSlide(n = 1) {
    customSlideIndex = (customSlideIndex + n + customSlides.length) % customSlides.length;
    showCustomSlide(customSlideIndex);
  }

  function goToCustomSlide(n) {
    customSlideIndex = n;
    showCustomSlide(customSlideIndex);
  }

  function createCustomPagination() {
    const pag = document.getElementById("custom-pagination");
    pag.innerHTML = "";
    customDots = [];

    for (let i = 0; i < customSlides.length; i++) {
      const dot = document.createElement("span");
      dot.addEventListener("click", () => goToCustomSlide(i));
      pag.appendChild(dot);
      customDots.push(dot);
    }

    customDots[customSlideIndex].classList.add("active");
  }

  document.querySelector(".custom-prev-btn").addEventListener("click", () => nextCustomSlide(-1));
  document.querySelector(".custom-next-btn").addEventListener("click", () => nextCustomSlide(1));

  window.addEventListener("load", initCustomSlider);
  window.addEventListener("resize", () => {
    if ((window.innerWidth <= 768) !== isCustomMobile) {
      initCustomSlider();
    }
  });
</script>
