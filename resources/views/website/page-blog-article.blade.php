@extends('layouts.website.app')

@section('title')
{{ $article['title_' . app()->getLocale()] }} - {{__('general.Latest News')}}
@endsection

@section('styles')
    <style>
        .post-navigation {
            align-items: unset;
        }
    </style>
@endsection

@section('pageName')

    <body class="page-article dm-dark">
    @endsection

    @section('content')
        <main class="page-main">
            <section class="page-header"
            style="background-image: url('{{asset('/website2-assets/img/page-header-theme.jpg')}}')">
                <div class="bg-shape grey"></div>
                <div class="container">
                    <div class="page-header-content">
                        <h4>{{ __('general.Latest News') }}</h4>
                        <h2>{!! __('general.blog_title') !!}</h2>
                    </div>
                </div>
            </section>
            <!--/.page-header-->

            <section class="blog-section bg-grey padding">
                <div class="bg-shape white"></div>
                <div class="container">
                    <div class="row blog-posts">
                        <div class="col-lg-8 col-md-12 sm-padding">
                            <div class="row single-layout">
                                <div class="col-lg-12 sm-padding">
                                    <div class="post-card">
                                        <div class="post-thumb">
                                            <img loading="lazy" data-lazy="true"  src="{{ asset($article->image) }}" alt="img">
                                        </div>
                                        <div class="post-content">
                                            <ul class="post-meta">
                                                <li><i class="far fa-calendar-alt"></i><a href="javascript:void">
                                                        {{ $article->updated_at->translatedFormat('d M Y') }}
                                                    </a></li>
                                            </ul>
                                            <h3><a href="javascript:void">
                                                    {{ $article['title_' . app()->getLocale()] }}
                                                </a></h3>
                                            <p>
                                                {{ $article['description_' . app()->getLocale()] }}
                                            </p>

                                            <div class="post-navigation">
                                                @if ($prev)
                                                    <div class="nav prev"
                                                        style="background-image: url('{{ asset($prev->image) }}');">
                                                        <h4><a href="{{ isset($health) ? route('health-infos.show', $prev->id) : route('get.new', $prev->id) }}"><span><i
                                                                        class="las la-arrow-left"></i>
                                                                    {{ __('general.prev') }}
                                                                </span>
                                                                {{ $prev['title_' . app()->getLocale()] }}
                                                            </a></h4>
                                                    </div>
                                                @endif
                                                @if ($next)
                                                    <div class="nav next"
                                                        style="background-image: url('{{ asset($next->image) }}');">
                                                        <h4><a href="{{ isset($health) ? route('health-infos.show', $next->id) : route('get.new', $next->id) }}"><span>
                                                                    {{ __('general.next') }}
                                                                    <i
                                                                        class="las la-arrow-right"></i></span>{{ $next['title_' . app()->getLocale()] }}</a>
                                                        </h4>
                                                    </div>
                                                @endif
                                            </div>
                                            <!--/.post-navigation -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 sm-padding">
                            @include('website.page-blog-sidebar')
                        </div>
                    </div>
                </div>
            </section>
        </main>
    @endsection
    @section('scripts')
    @endsection
