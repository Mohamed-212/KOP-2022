<header class="page-header">
    <div class="page-header__top" style="height: 100px;background-color: #cc3333;">
        <div class="uk-container p-1 h-100">
            <nav class="uk-navbar-container uk-navbar-transparent  h-100" data-uk-navbar="">
                <div class="uk-navbar-left">
                    <button class="uk-button" type="button" data-target="#offcanvas" data-uk-toggle
                            data-uk-icon="menu"></button>
                    <ul class="uk-navbar-nav">
                        <li><a href="{{route('menu.page')}}">{{ __('header.Menu')}}</a></li>
                        <li><a href="{{route('takeaway.page')}}">{{ __('header.Branches')}}</a></li>
                        <li><a href="{{route('news.all')}}">{{ __('header.What\'s New')}}</a></li>
                        <li><a href="{{route('health-infos.all')}}">{{ __('header.Health info')}}</a></li>
                        <li><a href="{{route('offers')}}">{{ __('header.Offers')}}</a></li>
                    </ul>
                </div>
                <div class="uk-navbar-center" style="margin:5px;">
                    <div class="logo">
                        <div class="logo__box" style="background-color:#fff"><a class="logo__link" href="{{route('home.page')}}"> <img
                                    class="logo__img logo__img--full" src="{{asset('website-assets/img/logokop.bmp')}}"
                                    alt="logo"><img loading="lazy" data-lazy="true"  class="logo__img logo__img-small"
                                                    src="{{asset('website-assets/img/output-onlinepngtools -small.bmp')}}" alt="logo"></a>
                        </div>
                    </div>
                </div>
                <div class="uk-navbar-right "><a class="uk-button" href="#"> <span>Make Your Pizza</span><img
                            class="uk-margin-small-left" src="{{asset('website-assets/img/icons/pizza.png')}}"
                            alt="pizza"></a>
                    <ul class="uk-navbar-nav">
                        
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{__('header.Media Center')}}
                            </a>
                            <div class="dropdown-menu uk-dropdown-nav" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('video.page')}}">{{ __('header.Videos')}}</a>
                                <a class="dropdown-item"
                                   href="{{route('gallery.page')}}">{{ __('header.Photo Albums')}}</a>
                            </div>
                        </li>
                        <li><a href="{{route('careers.all')}}">{{ __('header.Careers')}}</a></li>
                        <li><a href="{{route('aboutUS.page')}}">{{ __('header.About')}}</a></li>
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
                                    <a class="dropdown-item" rel="alternate" hreflang="en"
                                       href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                                        <i class="flag-icon flag-icon-us"></i> &nbsp;<span> English </span></a>
                                @else
                                    <a class="dropdown-item" rel="alternate" hreflang="ar"
                                       href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                                        <i class="flag-icon flag-icon-sa"></i> &nbsp;<span> العربية </span></a>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="page-header__bottom">
        <div class="uk-container">
            <div class="uk-navbar-container uk-navbar-transparent" data-uk-navbar="">
                <div class="uk-navbar-left">
                    <div>
                        <div class="block-with-phone"><img loading="lazy" data-lazy="true"  style="color:#f00" src="{{asset('website-assets/img/icons/delivery-man-') . app()->getLocale() . '.svg' }}"
                                                           alt="delivery" data-uk-svg width="42" height="42">
                            <div><span>{{__('header.For Delivery, Call us')}}</span><a href="tel:920001939">920001939</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-navbar-center"></div>
                <div class="uk-navbar-right">
                    <div class="other-links">
                        <ul class="other-links-list">
                            <li><a href="#modal-full" data-uk-toggle><span data-uk-icon="search"></span></a></li>
                            <li><a href="{{route('profile')}}"><span data-uk-icon="user"></span></a></li>
                            <li><a href="{{route('get.cart')}}"><span data-uk-icon="cart"></span>
                                    <span class='badge badge-warning' id='lblCartCount'> 0 </span>

                                </a></li>
                        </ul>
                        @if(!auth()->user())
                            <a class="uk-button d-table" href="{{route('get.login')}}">
                                <span style="display: table-cell;vertical-align: middle;text-align:center;">{{__('header.sign-in / sign-up')}}</span></a>
                        @elseif(auth()->user())
                            <a class="uk-button d-table" href="{{route('signout')}}"> <span style="display: table-cell;vertical-align: middle;text-align:center;">{{__('header.LOG OUT')}}</span></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
