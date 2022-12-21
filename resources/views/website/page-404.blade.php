@extends('layouts.website.app')

@section('title') {{__('general.not_found')}} @endsection

@section('styles')@endsection

@section('pageName') <body class="page-404 dm-dark"> @endsection

@section('content')
<main class="page-main">
    {{-- <div class="section-first-screen">
        <div class="first-screen__bg" style="background-image: url({{asset('website-assets/img/pages/contacts/bg-first-screen.jpg')}})"></div>
        <div class="first-screen__content">
            <div class="uk-container">
                <div class="first-screen__box">
                    <h2 class="first-screen__title">Page Not Found</h2>
                    <div class="first-screen__breadcrumb">
                        <ul class="uk-breadcrumb">
                            <li><a href="#">Back To Home</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <section class="page-header" style="padding-top: 5rem;">
        <div class="bg-shape grey"></div>
         <div class="container">
             <div class="page-header-content">
                 <h4>
                    {{__('general.oops')}}
                 </h4>
                 <h2>404 {{__('general.not_found')}}</h2>
                 <p>
                    {!! __('general.not_found_title') !!}
                 </p>
                 <a href="{{route('home.page')}}" class="default-btn mt-20"><i class="las la-hand-point-left"></i>{{__('general.back_to_home')}} <span></span></a>
             </div>
         </div>
     </section><!--/.page-header-->
    {{-- <div class="page-content">
        <div class="uk-section uk-container uk-container-small">
            <div class="page-404-error"> <img loading="lazy" data-lazy="true"  class="page-404-error__img" src="{{asset('website-assets/img/pages/404/404.svg')}}" alt="">
                <div class="page-404-error__form">
                    <div class="page-404-error__form-title">Sorry, but the page has not found.</div>
                    <div class="page-404-error__form-desc">We are unable to find the page you has requested, try searching below:</div>
                    <div class="page-404-error-form">
                        <form action="#">
                            <div class="page-404-error-form__box"><input type="email" placeholder="Type a keyword ..."><input class="uk-button" type="submit" value="Search"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</main>
@endsection

@section('scripts')@endsection

