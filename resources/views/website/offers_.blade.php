@extends('layouts.website.app')

@section('title') Offers @endsection

@section('styles')
<style>
   h6,h5,h4,h3,h2{
        font-family: inherit;
    }
</style>

@endsection

@section('pageName')
    <body class="page-article dm-light"> @endsection

    @section('content')
        <main>
            <div class="page-content">
                <div class="uk-container">
                    <div>
                        <div class="py-2">
                            <h2 class="mb-3 mt-0">{{__('general.Offers')}}</h2>
                            <div class="row">
                                @if(isset($offers))
                                    @foreach($offers as $offer)
                                        <div class="col-md-4 mb-3 mt-3" style="padding-right: 15px;padding-left: 15px;">
                                            <div class="card offer-card border-1 shadow-sm rounded" style="background-color: inherit;">
                                                <div class="card-body p-0">
                                                    <h5 class="card-title w-100 h-100"><img loading="lazy" data-lazy="true"  class="w-100 h-100 img-thumbnail rounded" src="{{asset($offer->image)}}"></h5>
                                                   <div class="pl-4 pr-4 pb-1 pt-0" style="overflow: hidden">
                                                       <h3 class="mt-2 mb-1 font-weight-bold">{{(app()->getLocale() == 'ar') ?$offer->title_ar:$offer->title}}</h3>

                                                       <p style="line-height: 1.3;font-size: 12px;"
                                                          class="card-subtitle mb-3 text-muted">
                                                           {{(app()->getLocale() == 'ar') ?$offer->description_ar:$offer->description}}
                                                       </p>
                                                       <h6 class="float-left card-subtitle mt-2 mb-3">{{__('general.Offer')}}: {{$offer->offer_type}}</h6>
                                                       <a href="{{route('offer.item',$offer->id)}}" class="float-right" style="color: red;font-weight: bold">{{__('general.Get Offer')}} >></a>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

@endsection

@section('scripts')@endsection
