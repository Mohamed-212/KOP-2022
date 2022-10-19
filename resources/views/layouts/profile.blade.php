@extends('layouts.website.app')

@section('content')
    <main class="page-main">
        <section class="page-header"
            {{-- style="background-image: url({{ asset('website-assets/img/pages/contacts/bg-first-screen.jpg') }})"
            style="background-image: url('/website2-assets/img/page-header-theme.jpg')" --}}
            style="background-image: url({{ asset('website2-assets/img/page-header-theme.jpg') }})"
            >
            <div class="bg-shape grey"></div>
            <div class="container">
                <div class="page-header-content">
                    <h4 class="text-">
                        {{ __('general.Account') }}
                    </h4>
                    <h2 class="text-">
                        {{ __('general.Manage account') }}
                    </h2>
                </div>
            </div>
        </section>
        <!--/.page-header-->

        <div class="page-content">
            <div class="row">
                <div class="col-12 col-sm-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center"><img
                            class="rounded-circle mt-5 p-1 border" width="150px" height="150px"
                            src="{{ asset(auth()->user()->image) }}"><span class="font-weight-bold">
                            @if (auth()->user()->active)
                                <i class="fas fa-check-circle text-success mx-1"></i>
                            @endif
                            {{ auth()->user()->name }}
                        </span><span class="text-black-50">
                            {{ auth()->user()->email }}
                        </span><span> </span></div>

                    <div class="card-body">
                        <ol class="list-group list-group-flush">
                            <li class="list-group-item bg-primary text-white">
                                <a class="d-flex align-items-center text-white justify-content-between">
                                    <span class="m-0">{{ __('general.Account Points') }}: </span>
                                    <span class="badge bg-info">
                                        @if (isset($points))
                                            {{ $points['user_points'] }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li
                                class="list-group-item list-group-item-action {{ request()->routeIs('profile') ? 'default-bg text-white' : '' }}">
                                <a class="nav-link" id="account-tab" href="{{ route('profile') }}">
                                    <h6 class="font-weight-bold mb-1">
                                        {{ __('general.Account') }}</h6>
                                    <p class="small text-muted m-0">
                                        {{ __('general.Edit your Account Details') }}</p>
                                </a>
                            </li>
                            <li
                                class="list-group-item list-group-item-action {{ request()->routeIs('profile.address') ? 'default-bg text-white' : '' }}"">
                                <a class="nav-link" id="addresses-tab" href='{{ route('profile.address') }}'>
                                    <h6 class="font-weight-bold mb-1">
                                        {{ __('general.Addresses') }}</h6>
                                    <p class="small text-muted m-0">
                                        {{ __('general.Add or remove a delivery address') }}</p>
                                </a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a class="nav-link" href="{{ route('get.orders') }}" aria-selected="false">
                                    <div class="left mr-3">
                                        <h6 class="font-weight-bold mb-1 text-dark">
                                            {{ __('general.My Orders') }}</h6>
                                        <p class="small text-muted m-0">
                                            {{ __('general.Show all Orders') }}</p>
                                    </div>
                                </a>
                            </li>
                            <li
                                class="list-group-item list-group-item-action {{ request()->routeIs('profile.loyality') ? 'default-bg text-white' : '' }}">
                                <a class="nav-link" id="loyality-tab" href='{{ route('profile.loyality') }}'>
                                    <h6 class="font-weight-bold mb-1">
                                        {{ __('general.Loyalty Program') }}</h6>
                                    <p class="small text-muted m-0">
                                        {{ __('general.Loyalty Points') }}</p>
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="col-12 col-sm-9 position-relative mt-4">
                    <div class="row px-5">
                        <div class="col-12 align-items-center justify-content-center">
                            @if (Session::has('success'))
                                <div class="row mr-2 ml-2">
                                    <div type="text" class="alert alert-success mb-2" id="type-error">
                                        {{ Session::get('success') }}
                                    </div>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="row mr-2 ml-2">
                                    <div type="text" class="alert alert-danger mb-2" id="type-error">
                                        <ul>
                                            @foreach ($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="rounded shadow-sm p-4 bg-white">
                        @yield('main')
                    </div>
                </div>
            </div>
        </div>

    </main>


@endsection
