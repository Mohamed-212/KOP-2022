@extends('layouts.website.app')

@section('title')
    {{ __('general.home') }}
@endsection
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"
        integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .product-item .ratting {
            min-height: 30px;
            max-height: 30px;
            font-size: 15px;
            padding-top: 2%;

        }

        .food-info h4 {
            font-size: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 50px;
            max-height: 50px;
        }

        .slick-next:before {
            content: none !important;
        }

        .slick-prev:before {
            content: none !important;
        }

        [dir=rtl] .slick-prev {
            right: auto;
            left: -15px;
        }

        [dir=rtl] .slick-prev i {
            margin-right: -20px;
        }

        .line-clamp5 {
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 135px;
            /* max-height: 180px; */
        }

        .about-section .content-img-holder {
            /* position: absolute !important;
                        top: 0 !important;
                        /* padding-top: 13% !important;
                        margin-left: 5% !important; */

        }

        .about-info {
            /* margin-left: 58% !important;
                        position: absolute !important;
                        top: 0 !important;
                        padding-top: 9% !important;*/
        }
    </style>
@endsection


@section('pageName')

    <body class="page-home dm-dark">
    @endsection

    @section('content')
        <!-- <div id="popup-search-box">
                                <div class="box-inner-wrap d-flex align-items-center">
                                    <form id="form" action="#" method="get" role="search">
                                        <input id="popup-search" type="text" name="s" placeholder="Type keywords here..." />
                                        <button id="popup-search-button" type="submit" name="submit"><i class="las la-search"></i></button>
                                    </form>
                                </div>
                            </div>/#popup-search-box -->

        <div id="main-slider" class="main-slider">
            <div class="single-slide {{ app()->getLocale() === 'ar' ? 'right' : '' }}" dir="ltr">
                <div class="bg-img kenburns-top"
                    style="background-image: url({{ asset('website2-assets/img/slider-bg-01.jpg') }});"></div>
                @if (app()->getLocale() === 'ar')
                    <div class="slider-shape left"
                        style="background-image: url({{ asset('website2-assets/img/slider-shape-02.png') }});"
                        data-animation="fade-in-left" data-delay="0.5s"></div>
                @else
                    <div class="slider-shape"
                        style="background-image: url({{ asset('website2-assets/img/slider-shape-01.png') }});"
                        data-animation="fade-in-right" data-delay="0.5s"></div>
                @endif
                @if (app()->getLocale() === 'ar')
                    <div class="food-img"
                        style="background-image: url({{ asset('website2-assets/img/food-img-01-ltr.png') }});"
                        data-animation="fade-in-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}" data-delay="1s"></div>
                @else
                    <div class="food-img" style="background-image: url({{ asset('website2-assets/img/food-img-01.png') }});"
                        data-animation="fade-in-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}" data-delay="1s"></div>
                @endif
                <div class="food-design"
                    style="background-image: url({{ asset('website2-assets/img/slider-elements.png') }});{{ app()->getLocale() == 'ar' ? 'right: -10%;' : '' }}"
                    data-animation="zoomIn" data-delay="1.3s"></div>

                <div class="slider-content-wrap d-flex align-items-center">
                    <div class="container">
                        <div class="slider-content" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : '' }}">
                            <div class="slider-caption medium">
                                <div class="inner-layer">
                                    <div data-animation="fade-in-top" data-delay="0.5s">{{ __('home.Eat Sleep And') }}
                                    </div>
                                </div>
                            </div>
                            <div class="slider-caption big">
                                <div class="inner-layer">
                                    <div data-animation="reveal-text" data-delay="1s">
                                        {{ __('home.Order Today, While It’s Hot!') }}</div>
                                </div>
                            </div>
                            <div class="slider-caption small">
                                <div class="inner-layer">
                                    <div data-animation="fade-in-bottom" data-delay="2s">
                                        {{ __('home.Eat Delicious & Tasty Fast-Foods With Real Flavours') }}</div>
                                </div>
                            </div>
                            <div class="slider-btn-group justify-content-left">
                                <div class="inner-layer">
                                    <a href="{{ route('menu.page') }}" class="slider-btn" data-animation="fade-in-bottom"
                                        data-delay="2.5s">{{ __('footer.Our Menu') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Slide-1-->
            <div class="single-slide center" dir="ltr">
                <div class="bg-img kenburns-top"
                    style="background-image: url({{ asset('website2-assets/img/slider-bg-02.jpg') }});"></div>
                <div class="slider-shape"
                    style="background-image: url({{ asset('website2-assets/img/slider-shape-01.png') }});"
                    data-animation="fade-in-right" data-delay="0.5s"></div>
                <div class="slider-shape left"
                    style="background-image: url({{ asset('website2-assets/img/slider-shape-02.png') }});"
                    data-animation="fade-in-left" data-delay="0.5s"></div>
                <div class="food-img" style="background-image: url({{ asset('website2-assets/img/food-img-02.png') }});"
                    data-animation="fade-in-bottom" data-delay="1s"></div>
                <div class="food-design"
                    style="background-image: url({{ asset('website2-assets/img/slider-elements-center.png') }});"
                    data-animation="zoomIn" data-delay="1.3s"></div>
                <div class="slider-content-wrap d-flex align-items-center text-center">
                    <div class="container">
                        <div class="slider-content">
                            <div class="slider-caption medium">
                                <div class="inner-layer">
                                    <div data-animation="fade-in-top" data-delay="0.5s">{{ __('home.Eat Sleep And') }}
                                    </div>
                                </div>
                            </div>
                            <div class="slider-caption big">
                                <div class="inner-layer">
                                    <div class="char-top" data-delay="1s" data-splittin>{{ __('home.Tasty Pizza') }}
                                    </div>
                                </div>
                            </div>
                            <div class="slider-caption small">
                                <div class="inner-layer">
                                    <div data-animation="fade-in-bottom" data-delay="1.5s">{!! __('home.slider2_descriptiopn') !!}</div>
                                </div>
                            </div>
                            <div class="slider-btn-group justify-content-center">
                                <div class="inner-layer">
                                    <a href="{{ route('menu.page') }}" class="slider-btn"
                                        data-animation="fade-in-bottom" data-delay="2.5s">{{ __('footer.Our Menu') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Slide-2-->
            <div class="single-slide {{ app()->getLocale() === 'ar' ? '' : 'right' }}" dir="ltr">
                <div class="bg-img kenburns-top"
                    style="background-image: url({{ asset('website2-assets/img/slider-bg-03.jpg') }});"></div>
                {{-- <div class="slider-shape left" style="background-image: url({{asset('website2-assets/img/slider-shape-02.png')}});" data-animation="fade-in-left" data-delay="0.5s"></div> --}}
                @if (app()->getLocale() !== 'ar')
                    <div class="slider-shape left"
                        style="background-image: url({{ asset('website2-assets/img/slider-shape-02.png') }});"
                        data-animation="fade-in-left" data-delay="0.5s"></div>
                @else
                    <div class="slider-shape"
                        style="background-image: url({{ asset('website2-assets/img/slider-shape-01.png') }});"
                        data-animation="fade-in-right" data-delay="0.5s"></div>
                @endif

                @if (app()->getLocale() !== 'ar')
                    <div class="food-img"
                        style="background-image: url({{ asset('website2-assets/img/food-img-03.png') }});"
                        data-animation="fade-in-top" data-delay="1s"></div>
                @else
                    <div class="food-img"
                        style="background-image: url({{ asset('website2-assets/img/food-img-03-rtl.png') }});"
                        data-animation="fade-in-top" data-delay="1s"></div>
                @endif
                <div class="food-design"
                    style="background-image: url({{ asset('website2-assets/img/slider-elements.png') }});"
                    data-animation="zoomIn" data-delay="1.3s"></div>
                <div class="slider-content-wrap d-flex align-items-center text-right">
                    <div class="container" @if (app()->getLocale() === 'ar') style="justify-content: flex-start;" @endif>
                        <div class="slider-content">
                            <div class="slider-caption medium">
                                <div class="inner-layer">
                                    <div data-animation="fade-in-top" data-delay="0.5s">{{ __('home.Eat Sleep And') }}
                                    </div>
                                </div>
                            </div>
                            <div class="slider-caption big">
                                <div class="inner-layer">
                                    <div class="char-right" data-delay="1s" data-splittin>{!! __('home.pick it up really fast, happy to SERVE you at our branches') !!}</div>
                                </div>
                            </div>
                            <div class="slider-caption small">
                                <div class="inner-layer">
                                    <div data-animation="fade-in-bottom" data-delay="2s">{!! __('home.slider2_descriptiopn') !!}</div>
                                </div>
                            </div>

                            <div class="slider-caption small">
                                <div class="inner-layer">
                                    <div data-animation="fade-in-bottom" data-delay="2s">{!! __('home.slider3_descriptiopn') !!}</div>
                                </div>
                            </div>

                            <div class="slider-btn-group justify-content-left">
                                <div class="inner-layer">
                                    <a href="{{ route('menu.page') }}" class="slider-btn"
                                        data-animation="fade-in-bottom" data-delay="2.5s">{{ __('footer.Our Menu') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Slide-3-->
        </div><!-- slider-section -->

        <section class="promo-section bg-grey padding">
            <style>
                .food-item:hover {
                    cursor: pointer;
                }
            </style>

            <div class="bg-shape white"></div>
            <div class="container">
                <div class="section-heading mb-30 text-center wow fadeInUp" data-wow-delay="200ms">
                    <h4>@lang('general.recommended_Dishes')</h4>
                    <h2>{!! __('general.ourDeliciousFood') !!} </h2>
                </div>
                <div class="nav-outside">
                    <div class="food-carousel swiper-container nav-visible">
                        <div class="swiper-wrapper">
                            @foreach ($menu['recommended'] as $recommended)
                                <div class="swiper-slide">
                                    <div class="food-item" onclick="window.location = '{{route('item.page', [$recommended->category_id, $recommended->id])}}'">
                                        <div class="food-icon">
                                            <i class="fi fi-pizza-slice"></i>
                                        </div>
                                        <div class="food-content">
                                            <h3>{{ app()->getLocale() == 'ar' ? $recommended->name_ar : $recommended->name_en }}
                                            </h3>
                                            <p>{{ app()->getLocale() == 'ar' ? $recommended->description_ar : $recommended->description_en }}
                                            </p>
                                        </div>
                                        <div class="food-thumbw">
                                            <img loading="lazy" data-lazy="true"  src="{{ asset($recommended->website_image) }}" alt="img"
                                                style="height: 210px;width:210px;border-radius: 100%;">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="dl-slider-controls style-2">
                            <div class="dl-slider-button-prev"><i class="las la-arrow-left"></i></div>
                            <div class="dl-swiper-pagination"></div>
                            <div class="dl-slider-button-next"><i class="las la-arrow-right"></i></div>
                        </div>
                        <div class="carousel-preloader">
                            <div class="dot-flashing"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/.promo-section-->

        <div id="main-slider1" dir="ltr">
            @foreach ($menu['main_offer'] as $main_offer)
                <div>
                    <section class="about-section padding">
                        <div class="bg-shape grey"></div>
                        <div class="container" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                            <div class="row align-items-center">
                                <div class="col-md-6 wow fadeInLeft" data-wow-delay="200ms">
                                    <div class="content-img-holder">
                                        <img loading="lazy" data-lazy="true"  src="{{ asset($main_offer->website_image) }}" alt="img">
                                        <div class="sale" style="display: none">
                                            @if ($main_offer->discount)
                                                <div>
                                                    <h4>@lang('general.Get')</h4>
                                                    @if ($main_offer->discount->discount_type == 1)
                                                        <h2><span>{{ $main_offer->discount->discount_value }}%</span></h2>
                                                        <h2>@lang('general.Off_Now')</h2>
                                                    @else
                                                        <h2><span>{{ $main_offer->discount->discount_value . ' ' }}
                                                                @lang('general.SR')</span></h2>
                                                        <h2>@lang('general.Off_Now')</h2>
                                                    @endif
                                                </div>
                                            @elseif($main_offer->buyGet)
                                                <div>
                                                    <h4>@lang('general.Buy') {{ $main_offer->buyGet->buy_quantity }}</h4>
                                                    <h2>@lang('general.Get') {{ $main_offer->buyGet->get_quantity }}
                                                        <span>@lang('general.now')</span>
                                                    </h2>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 wow fadeInRight" data-wow-delay="400ms">
                                    <div class="about-info">
                                        <h2>{{ app()->getLocale() == 'ar' ? $main_offer->title_ar : $main_offer->title }}
                                        </h2>
                                        <p>{{ app()->getLocale() == 'ar' ? $main_offer->description_ar : $main_offer->description }}
                                        </p>
                                        <ul class="check-list">
                                            <li><i class="fas fa-check"></i>{!! __('home.desc1') !!}</li>
                                            <li><i class="fas fa-check"></i>{!! __('home.desc2') !!}</li>
                                            <li><i class="fas fa-check"></i>{!! __('home.desc3') !!}</li>
                                            <li><i class="fas fa-check"></i>{!! __('home.desc4') !!}</li>
                                        </ul>

                                        <a @auth @if (!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" @endif @endauth
                                            href="{{ route('offer.item', $main_offer->id) }}"
                                            class="default-btn cart">@lang('general.Order Now') <span></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--/.about-section-->
                </div>
            @endforeach
        </div>

        <section class="food-menu bg-grey padding">
            <div class="container">
                <div class="section-heading mb-30 text-center wow fadeInUp" data-wow-delay="200ms">
                    <h4>@lang('general.menu')</h4>
                    <h2>{!! __('general.ourDeliciousFood') !!} </h2>
                    <p>@lang('general.home.food')</p>
                </div>
                <ul class="food-menu-filter">
                    <!-- <li class="active" data-filter="*">All</li> -->
                    <?php $c = 0; ?>
                    @foreach ($menu['categories'] as $index => $category)
                        @if($category->website_is_hidden)
                            @continue
                        @endif
                        @if ($c == 0)
                            <?php $c = $category->id; ?>
                            <li class="active" data-filter=".{{ $category->id }}">
                                {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</li>
                        @else
                            <li data-filter=".{{ $category->id }}">
                                {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</li>
                        @endif
                    @endforeach
                </ul>
                <div class="row product-items">
                    @foreach ($menu['dealItems'] as $dealItem)
                    @if ($dealItem->website_is_hidden)
                    @continue
                @endif
                        @if ($c == $dealItem->category_id)
                            <div style="cursor: pointer;"
                                class="col-lg-4 col-md-6 padding-15 isotop-grid {{ $dealItem->category_id }}"  onclick="location.href='{{ url('item/' . $dealItem->category_id . '/' . $dealItem->id) }}';">
                            @else
                                <div class="col-lg-4 col-md-6 padding-15 isotop-grid {{ $dealItem->category_id }}"
                                    style="display:none;"  onclick="location.href='{{ url('item/' . $dealItem->category_id . '/' . $dealItem->id) }}';">
                        @endif
                        <div class="product-item " style="cursor: pointer;">
                            @if ($dealItem->website_is_out_of_stock)
                                    <span class="badge text-white bg-danger text-uppercase" style="position: absolute;top: 1.5rem;{{app()->getLocale() == 'ar' ? 'right' : 'left'}}: 1rem;z-index: 1;font-size: 1.5rem;">
                                        {{__('general.out of stock')}}
                                    </span>
                                    @endif
                            <div class="product-thumb">
                                <img loading="lazy" data-lazy="true"  src="{{ asset($dealItem->website_image) }}" alt="food"
                                    style="    height: 270px;
                                    width: 270px;
                                    border-radius: 100%;
                                    margin-top: -2rem;">
                                <form id="addToCard" action="{{ route('add.cart') }}" method="POST">
                                    @csrf
                                    @if ($dealItem->offer)
                                        <input type="hidden" name="offer_id"
                                            value="{{ $dealItem->offer ? $dealItem->offer->offer_id : '' }}">
                                        <input type="hidden" name="offer_price"
                                            value="{{ $dealItem->offer ? round($dealItem->offer->offer_price, 2) : '' }}">
                                    @endif
                                    {{-- <input type="hidden" name="item_id" value="{{ $dealItem['id'] }}"> --}}
                                    <input type='hidden' name='add_items[]' value="{{ $dealItem }}" />
                                    <input type='hidden' name='sa55' value="1" />
                                    <input type='hidden' name='quantity' value="1" />

                                    @if ($dealItem->website_is_out_of_stock)
                                        <div><button data-target="#stockouterr" data-bs-toggle="modal"
                                            data-bs-target="#stockouterr" type="button"
                                                class="order-btn">@lang('general.Order Now2')</button></div>
                                            @else
                                    <div>
                                        @auth
                                            @if (session()->has('branch_id') || session()->has('address_branch_id'))
                                                @if (isset($cartHasOffers) && $cartHasOffers && $dealItem->offer)
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#offersMultibleInOneOrder" type="button"
                                                        class="order-btn">@lang('general.Order Now2')</button>
                                                @else
                                                <input type="hidden" name="item_id" value="{{ $dealItem['id'] }}">
                                                <button type="submit"
                                                        class="order-btn cart">@lang('general.Order Now2')</button>
                                                @endif
                                            @else
                                                <button data-target="#service-modal" data-bs-toggle="modal"
                                                    data-bs-target="#service-modal" type="button"
                                                    class="order-btn">@lang('general.Order Now2')</button>
                                            @endif
                                        @else
                                            <button type="submit" class="order-btn">@lang('general.Order Now2')</button>
                                        @endauth
                                        {{-- <button
                                            @auth @if (!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" 
                                        @elseif (isset($cartHasOffers) && $cartHasOffers && $dealItem->offer)
                                        data-bs-toggle="modal"
                                        data-bs-target="#offersMultibleInOneOrder"
                                        type="button"
                                        @else
                                        type="submit"
                                        @endif 
                                        @else
                                        type="submit" @endauth
                                            class="order-btn cart">@lang('general.Order Now')</button> --}}
                                        
                                        </div>
                                            @endif
                                </form>
                            </div>
                            <div class="food-info" style="display: block;text-align:center;margin-top: -1.5rem;" 
                            onclick="location.href='{{ url('item/' . $dealItem->category_id . '/' . $dealItem->id) }}';">
                                <ul class="ratting">
                                    <li>{{ $dealItem['category_name_' . app()->getLocale()] }}</li>

                                </ul>
                                <h4>{{ $dealItem['description_' . app()->getLocale()] }}</h4>
                                <div class="price">
                                    <ul class="product-meta">
                                        <li>{{ __('general.calories') }}:<a
                                                href="javascript:void(0)">{{ $dealItem->calories }}</a></li>
                                    </ul>
                                    <h4>@lang('home.Price'):
                                        <span>
                                            @if ($dealItem->offer)
                                                <del class="text-danger">{{ $dealItem->price }}</del>
                                                {{ $dealItem->offer->offer_price }}
                                            @else
                                                {{ $dealItem->price }}
                                            @endif
                                            @lang('general.SR')
                                        </span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('menu.page') }}" class="default-btn">{{ __('footer.Our Menu') }}<span></span></a>

            </div>
        </section>
        <!--/.food-menu-->

        <section class="content-section">
            <div class="bg-shape white"></div>
            <div class="bg-shape grey"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 wow fadeInLeft" data-wow-delay="200ms">
                        <div class="content-info">
                            <h2>{{ app()->getLocale() == 'ar' ? $menu['anoucement'][0]->name_ar : $menu['anoucement'][0]->name_en }}
                            </h2>
                            <p>{{ app()->getLocale() == 'ar' ? $menu['anoucement'][0]->description_ar : $menu['anoucement'][0]->description_en }}
                            </p>

                        </div>
                    </div>
                    <div class="col-md-6 wow fadeInRight" data-wow-delay="400ms">
                        <div class="content-img-holder">
                            <img loading="lazy" data-lazy="true"  src="{{ asset($menu['anoucement'][0]->image) }}" alt="img">

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/.content-section-->

        <section class="delivery-section padding">
            <div class="bg-shape grey"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 wow fadeInLeft" data-wow-delay="200ms">
                        <div class="delivery-info">
                            <h2>{!! __('general.delivery_caption') !!}</h2>
                            <p>{!! __('general.delivery_description') !!}</p>
                            <div class="order-content">
                                <a href="{{ route('menu.page') }}"
                                    class="default-btn">{{ __('header.Menu') }}<span></span></a>
                                <h3><span>{{ __('general.hot_line') }}</span> <a href="tel:920001939"
                                        style="color: #f99839;">
                                        920001939</a></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="delivery-boy-wrap">
                            <img loading="lazy" data-lazy="true"  class="delivery" src="{{ asset('website2-assets/img/cloud.png') }}" alt="img">
                            <div class="delivery-boy"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/.delivery-section-->

        <section class="banner-section padding">
            <div class="bg-shape grey"></div>
            <div class="container">
                <div class="row banner-wrapper">
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="200ms">
                        <div class="banner-item">
                            <img loading="lazy" data-lazy="true"  src="{{ asset($menu['homeitem'][0]->image) }}" alt="banner">
                            <div class="banner-content">
                                <h2>{{ app()->getLocale() == 'ar' ? $menu['homeitem'][0]->description_ar : $menu['homeitem'][0]->description_en }}
                                </h2>
                                <a href="{{ url('item/' . $menu['homeitem'][0]->category_id . '/' . $menu['homeitem'][0]->item_id) }}"@auth @if (!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" @endif @endauth
                                    class="order-btn cart">@lang('general.Order Now')</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 wow fadeInUp" data-wow-delay="400ms">
                                <div class="banner-item">
                                    <img loading="lazy" data-lazy="true"  src="{{ asset($menu['homeitem'][1]->image) }}" alt="banner">
                                    <div class="banner-content">
                                        <h2>{{ app()->getLocale() == 'ar' ? $menu['homeitem'][1]->description_ar : $menu['homeitem'][1]->description_en }}
                                        </h2>
                                        <a href="{{ url('item/' . $menu['homeitem'][1]->category_id . '/' . $menu['homeitem'][1]->item_id) }}"
                                            @auth @if (!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" @endif @endauth
                                            class="order-btn cart">@lang('general.Order Now')</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 wow fadeInUp" data-wow-delay="600ms">
                                <div class="banner-item">
                                    <img loading="lazy" data-lazy="true"  src="{{ asset($menu['homeitem'][2]->image) }}" alt="banner">
                                    <div class="banner-content">
                                        <h2>{{ app()->getLocale() == 'ar' ? $menu['homeitem'][2]->description_ar : $menu['homeitem'][2]->description_en }}
                                        </h2>
                                        <a href="{{ url('item/' . $menu['homeitem'][2]->category_id . '/' . $menu['homeitem'][2]->item_id) }}"
                                            @auth @if (!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" @endif @endauth
                                            class="order-btn cart">@lang('general.Order Now')</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 wow fadeInUp" data-wow-delay="800ms">
                                <div class="banner-item">
                                    <img loading="lazy" data-lazy="true"  src="{{ asset($menu['homeitem'][3]->image) }}" alt="banner">
                                    <div class="banner-content">
                                        <h2>{{ app()->getLocale() == 'ar' ? $menu['homeitem'][3]->description_ar : $menu['homeitem'][3]->description_en }}
                                        </h2>
                                        <a href="{{ url('item/' . $menu['homeitem'][3]->category_id . '/' . $menu['homeitem'][3]->item_id) }}"
                                            @auth @if (!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" @endif @endauth
                                            class="order-btn cart">@lang('general.Order Now')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/.banner-section-->

        <section class="blog-section bg-grey padding">
            <div class="bg-shape white"></div>
            <div class="container">
                <div class="section-heading mb-30 text-center wow fadeInUp" data-wow-delay="200ms">
                    <h4>@lang('general.home.Blog_Posts')</h4>
                    <h2>{!! __('general.blog_caption') !!}</h2>
                    <p>{!! __('general.blog_description') !!}</p>
                </div>
                <div class="row blog-posts">
                    @if (isset($menu['news']))
                        @foreach ($menu['news'] as $new)
                            <div class="col-lg-4 col-md-6 sm-padding wow fadeInUp" style="margin-bottom: 2%;"
                                data-wow-delay="200ms">
                                <div class="post-card">
                                    <div class="post-thumb">
                                        <img loading="lazy" data-lazy="true"  src="{{ asset($new->image) }}" alt="img">
                                        <div class="category"><a
                                                href="{{ route('get.new', $new->id) }}">{{ $new['title_' . app()->getLocale()] }}</a>
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <ul class="post-meta">
                                            <li><i class="far fa-calendar-alt"></i><a
                                                    href="{{route('news.archive', [$new->updated_at->year, $new->updated_at->format('m')])}}">{{ $new->created_at }}</a></li>

                                        </ul>
                                        <p class="line-clamp5">{{ $new['description_' . app()->getLocale()] }}</p>
                                        <a href="{{ route('get.new', $new->id) }}" class="read-more">@lang('general.Read More')<i
                                                class="las la-long-arrow-alt-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section><!-- /.blog-section -->



        {{-- <div id="scrollup">

            <button id="scroll-top" class="scroll-to-top"><i class="las la-arrow-up"></i></button>
        </div>  --}}

    @endsection

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
            integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {
                $('#main-slider1').slick({
                    dots: true,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    adaptiveHeight: true,
                    rtl: false
                });
            });
        </script>
    @endsection
