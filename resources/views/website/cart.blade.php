@extends('layouts.website.app')

@section('title')
    {{ __('general.cart') }}
@endsection

@section('styles')
    {{-- <link rel="stylesheet" href="{{asset('website2-assets/css/style2.css')}}"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .list-group-item {
            background-color: transparent;
            padding: 2px;
        }

        .small * {
            font-size: 14px;
        }
    </style>
@endsection

@section('pageName')

    <body class="page-article dm-light">
    @endsection

    @section('content')
        <section class="page-header" style="background-image: url({{ asset('website2-assets/img/page-header-theme.jpg') }})">
            <div class="bg-shape grey"></div>
            <div class="container">
                <div class="page-header-content">
                    <h4>
                        {{ __('general.cart') }}
                    </h4>
                    <h2>
                        {{ __('general.my_cart') }}
                    </h2>
                </div>
            </div>
        </section>
        <!--/.page-header-->

        <section class="cart-section bg-grey padding">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-12">
                        @if(session()->has('loyality_not_used'))
                        <div x-data x-init="() => {
                            const myModalAlternative = new bootstrap.Modal('#loyalityerror', {
                                backdrop: 'static',
                            });
                            myModalAlternative.show();
                        }"></div>
                        <div class="modal fade" id="loyalityerror" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loyalityerrorLabel" aria-modal="true" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                              <div class="modal-content">
                                <div class="modal-header bg-danger">
                                  <h5 class="modal-title text-white">{{__('general.confirm')}}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body alert-danger m-0">
                                  <p>
                                    {!! session('loyality_not_used') !!}
                                  </p>
                                </div>
                                <div class="modal-footer">
                                  <a href="{{route('menu.page')}}" class="btn default-btn rounded bg-info" >
                                    {{__('general.go_menu')}}
                                <span></span>
                                </a>
                                  <a href="{{route('loyalty.unset')}}" class="btn default-btn rounded bg-primary">
                                    {{__('general.remove_loyality')}}
                            <span></span></a>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endif
                    </div>
                </div>
                <div class="row cart-header">
                    <div class="col-lg-6">{{ __('general.Name') }}</div>
                    <div class="col-lg-3">{{ __('general.Quantity') }}</div>
                    <div class="col-lg-1">{{ __('menu.Price') }}</div>
                    <div class="col-lg-1">{{ __('general.Total') }}</div>
                    <div class="col-lg-1"></div>
                </div>
                @if ($carts->count())
                    @foreach ($carts as $cart)
                        <div class="row cart-body pb-30 cart2{{ $cart->id }}">
                            <div class="col-lg-6">
                                <div class="cart-item">
                                    <img src="{{ asset($cart->item->image) }}" alt="food">
                                    <div class="cart-content w-100">
                                        <h3><a
                                                href="{{ url('item/' . $cart->item->category_id . '/' . $cart->item->id) }}">{{ app()->getLocale() == 'ar' ? $cart->item->name_ar : $cart->item->name_en }}</a>
                                        </h3>
                                        {{-- <p> {{ app()->getLocale() == 'ar' ? $cart->item->description_ar : $cart->item->description_en }}
                                        </p> --}}
                                        <div style="font-size: 10px" class="small">
                                            @if (isset($cart['dough_type_' . app()->getLocale()]))
                                                <p>
                                                    {{ __('general.Dough Type') }}:
                                                    <b>{{ $cart['dough_type_' . app()->getLocale()] }}</b>
                                                </p>
                                            @endif
                                            @if (isset($cart['dough_type_2_' . app()->getLocale()]))
                                                <p>
                                                    {{ __('general.Dough Type2') }}:
                                                    <b>{{ $cart['dough_type_2_' . app()->getLocale()] }}</b>
                                                </p>
                                            @endif
                                            @if (count($cart->extras_objects))
                                                <p>
                                                    <b class="text-primary">{{ __('general.Extra') }}:</b>
                                                <div class="row">
                                                    @foreach ($cart->extras_objects as $extra)
                                                        <div class="col-4 text-center border p-1">
                                                            {{ $extra['name_' . app()->getLocale()] }}<br>({{$extra->price}} {{__('general.SR')}})
                                                        </div>
                                                    @endforeach
                                                </div>
                                                </p>
                                            @endif
                                            @if (count($cart->withouts_objects))
                                                <p>
                                                    <b class="text-danger">{{ __('general.Without') }}:</b>
                                                <ol class="list-group list-group-horizontal list-group-numbered">
                                                    @foreach ($cart->withouts_objects as $without)
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
                            <div class="col-4 col-lg-3">
                                <div class="form-group stepper-type-2 quantity-up-{{ $cart->id }}">
                                    <i class="fas fa-spinner fa-spin d-none"></i>
                                    @php
                                        $disalbleQty = false;
                                        if ($cart->offer_id && !$cart->dough_type_ar) {
                                            $offer = \App\Models\Offer::find($cart->offer_id);
                                            // dd($offer);
                                            if ($offer->offer_type == 'buy-get') {
                                                $disalbleQty = true;
                                            }
                                        }
                                    @endphp
                                    <input style="width: 30%;display: inline;" type="number"
                                        @if ($disalbleQty) disabled @endif data-zeros="true"
                                        value="{{ $cart->quantity }}" min="1" max="20" readonl
                                        data-id="{{ $cart->id }}" data-price="{{ $cart->price }}"
                                        data-prev="{{ $cart->quantity }}" data-price-without-offer="{{$cart->offer_id ? isset($cart->extras_objects) ? $cart->item->price + collect($cart->extras_objects)->sum('price') : $cart->item->price : $cart->price }}"
                                        data-url="{{ route('item.page', [$cart->item->category_id, $cart->item]) }}"
                                        class="form-control text-bold quantity_ch quantity_change{{ $cart->id }}" id="quantity_change{{ $cart->id }}">
                                        
                                </div>
                            </div>
                            <div class="col-3 col-lg-1">
                                <div class="cart-item" style="flex-direction: column;">
                                    @if ($cart->offer_id)
                                        <p class="text-danger" id="price_without_offer">
                                            @isset($cart->extras_objects)
                                                <del>{{ $cart->item->price + collect($cart->extras_objects)->sum('price') }}
                                                    {{ __('general.SR') }}</del>
                                            @else
                                                <del>{{ $cart->item->price }} {{ __('general.SR') }}</del>
                                            @endisset

                                        </p>
                                    @endif
                                    <p>

                                        {{ $cart->price }}
                                        {{ __('general.SR') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-1">
                                <div class="cart-item d-flex flex-column">
                                    @if ($cart->offer_id)
                                        <p class="text-danger">
                                            @isset($cart->extras_objects)
                                                <del><span id="without-offer-total{{$cart->id}}">{{ ($cart->item->price + collect($cart->extras_objects)->sum('price')) * $cart->quantity }}</span>
                                                    {{ __('general.SR') }}</del>
                                            @else
                                                <del><span id="without-offer-total{{$cart->id}}">{{ $cart->item->price * $cart->quantity }}</span> {{ __('general.SR') }}</del>
                                            @endisset

                                        </p>
                                    @endif
                                    <p> <span id="total{{ $cart->id }}">{{ $cart->price * $cart->quantity }}</span>
                                        {{ __('general.SR') }}</p>
                                </div>
                            </div>
                            <div class="col-2 col-lg-1 ">
                                <div @auth
                                        @if (!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" @endif
                                    @endauth class="cart-item delete_cart cart" data-id="{{ $cart->id }}">
                                    <a class="remove" href="javascript:void(0)"><i class="las la-times"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('checkout') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-header mt-30">
                                <h5 class='card-title text-center'>
                                    {{__('general.loyality_earneings')}}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="card-text row font-weight-bold text-indigo">
                                    <div class="col-md-4">
                                        {{__('general.Total')}}
                                    </div>
                                    <div class="col-lg-4 hidden visible-lg text-success">
                                        {{__('general.applied')}}
                                    </div>
                                    <div class="col-lg-4 text-danger">
                                        <span id="to-earn">
                                            {{round($arr_check['total'])}}</span> {{__('general.Points')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="cart-total mt-30">
                                <li>
                                    {{ __('general.Sub Total') }}: </b>
                                    {{-- <span
                                        id="subtotal"style="font-size: smaller;">{{ $arr_check['subtotal'] - round($arr_check['subtotal'] - $arr_check['subtotal'] / 1.15, 2) }}
                                        {{ __('general.SR') }}</span> --}}
                                    <span
                                        id="subtotal"style="font-size: smaller;">{{ $arr_check['subtotal_without_offer'] - round($arr_check['subtotal_without_offer'] - $arr_check['subtotal_without_offer'] / 1.15, 2) }}
                                        {{ __('general.SR') }}</span>
                                    <input id="subtotalinput" hidden
                                        name="subtotal"value="{{ $arr_check['subtotal_without_offer'] - round($arr_check['subtotal_without_offer'] - $arr_check['subtotal_without_offer'] / 1.15, 2) }}" />
                                </li>
                                <li><b class="inset-right-5 text-gray-light">{{ __('general.Taxes') }}
                                        : </b>
                                    <span id="taxes"
                                        style="font-size: smaller;">{{ round($arr_check['subtotal_without_offer'] - $arr_check['subtotal_without_offer'] / 1.15, 2) }}
                                        {{ __('general.SR') }}</span>
                                    <input id="taxesinput" hidden name="taxes"
                                        value="{{ $arr_check['subtotal_without_offer'] - $arr_check['subtotal_without_offer'] / 1.15 }}" />
                                </li>

                                <li><b class="inset-right-5 text-gray-light">{{ __('general.Delivery Fees') }}
                                        : </b> <span id="delivery_fees"
                                        style="font-size: smaller;">{{ $arr_check['delivery_fees'] }}
                                        {{ __('general.SR') }}</span>
                                    <input id="delivery_feesnput" hidden name="delivery_fees"
                                        value="{{ $arr_check['delivery_fees'] }}" />
                                </li>
                                @if ($arr_check['subtotal_without_offer'] > $arr_check['subtotal'])
                                    <li><b class="inset-right-5 text-gray-light">{{ __('general.discount') }}
                                            : </b>
                                        <span id="">
                                            -
                                            <span id="discount" style="font-size: smaller;">
                                                {{ round($arr_check['subtotal_without_offer'] - $arr_check['subtotal'], 2) }}
                                            </span>
                                            <span style="font-size: smaller;">
                                                {{ __('general.SR') }}
                                            </span>
                                        </span>
                                        <input id="discountinput" hidden name="discount"
                                            value="{{ round($arr_check['subtotal_without_offer'] - $arr_check['subtotal'], 2) }}" />
                                    </li>
                                @endif
                                @if (isset($arr_check['points']))
                                    <li><b class="inset-right-5 text-gray-light">{{ __('general.Loyality Discount') }}
                                            : </b> <span> -
                                            <span id="points"
                                                style="font-size: smaller;">{{ round($arr_check['points'], 2) }}</span>
                                            <span id="points" style="font-size: smaller;">
                                                {{ __('general.SR') }}</span></span>
                                        <input id="pointsinput" hidden name="points_paid"
                                            value="{{ $arr_check['points'] }}" />
                                        <input id="pointsValue" hidden name="points_value"
                                            value="{{ $arr_check['points_value'] }}" />
                                    </li>
                                @endif

                                @if ($firstDiscount)
                                <li>
                                    <b class="inset-right-5 text-gray-light">{{ __('general.first_discount') }}
                                        : </b> <span style="font-size: smaller;">50%</span>
                                </li>
                                @endif

                                <li><b class="inset-right-5 text-gray-light">{{ __('general.Total') }}
                                        : </b> <span style="font-size: smaller;" id="total">{{ $firstDiscount ? round($arr_check['total'] /2, 2) : $arr_check['total'] }}
                                        {{ __('general.SR') }}</span>
                                    <input id="totalinput" hidden name="total" value="{{ $firstDiscount ? round($arr_check['total'] /2, 2) : $arr_check['total'] }}" />
                                </li>

                                <li>
                                    <p>{{ __('general.continue') }}</p><button type="submit" class="default-btn"
                                        style="border-radius: 5px;">
                                        {{ __('general.Checkout') }}<span></span></button>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
        </section>
        <!--/.cart-section-->

        <!-- Modal -->
        <div class="modal fade" id="incressItemQuantity" tabindex="-1" aria-labelledby="incressItemQuantityLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="incressItemQuantityLabel">
                            {{ __('general.confirm') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('general.add_item_confirm') }}
                    </div>
                    <div class="modal-footer">
                        <a class="btn default-btn rounded shadow-sm bg-danger item-link">
                            {{ __('general.open_item') }}
                            <span></span>
                        </a>
                        <button type="button" class="btn default-btn rounded shadow-sm bg-primary confirm">
                            {{ __('general.confirm_txt') }}
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        @if (session()->has('branch_closed'))
        <div class="modal fade" id="branchClosed" tabindex="-1" aria-labelledby="branchClosedLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="branchClosedLabel">
                            {{ __('general.warning') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-capitalize">
                        {{ __('general.branch_is_closed', ['branch' => session('branch_name')]) }}
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('takeaway.page')}}" class="btn default-btn rounded shadow-sm bg-primary confirm">
                            {{ __('general.go_branches') }}
                            <span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif


    @endsection

    @section('scripts')
        {{-- <script src="{{asset('website2-assets/js/core.min.js')}}"></script>
    <script src="{{asset('website2-assets/js/script.js')}}"></script> --}}
        <script>
            $(document).ready(function() {
                const quantityConfirm = new bootstrap.Modal('#incressItemQuantity', {
                    keyboard: false,
                    backdrop: 'static',
                });

                @if (session()->has('branch_closed'))
                    const branchModal = new bootstrap.Modal('#branchClosed', {
                        keyboard: false,
                    });
                    branchModal.show();
                @endif

                $(document).on('click', '.delete_cart', function(e) {
                    e.preventDefault();
                    
                    var id = $(this).attr('data-id');
                    console.log('quantity_change'+id);
                    if(document.getElementById('quantity_change'+id).disabled){
                        let text = "{!! __('general.confirm delete offer')!!} ";
                            if (confirm(text) != true) {
                                    return false; 
                            }
                            }
                    else{console.log(document.getElementById('quantity_change'+id).disabled)}
                    $(this).find('i').addClass('fas fa-spinner fa-spin').removeClass('la-times');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: '{{ route('delete.cart') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'cart_id': id,
                        },
                        success: function(data) {
                            $.each(data.carts, function(index, deletedCart) {
                                $(`.cart1${deletedCart.id}`).hide();
                                $(`.cart2${deletedCart.id}`).hide();
                                $(`.cart3${deletedCart.id}`).hide();
                            });
                            $('.cart-count').text((parseInt($('.cart-count').first().text(), 10) -
                                1));
                            // $('#itemcount').text((parseInt($('#itemcount').text())) - data.carts.length);


                            // $('#subtotal').text(data.arr_check.taxes);
                            // $('#taxes').text((data.arr_check.taxes - (data.arr_check.taxes /
                            //     1.15)).toFixed(2));
                            // $('#total').text(data.arr_check.total);
                            // $('#delivery_fees').text(data.arr_check.delivery_fees);
                            data = data.arr_check;
                            $('#subtotal').text((data.subtotal_without_offer / 1.15).toFixed(2) +
                                ' {{ __('general.SR') }}');
                            $('#subtotalinput').val(data.subtotal_without_offer / 1.15);

                            $('#taxes').text((data.subtotal_without_offer - (data
                                    .subtotal_without_offer / 1.15)).toFixed(2) +
                                ' {{ __('general.SR') }}');
                            $('#taxesinput').val(data.subtotal_without_offer - (data
                                .subtotal_without_offer / 1.15));

                            @if($firstDiscount)
                            $('#total').text((data.total/2).toFixed(2) + ' {{ __('general.SR') }}');
                            $('#totalinput').val(data.total/2);
                            @else
                            $('#total').text((data.total).toFixed(2) + ' {{ __('general.SR') }}');
                            $('#totalinput').val(data.total);
                            @endif
                            
                            $('#to-earn').text(Math.round(data.total));

                            $('#delivery_fees').text((data.delivery_fees).toFixed(2) +
                                ' {{ __('general.SR') }}');
                            $('#delivery_feesinput').val(data.delivery_fees);
                            $('#discount').text((data.subtotal_without_offer - data.subtotal)
                                .toFixed(2));
                            @if (isset($arr_check['points']))
                                // $('#points').text(data.arr_check.points);
                                $('#points').text(data.arr_check.points);
                                $('#pointsnput').val(data.arr_check.points);
                            @endif
                            // if(((parseInt($('#itemcount').text())) - data.carts.length) == -1){
                            //     window.location.reload();
                            // }
                        },
                        error: function(reject) {
                            console.log(reject);
                            $(this).find('i').removeClass('fas fa-spinner fa-spin').addClass('la-times');
                        }
                    });
                });

                $(document).on('change', '.quantity_ch', function(ev) {
                    ev.preventDefault();

                    var elem = $(this);
                    var quantity = $(this).val();
                    var id = $(this).attr('data-id');
                    var price = $(this).attr('data-price');
                    var price_without_offer = $(this).attr('data-price-without-offer');
                    var href = $(this).attr('data-url');

                    $('.confirm').attr('data-id', id).attr('data-price', price).attr('quantity', parseInt(
                        quantity)).attr('data-price-without-offer', price_without_offer);
                    $('.item-link').attr('href', href);

                    var val = parseInt(elem.val(), 10);
                    var prev = parseInt(elem.attr('data-prev'), 10);
                    if (val <= 0) {
                        return;
                    }

                    // console.log(val, prev);

                    if (val === prev - 1) {
                        // console.log(quantity);
                        // @if (isset($arr_check['points']))
                        //     const itemTotal = price * quantity;
                        //     const cartTotal = parseFloat($('#totalinput').val());

                        //     console.log(itemTotal, cartTotal);
                        //     if (cartTotal - itemTotal < {{ round($arr_check['points'], 2) }}) {
                        //         console.log('you will not benifit');
                        //     }
                        // @endif
                        // return;

                        elem.attr('data-prev', val);
                        elem.val(val);
                        $('.confirm').click();
                        return;
                    }




                    quantityConfirm.show();
                    elem.val(parseInt(elem.val() - 1));

                    // add these attrs to confirm button
                    // $('.confirm').attr('quantity', parseInt(
                    //     quantity));
                });

                $('.confirm').click(function() {
                    var quantity = $(this).attr('quantity');
                    var id = $(this).attr('data-id');
                    var price = $(this).attr('data-price');
                    var price_without_offer = $(this).attr('data-price-without-offer');
                    $(".cart2" + id + ' .quantity_ch').attr('readonly', true);
                    $(".cart2" + id + ' .fa-spinner').removeClass('d-none');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: '{{ route('update.quantity') }}',
                        data: {
                            'cart_id': id,
                            'quantity': quantity,
                        },
                        success: function(data) {
                            console.log(data);
                            $('#subtotal').text((data.subtotal_without_offer / 1.15).toFixed(2) +
                                ' {{ __('general.SR') }}');
                            $('#subtotalinput').val(data.subtotal_without_offer / 1.15);

                            $('#taxes').text((data.subtotal_without_offer - (data
                                    .subtotal_without_offer / 1.15)).toFixed(2) +
                                ' {{ __('general.SR') }}');
                            $('#taxesinput').val(data.subtotal_without_offer - (data
                                .subtotal_without_offer / 1.15));

                            @if($firstDiscount)
                            $('#total').text((data.total/2).toFixed(2) + ' {{ __('general.SR') }}');
                            $('#totalinput').val(data.total/2);
                            @else
                            $('#total').text((data.total).toFixed(2) + ' {{ __('general.SR') }}');
                            $('#totalinput').val(data.total);
                            @endif
                            // $('#total').text((data.total).toFixed(2) + ' {{ __('general.SR') }}');
                            // $('#totalinput').val(data.total);

                            $('#to-earn').text(Math.round(data.total));

                            $('#delivery_fees').text((data.delivery_fees).toFixed(2) +
                                ' {{ __('general.SR') }}');
                            $('#delivery_feesinput').val(data.delivery_fees);
                            $('#discount').text((data.subtotal_without_offer - data.subtotal)
                                .toFixed(2));

                            $(".cart2" + id + ' .quantity_ch').val(quantity);
                            $(".cart2" + id + ' .quantity_ch').attr('data-prev', quantity);
                            // $('.quantity_ch').parent().parent().parent().next().next().find('.price-item')
                            //     .first().html('{{ __('home.Price') }}: ' + (quantity * price)
                            //         .toFixed(2) + ' {{ __('general.SR') }}');
                            $('#total' + id).text((quantity * price).toFixed(2));

                            $('#without-offer-total' + id).text((quantity * price_without_offer).toFixed(2));

                            @if (isset($arr_check['points']))
                                $('#points').text(data.points);
                                $('#pointsnput').val(data.points);
                            @endif

                            quantityConfirm.hide();
                            $(".cart2" + id + ' .quantity_ch').attr('readonly', false);
                            $(".cart2" + id + ' .fa-spinner').addClass('d-none');

                        },
                        error: function(reject) {
                            quantityConfirm.hide();
                            $(".cart2" + id + ' .quantity_ch').attr('readonly', false);
                            $(".cart2" + id + ' .fa-spinner').addClass('d-none');
                            // $(".cart2" + id + ' .quantity_ch').data('prev', quantity);
                            console.log(reject);
                        }
                    });
                });
            });
        </script>
    @endsection
    @push('scripts')
    @endpush