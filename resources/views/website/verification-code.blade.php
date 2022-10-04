@extends('layouts.website.app')

@section('title')
    {{ __('general.verification') }}
@endsection

@section('styles')
    <style>
        form {
            padding-top: 10px;
            font-size: 14px;
            margin-top: 30px;
        }

        .card-title {
            font-weight: 300;
        }

        .btn {
            font-size: 14px;
            margin-top: 20px;
        }

        .login-form {
            width: 320px;
            margin: 20px;
        }

        .sign-up {
            text-align: center;
            padding: 20px 0 0;
        }

        span {
            font-size: 14px;
        }
    </style>
@endsection

@section('pageName')

    <body class="page-article dm-dark">
    @endsection

    @section('content')
        <main class="page-main">
            <section class="page-header" {{-- style="background-image: url({{ asset('website-assets/img/pages/contacts/bg-first-screen.jpg') }})" --}}
                style="background-image: url('{{ asset('website2-assets/img/page-header-theme.jpg') }}')">
                <div class="bg-shape grey"></div>
                <div class="container">
                    <div class="page-header-content">
                        <h4 class="text-">
                            {{ __('general.verification') }}
                        </h4>
                        <h2 class="text-">
                            {{ __('general.verification_title') }}
                        </h2>
                    </div>
                </div>
            </section>
            <!--/.page-header-->
            <div class="col-10 text-center mx-auto">
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
            </div>
            <div class="container padding-bottom-3x mb-2">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <form class="card mt-4" action="{{ route('verifyCode.save') }}" id="verification" method="post">
                            @csrf
                            <input hidden type="text" id="number" name="phone" value="{{ session('user')['phone'] }}">
                            <input hidden type="text" id="user_id" name="user_id" value="{{ session('user')['id'] }}">
                            {{-- <input hidden  type="text" id="password" name="password" value="{{$password}}"> --}}
                            <input hidden type="text" id="verify" name="verify" value="1">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email-for-pass">{{ __('auth.Enter Your Verification Code') }}</label>
                                    <input class="form-control" type="email" id="email-for-pass"
                                        value="{{session('user')['email']}}"
                                        name="email" hidden>
                                    <input class="form-control" type="text" id="token-for-pass" placeholder="- - - - -"
                                        name="token">
                                    <div id="error"></div>
                                    <div id="recaptcha-container"></div>
                                    {{-- <button  id="otp_token" type="button" class="btn btn-primary mt-3" onclick="sendOTP()">Send OTP</button> --}}

                                    <div class="help-block" style="display: none"></div>
                                </div>
                            </div>
                            <div class="card-footer" id='submit_form'>
                                <button class="btn default-btn rounded my-1" id="save"
                                    type="submit">{{ __('general.verify') }}<span></span></button>
                                <button id="resend_otp_token" formaction="{{ route('verifyCode.resend') }}" type="submit"
                                    class="btn default-btn bg-danger rounded my-1 mx-5">{{ __('auth.resend code') }}<span></span></button>
                                <!-- <button class="btn btn-default font-weight-bold" style="color: #0f7ae5; @if (app()->getLocale() == 'ar') float:left; @else float:right; @endif" type="submit" onclick="sendOTP()">{{ __('auth.resend code') }}</button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    @endsection

    @section('scripts')
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyD7P_2ebS_75Ipug4RKuWUh30O8SVVqHLg",
            authDomain: "kopflutter.firebaseapp.com",
            projectId: "kopflutter",
            storageBucket: "kopflutter.appspot.com",
            messagingSenderId: "205767716669",
            appId: "1:205767716669:web:bdbb42d05daa0d43171f54",
            measurementId: "G-WNMF4VSY4F"
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
                document.getElementById('otp_token').style.display = 'none';
                document.getElementById('resend_otp_token').style.display = 'block';
                document.getElementById('submit_form').style.display = 'block';
                alert("Message sent");
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
    
        $(function(){
            $('#verification').on('submit', function(event){
                event.preventDefault();
                var code = $("#token-for-pass").val();
                coderesult.confirm(code).then(function (result) {
                    var user = result.user;
                    console.log(user);
                    $('#verify').val(1);
                    $('#verification').submit();
                    // $("#successOtpAuth").text("Auth is successful");
                    // $("#successOtpAuth").show();
                }).catch(function (error) {
                    $("#error").text(error.message);
                    $("#error").show();
                    $('#verify').val(0);
                });
                return false;
            });
        });
    </script> --}}
    @endsection
