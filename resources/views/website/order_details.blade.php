@extends('layouts.website.app')

@section('title')
    {{ __('general.order_details') }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('website2-assets/css/style2.css') }}">
    <style>
        .page-header__top {
            margin: 20px 0px 30px !important;
        }

        a:hover,
        a:focus {
            color: #ff0000;
            text-decoration: none;
        }

        .stepper-type-2 .stepper-arrow.up {
            top: 0;
            margin-top: -5px;
        }

        .stepper-type-2 .stepper-arrow.down {
            top: 100%;
            margin-top: -20px;
            font-size: 20px;
        }

        td {
            border: 0 !important;
        }
    </style>
@endsection

@section('pageName')

    <body class="page-article dm-light">
    @endsection

    @section('content')
        <main class="page-main">
            <section class="page-header"
                style="background-image: url({{ asset('website2-assets/img/page-header-theme.jpg') }})">
                <div class="bg-shape grey"></div>
                <div class="container">
                    <div class="page-header-content">
                        <h4 class="text-white">
                            {{ __('general.My Orders') }}
                        </h4>
                        <h2 class="text-warning">
                            {!! __('general.find_your_orders') !!}
                        </h2>
                    </div>
                </div>
            </section>
            <!--/.page-header-->

            <section class="cart-section bg-grey padding">
                <div class="container">
                    <div class="row cart-header">
                        <div class="col-lg-6">
                            {{ __('general.Name') }}
                        </div>
                        <div class="col-lg-2">
                            {{ __('general.Quantity') }}
                        </div>
                        <div class="col-lg-1">
                            {{ __('menu.Price') }}
                        </div>
                        <div class="col-lg-1">{{ __('general.ofer price') }}</div>
                        <div class="col-lg-1">
                            {{ __('general.Total') }}
                        </div>
                        {{-- <div class="col-lg-1"></div> --}}
                    </div>
                    @foreach ($items as $item)
                        <div class="row cart-body pb-30 cart2{{ $item->id }}">
                            <div class="col-lg-6">
                                <div class="cart-item" style="align-items: initial">
                                    <div class="" style="height: 100%">
                                        <img loading="lazy" data-lazy="true"  src="{{ asset($item->image) }}" alt="food">
                                    </div>
                                    <div class="cart-content">
                                        <h3><a
                                                href="{{ url('item/' . $item->category_id . '/' . $item->id) }}">{{ app()->getLocale() == 'ar' ? $item->name_ar : $item->name_en }}</a>
                                        </h3>
                                        <p> {{ app()->getLocale() == 'ar' ? $item->description_ar : $item->description_en }}
                                        </p>
                                        <div >
                                            <div style="font-size: " class="small">
                                                @if (isset($item['dough_type_' . app()->getLocale()]))
                                                    <p>
                                                        {{ __('general.Dough Type') }}:
                                                        <b>{{ $item['dough_type_' . app()->getLocale()] }}</b>
                                                    </p>
                                                @endif
                                                @if (isset($item['dough_type_2_' . app()->getLocale()]))
                                                    <p>
                                                        {{ __('general.Dough Type2') }}:
                                                        <b>{{ $item['dough_type_2_' . app()->getLocale()] }}</b>
                                                    </p>
                                                @endif
                                                {{-- @php
                                                    $item->extras_objects = 
                                                @endphp --}}
                                                @if (count($item->extras_objects))
                                                    <p>
                                                        <b class="text-primary">{{ __('general.Extra') }}:</b>
                                                        {{-- <ol class="list-group list-group-horizontal list-group-numbered">
                                                            @foreach ($item->extras_objects as $extra)
                                                                <li class='list-group-item px-1'>
                                                                    {{ $extra['name_' . app()->getLocale()] }} - ({{$extra->price}} {{__('general.SR')}})
                                                                </li>
                                                            @endforeach
            
                                                        </ol> --}}
                                                    <div class="row">
                                                        @foreach ($item->extras_objects as $extra)
                                                            <div class="col-4 text-center border p-1">
                                                                {{ $extra['name_' . app()->getLocale()] }}<br>({{$extra->price}} {{__('general.SR')}})
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    </p>
                                                @endif
                                                @if (count($item->withouts_objects))
                                                    <p>
                                                        <b class="text-danger">{{ __('general.Without') }}:</b>
                                                    <ol class="list-group list-group-horizontal list-group-numbered">
                                                        @foreach ($item->withouts_objects as $without)
                                                            <li class='list-group-item px-1'>
                                                                {{ $without['name_' . app()->getLocale()] }}
                                                            </li>
                                                        @endforeach
        
                                                    </ol>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               

                            </div>
                            <div class="col-4 col-lg-2">
                                <div class="form-group stepper-type-2 quantity-up-{{ $item->id }}">
                                    <input style="width: 60%;" type="number"
                                        class="form-control text-bold quantity_ch quantity_change{{ $item->id }}"
                                        value="{{ $item->pivot->quantity }}" readonly>
                                </div>
                            </div>
                            
                            <div class="col-2 col-lg-1">
                                @php
                                    if ($item->pivot->offer_id) {
                                            $offer = \App\Models\Offer::find($item->pivot->offer_id);
                                        } else {
                                            $offer = (object)['offer_type' => ''];
                                        }
                                @endphp
                                <div class="cart-item" style="flex-direction: column;">
                                    {{-- @if ($item->pivot->offer_id)
                                        <p class="text-danger" id="price_without_offer">
                                            @isset($cart->extras_objects)
                                                <del>{{ $item->price + collect($cart->extras_objects)->sum('price') }}
                                                    {{ __('general.SR') }}</del>
                                            @else
                                                <del>{{ $item->price }} {{ __('general.SR') }}</del>
                                            @endisset

                                        </p>
                                    @endif --}}
                                    <p >
                                        {{-- @dd($item) --}}
                                        @if ($item->pivot->offer_id && $offer->offer_type != 'buy-get')
                                        <del>{{ $item->price }} {{ __('general.SR') }}</del>
                                        @else

                                        @if ($item->pivot->offer_id && $offer->offer_type == 'buy-get' && $item->pivot->offer_price == 0)
                                        <del>{{ $item->price }} {{ __('general.SR') }}</del>
                                        @else

                                        {{ $item->price }}
                                        {{ __('general.SR') }}
                                        @endif

                                        @endif

                                        
                                    </p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-1">
                                <div class="cart-item" style="flex-direction: column;">
                                    {{-- @if ($item->pivot->offer_id)
                                        <p class="text-danger" id="price_without_offer">
                                            @isset($cart->extras_objects)
                                                <del>{{ $item->price + collect($cart->extras_objects)->sum('price') }}
                                                    {{ __('general.SR') }}</del>
                                            @else
                                                <del>{{ $item->price }} {{ __('general.SR') }}</del>
                                            @endisset

                                        </p>
                                    @endif --}}
                                    @if ($item->pivot->offer_id && $offer->offer_type != 'buy-get')
                                    <p>

                                        {{ $item->pivot->offer_price }}
                                        {{ __('general.SR') }}
                                    </p>
                                    @endif

                                    @if ($item->pivot->offer_id && $offer->offer_type == 'buy-get' && $item->pivot->offer_price == 0)
                                    <p>

                                        0
                                        {{ __('general.SR') }}
                                    </p>
                                    @endif

                                </div>
                            </div>

                            <div class="col-3 col-lg-1">
                                <div class="cart-item d-flex flex-column">
                                    {{-- @if ($item->pivot->offer_id)
                                        <p class="text-danger">
                                            <del>
                                                {{ $item->price * $item->pivot->quantity }}
                                                {{ __('general.SR') }}
                                            </del>
                                        </p>
                                    @endif --}}
                                    <p>{{ ($item->pivot->offer_id ? $item->pivot->offer_price : $item->price) * $item->pivot->quantity }}
                                        {{ __('general.SR') }}
                                    </p>
                                </div>
                            </div>
                            
                        </div>
                    @endforeach
                    <form method="post" id="checkout-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                {{-- <div class="row">
                                    <div class="col-12">
                                        <div class="card-header mt-30">
                                            <h5 class='card-title'>
                                                {{ __('general.Personal information') }}
                                            </h5>
                                        </div>
                                        <div class="">
                                            <div class="row my-2">
                                                <div class="col-md-4">
                                                    <label for="full_name" style="line-height: 3;">
                                                        {{ __('general.Full name') }}</label>
                                                </div>
                                                <div class="form-field col-md-8">
                                                    <input type="text" id="full_name" name="full_name"
                                                        class="form-control" value="{{ $user->name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-md-4">
                                                    <label for="Phone" style="line-height: 3;">
                                                        {{ __('general.Phone') }}</label>
                                                </div>
                                                <div class="form-field col-md-8">
                                                    <input type="text" id="Phone" name="Phone" class="form-control"
                                                        value="{{ $user->first_phone }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-md-4">
                                                    <label for="Email" style="line-height: 3;">
                                                        {{ __('general.Email') }}</label>
                                                </div>
                                                <div class="form-field col-md-8">
                                                    <input type="text" id="Email" name="Email" class="form-control"
                                                        value="{{ $user->email }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                @isset($address)
                                    <input type="hidden" hidden name="address_id" value="{{$address['id']}}" />
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card-header mt-30">
                                                <h5 class='card-title'>
                                                    <span>{{ __('general.We will deliver your address to') }}</span>
                                                </h5>
                                            </div>
                                            <div class="">
                                                <div class="row">
                                                    <p>
                                                        {{ $address->name }}
                                                    </p>
                                                    <p class="small text m-0">
                                                        {{ app()->getLocale() == 'ar' ? $address->city->name_ar : $address->city->name_en }}
                                                        ,
                                                        {{ app()->getLocale() == 'ar' ? $address->area->name_ar : $address->area->name_en }}
                                                    </p>
                                                </div>
                                                <div class="row">
                                                    <p class="small text m-0">{{ $address->street }}
                                                        , {{ __('general.BuildNo') }}: {{ $address->building_number }}
                                                        , {{ __('general.FloorNo') }}: {{ $address->floor_number }}
                                                        , {{ __('general.Landmark') }}: {{ $address->landmark }}
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endisset

                                @isset($branch)
                                    <div class='row my-3'>
                                        <div class="card-header">
                                            <h5 class='card-title'>
                                                {{ __('general.Receive Your Order From') }}
                                            </h5>
                                        </div>
                                        <div class="checkout-form">
                                            <div class="row my-2">
                                                <p class="">
                                                    {{ app()->getLocale() == 'ar' ? $branch->name_ar : $branch->name_en }}</p>

                                                <p class="small text m-0">
                                                    {{ app()->getLocale() == 'ar' ? $branch->address_description_ar . ' ' . $branch->city->name_ar . ' ' . $branch->area->name_ar : $branch->address_description_en . ' ' . $branch->city->name_en . ' ' . $branch->area->name_en }}
                                                </p>
                                            </div><br>
                                            <div class="row">
                                                @if (isset($work_hours))
                                                    <h6 class="mb-0">{{ __('general.Working Hours') }}</h6>
                                                    @foreach ($work_hours as $h)
                                                        <p class="small text-muted m-0">{{ __('general.From') }}
                                                            : {{ $h->time_from }} {{ __('general.To') }}
                                                            :{{ $h->time_to }}</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endisset

                                <div class='row my-3'>
                                    <div class="card-header">
                                        <h5 class='card-title'>
                                            {{ __('general.payment_type') }}:&nbsp;&nbsp;<b
                                                class="uppercase">{{ $order->payment_type }}</b>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($order->payment_type === 'online' && $payment)
                                            <h6>
                                                {{ __('general.Details') }}
                                            </h6>
                                            <div class="row mb-3">
                                                <label for="paymentID" class="col-sm-2 col-form-label">
                                                    {{ __('general.ID') }}
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="paymentID"
                                                        value="{{ $payment->payment_id }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="paymentStatus" class="col-sm-2 col-form-label">
                                                    {{ __('general.status') }}
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="paymentStatus"
                                                        value="{{ __('general.' . str_replace(' (Test Environment)', '', $payment->status)) }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="paymentmessage" class="col-sm-2 col-form-label">
                                                    {{ __('general.message') }}
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="paymentmessage"
                                                        value="{{ __('general.' . str_replace(' (Test Environment)', '', $payment->message)) }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="paymentmessage" class="col-sm-2 col-form-label">
                                                    {{ __('general.date_time') }}
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="paymentmessage"
                                                        value="{{ $payment->updated_at->translatedFormat('d M Y H:i:sa') }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-header mt-30">
                                            <h5 class='card-title text-center'>
                                                {{ __('general.loyality_earneings') }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-text row font-weight-bold text-indigo">
                                                <div class="col-md-4">
                                                    {{ __('general.Total') }}
                                                </div>
                                                <div class="col-lg-4 hidden visible-lg text-dark">
                                                    @if ($order->state == 'pending' || $order->state == 'in-progress')
                                            {{__('general.Pending')}}
                                        @elseif ($order->state == 'completed')
                                        <span class="text-success"> {{__('general.Valid')}} </span>
                                        @else
                                        {{__('general.in Valid')}}
                                        @endif
                                                </div>
                                                <div class="col-lg-4 text-danger">
                                                    <span id="to-earn">
                                                        {{ round($order->total) }}</span> {{ __('general.Points') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-header mt-30">
                                            <h5 class='card-title'>
                                                {{ __('general.Description') }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-text">
                                                {{ $order->description_box }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="cart-total mt-30">
                                    @isset($reorder)
                                        <input type="hidden" hidden name="reorder_me" value="1" />
                                        <input type="hidden" hidden name="order_id" value="{{$order['id']}}" />
                                    @endisset
                                    <li>
                                        {{ __('general.Sub Total') }}: </b> <span
                                            id="subtotal"style="font-size: smaller;">{{ $order['subtotal'] }}
                                            {{ __('general.SR') }}</span>
                                        <input id="subtotalinput" hidden
                                            name="subtotal"value="{{ $order['subtotal'] }}" />
                                    </li>
                                    <li><b class="inset-right-5 text-gray-light">{{ __('general.Taxes') }}
                                            : </b>
                                        <span id="taxes" style="font-size: smaller;">{{ $order['taxes'] }}
                                            {{ __('general.SR') }}</span>
                                        <input id="taxesinput" hidden name="taxes" value="{{ $order['taxes'] }}" />
                                    </li>
                                    @if ($order->service_type == 'delivery')
                                    <li><b class="inset-right-5 text-gray-light">{{ __('general.Delivery Fees') }}
                                            : </b> <span id="delivery_fees"
                                            style="font-size: smaller;">{{ $order['delivery_fees'] }}
                                            {{ __('general.SR') }}</span>
                                        <input id="delivery_feesnput" hidden name="delivery_fees"
                                            value="{{ $order['delivery_fees'] }}" />
                                    </li>
                                    @endif
                                    @if (isset($order['points']))
                                        <li><b class="inset-right-5 text-gray-light">{{ __('general.Loyality Discount') }}
                                                : </b> <span id="points" style="font-size: smaller;"> -
                                                {{ round($order['points_paid'], 2) }} {{ __('general.SR') }}</span>
                                            <input id="pointsinput" hidden name="points_paid"
                                                value="{{ $order['points_paid'] }}" />

                                        </li>
                                    @endif

                                    @if (round($order['offer_value']) > 0)
                                        <li><b class="inset-right-5 text-gray-light">{{ __('general.discount') }}
                                                : </b> <span id="points" style="font-size: smaller;">- 
                                                {{ round($order['offer_value'], 2) }}
                                                {{ __('general.SR') }}</span>
                                            <input id="discount-offers" hidden name="discount"
                                                value="{{ round($order['offer_value'], 2) }}" />
                                        </li>
                                    @endif
                                    @if ($order->is_first_order)
                                        <li><b class="inset-right-5 text-gray-light">{{ __('general.first_discount') }}
                                                : </b> <span style="font-size: smaller;" id="total">-
                                                {{ $order['total'] }}
                                                {{ __('general.SR') }}</span>
                                        </li>
                                    @endif
                                    <li><b class="inset-right-5 text-gray-light">{{ __('general.Total') }}
                                            : </b> <span style="font-size: smaller;" id="total">{{ $order['total'] }}
                                            {{ __('general.SR') }}</span>
                                        <input id="totalinput" hidden name="total" value="{{ $order['total'] }}" />
                                    </li>
                                    @if (strpos(request()->getUri(), 'reorder') > -1)
                                        <li>
                                            <p>{{ __('general.continue') }}</p>
                                            {{-- <button type="submit" class="default-btn"
                                                style="border-radius: 5px;">
                                                {{ __('general.Checkout') }}<span></span>
                                            </button> --}}
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn default-btn rounded checkout-btn">
                                                <i class="fas fa-spinner fa-spin" style="display: none"></i>
                                                {{ __('general.Checkout') }}
                                                <span></span>
                                            </button>
                                        </li>
                                    @endif
                                    <!-- Modal -->
                                    <div class="modal fade" id="reorder-error" tabindex="-1"
                                        aria-labelledby="reorder-errorLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content"
                                                style="color: #842029;
                                            background-color: #f8d7da;
                                            border-color: #f5c2c7;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="reorder-errorLabel">
                                                        {{ __('general.reorder_err') }}
                                                    </h5>
                                                    <button type="button" class="btn-close" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span id="message"></span>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('menu.page') }}" class="btn default-btn rounded">
                                                        {{ __('menu.Menu') }}
                                                        <span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </section>
            <!--/.cart-section-->
        </main>
    @endsection

    @section('scripts')
        {{-- <script src="{{ asset('website2-assets/js/core.min.js') }}"></script>
        <script src="{{ asset('website2-assets/js/script.js') }}"></script> --}}
        <script>
            $(document).ready(function() {
                let busy = false;
                const reorderErrorModal = new bootstrap.Modal('#reorder-error', {
                    // backdrop: 'static',
                    keyboard: false,
                });
                $('.checkout-btn').click(function() {
                    if (busy) return false;
                    busy = true;

                    $('.fa-spin').css('display', 'inline-block');

                    $.ajax({
                        url: "{{ route('re-order-check', $order->id) }}",
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        data: {
                            points_paid: {{ $order['points'] === null ? 0 : $order['points'] }},
                        },
                        success: function(res) {
                            if (!res.validation) {
                                // show alert with message
                                $('span#message').text(res.message);
                                // $('#confirm-modal').addClass('');
                                reorderErrorModal.show();
                                // hide reorder button
                                $('.checkout-btn').css('display', 'none');
                                return;
                            }

                            $('#checkout-form').attr('action', "{{ route('get_checkout_reorder') }}");
                            $('#checkout-form').submit();

                            // window.location.href = "{{ route('get.cart') }}";
                        },
                        error: function(err) {
                            // console.log(err);
                        },
                        complete: function() {
                            busy = false;
                            $('.fa-spin').css('display', 'none');
                        }
                    });
                })
            });
        </script>
        @php

        @endphp
    @endsection
