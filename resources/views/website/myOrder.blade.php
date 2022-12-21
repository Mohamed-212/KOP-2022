@extends('layouts.website.app')

@section('title')
    {{ __('general.My Orders') }}
@endsection

@section('styles')
    <style>
        p {
            margin: 0;
        }

        div {
            line-height: 1.5;
        }

        .page-item.active .page-link {
            z-index: 1;
            border-color: #6dc405;
            background: #6dc405;
            color: #ffffff;
        }

        .page-item.disabled .page-link {
            pointer-events: none;
            cursor: auto;
            background-color: inherit;
            border-color: #dee2e6;
        }

        .page-link {
            background-color: inherit;
        }

        .uk-lightbox {
            background: rgba(0, 0, 0, 0.60);
        }

        /*Pen styling*/
        .container {
            margin-top: 50px;
        }

        .alert-info {
            border-color: #e6e6e6;
            border-left: 5px solid #00b3c8;
            background-color: #fff;
            color: #888;
        }

        @media (min-width: 768px) {
            .alert {
                border-radius: 6px;
                display: table;
                width: 100%;
                padding-left: 78px;
                position: relative;
                padding-right: 78px;
                border: 1px solid #e6e6e6;
            }

            .alert .icon {
                text-align: center;
                width: 58px;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                border: 1px solid #bdbdbd;
                padding-top: 15px;
                border-radius: 6px 0 0 6px;
            }

            [dir="rtl"] .alert .icon {
                right: 0;
                border-radius: 0 6px 6px 0;
            }

            .alert .icon i {
                font-size: 20px;
                color: #fff;
                left: 21px;
                margin-top: -10px;
                position: absolute;
                top: 50%;
            }

            .alert .icon img {
                font-size: 20px;
                color: #fff;
                left: 18px;
                margin-top: -10px;
                position: absolute;
                top: 50%;
            }

            /*============ colors ========*/

            .alert.alert-info .icon,
            .alert.alert-info .icon:after {
                border-color: none;
                background: #00b3c8;
            }
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

            <div class="page-content">

                <div class="uk-margin-small-top uk-container">
                    @if (Session::has('success'))
                        <div class="row mr-2 ml-2">
                            <div class="col-12 justify-content-center align-items-center d-flex my-2" style="min-height: 50px;">
                                <button type="text" class="btn btn-lg btn-block btn-success mb-2"
                                    id="type-error">{{ Session::get('success') }}
                                </button>
                            </div>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="row mr-2 ml-2">
                            <div class="col-12 justify-content-center align-items-center d-flex my-2" style="min-height: 50px;">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                    id="type-error">{{ Session::get('error') }}
                                </button>
                            </div>
                        </div>
                    @endif
                    <section class="py-4 osahan-main-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <ul class="nav nav-tabsa custom-tabsa border-0 flex-column bg-white rounded overflow-hidden shadow-sm p-2 c-t-order"
                                    id="myTab" role="tablist"
                                    style="    box-shadow: 0 .125rem .25rem rgba(0,0,0,.25)!important;">
                                    <li class="nav-item border-top" role="presentation">
                                        <a class="nav-link border-0 text-dark py-3 active" id="pending-tab" data-bs-toggle="tab"
                                            href="#pending" role="tab" aria-controls="pending" aria-selected="false">
                                            <i class="fas fa-clock mr-2 text-warning mb-0"></i>
                                            {{ __('general.Pending') }}
                                        </a>
                                    </li>
                                    <li class="nav-item border-top" role="presentation">
                                        <a class="nav-link border-0 text-dark py-3" id="progress-tab" data-bs-toggle="tab"
                                            href="#progress" role="tab" aria-controls="progress" aria-selected="false">
                                            <i class="fas fa-car mr-2 text-warning mb-0"></i>
                                            {{ __('general.On Progress') }}
                                        </a>
                                    </li>
                                    <li class="nav-item border-top" role="presentation">
                                        <a class="nav-link border-0 text-dark py-3" id="completed-tab" data-bs-toggle="tab"
                                            href="#completed" role="tab" aria-controls="completed" aria-selected="false">
                                            <i class="fas fa-check @if (app()->getLocale() == 'en') mr-2 @else ml-2 @endif text-success mb-0"></i>
                                            {{ __('general.Completed') }}
                                        </a>
                                    </li>
                                    <li class="nav-item border-top" role="presentation">
                                        <a class="nav-link border-0 text-dark py-3" id="canceled-tab" data-bs-toggle="tab"
                                            href="#canceled" role="tab" aria-controls="canceled" aria-selected="false">
                                            <i class="fas fa-times-circle mr-2 text-danger mb-0"></i>
                                            {{ __('general.Canceled') }}
                                        </a>
                                    </li>
                                    <li class="nav-item border-top" role="presentation">
                                        <a class="nav-link border-0 text-dark py-3" id="rejected-tab" data-bs-toggle="tab"
                                            href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">
                                            <i class="fas fa-ban mr-2 text-danger mb-0"></i>
                                            {{ __('general.rejected') }}
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                        <a class="nav-link border-0 text-dark py-3 active" id="completed-tab"
                                            data-bs-toggle="tab" href="#completed" role="tab" aria-controls="completed"
                                            aria-selected="true">
                                            <i
                                                class="fas fa-check @if (app()->getLocale() == 'en') mr-2 @else ml-2 @endif text-success mb-0"></i>
                                            {{ __('general.Completed') }}
                                        </a>
                                    </li>
                                   
                                    <li class="nav-item border-top" role="presentation">
                                        <a class="nav-link border-0 text-dark py-3" id="canceled-tab" data-bs-toggle="tab"
                                            href="#canceled" role="tab" aria-controls="canceled" aria-selected="false">
                                            <i class="fas fa-times-circle mr-2 text-danger mb-0"></i>
                                            {{ __('general.Canceled') }}
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>

                            

                            <div class="tab-content col-md-9" id="myTabContent">

                                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                    @if (isset($pending_orders))
                                        @forelse ($pending_orders as $index => $pe)
                                            <div class="order-body">

                                                <div class="pb-3">

                                                    <div class="p-3 rounded shadow-sm bg-white"
                                                        style=";box-shadow: 0 .125rem 0.25rem rgba(0,0,0,.25)!important;">

                                                        <div class="d-flex border-bottom pb-3">
                                                            <div class="text-muted mr-3"
                                                                style="width: 110px;height: 110px">
                                                                <img alt="#"
                                                                    src="{{ asset('website2-assets/img/order.png') }}"
                                                                    class="w-100 h-100 img-fluid order_img rounded">
                                                            </div>
                                                            <div>
                                                                <p class="mb-0 font-weight-bold">
                                                                    {{ __('general.ORDER') }} {{ $index + 1 }}</p>
                                                                <p class="mb-0">{{ $pe->items->count() }}
                                                                    {{ __('general.items') }}</p>
                                                            </div>
                                                            <div
                                                                style="@if (app()->getLocale() == 'en') margin-left: auto!important; @else margin-right: auto!important; @endif">
                                                                <p
                                                                    class="bg-warning text-white py-1 px-2 rounded small mb-1">
                                                                    {{ __('general.Pending') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex pt-3 align-items-center justify-content-between">
                                                            <div class="text-muted m-0 small"
                                                                style="padding: 8px; @if (app()->getLocale() == 'en') margin-right: auto!important; @else margin-left: auto!important; @endif">
                                                                {{ __('general.Total') }}
                                                                :
                                                                <span
                                                                    class="text-dark font-weight-bold">{{ $pe->total - $pe->points_paid }}
                                                                    {{ __('general.SR') }}</span>
                                                            </div>
                                                            <div class="text-right">
                                                                @if (app()->getLocale() == 'en')
                                                                    <a href="{{ route('order.details', $pe->id) }}"
                                                                        class="btn px-3 default-btn rounded">{{ __('general.Details') }}
                                                                        <span></span>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('order.details', $pe->id) }}"
                                                                        class="btn px-3 default-btn">{{ __('general.Details') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        @empty
                                            <div class="alert alert-info">
                                                <div class="icon hidden-xs text-white">
                                                    <i class="fa fa-exclamation-circle"></i>
                                                </div>
                                                <p class="text-info">
                                                    <strong>{{ __('general.info') }}</strong>
                                                    <Br />
                                                    {{ __('general.no_orders', [
                                                        'type' => __('general.Pending'),
                                                    ]) }}
                                                </p>
                                            </div>
                                        @endforelse
                                        {{ $pending_orders->appends(['canceled' => $canceled_orders->currentPage(), 'pending' => $pending_orders->currentPage(), 'completed' => $completed_orders->currentPage(),
                                        'progress' => $progress_orders->currentPage(),
                                        'rejected' => $rejected_orders->currentPage()
                                        , 'id' => 'pending'])->links() }}
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="progress-tab">
                                    @if (isset($progress_orders))
                                        @forelse ($progress_orders as $index => $pe)
                                            <div class="order-body">

                                                <div class="pb-3">

                                                    <div class="p-3 rounded shadow-sm bg-white"
                                                        style=";box-shadow: 0 .125rem 0.25rem rgba(0,0,0,.25)!important;">

                                                        <div class="d-flex border-bottom pb-3">
                                                            <div class="text-muted mr-3"
                                                                style="width: 110px;height: 110px">
                                                                <img alt="#"
                                                                    src="{{ asset('website2-assets/img/order.png') }}"
                                                                    class="w-100 h-100 img-fluid order_img rounded">
                                                            </div>
                                                            <div>
                                                                <p class="mb-0 font-weight-bold">
                                                                    {{ __('general.ORDER') }} {{ $index + 1 }}</p>
                                                                <p class="mb-0">{{ $pe->items->count() }}
                                                                    {{ __('general.items') }}</p>
                                                            </div>
                                                            <div
                                                                style="@if (app()->getLocale() == 'en') margin-left: auto!important; @else margin-right: auto!important; @endif">
                                                                <p
                                                                    class="bg-warning text-white py-1 px-2 rounded small mb-1">
                                                                    {{ __('general.On Progress') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex pt-3 align-items-center justify-content-between">
                                                            <div class="text-muted m-0 small"
                                                                style="padding: 8px; @if (app()->getLocale() == 'en') margin-right: auto!important; @else margin-left: auto!important; @endif">
                                                                {{ __('general.Total') }}
                                                                :
                                                                <span
                                                                    class="text-dark font-weight-bold">{{ $pe->total - $pe->points_paid }}
                                                                    {{ __('general.SR') }}</span>
                                                            </div>
                                                            <div class="text-right">
                                                                @if (app()->getLocale() == 'en')
                                                                    <a href="{{ route('order.details', $pe->id) }}"
                                                                        class="btn px-3 default-btn rounded">{{ __('general.Details') }}
                                                                        <span></span>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('order.details', $pe->id) }}"
                                                                        class="btn px-3 default-btn">{{ __('general.Details') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        @empty
                                            <div class="alert alert-info">
                                                <div class="icon hidden-xs text-white">
                                                    <i class="fa fa-exclamation-circle"></i>
                                                </div>
                                                <p class="text-info">
                                                    <strong>{{ __('general.info') }}</strong>
                                                    <Br />
                                                    {{ __('general.no_orders', [
                                                        'type' => __('general.On Progress'),
                                                    ]) }}
                                                </p>
                                            </div>
                                        @endforelse
                                        {{ $progress_orders->appends(['canceled' => $canceled_orders->currentPage(), 'pending' => $pending_orders->currentPage(), 'completed' => $completed_orders->currentPage(),
                                        'progress' => $progress_orders->currentPage(),
                                        'rejected' => $rejected_orders->currentPage()
                                        , 'id' => 'progress'])->links() }}
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="completed" role="tabpanel"
                                    aria-labelledby="completed-tab">
                                    @if (isset($completed_orders))
                                        @forelse ($completed_orders as $index => $co)
                                            <div class="order-body">

                                                <div class="pb-3">
                                                    <div class="p-3 rounded shadow-sm bg-white"
                                                        style=";box-shadow: 0 .125rem 0.25rem rgba(0,0,0,.25)!important;">

                                                        <div class="d-flex border-bottom pb-3">
                                                            <div class="text-muted"
                                                                style="width: 110px;height: 110px; @if (app()->getLocale() == 'en') margin-right: 1rem!important; @else margin-left: 1rem!important; @endif">
                                                                <img alt="#"
                                                                    src="{{ asset('website2-assets/img/order.png') }}"
                                                                    class="w-100 h-100 img-fluid order_img rounded">
                                                            </div>
                                                            <div>
                                                                <p class="mb-0 font-weight-bold">{{ __('general.ORDER') }}
                                                                    {{ $index + 1 }}</p>
                                                                <p class="mb-0">{{ $co->items->count() }}
                                                                    {{ __('general.items') }}</p>
                                                            </div>
                                                            <div
                                                                style="@if (app()->getLocale() == 'en') margin-left: auto!important; @else margin-right: auto!important; @endif">
                                                                <p
                                                                    class="bg-success text-white py-1 px-2 rounded small mb-1">
                                                                    {{ __('general.Completed') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex pt-3 align-items-center justify-content-between">
                                                            <div class="text-muted m-0 small"
                                                                style="padding: 8px; @if (app()->getLocale() == 'en') margin-right: auto!important; @else margin-left: auto!important; @endif">
                                                                {{ __('general.Total') }}
                                                                :
                                                                <span
                                                                    class="text-dark font-weight-bold">{{ $co->total - $co->points_paid }}
                                                                    {{ __('general.SR') }}</span>
                                                            </div>
                                                            <div class="text-right">
                                                                @if (app()->getLocale() == 'en')
                                                                    <a {{$co->status != 'completed' ? 'style="display:none;"' : 'wwww'}} href="{{ route('order.details', [$co->id, 'reorder']) }}"
                                                                        class="btn bg-danger px-3 default-btn rounded">{{ __('general.Reorder') }}<span></span></a>
                                                                    <a href="{{ route('order.details', $co->id) }}"
                                                                        class="btn px-3 default-btn rounded">{{ __('general.Details') }}
                                                                        <span></span>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('order.details', $co->id) }}"
                                                                        class="btn px-3 default-btn">{{ __('general.Details') }}</a>
                                                                    <a href="{{ route('order.details', [$co->id, 'reorder']) }}"
                                                                        class="btn btn-outline-primary text-white px-3 default-btn" {{$co->status != 'completed' ? 'style="display:none;"' : ''}} >{{ __('general.Reorder') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info">
                                                <div class="icon hidden-xs text-white">
                                                    <i class="fa fa-exclamation-circle"></i>
                                                </div>
                                                <p class="text-info">
                                                    <strong>{{ __('general.info') }}</strong>
                                                    <Br />
                                                    {{ __('general.no_orders', [
                                                        'type' => __('general.Completed'),
                                                    ]) }}
                                                </p>
                                            </div>
                                        @endforelse
                                        {{ $completed_orders->appends(['canceled' => $canceled_orders->currentPage(), 'pending' => $pending_orders->currentPage(), 'completed' => $completed_orders->currentPage(),
                                        'progress' => $progress_orders->currentPage(),
                                        'rejected' => $rejected_orders->currentPage()
                                        , 'id' => 'completed'])->links() }}
                                    @endif
                                </div>


                                

                                <div class="tab-pane fade" id="canceled" role="tabpanel"
                                    aria-labelledby="canceled-tab">

                                    @if (isset($canceled_orders))
                                        @forelse ($canceled_orders as $index => $ca)
                                            <div class="order-body">

                                                <div class="pb-3">
                                                    <div class="p-3 rounded shadow-sm bg-white"
                                                        style=";box-shadow: 0 .125rem 0.25rem rgba(0,0,0,.25)!important;">
                                                        <div class="d-flex border-bottom pb-3">
                                                            <div class="text-muted mr-3"
                                                                style="width: 110px;height: 110px">
                                                                <img alt="#"
                                                                    src="{{ asset('website2-assets/img/order.png') }}"
                                                                    class="w-100 h-100 img-fluid order_img rounded">
                                                            </div>
                                                            <div>
                                                                <p class="mb-0 font-weight-bold">{{ __('general.ORDER') }}
                                                                    {{ $index + 1 }}</p>
                                                                <p class="mb-0">{{ $ca->items->count() }}
                                                                    {{ __('general.items') }}</p>
                                                            </div>
                                                            <div
                                                                style="@if (app()->getLocale() == 'en') margin-left: auto!important; @else margin-right: auto!important; @endif">
                                                                <p
                                                                    class="bg-danger text-white py-1 px-2 rounded small mb-1">
                                                                    {{ __('general.Canceled') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex pt-3 align-items-center justify-content-between">
                                                            <div class="text-muted m-0 small"
                                                                style="padding: 8px; @if (app()->getLocale() == 'en') margin-right: auto!important; @else margin-left: auto!important; @endif">
                                                                {{ __('general.Total') }}
                                                                :
                                                                <span
                                                                    class="text-dark font-weight-bold">{{ $ca->total - $ca->points_paid }}
                                                                    {{ __('general.SR') }}</span>
                                                            </div>
                                                            <div class="text-right">
                                                                @if (app()->getLocale() == 'en')
                                                                    {{-- <a href="{{ route('order.details', [$ca->id, 'reorder']) }}"
                                                                        class="btn bg-danger px-3 default-btn rounded">{{ __('general.Reorder') }}<span></span></a> --}}
                                                                    <a href="{{ route('order.details', $ca->id) }}"
                                                                        class="btn px-3 default-btn rounded">{{ __('general.Details') }}
                                                                        <span></span>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('order.details', $ca->id) }}"
                                                                        class="btn px-3 default-btn">{{ __('general.Details') }}</a>
                                                                    {{-- <a href="{{ route('order.details', [$ca->id, 'reorder']) }}"
                                                                        class="btn btn-outline-primary text-white px-3 default-btn">{{ __('general.Reorder') }}</a> --}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @empty
                                            <div class="alert alert-info">
                                                <div class="icon hidden-xs text-white">
                                                    <i class="fa fa-exclamation-circle"></i>
                                                </div>
                                                <p class="text-info">
                                                    <strong>{{ __('general.info') }}</strong>
                                                    <Br />
                                                    {{ __('general.no_orders', [
                                                        'type' => __('general.Canceled'),
                                                    ]) }}
                                                </p>
                                            </div>
                                        @endforelse
                                        {{ $canceled_orders->appends(['canceled' => $canceled_orders->currentPage(), 'pending' => $pending_orders->currentPage(), 'completed' => $completed_orders->currentPage(),
                                        'progress' => $progress_orders->currentPage(),
                                        'rejected' => $rejected_orders->currentPage()
                                        , 'id' => 'canceled'])->links() }}
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="rejected" role="tabpanel"
                                    aria-labelledby="rejected-tab">

                                    @if (isset($rejected_orders))
                                        @forelse ($rejected_orders as $index => $ca)
                                            <div class="order-body">

                                                <div class="pb-3">
                                                    <div class="p-3 rounded shadow-sm bg-white"
                                                        style=";box-shadow: 0 .125rem 0.25rem rgba(0,0,0,.25)!important;">
                                                        <div class="d-flex border-bottom pb-3">
                                                            <div class="text-muted mr-3"
                                                                style="width: 110px;height: 110px">
                                                                <img alt="#"
                                                                    src="{{ asset('website2-assets/img/order.png') }}"
                                                                    class="w-100 h-100 img-fluid order_img rounded">
                                                            </div>
                                                            <div>
                                                                <p class="mb-0 font-weight-bold">{{ __('general.ORDER') }}
                                                                    {{ $index + 1 }}</p>
                                                                <p class="mb-0">{{ $ca->items->count() }}
                                                                    {{ __('general.items') }}</p>
                                                            </div>
                                                            <div
                                                                style="@if (app()->getLocale() == 'en') margin-left: auto!important; @else margin-right: auto!important; @endif">
                                                                <p
                                                                    class="bg-danger text-white py-1 px-2 rounded small mb-1">
                                                                    {{ __('general.rejected') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex pt-3 align-items-center justify-content-between">
                                                            <div class="text-muted m-0 small"
                                                                style="padding: 8px; @if (app()->getLocale() == 'en') margin-right: auto!important; @else margin-left: auto!important; @endif">
                                                                {{ __('general.Total') }}
                                                                :
                                                                <span
                                                                    class="text-dark font-weight-bold">{{ $ca->total - $ca->points_paid }}
                                                                    {{ __('general.SR') }}</span>
                                                            </div>
                                                            <div class="text-right">
                                                                @if (app()->getLocale() == 'en')
                                                                    {{-- <a href="{{ route('order.details', [$ca->id, 'reorder']) }}"
                                                                        class="btn bg-danger px-3 default-btn rounded">{{ __('general.Reorder') }}<span></span></a> --}}
                                                                    <a href="{{ route('order.details', $ca->id) }}"
                                                                        class="btn px-3 default-btn rounded">{{ __('general.Details') }}
                                                                        <span></span>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('order.details', $ca->id) }}"
                                                                        class="btn px-3 default-btn">{{ __('general.Details') }}</a>
                                                                    {{-- <a href="{{ route('order.details', [$ca->id, 'reorder']) }}"
                                                                        class="btn btn-outline-primary text-white px-3 default-btn">{{ __('general.Reorder') }}</a> --}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @empty
                                            <div class="alert alert-info">
                                                <div class="icon hidden-xs text-white">
                                                    <i class="fa fa-exclamation-circle"></i>
                                                </div>
                                                <p class="text-info">
                                                    <strong>{{ __('general.info') }}</strong>
                                                    <Br />
                                                    {{ __('general.no_orders', [
                                                        'type' => __('general.rejected'),
                                                    ]) }}
                                                </p>
                                            </div>
                                        @endforelse
                                        {{ $rejected_orders->appends(['canceled' => $canceled_orders->currentPage(), 'pending' => $pending_orders->currentPage(), 'completed' => $completed_orders->currentPage(),
                                        'progress' => $progress_orders->currentPage(),
                                        'rejected' => $rejected_orders->currentPage()
                                        , 'id' => 'rejected'])->links() }}
                                    @endif
                                </div>

                            </div>
                        </div>

                    </section>

                </div>

            </div>
        </main>

    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
                /*var url = window.location.href;
                var activeTab = url.substring(url.indexOf("#") + 1);
                if(url.indexOf("#") != -1){
                    $(".tab-pane").removeClass("show active");
                    $("#" + activeTab).addClass("show active");
                    $("ul.nav-tabsa li a").removeClass("active");
                    $("#" + activeTab + '-tab').addClass("show active");
                }*/
                let url = (new URL(document.location)).searchParams;
                let activeTab = url.get("id");
                if (activeTab) {
                    $(".tab-pane").removeClass("show active");
                    $("#" + activeTab).addClass("show active");
                    $("ul.nav-tabsa li a").removeClass("active");
                    $("#" + activeTab + '-tab').addClass("show active");
                }

            });
        </script>
    @endsection
