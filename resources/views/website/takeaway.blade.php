@extends('layouts.website.app')

@section('title')
    {{ __('general.Branches') }}
@endsection

@section('styles')
    <style>
        .text-primary {
            color: #e23744 !important;
            text-decoration: none !important;
        }

        .card.active .card-title {
            color: #fff;
        }

        .card.active .card-text.text-muted {
            color: #c9c9c9 !important;
        }

        .card.active .text-info {
            color: #95f1ff !important;
        }

        .branch {
            padding-top: .5rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all ease-in .2s;
        }

        .branch:hover {

            box-shadow: 0 0 10px #000;

        }

        .branch.active {
            background-color: #ff9d2d;
            color: #fff;
        }
    </style>
@endsection

@section('pageName')

    <body class="page-catalog dm-dark">
    @endsection

    @section('content')
        <main class="page-main">

            <section class="page-header"
                style="background-image: url({{ asset('/website2-assets/img/page-header-theme.jpg') }})">
                <div class="bg-shape grey"></div>
                <div class="container">
                    <div class="page-header-content">
                        <h4>
                            {{ __('general.Branches') }}
                        </h4>
                        <h2>
                            {{ __('general.branch_title') }}
                        </h2>
                    </div>
                </div>
            </section>
            <!--/.page-header-->

            <div class="page-content">
                <div class="uk-container">
                    <div>
                        <div class="py-2">
                            <h2 class="mb-3 mt-0">{{ __('general.Branches') }}</h2>
                            <div class="row">
                                <section class="branches-section bg-grey padding">
                                    <div class="bg-shape white"></div>
                                    <div class="container">
                                        <div class="row branches-lists">
                                            @foreach ($branches as $branch)
                                                <div class="col-lg-3 col-sm-6 my-3" style="display: flex">
                                                    <div class="mx-2 px-2 sm-padding branch {{ session()->get('branch_id') === $branch->id ? 'text-white active' : '' }}"
                                                        data-href="{{ route('takeaway.branch', [$branch->id, 'takeaway']) }}">
                                                        <div class="branches-list">
                                                            <h3>
                                                                {{ $branch['name_' . app()->getLocale()] }}
                                                            </h3>
                                                            <ul>
                                                                <li>
                                                                    {{ app()->getLocale() === 'ar' ? $branch->address_description : $branch->address_description_en }}
                                                                </li>
                                                                <li><a href="tel:{{ $branch->first_phone }}">
                                                                        {{ $branch->first_phone }}</a></li>
                                                                <li><a
                                                                        href="mailto:{{ $branch->email }}">{{ $branch->email }}</a>
                                                                </li>
                                                                <div class="btn-group" role="group"
                                                                    aria-label="Basic example">
                                                                    @if (in_array('delivery', explode(',', $branch->service_type)))
                                                                    <button type="button"
                                                                        class="btn btn-sm  btn-secondary">
                                                                        {{ __('general.Delivery') }} {{in_array('takeaway', explode(',', $branch->service_type)) ? '' : __('general.only')}}
                                                                    </button>
                                                                    @endif
                                                                    @if (in_array('takeaway', explode(',', $branch->service_type)))
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-secondary">
                                                                        {{ __('general.Take away') }} {{in_array('delivery', explode(',', $branch->service_type)) ? '' : __('general.only')}}
                                                                    </button>
                                                                    @endif
                                                                </div>
                                                                <div class="">
                                                                    <i class="fa fa-clock"></i>
                                                                    {{ __('general.Working Hours') }}:
                                                                </div>
                                                                @foreach ($branch->working_hours as $working_hour)
                                                                    <li class="" style="font-size: 14px;">
                                                                        <div class="w-100 text-center">
                                                                            <span
                                                                                class=" text-center">{{ __('general.From') }}:
                                                                                {{ $working_hour->time_from }}&nbsp;&nbsp;
                                                                                {{ __('general.To') }}:
                                                                                {{ $working_hour->time_to }}</span>
                                                                        </div>
                                                                    </li>
                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('.branch').click(function() {
                    const href = $(this).data('href');

                    window.location.href = href;
                });
            });
        </script>
    @endsection
