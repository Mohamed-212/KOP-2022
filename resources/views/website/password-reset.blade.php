@extends('layouts.website.app')

@section('title') {{__('general.Forgot your password?')}} @endsection

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
            <section class="page-header"
            {{-- style="background-image: url({{ asset('website-assets/img/pages/contacts/bg-first-screen.jpg') }})" --}}
            style="background-image: url({{asset('website2-assets/img/page-header-theme.jpg')}})"
            >
            <div class="bg-shape grey"></div>
            <div class="container">
                <div class="page-header-content">
                    <h4 class="text-">
                        {{ __('general.Forgot your password?') }}
                    </h4>
                    <h2 class="text-">
                        {{ __('general.Enter Password') }}
                    </h2>
                </div>
            </div>
        </section>
        <!--/.page-header-->

            <div class="container padding-bottom-3x mb-2">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
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
                        <h2>{{__('general.Forgot your password?')}}</h2>
                        <form class="card mt-4" action="{{route('password.reset')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email-for-pass">{{__('general.Enter Your E-mail')}}</label>
                                    <input class="form-control" type="text" id="email-for-pass" value="{{old('email')}}" name="email"><small class="form-text text-muted">{{__('general.Type in the email address you used when you registered. Then we\'ll email a code to this address.')}}</small>
                                    @error('email')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">{{__('general.Send')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
@endsection

@section('scripts')@endsection

