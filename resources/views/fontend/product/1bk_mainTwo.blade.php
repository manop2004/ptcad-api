@extends('layouts.temp_user')

@section('og_site_name'){{ $og_site_name }}@endsection
@section('og_keywords'){{ $og_keywords }}@endsection
@section('og_title'){{ $og_title }}@endsection
@section('title'){{ $og_title }} |@endsection
@section('og_description'){{ $og_description }}@endsection
@section('og_url'){{ $og_url }}@endsection
@section('og_image'){{ $og_image }}@endsection

@section('og:id')<meta property="product:id" content="{{ $data['pro_sku'] }}">@endsection
@section('product:brand')<meta property="product:brand" content="{{ $data['pro_brand'] }}">@endsection
@section('product:availability')<meta property="product:availability" content="{{ $data['availability'] }}">@endsection
@section('product:condition')<meta property="product:condition" content="new">@endsection
@section('product:price:amount')<meta property="product:price:amount" content="{{ $data['og_price'] }}">@endsection
@section('product:price:currency')<meta property="product:price:currency" content="THB">@endsection

@section('css')

@endsection

@section('content')

<section id="content">
    <div class="content-wrap">
        <div class="container">

            @if (!empty($breadcrumb))
            <section id="page-title" class="page-title-mini page-title-right">
                <div class="clearfix">
                    <ol class="breadcrumb">
                        @foreach ($breadcrumb as $index => $item)
                            @if($index !== count($breadcrumb) -1 )
                                <li><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
                            @else
                                <li class="active">{{ $item['name'] }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>

            </section>
            @endif
            <div id="page-product-content" class="topmargin-sm bottommargin-sm clearfix">
                <div class="col_three_fourth nobottommargin">
                    @if(!empty($data))
						<input type="hidden" id="detail_check_stock_status" value="{{ $data['detail_check_stock_status'] }}">
						<input type="hidden" id="detail_stock" value="{{ $data['detail_stock'] }}">
						<!-- <?php print_r($data); ?> -->
                        <div class="b-product-im">
                            <div id="b-img-show-p">
                                <div class="b-h-img @if (count($data['pro_image']) != 0 && count($data['pro_image']) != 1)hidden-sm hidden-xs @endif">
                                    <img id="preview-item" width="300" height="300" src="{{ $data['pro_cover'] }}" alt="product" class="zoom full-width" >
                                </div>
                                @if (count($data['pro_image']) != 0 && count($data['pro_image']) != 1)
                                    <div id="oc-clients-pictures" class="owl-carousel image-carousel topmargin-sm bottommargin-sm carousel-widget" data-margin="10" data-loop="false" data-nav="false"  data-pagi="true" data-items-xxs="1" data-items-xs="1" data-items-sm="1" data-items-md="4" data-items-lg="5">
                                        @foreach ($data['pro_image'] as $picture)
                                            <div class="oc-item">
                                                <img width="50" height="50" class="item-pic full-width" onclick="itemPic(this)" data-img="{{ $picture['images'] }}" src="{{ $picture['images'] }}" alt="{{ $picture['images'] }}">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h1 class="nobottommargin">{{ $data['pro_name'] }}</h1>
								@if(!empty($rating))
									@if(!empty($rating['avg_rating']))
								<div class="product-rating" id="product-rating">
									<span class="stars cursor-pointer">
										@php
											$fullStars = floor($rating['avg_rating']);
											$halfStar = ($rating['avg_rating'] - $fullStars) >= 0.5 ? 1 : 0;
											$emptyStars = 5 - ($fullStars + $halfStar);
										@endphp

										@for ($i = 0; $i < $fullStars; $i++)
											<i class="fas fa-star full-star"></i>
										@endfor
										
										@if ($halfStar)
											<i class="fas fa-star-half-alt half-star"></i>
										@endif
										
										@for ($i = 0; $i < $emptyStars; $i++)
											<i class="far fa-star empty-star"></i>
										@endfor
									</span>
									<span class="avg_rating-score cursor-pointer">
										<span class="rating-value">{{ number_format($rating['avg_rating'], 1) }}/5</span>
										({{ $rating['count_review'] }} รีวิว)
									</span>
								</div>
									@endif
								@endif
								
                                <div class="mini-head-sku">
                                    @if(!empty($data['pro_brand'])){{ $data['pro_brand'] }}@endif <span>@if(!empty($data['pro_sku'])) SKU : {{ $data['pro_sku'] }} @else SKU : -@endif</span>
                                </div>
                                <div class="mini-head-sub">
                                    <span class="btn btn_none_vat" >ราคาไม่รวม VAT</span>
                                    @if(!empty($data['detailStatus']))
                                        @if(!empty($data['detailStatus']->stu_name))
                                            <span class="btn btn_status_p" style="background-color: {{ $data['detailStatus']->stu_color }}">
                                                {{ $data['detailStatus']->stu_name }} @if($data['detailStatus']->stu_preorder == 1) @if(!empty($data['detailStatus']->detail_preorder_day)) ({{ $data['detailStatus']->detail_preorder_day }} วัน) @endif @endif
                                            </span>
                                        @endif
                                    @endif
                                    @if (Route::has('administrator'))
                                        @auth
                                            @php
                                                $UserLevel = App\Models\UsersLevel::select('l_product_Action','UserId')->where('UserId',Auth::user()->id)->value('l_product_Action');
                                                if($UserLevel == 1){
                                                    echo '<a href="'.route('product.edit',['tab'=>1,'id' => $data['pro_id']]).'"><span class="btn btn_edit"><i class="icon-edit"></i>  แก้ไขสินค้า</span></a>';
                                                }
                                            @endphp
                                        @endauth
                                    @endif
                                </div>
                                <div class="topmargin-sm clearfix border-bottom" >
                                    <input id="local-favourite" type="hidden"  value="{{ $data['pro_id'] }}" />
                                    <button id="b-favorite" class="button-favorite add-favorite choose" data-price='{!! $data['detailPrice'] !!}' data-id="{{ $data['pro_id'] }}" data-name="{{ $data['pro_name'] }}" data-img="{{ $data['pro_cover'] }}" data-parmalink="{{ route('fronend.product.content',$data['pro_permalink']) }}">
                                        <img width="30" height="25" class="lazyload"  src="{{ asset('icon/ecom/heart2.webp')}}" alt="favorite" > <span>เพิ่มเป็นรายการโปรด</span>
                                    </button>
                                    <button id="n-favorite" class="button-favorite remove-favorite choose hidden" data-id="{{ $data['pro_id'] }}">
                                        <img width="30" height="25" class="lazyload"  src="{{ asset('icon/ecom/heart1.webp')}}" alt="favorite" > <span>รายการโปรด</span>
                                    </button>
                                    <div id="share-p" class="share">
                                        <span><img width="20" height="22" class="lazyload"  src="{{ asset('icon/icon-ionic-md-share.webp') }}" alt="share"> แบ่งปัน</span>
                                        <a href="http://www.facebook.com/sharer.php?u={{ route('fronend.article.content',$data['pro_permalink']) }}" target="_blank" class="social-icon si-small si-colored si-rounded si-facebook">
                                            <i class="icon-facebook"></i>
                                            <i class="icon-facebook"></i>
                                        </a>
                                        <a href="http://twitter.com/share?url={{ route('fronend.article.content',$data['pro_permalink']) }}" target="_blank" class="social-icon si-small si-colored si-rounded si-twitter">
                                            <i class="icon-twitter"></i>
                                            <i class="icon-twitter"></i>
                                        </a>
                                        <a href="https://social-plugins.line.me/lineit/share?url={{ route('fronend.article.content',$data['pro_permalink']) }}" target="_blank" class="social-icon si-small si-colored si-rounded si-ebay">
                                            <i><img width="30" height="30" class="lazyload"  src="{{ asset('icon/social/icon-line-covered.webp') }}" alt="line"></i>
                                            <i><img width="30" height="30" class="lazyload"  src="{{ asset('icon/social/icon-line-covered.webp') }}" alt="line"></i>
                                        </a>
                                    </div>
                                </div>
                                @if(!empty($data['pro_highlight']))<div class="highlight-p clearfix">{!! $data['pro_highlight'] !!}</div>@endif
                                <div class="main-price topmargin-sm bottommargin-sm relative clearfix">
                                    <h1 class="nobottommargin">{!! $data['detailPriceCover'] !!}</h1>
                                    @if(!empty($data['proInstallment']))
                                        <img data-toggle="modal" data-target="#installment" width="" height="" class=" lazyload btn_installment"  src="{{ asset('storage/condition/'.$data['proInstallment']->condition_img) }}" alt="{{ $data['proInstallment']->condition_name }}">
                                    @endif
                                </div>
                                <div class="topmargin-sm option-product clearfix">
                                    <div class="option-product-title">โปรดเลือกประเภทที่ต้องการสั่งซื้อ</div>
                                    <div class="option-product-input">
                                        <span class="option-product-subtitle"><strong>ตัวเลือก:</strong></span>
                                        @if($data['checkOption'] == 2)
                                            <div>
                                                @foreach ($data['proDetail'] as $detail)
                                                    <input type="button" class="btn btn-option option-{{ $detail['id'] }}" name="option_select" id="option_select_{{ $detail['id'] }}" data-id="{{ $detail['id'] }}" value="{{ $detail['name'] }}"  />
                                                @endforeach
                                            </div>
                                        @else
                                            <div>
                                                <select id="option_select" name="option_select" class="sm-form-control">
                                                    @foreach ($data['proDetail'] as $detail)
                                                        <option value="{{ $detail['id'] }}">{{ $detail['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="option-product-input">
                                        @if(!empty($data['detailOther']))
                                            <span class="option-product-subtitle"><strong>รายละเอียด:</strong></span>
                                            <div id="option-product-detailOther">{{ $data['detailOther'] }}</div>
                                        @else
                                            <span class="option-product-subtitle"><strong>รายละเอียด:</strong></span>
                                            <div id="option-product-detailOther">{{ $data['detailName'] }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="clearfix main-btn-quantity topmargin-sm">
                                    <div class="b-quantity">
                                        <span>จำนวน:</span>
                                        <div class="quantity clearfix">
                                            <input type="button" value="-" class="minus">
                                            <input type="text" id="quantity" name="quantity" value="1" class="qty">
                                            <input type="button" value="+" class="plus">
                                        </div>
                                    </div>
                                </div>
								<div id="div_alert_stock" style="display: none;">
                                    <span class="text-danger">คุณได้เพิ่มสินค้าครบตามจำนวนสต็อกแล้ว</span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="main-btn-product">
									<input type="hidden" id="ref" name="ref" @if (!empty($_GET['ref'])) value="{{ $_GET['ref'] }}" @else value="" @endif>
                                    @if ($data['detailContact'] == 2)
                                        <input id="p_id" name="p_id" type="hidden" value="{{ $data['pro_id'] }}" />
                                        <input id="p_option" name="p_option" type="hidden" value="{{ $data['checkOption'] }}" />
                                        <input id="p_id_d" name="p_id_d" type="hidden" value="{{ $data['detailId'] }}" />
                                        <button id="b-cart" class="button-cart choose b-carttwo" @if ($data['detailStatus'] == 1) style="display:none" @endif></button>
                                        @if($quotationSetting == 1)
                                            <form action="{{ route('fronend.quotation') }}" method="get" class="no-mg">
                                                <input type="hidden" id="_productId" name="productId" value="{{ $data['pro_id'] }}" />
                                                <input type="hidden" id="_productSku" name="productSku" value="{{ $data['detailSku'] }}" />
                                                <input type="hidden" id="_productUnit" name="productUnit" value="1" />
                                                <input type="hidden" id="_ref" name="_ref" @if (!empty($_GET['ref'])) value="{{ $_GET['ref'] }}" @else value="" @endif>
                                                <button id="b-quotation" class="button-quotation choose" type="submit"></button>
                                            </form>
                                        @endif
                                    @else
                                        @if($quotationSetting == 1)
                                            <form action="{{ route('fronend.quotation') }}" method="get" class="no-mg">
                                                <input type="hidden" id="_productId" name="productId" value="{{ $data['pro_id'] }}" />
                                                <input type="hidden" id="_productSku" name="productSku" value="{{ $data['detailSku'] }}" />
                                                <input type="hidden" id="_productUnit" name="productUnit" value="1" />
                                                <input type="hidden" id="_ref" name="_ref" @if (!empty($_GET['ref'])) value="{{ $_GET['ref'] }}" @else value="" @endif>
                                                <button id="b-quotation" class="button-salecontact choose" type="submit"></button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
								<?php
								/*
								<div class="clearfix">
									<center><a href="https://line.me/ti/p/%408BAHT" target="_blank"><img height="100" class="lazyload"  src="{{ asset('assets/fontend/images/button-line.gif') }}" alt="ขอราคา {{ $data['pro_name'] }}"></a></center>
								</div>
								*/
								?>
                                <div class="clearfix"></div>
                            </div>
                        </div>
						
						@php
							if($og_keywords && $og_keywords != 'ไม่พบข้อมูล'){
								$arr_keywords = array();
								if(strpos($og_keywords,',') !== FALSE){
									$arr_keywords = explode(',', $og_keywords);
								}else{
									$arr_keywords[] = $og_keywords;
								}
							}
						@endphp
						
						@if(!empty($arr_keywords))
						<div class="topmargin-sm">
							หมวดหมู่ : 
							@foreach($arr_keywords as $tag)
							<a href="/search?search={{ trim($tag) }}"><button type="button" class="btn btn-sm btn-tag">{{ $tag }}</button></a>
							@endforeach
						</div>
						@endif
						
                        @if(!empty($data['pro_codition']) || !empty($data['pro_download']))
                            <div class="b-product-service topmargin-sm">
                                <div class="flex-condition-p">
                                    @if(count($data['pro_codition']) != 0)
                                        @foreach ($data['pro_codition'] as $item)
                                            <div class="condition-p">
                                                <img width="30" height="30" class="lazyload"  src="{{ asset('storage/condition/'.$item['img']) }}" alt="{{ $item['name'] }}">
                                                <div class="display-center">
                                                    {{ $item['name'] }}
                                                    <span>{{ $item['des'] }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if(!empty($data['pro_download']))
                                    <div class="condition-p">
                                        <a href="{{ asset('storage/product_dowloads/'.$data['pro_download']) }}" download><img width="27" height="27" class="lazyload"  src="{{ asset('icon/icon-dowload.png') }}" alt="dowload"></a>
                                        <div class="display-center"><a href="{{ asset('storage/product_dowloads/'.$data['pro_download']) }}" download>ดาวน์โหลดโบว์ชัวร์</a></div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <hr/>
                        @endif
                        <div class="tabs clearfix b-product-detail topmargin-sm nobottommargin">
                            <ul class="tab-nav tab-nav2 clearfix hidden-xs">
                                @if(!empty($data['pro_content']))<li><a href="#tabs-pro_content">รายละเอียดสินค้า</a></li>@endif
                                @if(!empty($data['pro_specification']))<li><a href="#tabs-pro_spec">สเปกสินค้า</a></li>@endif
                                @if(!empty($data['pro_feature']))<li><a href="#tabs-pro_feature">คุณสมบัติ</a></li>@endif
                                @if(!empty($data['pro_gift']))<li><a href="#tabs-pro_gift">ของแถมและสิทธิอื่นๆ</a></li>@endif
								<li><a href="#tabs-pro_reviews">รีวิวจากผู้ใช้งาน</a></li>
							</ul>
                            <select class="sm-form-control hidden-sm hidden-md hidden-lg" id="change_tab">
                                @if(!empty($data['pro_content']))<option value="tabs-pro_content">รายละเอียดสินค้า</option>@endif
                                @if(!empty($data['pro_specification']))<option value="tabs-pro_spec">สเปกสินค้า</option>@endif
                                @if(!empty($data['pro_feature']))<option value="tabs-pro_feature">คุณสมบัติ</option>@endif
                                @if(!empty($data['pro_gift']))<option value="tabs-pro_gift">ของแถมและสิทธิอื่น ๆ</option>@endif
								<option value="tabs-pro_reviews">รีวิวจากผู้ใช้งาน</option>
							</select>
                            <div class="tab-container">
                                @if(!empty($data['pro_content']))<div class="tab-content select-tab clearfix entry-content" id="tabs-pro_content">{!! $data['pro_content'] !!}</div>@endif
                                @if(!empty($data['pro_specification']))
                                    <div class="tab-content select-tab clearfix" id="tabs-pro_spec">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                    @foreach ($data['pro_specification'] as $spec)
                                                    <tr>
                                                        <td class="table-head">{{ $spec['spec_name']}}</td>

                                                        <td class="table-detail"><div>{!!  $spec['spec_detail'] !!}</div></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($data['pro_feature']))<div class="tab-content select-tab clearfix entry-content" id="tabs-pro_feature">{!! $data['pro_feature'] !!}</div>@endif
                                @if(!empty($data['pro_gift']))<div class="tab-content select-tab clearfix entry-content" id="tabs-pro_gift">{!! $data['pro_gift'] !!}</div>@endif
                            
								<div class="tab-content select-tab clearfix entry-content" id="tabs-pro_reviews">
									
									@if(!empty($rating) && !empty($rating['avg_rating']))
										<div class="review-summary">
											<div class="rating-score">
												<h2>{{ number_format($rating['avg_rating'], 1) }} / 5</h2>
												<div class="stars">
													@php
														$fullStars = floor($rating['avg_rating']);
														$halfStar = ($rating['avg_rating'] - $fullStars) >= 0.5 ? 1 : 0;
														$emptyStars = 5 - ($fullStars + $halfStar);
													@endphp
													@for ($i = 0; $i < $fullStars; $i++)
														<i class="fas fa-star full-star"></i>
													@endfor
													@if ($halfStar)
														<i class="fas fa-star-half-alt half-star"></i>
													@endif
													@for ($i = 0; $i < $emptyStars; $i++)
														<i class="far fa-star empty-star"></i>
													@endfor
												</div>
												<p>จาก {{ $rating['count_review'] }} รีวิว</p>
											</div>

											<div class="review-distribution">
												@php
													$totalReviews = $rating['count_review'];
													$ratingsBreakdown = [5 => $rating['count_5']
																		, 4 => $rating['count_4']
																		, 3 => $rating['count_3']
																		, 2 => $rating['count_2'],
																		1 => $rating['count_1']];
												@endphp

												@foreach ($ratingsBreakdown as $star => $count)
													<div class="review-bar">
														<span>{{ $star }} ดาว</span>
														<div class="bar">
															<div class="fill" style="width: {{ ($count / $totalReviews) * 100 }}%;"></div>
														</div>
														<span>{{ $count }}</span>
													</div>
												@endforeach
											</div>
										</div>
									@endif
									
									@if(!empty($reviews) && count($reviews) > 0)
										<div id="review-comment">
											@foreach ($reviews as $review)
												<div class="review-item card shadow-sm p-3 mb-3">
													<div class="review-header d-flex justify-content-between">
														<strong>{{ mb_substr($review->name, 0, 1) }}{{ str_repeat('*', mb_strlen($review->name) - 1) }} 
															{{ mb_substr($review->lastname, 0, 1) }}{{ str_repeat('*', mb_strlen($review->lastname) - 1) }}
														</strong>
														<small class="review-date text-muted">({{ $review->created_at->diffForHumans() }})</small>
													</div>
													
													<div class="review-stars">
														@for ($i = 0; $i < $review->rating; $i++)
															<i class="fas fa-star full-star text-warning"></i>
														@endfor
														@for ($i = $review->rating; $i < 5; $i++)
															<i class="far fa-star empty-star text-secondary"></i>
														@endfor
													</div>
													
													<p class="review-text">{{ $review->review_text }}</p>
													
													<!-- Video Section (Thumbnail & Popup) -->
													<div class="review-media d-flex flex-wrap">
													@if(!empty($review->video_url))
														<div class="review-video">
															<a href="#" data-toggle="modal" data-target="#videoModal-{{ $review->id }}" class="video-wrapper">
																<video class="review-thumbnail" muted>
																	<source src="{{ asset('/'.$review->video_url) }}" type="video/mp4">
																	<source src="{{ asset('/'.$review->video_url) }}" type="video/ogg">
																	<source src="{{ asset('/'.$review->video_url) }}" type="video/webm">
																	วิดีโอไม่สามารถเล่นได้
																</video>
																<img src="{{ asset('/assets/fontend/images/icons/play-video.png') }}" alt="Play Video" class="play-icon">
															</a>
														</div>


														<!-- Video Popup Modal -->
														<div class="modal fade" id="videoModal-{{ $review->id }}" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog modal-dialog-centered">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																	</div>
																	<div class="modal-body text-center">
																		<video controls class="review-video-player">
																			<source src="{{ asset('/'.$review->video_url) }}" type="video/mp4">
																			<source src="{{ asset('/'.$review->video_url) }}" type="video/ogg">
																			<source src="{{ asset('/'.$review->video_url) }}" type="video/webm">
																			เบราว์เซอร์ของคุณไม่รองรับการเล่นวิดีโอ
																		</video>
																	</div>
																</div>
															</div>
														</div>
													@endif

													<!-- Image Section (Thumbnail & Popup) -->
													@if(!empty($review->image_url))
														<div class="review-images">
															<a href="#" data-toggle="modal" data-target="#imageModal-{{ $review->id }}">
																<img src="{{ asset('/'.$review->image_url) }}" alt="Review Image" class="img-thumbnail review-thumbnail">
															</a>
														</div>

														<!-- Image Modal -->
														<div class="modal fade" id="imageModal-{{ $review->id }}" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog modal-dialog-centered">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																	</div>
																	<div class="modal-body text-center">
																		<img src="{{ asset('/'.$review->image_url) }}" alt="Review Image" class="img-fluid">
																	</div>
																</div>
															</div>
														</div>
													@endif
													</div>
													
												</div>
											@endforeach

											<!-- Pagination -->
											<div class="review-pagination">
												{{ $reviews->appends(request()->except('page'))->links('vendor.pagination.custom') }}
											</div>
										</div>



									@else
										<div class="text-center">- ยังไม่มีรีวิว -</div>
									@endif
								</div>
							</div>
                        </div>
                    @else

                        <div class="clearfix topmargin-lg bottommargin-lg text-center">
                            <h2>ไม่พบรายการที่คุณค้นหา</h2>
                        </div>

                    @endif
                </div>
                <div class="col_one_fourth nobottommargin col_last">
                    <div class="sidebar-widgets-wrap text-center product-related">
                        <h2>สินค้าแนะนำ</h2>
                        @if (!empty($data['pro_related']))
                            @include('fontend._feed_product.related')
                        @else
                            <hr/>
                            <div class="topmargin-lg bottommargin-lg text-center">
                                <h4>ไม่พบข้อมูล</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.fontend.service')
    @if (!empty($data['proInstallment']))
        <div class="modal fade" id="installment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-body">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">การผ่อนชำระ</h4>
                        </div>
                        <div class="modal-body">
                            @foreach ($settingInstallment as $installment)
                            <div class="row b-installment">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                    <img width="42" height="42" class="lazyload"  src="{{ asset('storage/installment/'.$installment->installment_img) }}" alt="{{ $installment->installment_name }}">
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">{{ $installment->installment_name }}<br/><small>{{ $installment->installment_detail }}</small><br/><small>อัตราดอกเบี้ย <b style="color: red;">{{ $installment->interest_detail }}</b></small></div>
                            </div>
                            @endforeach
							<center style="color: red; font-size: 75%;">** อัตราดอกเบี้ยอาจมีการเปลี่ยนแปลงได้ ทั้งนี้ขึ้นอยู่กับโปรโมชั่นของธนาคารในแต่ละช่วง</center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
<div itemscope itemtype="http://schema.org/Product">
    <meta itemprop="brand" content="{{ $data['pro_brand'] }}">
    <meta itemprop="name" content="{{ $data['pro_name'] }}">
    <meta itemprop="description" content="{{ $data['pro_seo_detail'] }}">
    <meta itemprop="productID" content="{{ $data['pro_sku'] }}">
    <meta itemprop="url" content="{{ route('fronend.product.content',$data['pro_permalink']) }}">
    <meta itemprop="image" content="{{ asset('storage/product/'.$data['pro_cover']) }}">
    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
      <link itemprop="availability" href="http://schema.org/{{ $data['availability']}}">
      <link itemprop="itemCondition" href="http://schema.org/new">
      <meta itemprop="price" content="{{ $data['og_price'] }}">
      <meta itemprop="priceCurrency" content="THB">
    </div>
</div>
@endsection

@section('js')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v12.0&appId=1190234624660031&autoLogAppEvents=1" nonce="h8yjg5hD"></script>
<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
<script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"Product",
        "productID":"{{ $data['pro_sku'] }}",
        "name":"{{ $data['pro_name']}}",
        "description":"{{ $data['pro_seo_detail'] }}",
        "url":"{{ route('fronend.product.content',$data['pro_permalink']) }}",
        "image":"{{ $data['pro_cover'] }}",
        "brand":"{{ $data['pro_brand'] }}",
        "offers": [
            {
            "@type": "Offer",
            "price": "{{ $data['og_price'] }}",
            "priceCurrency": "THB",
            "itemCondition": "https://schema.org/new",
            "availability": "https://schema.org/{{ $data['availability'] }}"
            }
        ],
		"aggregateRating": {
			"@type": "AggregateRating",
			"ratingValue": "{{ number_format($rating['avg_rating']) }}",
			"reviewCount": "{{ number_format($rating['count_review']) }}"
		}
    }
</script>

@if(!empty($data['pro_brand']) && $data['pro_brand'] == 'Sketchup')
<!-- Facebook Pixel Code for Supplier (Sketchup) -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '<?php echo env('FACEBOOK_PIXEL_ID'); ?>');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo env('FACEBOOK_PIXEL_ID'); ?>&ev=PageView&noscript=1"/></noscript>
<!-- End Facebook Pixel Code for Supplier (Sketchup) --> 
@endif

<script>
/*
gtag("event", "view_item", {
	currency: "THB",
	value: "{{ $data['og_price'] }}",
	items: [
		{
			item_id: "{{ $data['pro_sku'] }}",
			item_name: "{{ $data['pro_name'] }}",
			item_brand: "{{ $data['pro_brand'] }}",
			price: "{{ $data['og_price'] }}",
			quantity: 1
		}
	]
});

fbq('track', 'ViewContent', {
	contents: [{id:"{{ $data['pro_sku'] }}",quantity:1,brand:"{{ $data['pro_brand'] }}",name:"{{ $data['pro_name'] }}",item_price:"{{ $data['og_price'] }}"}],
	content_type: "product",
	content_category: "{{ $data['pro_brand'] }}",
	content_name: "{{ $data['pro_name'] }}",
	currency: "THB",
	value: "{{ $data['og_price'] }}"
});

$("#b-cart").click(function(){
	
	var qty = $("#quantity").val();
	var og_price = "{{ $data['og_price'] }}";
	var totalPrice = qty*og_price;
	
	gtag("event", "add_to_cart", {
		currency: "THB",
		value: totalPrice,
		items: [
			{
				item_id: "{{ $data['pro_sku'] }}",
				item_name: "{{ $data['pro_name'] }}",
				item_brand: "{{ $data['pro_brand'] }}",
				price: og_price,
				quantity: qty
			}
		]
	});
	
	fbq('track', 'AddToCart', {
		contents: [{id:"{{ $data['pro_sku'] }}",quantity:qty,brand:"{{ $data['pro_brand'] }}",name:"{{ $data['pro_name'] }}",item_price:"{{ $data['og_price'] }}"}],
		content_type: "product",
		content_category: "{{ $data['pro_brand'] }}",
		content_name: "{{ $data['pro_name'] }}",
		currency: "THB",
		value: totalPrice
	});
	
});

$("#b-quotation").click(function(){
	
	var qty = $("#quantity").val();
	var og_price = "{{ $data['og_price'] }}";
	var totalPrice = qty*og_price;
	
	gtag("event", "add_to_quote", {
		currency: "THB",
		value: totalPrice,
		item_id: "{{ $data['pro_sku'] }}",
		item_name: "{{ $data['pro_name'] }}",
		item_brand: "{{ $data['pro_brand'] }}",
		price: og_price,
		quantity: qty
	});
	
});
*/
$(document).ready(function() {
	var products = @json($arr_sku_stock);

	function updateHiddenFields(selectedSku) {
		var product = products.find(p => p.sku === selectedSku);
		if (product) {
			$('#detail_check_stock_status').val(product.detail_check_stock_status ? product.detail_check_stock_status : 0);
			$('#detail_stock').val(product.detail_stock ? product.detail_stock : 0);
		} else {
			//$('#detail_check_stock_status').val(0);
			//$('#detail_stock').val(0);
		}
	}

	// Event handler for #option_select
	$("#option_select").change(function() {
		var selectedSku = $(this).val();
		$.ajax({
			dataType: "json",
			method: "get",
			url: "/api/jsonDetail",
			data: { detailId: selectedSku },
			cache: false,
			beforeSend: function () {},
			success: function (e) {
				$(".mini-head-sku span").html("SKU : " + e.sku);
				$(".mini-head-sub .btn_status_p").html(e.status);
				$(".main-price h1").html(e.price);
				$("#option-product-detailOther").html(e.detail);
				$("#_productSku").val(e.sku);
				for (var t = $(".mini-head-sub .btn_status_p"), a = 0; a < t.length; a++) {
					t[a].style.backgroundColor = e.background;
				}
				if (e.image.length != 0) {
					document.getElementById("preview-item").src = e.image;
					var n = 0.1,
						i = document.getElementById("preview-item"),
						o = setInterval(function () {
							n >= 1 && clearInterval(o), (i.style.opacity = n), (i.style.filter = "alpha(opacity=" + 100 * n + ")"), (n += 0.1 * n);
						}, 30);
				} else {
					if (document.getElementById("preview-item").src != e.picture) {
						document.getElementById("preview-item").src = e.picture;
						(n = 0.1),
							(i = document.getElementById("preview-item")),
							(o = setInterval(function () {
								n >= 1 && clearInterval(o), (i.style.opacity = n), (i.style.filter = "alpha(opacity=" + 100 * n + ")"), (n += 0.1 * n);
							}, 30));
					}
				}
				if (1 == e.display) {
					var l = $("#b-cart");
					for (a = 0; a < l.length; a++) l[a].style.display = "none";
				} else {
					for (l = $("#b-cart"), a = 0; a < l.length; a++) l[a].style.display = "flex";
				}
				updateHiddenFields(e.sku); // Update hidden fields
				$("#quantity").val(1); // Reset quantity
				$("#div_alert_stock").hide(); // Hide alert
			},
			failure: function (e) {
				alert(e);
			},
		});
	});

	// Event handler for .btn-option
	$(".btn-option").click(function() {
		var selectedSku = $(this).data("id");
		$.ajax({
			dataType: "json",
			method: "get",
			url: "/api/jsonDetail",
			data: { detailId: selectedSku },
			cache: false,
			beforeSend: function () {},
			success: function (t) {
				$(".mini-head-sku span").html("SKU : " + t.sku);
				$(".mini-head-sub .btn_status_p").html(t.status);
				$(".main-price h1").html(t.price);
				$("#option-product-detailOther").html(t.detail);
				$("#p_id_d").val(selectedSku);
				$("#_productSku").val(t.sku);
				for (var a = $(".mini-head-sub .btn_status_p"), n = 0; n < a.length; n++) {
					a[n].style.backgroundColor = t.background;
				}
				var i = $(".btn-option");
				for (n = 0; n < i.length; n++) {
					i[n].style.borderColor = "#707070";
					i[n].style.color = "#707070";
				}
				var o = $(".option-" + selectedSku);
				for (n = 0; n < o.length; n++) {
					o[n].style.borderColor = "#1765ff";
					o[n].style.color = "#1765ff";
				}
				if (t.image.length != 0) {
					document.getElementById("preview-item").src = t.image;
					var l = 0.1,
						c = document.getElementById("preview-item"),
						r = setInterval(function () {
							l >= 1 && clearInterval(r), (c.style.opacity = l), (c.style.filter = "alpha(opacity=" + 100 * l + ")"), (l += 0.1 * l);
						}, 30);
				} else {
					if (document.getElementById("preview-item").src != t.picture) {
						document.getElementById("preview-item").src = t.picture;
						(l = 0.1),
							(c = document.getElementById("preview-item")),
							(r = setInterval(function () {
								l >= 1 && clearInterval(r), (c.style.opacity = l), (c.style.filter = "alpha(opacity=" + 100 * l + ")"), (l += 0.1 * l);
							}, 30));
					}
				}
				if (1 == t.display) {
					var s = $("#b-cart");
					for (n = 0; n < s.length; n++) s[n].style.display = "none";
				} else {
					for (s = $("#b-cart"), n = 0; n < s.length; n++) s[n].style.display = "flex";
				}
				updateHiddenFields(t.sku); // Update hidden fields
				$("#quantity").val(1); // Reset quantity
				$("#div_alert_stock").hide(); // Hide alert
			},
			failure: function (e) {
				alert(e);
			},
		});
	});

	$(".minus").click(function () {
		var e = parseInt($("#quantity").val());
		if (e > 1) {
			e -= 1;
			$("#quantity").val(e);
			$("#_productUnit").val(e);
			$("#div_alert_stock").hide();
		}
	});

	$(".plus").click(function () {
		var e = parseInt($("#quantity").val());
		var stock = parseInt($("#detail_stock").val());
		var check_stock = parseInt($("#detail_check_stock_status").val());
		if (check_stock === 1 && e >= stock) {
			$("#div_alert_stock").show();
		} else {
			e += 1;
			$("#quantity").val(e);
			$("#_productUnit").val(e);
			$("#div_alert_stock").hide();
		}
	});

	$("#quantity").on('input', function () {
		var currentVal = parseInt($(this).val());
		var stock = parseInt($("#detail_stock").val());
		var check_stock = parseInt($("#detail_check_stock_status").val());
		if (check_stock === 1 && currentVal > stock) {
			$(this).val(stock);
			$("#div_alert_stock").show();
		} else if (currentVal < 1 || isNaN(currentVal)) {
			$(this).val(1);
			$("#div_alert_stock").hide();
		} else {
			$("#div_alert_stock").hide();
		}
		$("#_productUnit").val($(this).val());
	});

	// Initialize with the first option selected
	var initialSku = $('#option_select').val();
	updateHiddenFields(initialSku);
});
</script>
<script type="text/javascript" src="{{ asset('assets/fontend/js/product-review.js') }}"></script>

@endsection
