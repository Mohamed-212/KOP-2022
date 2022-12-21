@extends('layouts.website.app')

@section('title') Home @endsection

@section('styles')
    <style>
        .categoriesActive {
            border-color: #6dc405;
            background-color: #6dc405;
        }
        .line-clamp2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp5 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .video-img a img {
            width: 400px;
            height: 20.83333vw;
        }
    </style>
@endsection

@section('pageName')
    <body class="page-home dm-dark"> @endsection

    @section('content')
        <main class="page-main">
            <div class="section-first-screen">
                <div class="first-screen__slideshow">
                    <div data-uk-slideshow="min-height: 400; max-height: 785; autoplay: true">
                        <div class="uk-position-relative" tabindex="-1">
                            <ul class="uk-slideshow-items">
                                <li>
                                    <div
                                        class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                        <img loading="lazy" data-lazy="true"  src="{{asset('website-assets/img/pages/home/khome.jpg')}}"
                                             alt="slider-1" data-uk-cover></div>
                                </li>
                                <li>
                                    <div
                                        class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                        <img loading="lazy" data-lazy="true"  src="{{asset('website-assets/img/pages/home/khome2.jpg')}}"
                                             alt="slider-2" data-uk-cover></div>
                                </li>
                                <li>
                                    <div
                                        class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                        <img loading="lazy" data-lazy="true"  src="{{asset('website-assets/img/pages/home/khome3.jpg')}}"
                                             alt="slider-3" data-uk-cover></div>
                                </li>
                            </ul>
                        </div>
                        <div class="slideshow-dotnav uk-position-bottom-center">
                            <ul class="uk-slideshow-nav uk-dotnav uk-flex-center"></ul>
                        </div>
                    </div>
                </div>
                <div class="first-screen__content">
                    <div class="uk-container">
                        <div class="first-screen__box">
                            <h2 class="first-screen__title">{{__('home.Order Today, While It’s Hot!')}}</h2>
                            <p class="first-screen__desc">{{__('home.Eat Delicious & Tasty Fast-Foods With Real Flavours')}}</p>
                            <a class="uk-button" style="height: auto;" href="{{route('menu.page')}}">{{__('footer.Our Menu')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="section-about">-->
            <!--    <div class="uk-section uk-container">-->
            <!--        <div class="uk-grid uk-child-width-1-2@m uk-flex-middle" data-uk-grid>-->
            <!--            <div class="uk-text-center"><img loading="lazy" data-lazy="true"  src="{{asset('website-assets/img/pages/home/Aboutus.jpg')}}"-->
            <!--                                             alt=""></div>-->
            <!--            <div>-->
            <!--                <div class="section-title burger wave">-->
            <!--                    <h3 class="uk-h3">{{$menu['aboutus']["title_".app()->getLocale()] ?? 'About Us'}}</h3>-->
            <!--                </div>-->
            <!--                <div class="section-content">-->
            <!--                    <div style="overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 7;-webkit-box-orient: vertical;">{!!$menu['aboutus']["description_".app()->getLocale()] ?? 'about us'!!}</p>-->
            <!--                    <div class="uk-margin-medium-top"><a class="uk-button" href="{{route('aboutUS.page')}}"><span>{{__('home.Read More')}}</span><img-->
            <!--                                class="uk-margin-small-left"-->
            <!--                                src="{{asset('website-assets/img/icons/ice-cream.svg')}}" alt=""></a></div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="section-features" style="background-image: url({{asset('website-assets/img/pages/home/khomeicon.jpg')}});">-->
            <!--    <div class="uk-section uk-container">-->
            <!--        <div class="uk-grid uk-child-width-1-3@s" data-uk-grid>-->
            <!--            <div>-->
            <!--                <div class="feature-item text-center">-->
            <!--                    <div class="feature-item__icon"><img-->
            <!--                            src="{{asset('website-assets/img/icons/feature-1.svg')}}" alt="feature"></div>-->
            <!--                    <div class="feature-item__title">{{__('home.Fresh Ingredients')}}</div>-->
            <!--                    <div class="feature-item__desc">Magna aliqua enim minim veniam quisya nost exercitation-->
            <!--                        ullamco sed laboris nisy.-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div>-->
            <!--                <div class="feature-item text-center">-->
            <!--                    <div class="feature-item__icon"><img-->
            <!--                            src="{{asset('website-assets/img/icons/feature-2.svg')}}" alt="feature"></div>-->
            <!--                    <div class="feature-item__title">{{__('home.The Certified Chefs')}}</div>-->
            <!--                    <div class="feature-item__desc">Magna aliqua enim minim veniam quisya nost exercitation-->
            <!--                        ullamco sed laboris nisy.-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div>-->
            <!--                <div class="feature-item text-center">-->
            <!--                    <div class="feature-item__icon"><img-->
            <!--                            src="{{asset('website-assets/img/icons/feature-3.svg')}}" alt="feature"></div>-->
            <!--                    <div class="feature-item__title">{{__('home.30 Mins Delivery')}}</div>-->
            <!--                    <div class="feature-item__desc">Magna aliqua enim minim veniam quisya nost exercitation-->
            <!--                        ullamco sed laboris nisy.-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="section-special-deals">
                <div class="uk-section uk-container">
                    <div class="section-title section-title--center wave french-fries">
                        <h3 class="uk-h3">{{__('home.Our Special Deals')}}</h3>
                    </div>
                    <div class="section-content" data-uk-filter="target: .js-filter">
                        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

                            <ul class="uk-slider-items uk-child-width-1-5@l uk-child-width-1-3@m uk-child-width-1-1@s uk-grid">
                                @foreach($menu['categories'] as $index => $category)
                                    <li>
                                        <div class="uk-panel h-75">
                                            <img loading="lazy" data-lazy="true"  src="{{$category->image}}" id="{{$category->id}}" class="img-thumbnail rounded w-100 h-100 cat" alt="">
                                            <h4 class="m-1 text-center">{{(app()->getLocale() == 'ar')? $category->name_ar : $category->name_en}}</h4>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" @if(app()->getLocale() == 'en') uk-slidenav-previous @else uk-slidenav-next @endif uk-slider-item="previous"></a>
                            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" @if(app()->getLocale() == 'en') uk-slidenav-next @else uk-slidenav-previous @endif uk-slider-item="next"></a>

                        </div>

                        <div class="uk-position-relative uk-visible-toggle mt-5 uk-light" tabindex="-1" uk-slider>

                            <ul class="items uk-slider-items uk-child-width-1-4@l uk-child-width-1-3@m uk-child-width-1-1@s uk-grid">

                            </ul>

                            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" @if(app()->getLocale() == 'en') uk-slidenav-previous @else uk-slidenav-next @endif uk-slider-item="previous"></a>
                            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" @if(app()->getLocale() == 'en') uk-slidenav-next @else uk-slidenav-previous @endif uk-slider-item="next"></a>

                        </div>

                    </div>
                </div>
            </div>
            <div class="section-steps" style="background-image: url({{asset('website-assets/img/pages/home/khomestep.jpg')}});">
                <div class="uk-section">
                    <div class="uk-container p-0">
                        <div class="section-title"><span>{{__('home.Order Your Own Tasty Food')}}</span>
                            <h3 class="uk-h3">{{__('home.It Takes 2 Minutes To Make Your')}}
                                <br>{{__('home.Own Tasty Pizza And Order From Us')}}</h3>
                        </div>
                    </div>
                    <div class="uk-container-expand">
                        <div class="section-content">
                            <div class="uk-grid" data-uk-grid>
                                <!--<div class="uk-width-1-3@m"><img-->
                                <!--        src="{{asset('website-assets/img/pages/home/Pizza steps big.png')}}" alt="">-->
                                <!--</div>-->
                                <div class="uk-width-3-3@m">
                                    <div data-uk-slider="finite: true">
                                        <div class="uk-position-relative">
                                            <div class="uk-slider-container">
                                                <ul class="m-4 uk-slider-items uk-grid uk-grid-medium uk-child-width-1-1 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-4@l uk-child-width-1-4@xl">
                                                    <li>
                                                        <div class="step-item step-item--1">
                                                            <div class="step-item__icon"><img
                                                                    src="{{asset('website-assets/img/pages/home/step1.png')}}"
                                                                    alt="img-step"></div>
                                                            <div class="step-item__numb">@lang('home.Step') 1</div>
                                                            <div class="step-item__title">@lang('home.st1t')</div>
                                                            <div class="step-item__desc">@lang('home.st1d')</div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="step-item step-item--2">
                                                            <div class="step-item__icon"><img
                                                                    src="{{asset('website-assets/img/pages/home/step2.png')}}"
                                                                    alt="img-step"></div>
                                                            <div class="step-item__numb">@lang('home.Step') 2</div>
                                                            <div class="step-item__title">@lang('home.st2t')</div>
                                                            <div class="step-item__desc">@lang('home.st2d')</div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="step-item step-item--3">
                                                            <div class="step-item__icon"><img
                                                                    src="{{asset('website-assets/img/pages/home/step3.png')}}"
                                                                    alt="img-step"></div>
                                                            <div class="step-item__numb">@lang('home.Step') 3</div>
                                                            <div class="step-item__title">@lang('home.st3t')</div>
                                                            <div class="step-item__desc">@lang('home.st3d')</div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="step-item step-item--4">
                                                            <div class="step-item__icon"><img
                                                                    src="{{asset('website-assets/img/pages/home/Pizza steps big.png')}}"
                                                                    alt="img-step" style="height:284px"></div>
                                                            <div class="step-item__numb">@lang('home.Step') 4</div>
                                                            <div class="step-item__title">@lang('home.st4t')</div>
                                                            <div class="step-item__desc">@lang('home.st4d')</div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-margin-medium-top uk-text-center"><a class="uk-button d-table m-auto"
                                                                                        href="{{route('menu.page')}}"><span style="display: table-cell;vertical-align: middle;">@lang('home.Create & Order Now!')</span><img
                                                class="uk-margin-small-left"
                                                src="{{asset('website-assets/img/icons/ice-cream.svg')}}" alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-recommend">
                <div class="uk-section uk-container">
                    <div class="section-title section-title--center wave french-fries">
                        <h3 class="uk-h3">@lang('home.Our Offers')</h3>
                    </div>
                    <div class="section-content">
                        @if(isset($menu['offers']))
                        <div class="uk-margin-medium-top" data-uk-slider>
                            <div class="uk-position-relative">
                                <div class="uk-slider-container">
                                    <ul class="uk-slider-items uk-grid uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-3@xl uk-child-width-1-3@xl"
                                        data-uk-height-match=".product-card__intro">
                                        @foreach($menu['offers'] as $offer)
                                        <li class="{{$menu['offers']}}">
                                            <div class="product-card">
                                                <div class="product-card__media"><a href="{{route('offer.item',$offer->id)}}"><img
                                                            class="uk-width-1-1"
                                                            src="{{asset($offer->image)}}"
                                                            alt="The Spruce Burger"/></a></div>
                                                <div class="product-card__body">
                                                    <div class="product-card__title">
                                                        <a href="{{route('offer.item',$offer->id)}}">
                                                            {{(app()->getLocale() == 'ar') ?$offer->title_ar:$offer->title}}
                                                        </a>
                                                    </div>
                                                    <div class="product-card__intro">
                                                        <div>{{(app()->getLocale() == 'ar') ?$offer->description_ar:$offer->description}}</div>
                                                    </div>
                                                    <div class="product-card__addcart">
                                                        <a class="uk-button uk-width-1-1 d-table" href="{{route('offer.item',$offer->id)}}">
                                                            <span style="display: table-cell;vertical-align: middle;text-align:center;">{{__('general.Get Offer')}}</span>
                                                            <img loading="lazy" data-lazy="true"  class="uk-margin-small-left" src="{{asset('website-assets/img/icons/ice-cream.svg')}}" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach 
                                    </ul>
                                </div>
                                <div class="uk-visible@l"><a class="uk-position-top-left-out" href="#"
                                                             data-uk-slidenav-previous
                                                             data-uk-slider-item="previous"></a><a
                                        class="uk-position-top-right-out" href="#" data-uk-slidenav-next
                                        data-uk-slider-item="next"></a></div>
                                <div>
                                    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="uk-margin-large-top">
                            <div style="height:300px" class="uk-grid uk-grid-medium uk-child-width-1-2@m" data-uk-grid>
                                <div>
                                    <div class="banner-card">
                                        <div class="banner-card__bg"
                                             style="background-image: url({{asset('website-assets/img/first.jpeg')}})"></div>
                                        <!--<div class="banner-card__box"><a class="banner-card__category" href="">INTRODUCING</a>-->
                                        <!--    <h4 class="banner-card__title">For lovers of<br> good taste</h4>-->
                                        <!--    <a class="banner-card__btn" href="{{route('menu.page')}}">{{__('home.Read More')}}</a>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                                <div>
                                    <div class="banner-card">
                                        <div class="banner-card__bg"
                                             style="background-image: url({{asset('website-assets/img/second.jpeg')}})"></div>
                                        <!--<div class="banner-card__box"><a class="banner-card__category" href="">INTRODUCING</a>-->
                                        <!--    <h4 class="banner-card__title">For lovers of<br> different flavours</h4>-->
                                        <!--    <a class="banner-card__btn" href="{{route('menu.page')}}">{{__('home.Read More')}}</a>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(count($menu['dealItems']) > 0)
            <div class="section-deal-of-the-week">
                <div class="uk-section uk-container uk-container-expand">
                    <div data-uk-slider>
                        <div class="uk-position-relative">
                            <div class="uk-slider-container uk-light" style="height: 390px;">
                                <ul class="uk-slider-items uk-grid uk-grid-small uk-child-width-1-1">

                                        @foreach($menu['dealItems'] as $dealItem)
                                            <li>
                                                <div class="section-deal-of-the-week__box">
                                                    <div class="d-flex flex-column w-100">
                                                        <div class="section-title">
                                                            <span> @lang('home.Deal of the Week') </span>
                                                        </div>
                                                        <div class="section-deal-of-the-week__content" style="max-width: unset">
                                                            <div class="section-content">
                                                                <div class="section-title">
                                                                    <h3 class="uk-h3">{{$dealItem['name_'.app()->getLocale()]}}</h3>
                                                                </div>
                                                                <p>{{$dealItem['description_'.app()->getLocale()]}}</p>
                                                                <div class="price-item"><span>@lang('home.Price') </span><span class="value">{{$dealItem->price}} @lang('general.SR')</span></div>
                                                                <div class="uk-margin-medium-top"><a class="uk-button" href="{{route('item.page',[$dealItem->category_id, $dealItem->id])}}"><span>@lang('home.Create & Order Now!')</span><img
                                                                            class="uk-margin-small-left"
                                                                            src="{{asset('website-assets/img/icons/ice-cream.svg')}}" alt=""></a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="section-deal-of-the-week__media"><img loading="lazy" data-lazy="true"  class="rounded-circle" style="right: 45%;"
                                                            src="{{$dealItem->image}}"
                                                            alt="deal-of-the-week">
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach

                                </ul>
                            </div>
                            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="section-video">
                <div class="uk-section uk-container">
                    <div class="section-title section-title--center wave french-fries">
                        <h3 class="uk-h3">We Value Our Food<br> Only Familits & Communities</h3>
                    </div>
                    <div class="section-content">
                        <div class="uk-text-large uk-text-center">@lang('general.titv')</div>
                        <!--<div class="uk-grid uk-child-width-1-2@m uk-margin-medium-top" data-uk-grid>-->
                        <!--    <div>-->
                        <!--        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor-->
                        <!--            incididunt ut labore dolore magna aliqua. Ut enim ad minim veniam quis nostrud-->
                        <!--            exercitation ullamco laboris nisi ut aliquip.</p>-->
                        <!--    </div>-->
                        <!--    <div>-->
                        <!--        <p>Velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat-->
                        <!--            non proident, sunt in culpa qui officia deserunt mollit anim id est laborum sed ut-->
                        <!--            perspiciatis unde omnis iste.</p>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="video-box">
                            <div class="video-column video-column--center">
                                <div class="video-img">
                                    <div data-uk-lightbox="video-autoplay: true"><a
                                            href="https://www.youtube.com/watch?v=ecXnEXhq75A"
                                            data-attrs="width: 1280; height: 720;"><img
                                                src="{{asset('website-assets/img/pages/home/home-video.png')}}"
                                                alt="img-video"></a></div>
                                </div>
                            </div>
                            <div class="video-column video-column--left">
                                <div class="video-item">
                                    <div class="video-item__icon text-center"><img
                                            src="{{asset('website-assets/img/icons/video-1.svg')}}" alt="icon-video">
                                    </div>
                                    <div class="video-item__title text-center">@lang('general.tit1')</div>
                                    <div class="video-item__text text-center">@lang('general.sec1')</div>
                                </div>
                                <div class="video-item">
                                    <div class="video-item__icon text-center"><img
                                            src="{{asset('website-assets/img/icons/video-2.svg')}}" alt="icon-video">
                                    </div>
                                    <div class="video-item__title text-center">@lang('general.tit2')</div>
                                    <div class="video-item__text text-center">@lang('general.sec2')</div>
                                </div>
                            </div>
                            <div class="video-column video-column--right">
                                <div class="video-item">
                                    <div class="video-item__icon text-center"><img
                                            src="{{asset('website-assets/img/icons/video-3.svg')}}" alt="icon-video">
                                    </div>
                                    <div class="video-item__title text-center">@lang('general.tit3')</div>
                                    <div class="video-item__text text-center">@lang('general.sec3')</div>
                                </div>
                                <div class="video-item">
                                    <div class="video-item__icon text-center"><img
                                            src="{{asset('website-assets/img/icons/video-4.svg')}}" alt="icon-video">
                                    </div>
                                    <div class="video-item__title text-center">@lang('general.tit4')</div>
                                    <div class="video-item__text text-center">@lang('general.sec4')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-featured-deals">
                <div class="uk-container">
                    <div data-uk-slider>
                        <div class="uk-position-relative">
                            <div class="uk-slider-container uk-light">
                                <ul class="uk-slider-items uk-grid uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-4@xl">
                                    @if(isset($menu['galleries']))
                                        @foreach($menu['galleries'] as $gallery)
                                    <li style="height: 260px;">
                                        <div class="featured-deal-item h-100">
                                            <div class="uk-width-1-1 uk-inline-clip uk-transition-toggle h-100" tabindex="0">
                                                <img loading="lazy" data-lazy="true"  class="uk-width-1-1 w-100 h-100"
                                                     src="{{asset($gallery->url)}}"
                                                     alt="featured-deal">
                                                <a class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-primary uk-flex uk-flex-column uk-flex-center uk-flex-middle"
                                                    href="{{route('gallery.page')}}">
                                                    <div class="featured-deal-item__title">{{$gallery['title_'.app()->getLocale()]}}</div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-blog">
                <div class="uk-section uk-container">
                    <div class="section-title section-title--center wave burger">
                        <h3 class="uk-h3">@lang('general.News Blog Articles')</h3>
                    </div>

                    <div class="section-content">
                        <div class="uk-margin-medium-top" data-uk-slider>
                            <div class="uk-position-relative">
                                <div class="uk-slider-container">
                                    <ul class="uk-slider-items uk-grid uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-3@xl uk-child-width-1-3@xl">
                                        @if(isset($menu['news']))
                                            @foreach($menu['news'] as $new)

                                                <li>
                                                    <div class="article-card">

                                                        <div class="article-card__media"><a
                                                                href="{{route('get.new',$new->id)}}"><img loading="lazy" data-lazy="true"  
                                                                    style="height:268px;"
                                                                    src="{{$new->image}}"
                                                                    alt="Soft &amp; fresh-baked chocolate cookie with chunks"></a>
                                                        </div>
                                                        <div class="article-card__body" style="height:370px;">
                                                            <div class="article-card__info"><span
                                                                    class="article-card__date">{{$new ->created_at}}</span>
                                                                {{--                                                        <span  class="article-card__comments">210 </span>--}}
                                                            </div>
                                                            <div class="article-card__title">
                                                                <a class="line-clamp2" href="{{route('get.new',$new->id)}}">{{$new['title_'.app()->getLocale()]}}</a>
                                                            </div>
                                                            <div class="article-card__intro">
                                                                <div class="line-clamp5">{{$new['description_'.app()->getLocale()]}}</div>
                                                            </div>
                                                            <div class="article-card__more" style="position: absolute;bottom:35px;">
                                                                <a class="uk-button-link"
                                                                   href="{{route('get.new',$new->id)}}"
                                                                   data-uk-icon="arrow-right">@lang('general.Read More')</a>
                                                           </div>
                                                        </div>
                                                    </div>
                                                </li>

                                            @endforeach
                                        @endif
                                    </ul>

                                </div>
                                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    @endsection

    @section('scripts')
        <script>
            $('.cat').click(function () {
                $('img.cat').removeClass('categoriesActive');
                $(this).addClass('categoriesActive');
                var styleOffer = '';
                var offerPrice = '';
                var doughTypes = '';
                $.ajax({
                    type:'post',
                    url:'{{url('api/menu/categories/')}}' + '/' + $(this).attr('id') + '/items',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        'branch_id': {{(session()->has('branch_id'))? session()->get('branch_id'): 0}}
                    },
                    success:function (data){
                        if(data.success === true)
                        {
                            $('.items').html('');
                            $.each(data.data, function(index, item) {
                                if(! item.is_hidden)
                                {
                                    styleOffer = '';
                                    offerPrice = '';
                                    doughTypes = '';
                                    if(item.offer) {
                                        styleOffer = 'style="text-decoration: line-through;font-size: 20px;"';
                                        offerPrice = '<span style="font-size: 26px;color:#6dc405;text-decoration: none">' + (parseFloat(item['offer']['offer_price'])).toFixed(2) + '</span>';
                                    }
                                    $.each(item.dough_type, function(index2, dough) {
                                        doughTypes+= '<li><label class="mb-0">';
                                        if(index2 == 0){
                                            doughTypes+= '<input type="radio" name="thickness-' + item.id + '" checked="checked" /><span>'+
                                                @if(app()->getLocale() == 'ar')
                                                    dough.name_ar +
                                                @else
                                                    dough.name_en +
                                                @endif
                                                    '</span></label></li>';
                                        }
                                        else {
                                            doughTypes+= '<input type="radio" name="thickness-' + item.id + '" /><span>'+
                                                @if(app()->getLocale() == 'ar')
                                                    dough.name_ar +
                                                @else
                                                    dough.name_en +
                                                @endif
                                                    '</span></label></li>';
                                        }
                                    });
                                    $('.items').append(
                                        '<li>'+
                                        '<div class="product-item shadow mb-5 rounded">'+
                                        '<div class="product-item__box">'+

                                        '<div class="product-item__intro">'+

                                        '<div class="product-item__not-active">'+

                                        '<div class="product-item__media">'+
                                        '<a href="{{url('/item/')}}'+ '/' + item.category_id + '/' + item.id + '">'+
                                        '<div class="uk-inline-clip p-4 uk-transition-toggle uk-light" style="background-color: #d6d6d6;">'+
                                        '<img loading="lazy" data-lazy="true"  class="w-100 h-100" src="' + item.image + '" alt="Image"/>'+
                                        '</div>'+
                                        '</a>'+
                                        '</div>'+

                                        '<div class="product-item__title uk-text-truncate">'+
                                        '<a href="{{url('/item/')}}'+ '/' + item.category_id + '/' + item.id + '">' +
                                        @if(app()->getLocale() == 'ar')
                                            item.name_ar +
                                        @else
                                            item.name_en +
                                        @endif
                                            '</a>'+
                                        '</div>'+

                                        '<div class="product-item__desc">'+
                                        @if(app()->getLocale() == 'ar')
                                            item.description_ar +
                                        @else
                                            item.description_en +
                                        @endif
                                            '</div>'+

                                        '<div class="product-item__price">{{__('home.Calories')}}: ' + item.calories + '</div>'+

                                        '<div class="product-item__select">'+
                                        '<div class="select-box select-box--thickness">'+
                                        '<ul>'+
                                        doughTypes
                                        +'</ul>'+
                                        '</div>'+
                                        '</div>'+

                                        '</div>'+

                                        '</div>'+

                                        '<div class="product-item__info">'+
                                        '<div class="product-item__price">'+
                                        '<span>{{__('home.Price')}}: </span>'+
                                        '<span class="value"'+ styleOffer + '>' + (parseFloat(item.price)).toFixed(2) + '</span>'+
                                        offerPrice
                                        + ' @lang('general.SR')'
                                        +'</div>'+
                                        '<div class="product-item__addcart">'+
                                        '<a @auth @if(!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" @endif @endauth class="uk-button uk-button-default cart" href="{{url('/item/')}}'+ '/' + item.category_id + '/' + item.id + '">'+
                                        @if(app()->getLocale() == 'ar')
                                            '<span data-uk-icon="cart"></span> {{__('home.Add to Cart')}}'+
                                        @else
                                            '{{__('home.Add to Cart')}} <span data-uk-icon="cart"></span>'+
                                        @endif
                                            '</a>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>'+
                                        '</li>');

                                }
                            });
                        }//end success
                    },
                    error:function (reject){
                    }
                })
            });
        </script>
@endsection
