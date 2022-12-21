<footer class="page-footer">
    <div class="page-footer__top">
        <div class="uk-container">
            <!--<div class="page-footer__logo">-->
            <!--    <div class="logo"> <a class="logo__link" href="#"><img loading="lazy" data-lazy="true"  class="logo__img" src="{{asset('website-assets/img/logokop.bmp')}}" alt="logo"></a></div>-->
            <!--</div>-->
            <div class="page-footer__contacts">
                <div class="contact-item-box">
                    <div class="contact-item-box__title">{{__('footer.Our Address')}} </div>
                    <div class="contact-item-box__value">الأحساء - المبرز - شارع الستين<br>برج الملحم الأداري - الدور الثالث<br>المملكة العربية السعودية</div>
                </div>
                <div class="contact-item-box">
                    <div class="contact-item-box__title">{{__('footer.Opening Hours')}}</div>
                    <div class="contact-item-box__value">@lang('footer.Sat') – @lang('footer.Thur'): 05:00 @lang('footer.AM') – 12:00 @lang('footer.PM')<br> @lang('footer.Sat') – @lang('footer.Thur'): 04:00 @lang('footer.PM') – 01:00 @lang('footer.AM')<br> @lang('footer.Fri'): 05:00 @lang('footer.AM') – 10:30 @lang('footer.AM')<br> @lang('footer.Fri'): 04:00 @lang('footer.PM') – 01:00 @lang('footer.AM')</div>
                </div>
                <div class="contact-item-box">
                    <div class="contact-item-box__title">{{__('footer.Contact us')}}</div>
                    <div class="contact-item-box__value">{{__('general.Email')}}: <a href="mailto:Admin@gulfinvestment.net">Admin@gulfinvestment.net</a><br> {{__('general.Phone')}}: <a href="tel:920001939">920001939</a></div>
                </div>
                <div class="contact-item-box w-25">
                    <img loading="lazy" data-lazy="true"  src="{{asset('website-assets/img/icons/tax.svg')}}"
                                                           alt="delivery" data-uk-svg>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="page-footer__middle">--}}
{{--        <div class="uk-container">--}}
{{--            <ul class="uk-navbar-nav">--}}
{{--                <li><a href="#">{{__('footer.Home')}}</a></li>--}}
{{--                <li><a href="#">{{__('footer.Our Menu')}}</a></li>--}}
{{--                <li><a href="#">{{__('footer.Offers')}}</a></li>--}}
{{--                <li><a href="#">404</a></li>--}}
{{--                <li><a href="#">{{__('footer.Wishlist')}}</a></li>--}}
{{--                <li><a href="#">{{__('footer.News')}}</a></li>--}}
{{--                <li><a href="#">{{__('footer.Contact')}}</a></li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="page-footer__bottom">
        <div class="uk-container">
            <div class="page-footer__social">
                <ul class="social">
                    <li class="social-item"><a class="social-link" href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="social-item"><a class="social-link" href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="social-item"><a class="social-link" href="#"><i class="fab fa-linkedin-in"></i></a></li>
                    <li class="social-item"><a class="social-link" href="#"><i class="fab fa-google-plus-g"></i></a></li>
                    <li class="social-item"><a class="social-link" href="#"><i class="fab fa-youtube"></i></a></li>
                </ul>
            </div>
            <div class="page-footer__copy"><span>@lang('footer.copy') <a href="http://212solutions.net/"> 212 Solutions </a> @lang('footer.right')</span>@lang('footer.terms')</div>
        </div>
    </div>
    <div id="offcanvas" data-uk-offcanvas="overlay: true">
        <div class="uk-offcanvas-bar"><button class="uk-offcanvas-close" type="button" data-uk-close=""></button>
            <div class="uk-margin-top">
                <ul class="uk-nav">
                    <li><a href="{{route('home.page')}}">{{__('menu.Home')}}</a></li>
                    <li><a href="{{route('aboutUS.page')}}">{{ __('header.About')}}</a></li>
                    <li><a href="{{route('menu.page')}}">{{ __('header.Menu')}}</a></li>
                    <li><a href="{{route('offers')}}">{{ __('header.Offers')}}</a></li>
                    <li><a href="{{route('takeaway.page')}}">{{ __('header.Branches')}}</a></li>
                    <li><a href="{{route('news.all')}}">{{ __('header.What\'s New')}}</a></li>
                    <li><a href="{{route('health-infos.all')}}">{{ __('header.Health info')}}</a></li>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{__('header.Media Center')}}
                        </a>
                        <div class="dropdown-menu uk-dropdown-nav" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" style="color:black!important" href="{{route('video.page')}}">{{ __('header.Videos')}}</a>
                            <a class="dropdown-item" style="color:black!important"
                               href="{{route('gallery.page')}}">{{ __('header.Photo Albums')}}</a>
                        </div>
                    </li>
                    <li><a href="{{route('careers.all')}}">{{ __('header.Careers')}}</a></li>
                    <li><a href="{{route('contact.page')}}">{{ __('header.Contact Us')}}</a></li>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdown-flag"
                           href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), null, [], true) }}"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            @if(LaravelLocalization::getCurrentLocaleName() == 'Arabic')
                                <i class="flag-icon flag-icon-sa"></i> &nbsp;<span> العربية </span>
                            @else
                                <i class="flag-icon flag-icon-us"></i> &nbsp;<span> English </span>
                            @endif
                        </a>
                        <div class="dropdown-menu uk-dropdown-nav" aria-labelledby="dropdown-flag">
                            @if(LaravelLocalization::getCurrentLocaleName() == 'Arabic')
                                <a class="dropdown-item" style="color:black!important" rel="alternate" hreflang="en"
                                   href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                                    <i class="flag-icon flag-icon-us"></i> &nbsp;<span> English </span></a>
                            @else
                                <a class="dropdown-item" style="color:black!important" rel="alternate" hreflang="ar"
                                   href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                                    <i class="flag-icon flag-icon-sa"></i> &nbsp;<span> العربية </span></a>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
            <hr class="uk-margin">
            <div class="uk-margin-bottom">
                <div class="block-with-phone"><img loading="lazy" data-lazy="true"  src="{{asset('website-assets/img/icons/delivery.svg')}}" alt="delivery" data-uk-svg>
                    <div> <span>For Delivery, Call us</span><a href="tel:920001939">920001939</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-flex-top" id="callback" data-uk-modal="">
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical"><button class="uk-modal-close-default" type="button" data-uk-close=""></button>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
    </div>
    <div class="uk-modal-full uk-modal" id="modal-full" data-uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" data-uk-height-viewport><button class="uk-modal-close-full" type="button" data-uk-close></button>
            <form action="{{route('search.page')}}" method="GET" id="formSearch" class="uk-search uk-search-large">@csrf<input class="uk-search-input uk-text-center" name="itemSearch" id="searchInput" type="search" placeholder="{{__('footer.Search')}}" autofocus></form>
        </div>
    </div>
    {{-- <button class="light" style="display: inline-block!important;" id="mode-toggler"><span data-uk-icon="paint-bucket" class="uk-icon"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="paint-bucket"><path d="M10.21,1 L0,11.21 L8.1,19.31 L18.31,9.1 L10.21,1 L10.21,1 Z M16.89,9.1 L15,11 L1.7,11 L10.21,2.42 L16.89,9.1 Z"></path><path fill="none" stroke="#000" stroke-width="1.1" d="M6.42,2.33 L11.7,7.61"></path><path d="M18.49,12 C18.49,12 20,14.06 20,15.36 C20,16.28 19.24,17 18.49,17 L18.49,17 C17.74,17 17,16.28 17,15.36 C17,14.06 18.49,12 18.49,12 L18.49,12 Z"></path></svg></span></button> --}}
</footer>
