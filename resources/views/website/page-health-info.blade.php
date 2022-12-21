@extends('layouts.website.app')

@section('title')
    {{ __('general.Health Information') }}
@endsection

@section('styles')
    <style>
        .article .card {
            transition: all ease-in .4s;
        }

        .article .card:hover {
            box-shadow: 0 0 5px #000;
            transform: scale(1.1);
        }
    </style>
@endsection

@section('pageName')

    <body class="page-health dm-dark">
    @endsection

    @section('content')
        <main class="page-main">
            <section class="page-header"
            style="background-image: url('{{asset('/website2-assets/img/page-header-theme.jpg')}}')">
                <div class="bg-shape grey"></div>
                <div class="container">
                    <div class="page-header-content">
                        <h4>{{ __('general.Health Information') }}</h4>
                        <h2>
                            {!! __('general.health_title') !!}
                        </h2>
                    </div>
                </div>
            </section>
            <!--/.page-header-->

            <section class="blog-section bg-grey padding">
                <div class="bg-shape white"></div>
                <div class="container">
                    <div class="row blog-posts">
                        <div class="col-lg-8 col-md-12 sm-padding">
                            <div class="row classic-layout">
                                @foreach ($infos as $info)
                                    <div class="col-lg-12 sm-padding my-4">
                                        <div class="post-card">
                                            <div class="post-thumb">
                                                <img loading="lazy" data-lazy="true"  src="{{ asset($info->image) }}" alt="img">
                                                <div class="category">
                                                    <a href="javascript:void">
                                                        {{ $info['title_' . app()->getLocale()] }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="post-content">
                                                <ul class="post-meta">
                                                    <li><i class="far fa-calendar-alt"></i><a href="#">
                                                            {{ $info->updated_at->translatedFormat('d M Y') }}
                                                        </a></li>
                                                    {{-- <li><i class="far fa-user"></i><a href="#">Jonathan Smith</a></li> --}}
                                                </ul>
                                                {{-- <h3><a href="javascript:void">
                                                        {{ $info['title_' . app()->getLocale()] }}
                                                    </a></h3> --}}
                                                <p class="line-clamp5">
                                                    {{ $info['description_' . app()->getLocale()] }}
                                                </p>
                                                {{-- <a href="{{ route('get.new', $info->id) }}" class="read-more">
                                                    {{__('general.Read More')}} <i
                                                        class="las la-long-arrow-alt-right"></i></a> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 sm-padding">
                            @include('social-btn')
                        </div>
                    </div>
                </div>
            </section>
        </main>
    @endsection

    @section('scripts')
    @endsection
