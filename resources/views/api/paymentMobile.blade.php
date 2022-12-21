<!DOCTYPE html>
<html>
    <head>
        <title>Payment</title>@include('layouts.website.head')
        <link href="{{asset('website-assets/css/payment.css')}}" rel="stylesheet"/>
    </head>

    <body class="page-article dm-dark">
        <div class="card mr-auto ml-auto mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="left border">
                            <div class="row"><span class="header">{{__('general.Payment')}}</span>
                                <div class="icons"><img loading="lazy" data-lazy="true"  src="https://img.icons8.com/color/48/000000/visa.png"/> <img
                                        src="https://img.icons8.com/color/48/000000/mastercard-logo.png"/> <img
                                        src="https://img.icons8.com/color/48/000000/maestro.png"/></div>
                            </div>

                            @if(Session::has('success'))
                                <div class="row mr-2 ml-2">
                                    <button type="text" class="btn btn-lg btn-block btn-outline-success mb-2"
                                            id="type-error">{{Session::get('success')}}
                                    </button>
                                </div>
                            @endif
                            @if(Session::has('error'))
                                <div class="row mr-2 ml-2" >
                                    <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                            id="type-error">{{Session::get('error')}}
                                    </button>
                                </div>
                            @endif
                            <form action="{{route('do.paymentMobile')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="callback_url" value="{{url('api/payment/response')}}">
                                <input type="hidden" name="publishable_api_key"
                                       value="pk_test_PVAhCbyVsgq5GjTukpHGvHa5J85ofUWPWFnkASEi">
                                <input type="hidden" name="amount" value="{{$amount}}">
                                <input type="hidden" name="source[type]" value="creditcard">
                                <input type="hidden" name="description" value="Order id 1234 by guest">

                                <span>{{__('general.Cardholder\'s name')}}:</span>
                                <input type="text" name="source[name]" value="{{old("source.name")}}"
                                       @error('source.name')class="mb-0" @enderror
                                />
                                @error('source.name')
                                <p class="text-danger font-weight-bold mt-0" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                                @enderror

                                <span>{{__('general.Card Number')}}:</span>
                                <input type="text" name="source[number]" value="{{old("source.number")}}"
                                       @error('source.number')class="mb-0" @enderror
                                />
                                @error('source.number')
                                <p class="text-danger font-weight-bold mt-0" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                                @enderror
                                <div class="row">
                                    <div class="col-12">
                                        <span>{{__('general.Expiry date')}}</span>
                                        <div class="row d-flex">
                                            <div class="col-6">
                                                <span>{{__('general.Month')}}:</span>
                                                <input type="text" name="source[month]" value="{{old("source.month")}}"
                                                       @error('source.month')class="mb-0" @enderror
                                                />
                                                @error('source.month')
                                                <p class="text-danger font-weight-bold mt-0" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <span>{{__('general.Year')}}:</span>
                                                <input type="text" name="source[year]"  value="{{old("source.year")}}"
                                                       @error('source.year')class="mb-0" @enderror
                                                />
                                                @error('source.year')
                                                <p class="text-danger font-weight-bold mt-0" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12"><span>CVC:</span>
                                        <input type="number" name="source[cvc]" value="{{old("source.cvc")}}"
                                               @error('source.cvc')class="mb-0" @enderror
                                        />
                                        @error('source.cvc')
                                        <p class="text-danger font-weight-bold mt-0" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="uk-button btn w-100">{{__('general.Purchase')}}</button>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div></div>
        </div>
    </body>
</html>

