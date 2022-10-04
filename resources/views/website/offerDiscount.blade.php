@extends('layouts.website.app')

@section('title') Offer @endsection

@section('styles')@endsection

@section('pageName') <body class="page-catalog dm-dark"> @endsection

@section('content')
<section class="page-header">
            <div class="bg-shape grey"></div>
            <div class="container">
                <div class="page-header-content">
                 
                    <h2>{{__('general.Offer Menu')}}</h2>
                  
            </div>
        </section><!--/.page-header-->
    <main class="page-main">
        <div class="page-content">
            <div class="uk-container">
                <div>
                    <div class="py-2"> 
                        <div class="row">
                            <div class="product-full-card__tabs w-100 mt-0">

                                <div class="row">
                                    @if($offers['details']['items']->count() > 0)
                                        <div class="col-sm-11 m-auto">
                                        <div class="row"> 
                                            @foreach($offers['details']['items'] as $item)
                                            <div class="col-md-6" style="margin-bottom: 1%;">
                                                <div class="rounded border" style="background-color: #f5f5f5!important;box-shadow: 0.1rem 0rem 1.5rem rgb(0 0 0 / 20%);">
                                                        <form id="addToCard" action="{{route('add.cart')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="item_id" value="{{$item['id']}}">
                                                            <input type="hidden" name="quantity" value="{{$offers['details']['quantity']}}">
                                                            <input type="hidden" name="offer_id" value="{{$offers['details']['offer_id']}}">
                                                            <input type="hidden" name="offer_price" value="{{round($item['offer_price'], 2)}}">
                                                            <div class="gold-members p-3 border-bottom">
                                                                <div class="media d-flex">
                                                                    <div class="mr-3 col-3" style="height: 150px;width: 150px;">
                                                                        <img class="img-thumbnail rounded w-100 h-100" src="{{asset($item['image'])}}" alt="">
                                                                    </div>
                                                                    <div class="media-body" style="margin-left: 2%;">
                                                                        <h6 class="m-0" style="font-size: 14px;line-height: 1.8;">{{(app()->getLocale() == 'ar')? $item['name_ar'] : $item['name_en'] }}</h6>
                                                                        <ul class="product-meta">
                                                                                <li>{{__('general.calories')}}:<a href="javascript:void(0)">{{ $item['calories'] }}</a></li>
                                                                            </ul>       
                                                                        <span>{{__('menu.Price')}}: </span><span class="value text-danger" style="text-decoration: line-through;font-size: 20px;" > {{$item['price']}} {{__('general.SR')}}</span>
                                                                        <span style="font-size: 26px;color:#6dc405;text-decoration: none">
                                                                            {{round($item['offer_price'], 2)}} {{__('general.SR')}}
                                                                        </span>
                                                                        <br>
                                                                        <button type="submit" class="default-btn btn-sm float-left btnAdd">Add to cart<span></span></button>

                                                                    </div>

                                                                </div>
                                                                

                                                            </div>
                                                            </div>
                                                            </div>
                                                        </form>
                                                    @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')@endsection
