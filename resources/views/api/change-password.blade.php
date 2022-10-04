@extends('layouts.website.app')

@section('title')
    {{ __('general.Change password') }}
@endsection

@section('styles')
<style>

.header,.sticky-header{
    display:none !important;
}
    </style>
@endsection

@section('pageName')

    <body class="page-article dm-dark">
    @endsection

    @section('content')
        <main class="page-main">
            <section class="page-header" {{-- style="background-image: url({{ asset('website-assets/img/pages/contacts/bg-first-screen.jpg') }})" --}}
                style="background-image: url({{asset('website2-assets/img/page-header-theme.jpg')}})">
                <div class="bg-shape grey"></div>
                <div class="container">
                    <div class="page-header-content">
                        <h4 class="text-">
                            {{ __('general.New Password') }}
                        </h4>
                        <h2 class="text-">
                            {{ __('general.Set a new password') }}
                        </h2>
                    </div>
                </div>
            </section>
            <!--/.page-header-->
            <div class="container padding-bottom-3x my-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10">
                        @if (Session::has('success'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-success mb-2"
                                    id="type-error">{{ Session::get('success') }}
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
                        <!--Section: Block Content-->
                        @if (isset($email) && isset($token))
                            <section class="mb-5 text-center">

                                {{-- <p>{{__('general.Set a new password')}}</p> --}}

                                <form action="{{ route('reset') }}" method="POST" id="change_password">
                                    @csrf
                                    <input type="email" id="email" name="email" value="{{ $email }}" hidden>
                                    <input type="text" id="token" name="token" value="{{ $token }}" hidden>

                                    <div class="row mb-3">
                                        <label for="password"
                                            class="col-sm-3 col-form-label">{{ __('general.New Password') }}</label>
                                        <div class="col-sm-9">
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="{{ __('general.Enter Password') }}" required>
                                            @error('password')
                                                <div class="help-block err">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassConfirm"
                                            class="col-sm-3 col-form-label">{{ __('general.Confirm Password') }}</label>
                                        <div class="col-sm-9">
                                            <input type="password" id="confirm_password" name="password_confirmation"
                                                class="form-control" placeholder="{{ __('general.Confirm Password') }}" required>

                                            @error('password_confirmation')
                                                <div class="help-block err">{{ $message }}</div>
                                            @enderror
                                            <span id='message'></span>

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9">
                                            <button type="submit" id="submit"
                                                class="btn btn-primary mt-4" disabled >{{ __('general.Change password') }}</button>
                                        </div>
                                    </div>
                                </form>

                                {{-- <div class="d-flex justify-content-between align-items-center mb-2"> --}}

                                {{-- <u><a href="https://mdbootstrap.com/docs/jquery/admin/auth/login/">Back to Log --}}
                                {{-- In</a></u> --}}

                                {{-- <u><a href="https://mdbootstrap.com/docs/jquery/admin/auth/register/">Register</a></u> --}}

                                {{-- </div> --}}

                            </section>
                            <!--Section: Block Content-->
                        @endif
                    </div>

                </div>
            </div>
        </main>
    @endsection

    @section('scripts')
        <script>
                $(' #confirm_password').on('keyup', function () {
                    if ($('#password').val() == $('#confirm_password').val()) {
                        $('#message').html('Matching').css('color', 'green');
                        document.querySelector('#submit').disabled = false;
                    } else 
                       { $('#message').html('Not Matching').css('color', 'red');
                        document.querySelector('#submit').disabled = true;}
                    });
        </script>
    @endsection
