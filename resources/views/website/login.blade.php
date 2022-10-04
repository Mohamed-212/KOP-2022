{{-- <!DOCTYPE html>
<html lang="en">

@include('layouts.website.head') --}}
@extends('layouts.website.app')

@section('title')
    {{ __('auth.login') }}
@endsection

@section('styles')
    <style>
        .login-page video {
            width: 100%;
            /* position: fixed; */
            bottom: 0;
            left: 0;
            height: 100%;
        }

        [dir="rtl"] .login-page video {
            right: 0;
        }

        [dir="rtl"] .login-page input:focus {
            direction: ltr;
        }

        .header {
            background-color: #fff;
        }

        .header a {
            color: #000;
        }

        .footer-section {
            /* display: none; */
        }

        @media (max-width: 992px) {}

        @media (max-width: 736px) {
            .login-page video {
                display: none;
            }
        }
    </style>
@endsection
@section('pageName')

    <body class="page-login dm-dark">
    @endsection

    @section('content')
        <div class="page-wrapper">
            <div class="login-page row position-relative" style="padding-top: 125px;height: 1024px;">
                <div class="col-0 col-md-6 col-lg-8">
                    <video loop autoplay muted id="video" style="object-fit: fill;height: 100%;">
                        <source src="{{ asset('website2-assets/img/bg.mp4') }}" type="video/mp4">
                        <source src="{{ asset('website2-assets/img/bg.mp4') }}" type="video/ogg">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex justify-content-center">
                        <div class="ml-auto w-100">
                            <div class="px-2 col-12 mx-auto">
                                <a href="{{ route('home.page') }}">
                                    <img class="logo__img logo__img--full m-auto" style="cursor: pointer;height: 14rem;"
                                        src="{{ asset('website-assets/img/logokop.png') }}" alt="logo">
                                </a>
                                <h2 class="text-dark my-0">{{ __('general.Welcome Back') }}</h2>
                                <p class="text-50">{{ __('general.Sign in to continue') }}</p>
                                <div class="row">
                                    @if (Session::has('success'))
                                        <div class="col-12 mr-2 ml-2">
                                            <button type="text" class="btn btn-lg btn-block btn-outline-success mb-2"
                                                id="type-error">{{ Session::get('success') }}
                                            </button>
                                        </div>
                                    @endif
                                    @if (Session::has('error'))
                                        <div class="col-12 mr-2 ml-2">
                                            <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                                id="type-error">{{ Session::get('error') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <form class="mt-0 mb-0" method="post" action="{{ route('sign.in') }}">
                                    @csrf
                                    <div class="form-group my-2">
                                        <label for="exampleInputEmail1" class="text-dark">{{ __('general.Email') }}</label>
                                        <input type="email"
                                            value="{{ Session::has('email') ? Session::get('email') : old('email') }}"
                                            name="email" placeholder="{{ __('general.Enter Your E-mail') }}"
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                        @error('email')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="exampleInputPassword1"
                                            class="text-dark">{{ __('general.Password') }}</label>
                                        <input type="password" name="password"
                                            placeholder="{{ __('general.Enter Password') }}" class="form-control"
                                            id="exampleInputPassword1">
                                        @error('password')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                        class="btn default-btn rounded">{{ __('general.SIGN IN') }}<span></span></button>
                                </form>
                                <div class="mt-3">
                                    <a href="{{ route('forget.password') }}" class="text-decoration-none">
                                        <p class="text-center">{{ __('general.Forgot your password?') }}</p>
                                    </a>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('get.sign.up') }}">
                                            <p class="text-center m-0">{{ __('general.Don\'t have an account? Sign up') }}
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    {{-- @include('layouts.website.script') --}}
    {{-- @yield('scripts') --}}
    @section('scripts')
        <script>
            $(document).ready(function() {
                // $('.sticky-header').addClass('sticky-fixed-top');
            });
        </script>
    @endsection
