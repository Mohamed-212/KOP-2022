@extends('layouts.website.app')

@section('title')
{{ $article['title_' . app()->getLocale()] }} - {{__('general.Gallery')}}
@endsection

@section('styles')
    <style>
        .page-item.active .page-link {
            z-index: 1;
            border-color: #6dc405;
            background: #6dc405;
            color: #ffffff;
        }

        .page-item.disabled .page-link {
            color: #ffffff;
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

        .carousel-inner li {
            display: none;
        }

        .card-img-overlay-custom {
            text-align: center;
            width: 100%;
            position: absolute;
            bottom: 0;
        }

        .card-title {
            background: #0000008c;
            color: #fff;
        }

        .image-card img:hover {
            cursor: pointer;
            transform: scale(1.5);
            transition: all ease-in .3s;
        }

        button.close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            color: #fff;
            opacity: 1;
            padding: 5px 10px;
            border-radius: 6px;
            border: 1px solid #000;
            z-index: 999999;
        }

        .close:hover {
            color: gray;
            border-color: #fff;
        }

        .carousel-caption {
            bottom: 15%;
        }

        .carousel-caption h5 {
            background: #0000008c;
            color: #fff;
        }
    </style>
@endsection

@section('pageName')

    <body class="page-catalog gallery-page dm-dark">
    @endsection

    @section('content')
        <main class="page-main">
            {{-- <div class="section-first-screen">
                <div class="first-screen__bg"
                    style="background-image: url({{ asset('website-assets/img/pages/home/gallery.jpg') }})"></div>
                <div class="first-screen__content">
                    <div class="uk-container">
                        <div class="first-screen__box">
                            <h2 class="first-screen__title">{{ __('general.Gallery') }}</h2>
                            <p class="first-screen__desc">{{ __('general.Pictures of pastries kingdom products') }}</p>
                            <div class="first-screen__breadcrumb">
                                <ul class="uk-breadcrumb">
                                    <li><a href="/">{{ __('menu.Home') }}</a></li>
                                    <li><span>{{ __('general.Gallery') }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <div class="uk-container">
                    <div class="mt-5" x-data="{
                        showModal: false,
                        active: 0,
                    }">
                        <div class="row">
                            @foreach ($galleries as $gallery)
                                <div class="col-4 my-2 image-card">
                                    <div class="card overflow-hidden">
                                        <img uk-img class="card-img" src="{{ $gallery->url }}"
                                            alt="{{ app()->getLocale('ar') ? $gallery->title_ar : $gallery->title_en }}"
                                            x-on:click.prevent="active = {{ $loop->index }};showModal = true;" />
                                        <div class="card-img-overlay-custom py-1 rounded">
                                            <h5 class="card-title">
                                                {{ app()->getLocale('ar') ? $gallery->title_ar : $gallery->title_en }}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="position-relative">
                            <div class="position-fixed modal-backdrop w-100 h-100" x-show="showModal"
                                x-on:click.outside="showModal = false" x-on:keydown.esc="showModal = false">
                                <div id="carousel-images-modal" class="carousel slide w-100 h-100" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @foreach ($galleries as $gallery)
                                            <li data-target="#carousel-images-modal" x-bind:data-slide-to="active"
                                                x-bind:class="{
                                                    'active': active === {{ $loop->index }}
                                                }">
                                            </li>
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach ($galleries as $gallery)
                                            <li data-target="#carousel-images-modal" x-bind:data-slide-to="active"
                                                x-bind:class="{
                                                    'active': active === {{ $loop->index }}
                                                }">
                                            </li>
                                            <div class="carousel-item"
                                                x-bind:class="{
                                                    'active': active === {{ $loop->index }}
                                                }">
                                                <img uk-img class="d-block w-100" src="{{ $gallery->url }}"
                                                    alt="{{ app()->getLocale('ar') ? $gallery->title_ar : $gallery->title_en }}" />
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5 class="rounded">{{ app()->getLocale('ar') ? $gallery->title_ar : $gallery->title_en }}
                                                    </h5>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="close" aria-label="Close"
                                        x-on:click.prevent="showModal = false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <a class="carousel-control-prev" href="#carousel-images-modal" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel-images-modal" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ $galleries->links() }}
                </div>
            </div>
            </div> --}}

            <section class="page-header"
            style="background-image: url('{{asset('/website2-assets/img/page-header-theme.jpg')}}')">
                <div class="bg-shape grey"></div>
                <div class="container">
                    <div class="page-header-content">
                        <h4>
                            {{ __('general.Gallery') }}
                        </h4>
                        <h2>
                            {{ __('general.Pictures of pastries kingdom products') }}
                        </h2>
                    </div>
                </div>
            </section>
            <!--/.page-header-->

            <section class="gallery-section bg-grey padding">
                <div class="bg-shape white"></div>
                <div class="container">
                    <div class="row">
                        @foreach ($galleries as $ga)
                            <div class="col-lg-4 col-sm-6 padding-15">
                                <div class="gallery-item">
                                    <img src="{{asset($ga->url)}}" width='500' height='300' alt="img">
                                    <a class="img-popup" data-gall="gallery01"
                                        href="{{asset($ga->url)}}" title="{{$ga['title_'. app()->getLocale()]}}"><i class="fas fa-expand"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-40">
                        {{-- <a href="#" class="default-btn">Load More <span></span></a> --}}
                        {{$galleries->links()}}
                    </div>
                </div>
            </section>
            <!--/.gallery-section-->
        </main>
    @endsection

    @section('scripts')
    @endsection
