@extends('layouts.website.app')

@section('title') Menu @endsection

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
                     style="background-image: url({{asset('website-assets/img/pages/home/menu.jpg')}})"></div>
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
                    <div data-uk-filter="target: .js-filter">
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
                        <div class="mt-5 uk-light" >

                            <div class="items row">

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
                        console.log(data.data);
                        $('.items').html('');
                        $.each(data.data, function(index, item) {
                            console.log(item);
                            if(! item.website_is_hidden)
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
                                    '<div class="col-md-3 col-s-12">'+
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
                                    '</div>');

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
