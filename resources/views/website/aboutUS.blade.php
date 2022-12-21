@extends('layouts.website.app')

@section('title')
    {{__('general.about_us')}}
@endsection

@section('styles')
    <style>
        .about-p p {
            font-size: 18px;
        }

        .feat:hover {
            transition: all ease-in .3s;
            background-color: white;
            box-shadow: 0 0 5px #000;
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

    <body class="page-article dm-dark aboutus-page">
    @endsection

    @section('content')
        <main class="page-main">
            <section class="page-header" style="background-image: url('{{asset('/website2-assets/img/page-header-theme.jpg')}}')">
                <div class="bg-shape white"></div>
                <div class="container">
                    <div class="page-header-content">
                        <h4>
                            {{ __('general.about_us') }}
                        </h4>
                        <h2>
                            {!! __('menu.title') !!}
                        </h2>
                    </div>
                </div>
            </section>
            <!--/.page-header-->
            @foreach ($sections as $sec)
                @if ($sec->type === 'first')
                <section class="about-section inner padding">
                    <div class="bg-shape grey"></div>
                    <div class="container">
                        <div class="row align-items-center">
                           <div class="col-md-6">
                               <div id="gallery-videos-demo" class="content-img-holder position-relative">
                                <img src="{{asset( $sec->image)}}" width="700" height="500" alt="img" id="image{{$loop->index}}">
                                <div class="position-absolute top-0 w-100 h-100" id="vedo5645">
                                    <video controls width="100%" height="100%" id="video{{$loop->index}}" style="opacity: 0;: hidden;">                                        
                                        <source src="{{asset($sec->video)}}"
                                                type="video/mp4">
                                        Sorry, your browser doesn't support embedded videos.
                                    </video>
                                </div>
                                <a class="play-btn" data-video="{{$loop->index}}">
                                    <span class="play-icon"><i class="fas fa-play"></i></span>
                                </a>
                               </div>
                           </div>
                            <div class="col-md-6">
                                <div class="about-info">
                                    <h2>
                                        <span>{{ $sec['title_' . app()->getLocale()] }}</span>
                                    </h2>
                                    <p>
                                        {{ $sec['description_' . app()->getLocale()] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section><!--/.about-section-->
                @endif
                @if ($sec->type === 'bg-st')
                    <section class="content-section-2 bg-grey padding">
                        <div class="bg-shape white"></div>
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="section-heading">
                                        <h2>
                                            <span>{{ $sec['title_' . app()->getLocale()] }}</span>
                                        </h2>
                                        <p>
                                            {{ $sec['description_' . app()->getLocale()] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content-img">
                                        <img src="{{asset( $sec->image)}}" width='600' height="400" alt="img">
                                        {{-- <img src="{{$sec->image}}" alt="img"> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--/.content-section-->
                @endif

                @if ($loop->index === 1)
                <section class="team-section padding">
                    <div class="bg-shape grey"></div>
                    <div class="container">
                        <div class="section-heading mb-30 text-center">
                            <h4>
                                {{__('general.about.team')}}
                            </h4>
                            <h2>
                                {!! __('general.about.cook') !!}
                            </h2>
                        </div>
                        <div class="row">
                            @foreach ($sections->where('type', 'emp') as $emp)
                                <div class="col-lg-3 col-sm-6 sm-padding">
                                    <div class="team-item">
                                        <div class="team-thumb">
                                            <img src="{{asset( $emp->image)}}"
                                                alt="team">
                                            <ul class="team-social">
                                                @foreach ($emp->links as $link)
                                                    @if($loop->index === 0 && $link)
                                                    <li><a href="{{$link}}"><i class="fab fa-facebook-f"></i></a></li>
                                                    @elseif($loop->index === 1 && $link)
                                                    <li><a href="{{$link}}"><i class="fab fa-twitter"></i></a></li>
                                                    @elseif($loop->index === 2 && $link)
                                                    <li><a href="{{$link}}"><i class="fab fa-instagram"></i></a></li>
                                                    @elseif($loop->index === 3 && $link)
                                                    <li><a href="{{$link}}"><i class="fab fa-behance"></i></a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="team-content">
                                            <div class="team-shape"></div>
                                            <div class="inner">
                                                <h3>
                                                    {{$emp['title_'. app()->getLocale()]}}
                                                </h3>
                                                <h4>
                                                    {{is_null($emp['description_' . app()->getLocale()]) ? __('general.chef') : $emp['description_' . app()->getLocale()]}}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                <!--/.team-section-->
                @endif

                @if ($sec->type === 'bg-nd')
                    <section class="content-section-2 bg-grey padding">
                        <div class="bg-shape white"></div>
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="content-img">
                                        {{-- <img src="/website2-assets/img/about03.png" width="600" height="400" alt="img"> --}}
                                        <img src="{{asset( $sec->image)}}" width="600" height="400" alt="img">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="section-heading">
                                        <h2>
                                            <span>{{ $sec['title_' . app()->getLocale()] }}</span>
                                        </h2>
                                        <p>
                                            {{ $sec['description_' . app()->getLocale()] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--/.content-section-->
                @endif

                @if ($sec->type === 'with-bg')
                <section class="content-section" style="height: 400px;">
                    <div class="bg-shape white"></div>
                    <div class="bg-shape grey"></div>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-6 wow fadeInLeft" data-wow-delay="200ms">
                                <div class="content-info">
                                <h2>{{$sec['title_' . app()->getLocale()]}}</h2>
                                    <p>{{$sec['description_' . app()->getLocale()]}}</p>
                                   
                                </div>
                            </div>
                            <div class="col-md-6 wow fadeInRight" data-wow-delay="400ms">
                                <div class="content-img-holder">
                                    <img src="{{asset($sec->image)}}" alt="img">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/.content-section-->
                @endif
        @endforeach
    </main>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.play-btn').click(function() {
            let vid = $(this).data('video');
            const video = $('#video' + vid)[0];
            const image = $('#image' + vid)[0];

            $(video).animate({opacity: '1.0'}, 'slow');
            $(this).css('display', 'none');
            $('#vedo5645').css('background', '#000');
        });
    });
</script>
@endsection
