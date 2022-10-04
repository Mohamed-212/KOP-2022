@extends('layouts.website.app')

@section('title')
    {{ __('general.Payment') }}
@endsection
@section('styles')
    <link href="{{ asset('website-assets/css/payment.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.6.1/moyasar.css">

    <!-- Moyasar Scripts -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>
    <script src="https://cdn.moyasar.com/mpf/1.6.1/moyasar.js"></script>
    <style>
        <style>@media screen and (min-width: 768px) {
            .pl-form {
                margin-left: auto !important;
                margin-right: auto !important;
                max-width: 340px !important
            }
        }

        @media screen and (min-width: 768px) {
            .pl-form {
                margin-left: auto !important;
                margin-right: auto !important;
                max-width: 340px !important
            }
        }

        .pl-form {
            min-width: 240px;
        }

        .border-colored {
            color: #fe9d2d;
        }
    </style>
    </style>
@endsection


@section('content')
    <section class="page-header" {{-- style="background-image: url({{ asset('website-assets/img/pages/contacts/bg-first-screen.jpg') }})" --}}
        style="background-image: url({{ asset('website2-assets/img/page-header-theme.jpg') }})">
        <div class="bg-shape grey"></div>
        <div class="container">
            <div class="page-header-content">
                <h4 class="text-">
                    {{ __('general.Payment') }}
                </h4>
                <h2 class="text-">
                    {{ __('general.payment_title') }}
                </h2>
            </div>
        </div>
    </section>
    <!--/.page-header-->

    {{-- @dump(request()->all()) --}}

    <div class="card mx-auto mt-3">
        <div class="card-body">
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="left border">
                        <div class="row"><span class="header"
                                style="display: contents !important;">{{ __('general.Payment') }}</span>
                            <div class="icons"><img src="https://img.icons8.com/color/48/000000/visa.png" /> <img
                                    src="https://img.icons8.com/color/48/000000/mastercard-logo.png" /> <img
                                    src="https://img.icons8.com/color/48/000000/maestro.png" /></div>
                        </div>

                        @if (Session::has('success'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-success mb-2"
                                    id="type-error">{{ Session::get('success') }}
                                </button>
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                    id="type-error">{{ Session::get('error') }}
                                </button>
                            </div>
                        @endif
                        <form action="{{ route('do.payment') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="callback_url" value="{{ route('make-order.payment') }}">
                            <input type="hidden" name="publishable_api_key"
                                value="pk_test_q8VZ5iA7J3ZCRXzCo8mVkjgNr1WmDvXJHdm2mQRt">
                            <input type="hidden" name="amount" value="10000">
                            <input type="hidden" name="source[type]" value="creditcard">
                            <input type="hidden" name="description" value="Order id 1234 by guest">

                            <span>{{ __('general.Cardholder\'s name') }}:</span>
                            <input type="text" name="source[name]" value="{{ old('source.name') }}"
                                @error('source.name')class="mb-0" @enderror />
                            @error('source.name')
                                <p class="text-danger font-weight-bold mt-0" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror

                            <span>{{ __('general.Card Number') }}:</span>
                            <input type="text" name="source[number]" value="{{ old('source.number') }}"
                                @error('source.number')class="mb-0" @enderror />
                            @error('source.number')
                                <p class="text-danger font-weight-bold mt-0" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror
                            <div class="row">
                                <div class="col-12">
                                    <span>{{ __('general.Expiry date') }}</span>
                                    <div class="row d-flex">
                                        <div class="col-6">
                                            <span>{{ __('general.Month') }}:</span>
                                            <input type="text" name="source[month]" value="{{ old('source.month') }}"
                                                @error('source.month')class="mb-0" @enderror />
                                            @error('source.month')
                                                <p class="text-danger font-weight-bold mt-0" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <span>{{ __('general.Year') }}:</span>
                                            <input type="text" name="source[year]" value="{{ old('source.year') }}"
                                                @error('source.year')class="mb-0" @enderror />
                                            @error('source.year')
                                                <p class="text-danger font-weight-bold mt-0" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"><span>CVC:</span>
                                    <input type="number" name="source[cvc]" value="{{ old('source.cvc') }}"
                                        @error('source.cvc')class="mb-0" @enderror />
                                    @error('source.cvc')
                                        <p class="text-danger font-weight-bold mt-0" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="default-btn w-100">{{ __('general.Purchase') }}<span
                                    style="width: 200% !important;"></span></button>


                        </form>
                    </div>
                </div>

            </div> --}}
            @if (session()->has('error'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger w-75 mx-auto">
                            {{ __('general.' . session('error')) }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="mysr-form">
                        <div class="w-100 text-center h-100 d-flex align-items-center justify-content-center"
                            style="min-height: 200px;">
                            <div class="spinner-border border-colored" style="width: 4rem; height: 4rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div></div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            Moyasar.init({
                element: '.mysr-form',
                amount: {{ $amount * 100 }},
                currency: 'SAR',
                description: '{{ $user->name }} Order',
                publishable_api_key: 'pk_test_q8VZ5iA7J3ZCRXzCo8mVkjgNr1WmDvXJHdm2mQRt',
                callback_url: "{{ session()->has('payment_hash') ? route('api.make-order.payment') : route('make-order.payment') }}",
                language: "{{ app()->getLocale() }}",
                on_completed: function(payment) {
                    return new Promise(function(resolve, reject) {
                        // This is just an example, provide anything you want here
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('api.payment.store') }}",
                            data: payment,
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Authorization': "Bearer {{ $user->token }}",
                            },
                            dataType: 'json',
                            success: function(data, textStatus, jqXHR) {
                                // An empty dictionary/object is required to indicate to the form everything is good to go
                                // console.log(data, textStatus, jqXHR);
                                if (jqXHR.status === 201) {
                                    resolve({
                                        status: jqXHR.status
                                    });
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                reject();
                            }
                        });
                    });
                },
                methods: [
                    'creditcard',
                ],
            });
        });
    </script>
@endsection
