@extends('layouts.website.app')

@section('title') {{__('general.Offer')}} @endsection

@section('styles')
    <style>
        .white{
            color:white;
        }
        .btn-primary{
            background: #007bff!important;
            color:white;
            border-color: #007bff!important;
        }
        .btn-outline-primary{
            border-color: #007bff!important;
        }
        .btn-success {
            color: #fff;
            background-color: #198754 !important;
            border-color: #198754 !important;
        }
    </style>
@endsection

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
                        <!-- <h2 class="mb-3 mt-0">{{__('general.Offer Menu')}}</h2> -->
                        <div class="row">
                            <div class="product-full-card__tabs w-100 mt-0">
                                <form id="addToCard" action="{{route('add.cart')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="offer_id" value="{{$offers['buy_get']['offer_id']}}">
                                    <input type="hidden" hidden name="from_buy_gey" value="1" />
                                    <div class="row">
                                        @if(count($offers['details']['buy_items']) > 0)
                                            <div class="col-sm-11 m-auto">
                                                <h3 class="mb-4 mt-3 col-md-12">{{__('general.Buy')}} <small class="h6 text-black-50">  {{$offers['buy_get']['buy_quantity']}}</small></h3>
                                                   <div class="row">
                                                    @foreach($offers['details']['buy_items'] as $buyItem)
                                                 
                                                    <div class="col-md-6" style="margin-bottom: 1%;">
                                                        <div class="rounded border" style="background-color: #f5f5f5!important;box-shadow: 0.1rem 0rem 1.5rem rgb(0 0 0 / 20%);">
                                                                <input type="hidden" name="offer_price[]" value="{{round($buyItem['price'], 2)}}">
                                                                <div class="gold-members p-3 border-bottom">
                                                                    <div class="media d-flex">
                                                                        <div class="mr-3 col-3" style="height: 150px;width: 150px;">
                                                                            <img class="img-thumbnail rounded h-100 w-100" src="{{asset($buyItem['image'])}}" alt="">
                                                                        </div>
                                                                        <div class="media-body" style="margin-left: 2%;">
                                                                            <h4 class="m-0" style="font-size: 20px;line-height: 1.8;">{{(app()->getLocale() == 'ar')? $buyItem['name_ar'] : $buyItem['name_en'] }}</h4>
                                                                            <ul class="product-meta">
                                                                                <li>{{__('general.calories')}}:<a href="javascript:void(0)">{{ $buyItem['calories'] }}</a></li>
                                                                            </ul>           
                                                                            <p class="text-gray m-0" style="font-size: 12px;">{{__('menu.Price')}}: <span class="text-danger font-weight-bold">{{round($buyItem['price'], 2)}} {{__('general.SR')}}</span></p>
                                                                            <a class="default-btn float-right buyBtnAdd" href="#">{{__('general.Buy')}}<span></span></a>
                                                                            <input hidden type="checkbox" value="{{$buyItem['id']}}"  name="buy_items[]"  class="checkItem">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                @endforeach
                                            </div>
                                            </div>
                                        @endif
                                        @if(count($offers['details']['get_items']) > 0)
                                            <div class="col-sm-11 m-auto">
                                                <h3 class="mb-4 mt-3 col-md-12">{{__('general.Get')}} <small class="h6 text-black-50">  {{$offers['buy_get']['get_quantity']}}</small></h3>
                                                  <div class="row">
                                                @foreach($offers['details']['get_items'] as $getItem)
                                                  <div class="col-md-6" style="margin-bottom: 1%;">
                                                        <div class="rounded border" style="background-color: #f5f5f5!important;box-shadow: 0.1rem 0rem 1.5rem rgb(0 0 0 / 20%);">
                                                            <div class="gold-members p-3 border-bottom">
                                                                <div class="media d-flex">
                                                                    <div class="mr-3 col-3" style="height: 150px;width: 150px;">
                                                                        <img class="img-thumbnail rounded h-100 w-100" src="{{asset($getItem['image'])}}" alt="">
                                                                    </div>
                                                                    <div class="media-body" style="margin-left: 2%;">
                                                                        <h4 class="m-0" style="font-size: 20px;line-height: 1.8;">{{(app()->getLocale() == 'ar')? $getItem['name_ar'] : $getItem['name_en'] }}</h4>
                                                                        <ul class="product-meta">
                                                                                <li>{{__('general.calories')}}:<a href="javascript:void(0)">{{ $buyItem['calories'] }}</a></li>
                                                                            </ul>    
                                                                        <p class="text-gray m-0 " style="font-size: 12px;">{{__('menu.Price')}}: <span class="text-success font-weight-bold">0 {{__('general.SR')}}</span></p>
                                                                        <a class="default-btn float-right getBtnAdd" href="#">{{__('general.Buy')}}<span></span></a>
                                                                        <input  hidden type="checkbox" value="{{$getItem['id']}}" name="get_items[]" id="get_item" class="checkItem">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                 @endforeach
                                            </div>
                                            </div>
                                        @endif
                                            <div class="col-sm-3 mt-4 offset-9">
                                                <button class="default-btn submitOffer" style="@if(app()->getLocale() == 'en') margin-left: 50px; @else margin-right: 115px; @endif" type="submit"> {{__('general.Confirm Offer')}}<span></span></button>
                                            </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $( document ).ready(function() {
            var buy_quantity = parseInt({{$offers['buy_get']['buy_quantity']}});
            var get_quantity = parseInt({{$offers['buy_get']['get_quantity']}});

            var buy_quantity_counter = 0;
            var get_quantity_counter = 0;

            $('.buyBtnAdd').click(function (e) {
               
                e.preventDefault();
                let selectele = $(this);
                if(buy_quantity_counter < buy_quantity){
                   
                    if(selectele.text() == "{{__('general.Buy')}}"){
                        selectele.text("{{__('general.Cancel')}}");
                        selectele.addClass("btn-success");
                        selectele.removeClass("btn-primary");
                        selectele.next().attr('checked','checked');
                        buy_quantity_counter++;
                    }
                    else {
                        selectele.text("{{__('general.Buy')}}");
                        selectele.removeClass("btn-success");
                        selectele.addClass("btn-primary");
                        selectele.next().attr('checked','');
                        buy_quantity_counter--;
                    }
                }
                else if(buy_quantity_counter <= buy_quantity){
                    if(selectele.text() == "{{__('general.Cancel')}}"){
                        selectele.text("{{__('general.Buy')}}");
                        selectele.removeClass("btn-success");
                        selectele.addClass("btn-primary");
                        selectele.next().attr('checked','');
                        buy_quantity_counter--;
                    }
                    else
                    {
                        alert('{{__('general.you cant choose more than')}}: ' + buy_quantity + ' {{__('general.items')}}')
                    }
                }
                else
                {
                    alert('{{__('general.you cant choose more than')}}: ' + buy_quantity + ' {{__('general.items')}}')
                }
            });

            $('.getBtnAdd').click(function (e) {
                e.preventDefault();
                let selectele = $(this);
                if(get_quantity_counter < get_quantity){
                    if(selectele.text() == "{{__('general.Buy')}}"){
                        selectele.text("{{__('general.Cancel')}}");
                        selectele.addClass("btn-success");
                        selectele.removeClass("btn-primary");
                        selectele.next().attr('checked','checked');
                        // console.log(selectele.next());
                        get_quantity_counter++;
                    }
                    else {
                        selectele.text("{{__('general.Buy')}}");
                        selectele.removeClass("btn-success");
                        selectele.addClass("btn-primary");
                        selectele.next().attr('checked','');
                        get_quantity_counter--;
                    }
                }
                else if(get_quantity_counter <= get_quantity){
                    if(selectele.text() == "{{__('general.Cancel')}}"){
                        selectele.text("{{__('general.Buy')}}");
                        selectele.removeClass("btn-success");
                        selectele.addClass("btn-primary");
                        selectele.next().attr('checked','');
                        get_quantity_counter--;
                    }
                    else
                    {
                        alert('{{__('general.you cant choose more than')}}: ' + get_quantity + ' {{__('general.items')}}')
                    }
                }
                else
                {
                    alert('{{__('general.you cant choose more than')}}: ' + get_quantity + ' {{__('general.items')}}')
                }

            });

            $('.submitOffer').click(function (e){
                e.preventDefault();
                if(get_quantity == get_quantity_counter && buy_quantity == buy_quantity_counter){
                    @if($cartHasOffers)
                    const myModalAlternative = new bootstrap.Modal('#offersMultibleInOneOrder');
                    myModalAlternative.show();
                    @else
                        $('#addToCard').submit();
                    @endif
                }
                else if (buy_quantity > buy_quantity_counter){
                    alert('{{__('general.Please buy')}} {{$offers['buy_get']['buy_quantity']}} {{__('general.at least')}} {{__('general.to get')}} {{$offers['buy_get']['get_quantity']}}')
                }
                else if (get_quantity > get_quantity_counter){
                    alert('{{__('general.Please buy')}} {{$offers['buy_get']['get_quantity']}} {{__('general.at least')}} {{__('general.to get')}} {{$offers['buy_get']['buy_quantity']}}')
                }

            });


        });
    </script>
@endsection
