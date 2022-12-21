@extends('layouts.website.app')

@section('title') Page Wishlist @endsection

@section('styles')@endsection

@section('pageName') <body class="page-wishlist dm-dark"> @endsection

@section('content')
    <main class="page-main">
        <div class="section-first-screen">
            <div class="first-screen__bg" style="background-image: url({{asset('website-assets/img/pages/contacts/bg-first-screen.jpg')}})"></div>
            <div class="first-screen__content">
                <div class="uk-container">
                    <div class="first-screen__box">
                        <h2 class="first-screen__title">Your Wishlist</h2>
                        <div class="first-screen__breadcrumb">
                            <ul class="uk-breadcrumb">
                                <li><a href="/">Home</a></li>
                                <li> <span>Your Wishlist</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="uk-margin-large-top uk-container uk-container-small"><img loading="lazy" data-lazy="true"  class="page-wishlist__img" src="{{asset('website-assets/img/pages/wishlist/img-wishlist.png')}}" alt="">
                <div class="page-wishlist__box">
                    <div class="page-wishlist__title">The Wishlist is currently empty.</div>
                    <div class="page-wishlist__desc">You need to click the icon to add items to your wishlist.</div><a class="uk-button" href="page-catalog.html">Return to Shop</a>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')@endsection
