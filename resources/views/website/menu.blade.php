@extends('layouts.website.app')

@section('title')
    {{ __('general.menu') }}
@endsection

@section('styles')
    <style>
        .categoriesActive {
            border-color: #6dc405;
            background-color: #6dc405;
        }

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
    </style>
@endsection

@section('pageName')

    <body class="page-catalog dm-dark">
    @endsection

    @section('content')
        <section class="page-header" style="background-image: url({{ asset('website2-assets/img/page-header-theme.jpg') }})">

            <div class="bg-shape grey"></div>
            <div class="container">
                <div class="page-header-content">
                    <h4>
                        {{ __('menu.Menu') }}
                    </h4>
                    <h2>
                        {!! __('menu.title') !!}
                    </h2>
                </div>
            </div>
        </section>
        <!--/.page-header-->

        <section class="food-menu bg-grey padding">
            <div class="container">
                <ul class="food-menu-filter">
                    <li class="active" data-filter="*">@lang('general.All')</li>
                    @foreach ($menu['categories'] as $index => $category)
                        @if ($category->website_is_hidden)
                            @continue
                        @endif
                        @if ($category->items != [])
                            <li data-filter=".{{ $category->id }}">
                                {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</li>
                        @endif
                    @endforeach
                </ul>
                <div class="row product-items">
                    @foreach ($menu['categories'] as $index => $category)
                        @foreach ($category->items as $dealItem)
                            @if ($dealItem->website_is_hidden)
                                @continue
                            @endif
                            <div style="cursor: pointer;"
                                class="col-lg-4 col-md-6 padding-15 isotop-grid {{ $dealItem->category->id }}" onclick="location.href='{{ url('item/' . $dealItem->category_id . '/' . $dealItem->id) }}';">
                                <div class="product-item">
                                    <!-- <div class="sale"></div> -->
                                    @if ($dealItem->website_is_out_of_stock)
                                        <span class="badge text-white bg-danger text-uppercase"
                                            style="position: absolute;top: 1.5rem;{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem;z-index: 1;font-size: 1.5rem;">
                                            {{ __('general.out of stock') }}
                                        </span>
                                    @endif
                                    <div class="product-thumb">

                                        <img loading="lazy" data-lazy="true"  src="{{ asset($dealItem->website_image) }}" alt="food"
                                            style="    height: 270px;
                                            width: 270px;
                                            border-radius: 100%;
                                            margin-top: -2rem;" />
                                        <form id="addToCard" action="{{ route('add.cart') }}" method="POST">
                                            @csrf
                                            @if ($dealItem->offer)
                                                <input type="hidden" name="offer_id"
                                                    value="{{ $dealItem->offer ? $dealItem->offer->offer_id : '' }}">
                                                <input type="hidden" name="offer_price"
                                                    value="{{ $dealItem->offer ? round($dealItem->offer->offer_price, 2) : '' }}">
                                            @endif
                                            
                                            {{-- @unless($dealItem->offer && $dealItem->offer->offer_id) --}}
                                                <input type='hidden' name='add_items[]' value="{{ $dealItem }}" />
                                            {{-- @endunless --}}
                                            {{-- {{dd()}} --}}
                                            {{-- @php
                                                $d = $dealItem->dough_type;
                                                if (isset($d[1])) {
                                                    $d = $d[1];
                                                }
                                            @endphp
                                            @isset($d[1])
                                            <input type="hidden" name="dough" value="{{$d->name_ar}},{{$d->name_en}}" />
                                            @endisset --}}
                                            
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
                                            <li>{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                            </li>
                                        </ul>
                                        <h4>{{ $dealItem['name_' . app()->getLocale()] }}</h4>
                                        <ul class="product-meta">
                                            <li>{{ __('general.calories') }}:<a
                                                    href="javascript:void(0)">{{ $dealItem->calories }}</a></li>
                                        </ul>
                                        <div class="price">
                                            <h4>@lang('home.Price'): <span class="">
                                                    @if ($dealItem->offer)
                                                        <del class="text-danger">{{ $dealItem->price }}</del>
                                                        {{ $dealItem->offer->offer_price }}
                                                    @else
                                                        {{ $dealItem->price }}
                                                    @endif
                                                    @lang('general.SR')
                                                </span> </h4>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
        </section>
        <!--/.food-menu-->
    @endsection

    @section('scripts')
        <script>
            $('.cat').click(function() {
                $('img.cat').removeClass('categoriesActive');
                $(this).addClass('categoriesActive');
                var styleOffer = '';
                var offerPrice = '';
                var doughTypes = '';
                $.ajax({
                    type: 'post',
                    url: '{{ url('api/menu/categories/') }}' + '/' + $(this).attr('id') + '/items',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'branch_id': {{ session()->has('branch_id') ? session()->get('branch_id') : 0 }}
                    },
                    success: function(data) {
                        if (data.success === true) {
                            // console.log(data.data);
                            $('.items').html('');
                            $.each(data.data, function(index, item) {
                                console.log('wwewewe');
                                if (!item.is_hidden) {
                                    styleOffer = '';
                                    offerPrice = '';
                                    doughTypes = '';
                                    if (item.offer) {
                                        styleOffer =
                                            'style="text-decoration: line-through;font-size: 20px;"';
                                        offerPrice =
                                            '<span style="font-size: 26px;color:#6dc405;text-decoration: none">' +
                                            (parseFloat(item['offer']['offer_price'])).toFixed(2) +
                                            '</span>';
                                    }
                                    $.each(item.dough_type, function(index2, dough) {
                                        doughTypes += '<li><label class="mb-0">';
                                        if (index2 == 0) {
                                            doughTypes +=
                                                '<input type="radio" name="thickness-' +
                                                item.id + '" checked="checked" /><span>' +
                                                @if (app()->getLocale() == 'ar')
                                                    dough.name_ar +
                                                @else
                                                    dough.name_en +
                                                @endif
                                            '</span></label></li>';
                                        } else {
                                            doughTypes +=
                                                '<input type="radio" name="thickness-' +
                                                item.id + '" /><span>' +
                                                @if (app()->getLocale() == 'ar')
                                                    dough.name_ar +
                                                @else
                                                    dough.name_en +
                                                @endif
                                            '</span></label></li>';
                                        }
                                    });
                                    $('.items').append(
                                        '<div class="col-md-3 col-s-12">' +
                                        '<div class="product-item shadow mb-5 rounded">' +
                                        '<div class="product-item__box">' +

                                        '<div class="product-item__intro">' +

                                        '<div class="product-item__not-active">' +

                                        '<div class="product-item__media">' +
                                        '<a href="{{ url('/item/') }}' + '/' + item
                                        .category_id + '/' + item.id + '">' +
                                        '<div class="uk-inline-clip p-4 uk-transition-toggle uk-light" style="background-color: #d6d6d6;">' +
                                        '<img loading="lazy" data-lazy="true"  class="w-100 h-100" src="' + asset(item.image) +
                                        '" alt="Image" style="height: 250px;width:250px;border-radius: 100%;" />' +
                                        '</div>' +
                                        '</a>' +
                                        '</div>' +

                                        '<div class="product-item__title uk-text-truncate">' +
                                        '<a href="{{ url('/item/') }}' + '/' + item
                                        .category_id + '/' + item.id + '">' +
                                        @if (app()->getLocale() == 'ar')
                                            item.name_ar +
                                        @else
                                            item.name_en +
                                        @endif
                                        '</a>' +
                                        '</div>' +

                                        '<div class="product-item__desc">' +
                                        @if (app()->getLocale() == 'ar')
                                            item.description_ar +
                                        @else
                                            item.description_en +
                                        @endif
                                        '</div>' +

                                        '<div class="product-item__price">{{ __('home.Calories') }}: ' +
                                        item.calories + '</div>' +

                                        '<div class="product-item__select">' +
                                        '<div class="select-box select-box--thickness">' +
                                        '<ul>' +
                                        doughTypes +
                                        '</ul>' +
                                        '</div>' +
                                        '</div>' +

                                        '</div>' +

                                        '</div>' +

                                        '<div class="product-item__info">' +
                                        '<div class="product-item__price">' +
                                        '<span>{{ __('home.Price') }}: </span>' +
                                        '<span class="value"' + styleOffer + '>' + (parseFloat(
                                            item.price)).toFixed(2) + '</span>' +
                                        offerPrice +
                                        ' @lang('general.SR')' +
                                        '</div>' +
                                        '<div class="product-item__addcart">' +
                                        '<a @auth @if (!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" @endif @endauth class="uk-button uk-button-default cart" href="{{ url('/item/') }}' +
                                        '/' + item.category_id + '/' + item.id + '">' +
                                        @if (app()->getLocale() == 'ar')
                                            '<span data-uk-icon="cart"></span> {{ __('home.Add to Cart') }}' +
                                        @else
                                            '{{ __('home.Add to Cart') }} <span data-uk-icon="cart"></span>' +
                                        @endif
                                        '</a>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>');

                                }
                            });
                        } //end success
                    },
                    error: function(reject) {}
                })
            });
        </script>
    @endsection
