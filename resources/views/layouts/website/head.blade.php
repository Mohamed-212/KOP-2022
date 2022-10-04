<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="Chernyh Mihail" name="author">
    <meta content="Spedito - All in one place" name="description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="HandheldFriendly" content="true">
    <meta name="format-detection" content="telephone=no">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('website-assets/img/faviconkop.png') }}" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo&display=swap');
    </style>

    @if (app()->getLocale() == 'ar')
        {{-- <link
            rel="stylesheet"
            href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css"
            integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe"
            crossorigin="anonymous" />
        <link id="dm-light" rel="stylesheet" href="{{asset('website-assets/css-rtl/style.css')}}">
        <link rel="stylesheet" href="{{asset('website-assets/css-rtl/main-rtl.css')}}">
        <link rel="stylesheet" href="{{asset('website-assets/css-rtl/uikit-rtl.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('website-assets/css-rtl/slick-rtl.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('website-assets/css-rtl/slick-theme-rtl.min.css')}}" /> --}}
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/animate_rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/bootstrap_rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/fontawesome_rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/line-awesome_rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/food-icon_rtl.css') }}">
        {{-- <link rel="stylesheet" href="{{asset('website2-assets/css-rtl/slider_rtl.css')}}"> --}}
        <link rel="stylesheet" href="{{ asset('website2-assets/css/slider.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/venobox_rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/slick_rtl.min.css') }}">
        {{-- <link rel="stylesheet" href="{{asset('website2-assets/css/slick.min.css')}}"> --}}
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/swiper_rtl.min.css') }}">
        {{-- <link rel="stylesheet" href="{{asset('website2-assets/css/swiper.min.css')}}"> --}}
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/splitting-cells_rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/splitting_rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/keyframe-animation.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/header_rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/blog_rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/main_rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css-rtl/responsive_rtl.css') }}">
    @else
        <!-- <link href="{{ asset('website2-assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('website2-assets/css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('website-assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('website-assets/css/uikit.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('website2-assets/vendor/slick/slick.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('website2-assets/vendor/slick/slick-theme.min.css') }}" /> -->
        <link rel="stylesheet" href="{{ asset('website2-assets/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/food-icon.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/slider.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/venobox.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/slick.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/swiper.min.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/splitting-cells.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/splitting.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/keyframe-animation.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/header.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/blog.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('website2-assets/css/responsive.css') }}">
    @endif

    <!-- <link href="{{ asset('website2-assets/vendor/icons/feather.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('website2-assets/vendor/sidebar/demo.css') }}" rel="stylesheet">
    <link href="{{ asset('website2-assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet"> -->

    <style>
        .default-bg {
            background: #ff9d2d;
        }

        .default-bg:hover {
            background: #fe9d2d;
        }
        .header-menu-wrap ul li > a {
            padding: 0 5px;
        }
        .food-info h4 {
            min-height: 0 !important;
        }
    </style>


    {{-- <link id="dm-light" rel="stylesheet" href="{{asset('website-assets/css/light.css')}}"> --}}
    {{-- <link id="dm-dark" rel="stylesheet" href="{{asset('website-assets/css/dark.css')}}" disabled="true"> --}}
    <!-- Flag Icon -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" integrity="sha512-Cv93isQdFwaKBV+Z4X8kaVBYWHST58Xb/jVOcV9aRsGSArZsgAnFIhMpDoMDcFNoUtday1hdjn0nGp3+KZyyFw==" crossorigin="anonymous" /> --}}

    <meta charset="UTF-8">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' rel='stylesheet'
        type='text/css'>

    {{-- <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js'></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> --}}

    @yield('styles')
    <style>
        /* @font-face {
          font-family: sans-arab-bold;
          src: url({{ asset('fonts/TheSans-bold.otf') }});
        }
        *{
            font-family: sans-arab-bold !important;
        } */
        body {
            overflow-x: hidden;
        }

        .help-block {
            color: red;
            font-weight: bold;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #6dc405;
            border-color: #6dc405;
        }

        .btn-outline-primary {
            color: #ff0000;
            border-color: #fe3000 !important;
        }

        .btn-outline-primary:hover {
            color: #ffffff;
            border-color: #fe3000 !important;
            background-color: #fe3000 !important;
            background: #fe3000 !important;
        }

        .btn-primary {
            border-color: #fe3000 !important;
            background-color: #fe3000 !important;
            background: #fe3000 !important;
        }

        .text-danger {
            color: #fe3000 !important;
        }

        body.dm-light .uk-slidenav {
            -webkit-transition: 0.3s;
            -o-transition: 0.3s;
            border: 1px solid #cccccc;
            color: #585353;
            transition: 0.3s;
            font-weight: bold;
        }

        .section-special-deals .uk-subnav li {
            margin-bottom: 10px;
            margin-top: 30px;
        }

        .section-special-deals .section-content {
            min-height: unset;
        }

        .first-screen__desc {
            text-align: center;
        }

        body.dm-light .product-item__box:hover,
        body.dm-light .product-full-card__box:hover {
            border: 1px solid #808080;
        }

        .badge {
            padding-left: 9px;
            padding-right: 9px;
            -webkit-border-radius: 9px;
            -moz-border-radius: 9px;
            border-radius: 9px;
        }

        .label-warning[href],
        .badge-warning[href] {
            background-color: #ff0000;
        }

        #lblCartCount {
            font-size: 12px;
            background: #ff0000;
            color: #fff;
            padding: 0 5px;
            vertical-align: top;
            margin-left: -10px;
        }

        .uk-light .uk-slidenav:focus {
            color: #585353;
        }

        .uk-slidenav-previous,
        .uk-slidenav-next {
            border-radius: 50% !important;
        }

        .select2.select2-container {
            width: 100% !important;
        }

        .header-menu-wrap li li.active {
            background-color: #ff8e28;
        }
        .contact-info-list li a:hover {
            color: #585353;
        }
        [dir=rtl] .dl-slider-button-prev i, [dir=rtl] .dl-slider-button-next i, .las.la-arrow-left i, .las.la-arrow-right i {
        transform: rotateY(180deg);
      }
    </style>
    @if (app()->getLocale() == 'ar')
        <style>
            /* .uk-icon svg[data-svg="slidenav-previous"], .uk-icon svg[data-svg="slidenav-next"] {
                transform: translate(-5px,10px);
            } */
            .vbox-next,
            .vbox-prev,
            .post-card .la-long-arrow-alt-right {
                transform: rotateY(180deg);
                margin: 0;
            }

            /* .main-slider .slick-arrow.slick-prev i {
                margin-right: 0;
                margin-left: 5px;
            }
            .main-slider .slick-arrow.slick-next i {
                margin-right: 0;
                margin-left: 5px;
            } */
        </style>
    @else
        <style>
            /* .uk-icon svg[data-svg="slidenav-previous"], .uk-icon svg[data-svg="slidenav-next"] {
                transform: translate(5px,10px);
            } */
        </style>
    @endif
</head>
