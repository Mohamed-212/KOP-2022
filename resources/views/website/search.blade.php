@extends('layouts.website.app')

@section('title') Items @endsection

@section('styles')
    <style>
        .categoriesActive{
            border-color: #6dc405;
            background-color: #6dc405;
        }
    </style>
@endsection

@section('pageName')
    <body class="page-catalog dm-dark"> @endsection

    @section('content')
        <main class="page-main">
            <div class="section-first-screen">
                <div class="first-screen__bg"
                     style="background-image: url({{asset('website-assets/img/pages/contacts/bg-first-screen.jpg')}})"></div>
                <div class="first-screen__content">
                    <div class="uk-container">
                        <div class="first-screen__box">
                            <h2 class="first-screen__title">{{__('menu.Menu')}}</h2>
                            <p class="first-screen__desc">{{__('menu.Delicious & Tasty Pastries By Expert Chefs')}}</p>
                            <div class="first-screen__breadcrumb">
                                <ul class="uk-breadcrumb">
                                    <li><a href="{{route('home.page')}}">{{__('menu.Home')}}</a></li>
                                    <li><span>{{__('menu.Menu')}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content mt-5">
                <div class="uk-container">
                    @if($items->count() > 0)
                    <div class="row w-100">
                        @foreach($items as $item)
                            @if($item->is_hidden == false)
                                <div class="product-item col-3 mt-4">
                                    <div class="product-item__box shadow mb-5 rounded">
                                        <div class="product-item__intro">
                                            <div class="product-item__not-active">
                                                <!--<div class="product-item__media">-->
                                                <!--    <div-->
                                                <!--        class="uk-inline-clip uk-transition-toggle uk-light"-->
                                                <!--        data-uk-lightbox="data-uk-lightbox"><a-->
                                                <!--            href="{{asset($item->image)}}"-->
                                                <!--            class="w-100 h-100"><img loading="lazy" data-lazy="true"  class="w-100 h-100"-->
                                                <!--                                     src="{{asset($item->image)}}"-->
                                                <!--                                     alt="{{(app()->getLocale() == 'ar')? $item->name_ar : $item->name_en}}"/>-->
                                                <!--            <div-->
                                                <!--                class="uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary"></div>-->
                                                <!--            <div class="uk-position-center"><span-->
                                                <!--                    class="uk-transition-fade"-->
                                                <!--                    data-uk-icon="icon: search;"></span>-->
                                                <!--            </div>-->
                                                <!--        </a></div>-->
                                                <!--    <div class="product-item__tooltip"-->
                                                <!--         data-uk-tooltip="title: {{(app()->getLocale() == 'ar')? $item->name_ar : $item->name_en}}; pos: bottom-right">-->
                                                <!--        <i class="fas fa-info-circle"></i></div>-->
                                                <!--</div>-->
                                                <div class="product-item__media">
                                                    <a href="{{route('item.page',[$item->category->id,$item->id])}}">
                                                        <div class="uk-inline-clip p-4 uk-transition-toggle uk-light" style="background-color: #d6d6d6;">
                                                            <img loading="lazy" data-lazy="true"  class="w-100 h-100" src="{{asset($item->image)}}" alt="Image"/>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="product-item__title uk-text-truncate"><a
                                                        href="{{route('item.page',[$item->category->id,$item->id])}}">{{(app()->getLocale() == 'ar')? $item->name_ar : $item->name_en}}</a>
                                                </div>
                                                <div
                                                    class="product-item__desc">{{(app()->getLocale() == 'ar')? $item->description_ar : $item->description_en}}</div>
                                                <div class="product-item__price">{{__('menu.Calories')}}
                                                    : {{$item->calories}}</div>

                                                <div class="product-item__select">
                                                    <div class="select-box select-box--thickness">
                                                        <ul>
                                                            @foreach($item->dough_type as $index => $dough)
                                                                <li><label class="mb-0"><input type="radio"
                                                                                               name="thickness-{{$item->id}}"
                                                                                               @if($index == 0) checked="checked" @endif /><span>{{(app()->getLocale() == 'ar')? $dough->name_ar : $dough->name_en}}</span></label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="product-item__info">
                                            <div class="product-item__price">
                                                <span>{{__('menu.Price')}}: </span><span class="value"
                                                                                         @if($item['offer']) style="text-decoration: line-through;font-size: 20px;" @endif > {{round($item->price, 2)}} </span>
                                                @if($item['offer']) <span
                                                    style="font-size: 26px;color:#6dc405;text-decoration: none"> {{round($item['offer']['offer_price'], 2)}} </span> @endif
                                             @lang('general.SR')
                                            </div>
                                            <div class="product-item__addcart">
                                                <a
                                                    @auth
                                                    data-toggle="modal"
                                                    data-target="#service-modal"
                                                    @endauth
                                                    class="uk-button uk-button-default cart"
                                                    href="{{route('item.page',[$item->category->id,$item->id])}}">
                                                    @if(app()->getLocale() == 'ar')
                                                        <span data-uk-icon="cart"></span> {{__('home.Add to Cart')}}
                                                    @else
                                                        {{__('home.Add to Cart')}} <span data-uk-icon="cart"></span>
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @else
                    <div class="row w-100 text-center m-auto d-block">
                        <h1 class="text-center" style="margin:100px"> @lang('general.nodata') </h1>
                    </div>
                    @endif
                </div>
            </div>
        </main>
@endsection

@section('scripts')@endsection
