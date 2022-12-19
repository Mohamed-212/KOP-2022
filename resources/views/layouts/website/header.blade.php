<header class="header"
    @if (request()->routeIs('get.login') || request()->routeIs('get.sign.up')) style="background-image: url('{{ asset('/website2-assets/img/page-header-theme.jpg') }}');" @endif>
    <div class="primary-header-one primary-header">
        <div class="">
            <div class="primary-header-inner">
                <div class="header-logo">
                    <a href="{{ route('home.page') }}">
                        <img class="light" style="max-width: 120px" src="{{ asset('website-assets/img/logokop_l.png') }}"
                            alt="Logo" />
                    </a>
                </div><!-- /.header-logo -->
                <div class="header-menu-wrap">
                    <ul class="slider-menu">
                        <li class="{{ request()->routeIs('menu.page') ? 'active' : '' }}"><a
                                href="{{ route('menu.page') }}">{{ __('header.Menu') }}</a></li>
                        <li class="{{ request()->routeIs('takeaway.page') ? 'active' : '' }}"><a
                                href="{{ route('takeaway.page') }}">{{ __('general.Branches') }}</a></li>


                        <li class="{{ request()->routeIs('news.all') ? 'active' : '' }}"><a
                                href="{{ route('news.all') }}">
                                {{ __('general.blog') }}
                            </a></li>
                        <li><a class="cart"
                                @auth
@if (!session()->has('branch_id')) data-toggle="modal" data-target="#service-modal" @endif @endauth
                                href="{{ route('offers') }}">{{ __('header.Offers') }}</a></li>
                        <li><a href="javascript:void(0)">{{ __('general.media_cen') }}</a>
                            <ul>
                                <li class="{{ request()->routeIs('gallery.page') ? 'active' : '' }}"><a
                                        href="{{ route('gallery.page') }}">{{ __('general.Gallery') }}</a></li>
                                <li class="{{ request()->routeIs('video.page') ? 'active' : '' }}"><a
                                        href="{{ route('video.page') }}">{{ __('general.Video Library') }}</a></li>
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('health-infos.all') ? 'active' : '' }}"><a
                                href="{{ route('health-infos.all') }}">
                                {{ __('general.Health Information') }}
                            </a></li>
                        
                            <li class="{{ request()->routeIs('careers.all') ? 'active' : '' }}"><a
                                href="{{ route('careers.all') }}">{{ __('general.Careers') }}</a></li>
                                <li class="{{ request()->routeIs('contact.page') ? 'active' : '' }}"><a
                                    href="{{ route('contact.page') }}">
                                    {{ __('general.contact_us') }}
                                </a></li>
                        <li class="{{ request()->routeIs('aboutUS.page') ? 'active' : '' }}"><a
                                href="{{ route('aboutUS.page') }}">
                                {{ __('general.about_us') }}</a></li>



                       
                        <li><a href="javascript:void(0)">
                                {{-- {{ __('general.language') }} --}}
                                @if (app()->getLocale() === 'ar')
                                    <img src="{{ asset('/website2-assets/img/icons/sa.svg') }}" width="16"
                                        height="16" />
                                @else
                                    <img src="{{ asset('/website2-assets/img/icons/us.svg') }}" width="16"
                                        height="16" />
                                @endif
                            </a>
                            <ul>
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li
                                        style="{{ strpos(url()->current(), "/$localeCode") > 0 ? 'background-color: #ff8e28;color: #fff' : '' }}">
                                        <a rel="alternate" hreflang="{{ $localeCode }}"
                                            href="{{ strpos(url()->current(), "/$localeCode") > -1 ? 'javascript:void(0)' : LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                            class='w-full'>
                                            @if ($localeCode === 'ar')
                                                <img src="{{ asset('/website2-assets/img/icons/sa.svg') }}"
                                                    width="16" height="16" />
                                            @else
                                                <img src="{{ asset('/website2-assets/img/icons/us.svg') }}"
                                                    width="16" height="16" />
                                            @endif

                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        @auth
                            <li>
                                <a href="javascript:void(0)"><i class="fas fa-user"></i></a>
                                <ul>
                                    <li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                                        <a href="{{ route('profile') }}">
                                            {{ __('general.profile') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="document.getElementById('log112255').click()">
                                            <form action="{{ route('signout') }}" method='post'>
                                                @csrf
                                                <button id="log112255" class="" type="submit">
                                                    {{ __('general.logout') }}
                                                </button>
                                            </form>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ request()->routeIs('get.cart') ? 'active' : '' }}">
                                <a href="{{ route('get.cart') }}" class="cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    <sup class="cart-count badge default-bg">0</sup>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="javascript:void(0)"><i class="fas fa-user"></i></a>
                                <ul>
                                    <li class="{{ request()->routeIs('get.get.login') ? 'active' : '' }}">
                                        <a href="{{ route('get.login') }}">
                                            {{ __('auth.login') }}
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('get.sign.up') ? 'active' : '' }}">
                                        <a href="{{ route('get.sign.up') }}">
                                            {{ __('auth.signup') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                </div>

                <!-- /.header-menu-wrap -->
                <div class="header-right">
                    {{-- <div class="search-icon dl-search-icon"><i class="las la-search"></i></div> --}}
                    {{-- <a class="header-btn" href="reservation.html">Reservation<span></span></a> --}}
                    <span class="sr-only">Burger menu</span>
                    <div class="mobile-menu-icon">
                        <div class="burger-menu">
                            <div class="line-menu line-half first-line"></div>
                            <div class="line-menu"></div>
                            <div class="line-menu line-half last-line"></div>
                        </div>
                    </div>
                </div>
            </div><!-- /.primary-header-one-inner -->
        </div>
    </div><!-- /.primary-header-one -->
    @if (request()->routeIs('get.login') || request()->routeIs('get.sign.up'))
        <div class="bg-shape white"></div>
    @endif
</header><!-- /.header-one -->
