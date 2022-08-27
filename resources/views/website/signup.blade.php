@extends('layouts.website.app')

@section('title')
    {{ __('auth.signup') }}
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
        [dir="rtl"] .login-page input:not(#exampleInputName1):focus {
            direction: ltr;
        }
        .header {
            background-color: #fff;
        }

        .header a {
            color: #000;
        }

        @media (max-width: 992px) {
            .login-page video {
                /* width: 30%; */
            }
        }

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
                                    <img class="logo__img logo__img--full m-auto" style="cursor: pointer;height: 10rem;"
                                        src="{{ asset('website-assets/img/logokop.bmp') }}" alt="logo">
                                </a>
                                <h2 class="text-dark my-0">{{ __('general.Hello There.') }}</h2>
                                <p class="text-50">{{ __('general.Sign up to continue') }}</p>


                                @error('errors')
                                    <div class="row mr-2 ml-2">
                                        <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                            id="type-error">{{ $message }}
                                        </button>
                                    </div>
                                @enderror
                                <form class="mt-5 mb-4" method="POSt" action="{{ route('sign.up') }}">
                                    @CSRF
                                    <div class="form-group my-2">
                                        <label for="exampleInputName1"
                                            class="text-dark">{{ __('general.Full name') }}</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            placeholder="{{ __('general.Enter Full name') }}" class="form-control"
                                            id="exampleInputName1" aria-describedby="nameHelp">
                                        @error('name')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="exampleInputEmail" class="text-dark">{{ __('general.Email') }}</label>
                                        <input type="email" value="{{ old('email') }}" name="email"
                                            placeholder="{{ __('general.Enter Your E-mail') }}" class="form-control"
                                            id="exampleInputEmail" aria-describedby="EmailHelp">
                                        @error('email')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="exampleInputNumber1"
                                            class="text-dark">{{ __('general.Mobile') }}</label>
                                        <input type="number" name="phone" value="{{ old('phone') }}"
                                            placeholder="{{ __('general.Enter Mobile') }}" class="form-control"
                                            id="exampleInputNumber1" aria-describedby="numberHelp">
                                        @error('phone')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group my-2">
                                        <label for="exampleInputPassword1"
                                            class="text-dark">{{ __('general.Password') }}</label>
                                        <input type="password" name="password" value="{{ old('password') }}"
                                            placeholder="{{ __('general.Enter Password') }}" class="form-control"
                                            id="exampleInputPassword1">
                                        @error('password')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-lg btn-block default-btn rounded">
                                        {{ __('general.SIGN UP') }}
                                        <span></span>
                                    </button>
                                </form>
                                <div class="new-acc d-flex align-items-center justify-content-center">
                                    <a href="{{ route('get.login') }}">
                                        <p class="text-center m-0">{{ __('general.Already an account? Sign in') }}</p>
                                    </a>
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
         <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     Firebase App (the core Firebase SDK) is always required and must be listed first 
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <script>
        var firebaseConfig = {
            apiKey: "API_KEY",
            authDomain: "PROJECT_ID.firebaseapp.com",
            databaseURL: "https://PROJECT_ID.firebaseio.com",
            projectId: "PROJECT_ID",
            storageBucket: "PROJECT_ID.appspot.com",
            messagingSenderId: "SENDER_ID",
            appId: "APP_ID"
        };
        firebase.initializeApp(firebaseConfig);
    </script>
    <script type="text/javascript">
        window.onload = function () {
            render();
        };
        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }
        function sendOTP() {
            var number = $("#number").val();
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                console.log(coderesult);
                $("#successAuth").text("Message sent");
                $("#successAuth").show();
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
        function verify() {
            var code = $("#verification").val();
            coderesult.confirm(code).then(function (result) {
                var user = result.user;
                console.log(user);
                $("#successOtpAuth").text("Auth is successful");
                $("#successOtpAuth").show();
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
    </script> -->
    @endsection
