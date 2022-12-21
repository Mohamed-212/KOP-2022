@extends('layouts.website.app')

@section('title')
    {{__('general.contact_us')}}
@endsection

@section('styles')
@endsection

@section('pageName')

    <body class="page-contacts dm-dark header-1">
    @endsection

    @section('content')
        {{-- <main class="page-main">
            <div class="section-first-screen">
                <div class="first-screen__bg"
                     style="background-image: url({{asset('website-assets/img/pages/home/contactus.jpg')}})"></div>
                <div class="first-screen__content">
                    <div class="uk-container">
                        <div class="first-screen__box">
                            <h2 class="first-screen__title">{{__('contact_us.Contact Us')}}</h2>
                            <div class="first-screen__breadcrumb">
                                <ul class="uk-breadcrumb">
                                    <li><a href="{{route('home.page')}}">{{__('contact_us.Home')}}</a></li>
                                    <li><span>{{__('contact_us.Contact Us')}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-contacts-form">
                <div class="uk-section uk-container">
                    <div class="uk-grid" data-uk-grid>
                        <div class="uk-width-1-3@m">
                            <div class="section-title burger wave">
                                <h3 class="uk-h3">{{__('contact_us.Contact Details')}}</h3>
                            </div>
                            <div class="section-content">
                                <div class="uk-text-large">{{__('general.ownername')}}</div>
                                <div>الأحساء - المبرز - شارع البستان - برج الملحم الأداري - الدور الثالث<br> المملكة العربية السعودية</div><ul class="contacts-list">
                                    <li><span>{{__('general.Phone')}}: </span><a style="color: #f00;" href="tel:920001939">920001939</a></li>
                                    <li><span>{{__('general.Email')}}: </span><a style="color: #f00;" href="mailto:Admin@gulfinvestment.net">Admin@gulfinvestment.net</a></li>
                                </ul>
                                <hr class="uk-margin">
                                <div class="block-with-phone"><img
                                        src="{{asset('website-assets/img/icons/delivery.svg')}}" alt="delivery"
                                        data-uk-svg>
                                    <div><span>{{__('general.For Delivery, Call us')}}</span><a href="tel:920001939">920001939</a>
                                    </div>
                                </div>
                                <hr class="uk-margin">
                                <div class="block-with-phone"><img
                                        src="{{asset('website-assets/img/icons/delivery.svg')}}" alt="delivery"
                                        data-uk-svg>
                                    <div><b>{{__('general.Delivery Hours')}}</b>
                                        <div>@lang('footer.Sat') – @lang('footer.Thur'): 05:00 @lang('footer.AM') – 12:00 @lang('footer.PM')<br> @lang('footer.Sat') – @lang('footer.Thur'): 04:00 @lang('footer.PM') – 01:00 @lang('footer.AM')<br> @lang('footer.Fri'): 05:00 @lang('footer.AM') – 10:30 @lang('footer.AM')<br> @lang('footer.Fri'): 04:00 @lang('footer.PM') – 01:00 @lang('footer.AM')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-2-3@m">
                            <div class="section-title burger wave">
                                <h3 class="uk-h3">{{__('contact_us.Send us a Message')}}</h3>
                            </div>
                            <div class="section-content">
                                @if (Session::has('success'))
                                    <div class="row mr-2 ml-2">
                                        <button type="text" class="btn btn-lg btn-block btn-outline-success mb-2"
                                                id="type-error">{{Session::get('success')}}
                                        </button>
                                    </div>
                                @endif
                                @if (Session::has('error'))
                                    <div class="row mr-2 ml-2">
                                        <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                                id="type-error">{{Session::get('error')}}
                                        </button>
                                    </div>
                                @endif
                                <form action="{{route('contact.store')}}" method="POST">
                                    @csrf
                                    <div class="uk-grid uk-grid-medium uk-child-width-1-2@s" data-uk-grid>
                                        <div class="uk-width-1-1">
                                            <select name="subject" class="uk-input mb-2">
                                                <option value="@lang('contact_us.suggestions')">@lang('contact_us.suggestions')</option>
                                                <option value="@lang('contact_us.message_us')">@lang('contact_us.message_us')</option>
                                                <option value="@lang('contact_us.complaints')">@lang('contact_us.complaints')</option>
                                            </select>  
                                        <div class="uk-width-1-1"><textarea class="uk-textarea" name="body"
                                                                            placeholder="{{__('general.Message')}}">{{old('body')}}</textarea>
                                            @error('body')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror</div>
                                    </div>
                                    <div><input class="uk-button mt-2" type="submit"
                                                value="{{__('contact_us.Send message')}}"></div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="section-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3604.3436712707835!2d49.57659688498658!3d25.39330428380537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e3796f8ba9b6a57%3A0xde25e24a4501ad0f!2z2KjYsdisINin2YTZhdmE2K3ZhQ!5e0!3m2!1sar!2ssa!4v1629108955647!5m2!1sar!2ssa" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </main> --}}

        <main class="page-main contactus-page">
            <section class="page-header" style="background-image: url('{{asset('/website2-assets/img/page-header-theme.jpg')}}');height: 130px;">
                <div class="bg-shape white"></div>
            </section>
            <!--/.page-header-->
            <div class="map-wrapper pt-5">
                {{-- <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27624.661995750994!2d31.32658535!3d30.06316245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583e4cfbd1592d%3A0xc90510d48ee6cca4!2z2LPYqtin2K8g2KfZhNmC2KfZh9ix2Kkg2KfZhNiv2YjZhNmK!5e0!3m2!1sar!2seg!4v1660551431152!5m2!1sar!2seg"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe> --}}

                    <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3604.3436712707835!2d49.57659688498658!3d25.39330428380537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e3796f8ba9b6a57%3A0xde25e24a4501ad0f!2z2KjYsdisINin2YTZhdmE2K3ZhQ!5e0!3m2!1sar!2ssa!4v1629108955647!5m2!1sar!2ssa"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

                    
            </div><!-- /#google-map -->

            <section class="contact-section padding">
                <div class="bg-shape grey"></div>
                <div class="map"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="contact-details-wrap">
                                <div class="contact-title">
                                    <h2>
                                        {{ __('general.do_you_have') }}
                                        <span></span>
                                    </h2>
                                    <p>
                                        {{ __('general.send_us') }}
                                    </p>
                                </div>
                                <ul class="contact-details">
                                    <li><i class="fas fa-map-marker-alt mx-1"></i>
                                        {{__('general.rest_address')}}
                                    </li>
                                    <li><i class="fas fa-envelope mx-1"></i>
                                        <a style="color: inherit;"
                                            href="mailto:Admin@gulfinvestment.net">Admin@gulfinvestment.net</a>
                                    </li>
                                    <li><i class="fas fa-phone mx-1"></i>
                                        <a style="color: inherit;" href="tel:920001939">920001939</a>
                                    </li>
                                    <li><i class="fas fa-truck mx-1"></i>
                                        <div><span>{{ __('general.For Delivery, Call us') }}&nbsp;&nbsp;</span><a
                                                href="tel:920001939" style="color:inherit">920001939</a>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="fas fa-clock mx-1 fa-2x"></i>
                                        <div class="block-with-phone">
                                            <div><b>{{ __('general.Delivery Hours') }}</b>
                                                <div>@lang('footer.Sat') – @lang('footer.Fri'): 05:00 @lang('footer.AM') – 12:00
                                                    @lang('footer.PM')<br> @lang('footer.Sat') – @lang('footer.Fri'): 04:00
                                                    @lang('footer.PM') – 01:00 @lang('footer.AM')
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-form">
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
                                <form action="{{ route('contact.store') }}" method="POST" id="ajax_contact"
                                    class="form-horizontal">
                                    @csrf
                                    <div class="contact-title">
                                        <h2>
                                            {{ __('general.drop_us') }}
                                            <span></span>
                                        </h2>
                                    </div>
                                    <div class="contact-form-group">
                                        <div class="form-field">
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="{{ __('general.Name') }}" required
                                                value="{{ auth()->check() ? auth()->user()->name : null }}" @auth readonly
                                                @endauth>
                                            @error('name')
                                                <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-field">
                                            <select name="subject" class="form-control" required>
                                                <option value="@lang('contact_us.suggestions')">@lang('contact_us.suggestions')</option>
                                                <option value="@lang('contact_us.message_us')">@lang('contact_us.message_us')</option>
                                                <option value="@lang('contact_us.complaints')">@lang('contact_us.complaints')</option>
                                            </select>
                                        </div>
                                        <div class="form-field message">
                                            <textarea id="message" name="body" cols="30" rows="4" class="form-control"
                                                placeholder="{{ __('general.Message') }}" required></textarea>
                                            @error('body')
                                                <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-field">
                                            <button id="submit" class="default-btn" type="submit">
                                                {{ __('general.Send') }}
                                                <span></span></button>
                                        </div>
                                    </div>
                                    <div id="form-messages" class="alert" role="alert"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/.contact-section-->

            <section class="branches-section bg-grey padding">
                <div class="bg-shape white"></div>
                <div class="container">
                    <div class="row branches-lists">
                        @foreach ($branches as $branch)
                            <div class="col-lg-3 col-sm-6 sm-padding my-3 branch">
                                <div class="branches-list">
                                    <h3>
                                        {{ $branch['name_' . app()->getLocale()] }}
                                    </h3>
                                    <ul>
                                        <li>
                                            {{ app()->getLocale() === 'ar' ? $branch->address_description : $branch->address_description_en }}
                                        </li>
                                        <li><a href="tel:{{ $branch->first_phone }}">
                                                {{ $branch->first_phone }}</a></li>
                                        {{-- <li><a href="tel:{{ $branch->second_phone }}">
                                                {{ $branch->second_phone }}</a></li> --}}
                                        <li><a href="mailto:{{ $branch->email }}">{{ $branch->email }}</a></li>
                                        <div class="btn-group" role="group"
                                        aria-label="Basic example">
                                        @if (in_array('delivery', explode(',', $branch->service_type)))
                                        <button type="button"
                                            class="btn btn-sm  btn-secondary">
                                            {{ __('general.Delivery') }} {{in_array('takeaway', explode(',', $branch->service_type)) ? '' : __('general.only')}}
                                        </button>
                                        @endif
                                        @if (in_array('takeaway', explode(',', $branch->service_type)))
                                        <button type="button"
                                            class="btn btn-sm btn-secondary">
                                            {{ __('general.Take away') }} {{in_array('delivery', explode(',', $branch->service_type)) ? '' : __('general.only')}}
                                        </button>
                                        @endif
                                    </div>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <!--/.branches-section-->
        </main>
    @endsection

    @section('scripts')
    @endsection
