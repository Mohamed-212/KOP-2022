<aside class="main-sidebar sidebar-dark-primary elevation-4" style="height: 140vh;">
    <div
        class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
        <div class="os-resize-observer-host">
            <div class="os-resize-observer observed" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer observed"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 900px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
                <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                    <div class="pb-3 mt-3 mb-3 user-panel d-flex">
                        <div class="image">
                            <img src="{{ url('/admin-assets/image/user2-160x160.jpg') }}" class="img-circle elevation-2"
                                alt="User Image">
                        </div>
                        <div class="info">
                            <h6 style="color:white" class="d-block">{{ auth()->user()->name }}</h6>
                        </div>
                    </div>

                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('admin.home') }}" class="nav-link"><i
                                        class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            @if (auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a href="{{ route('admin.notification.index') }}" class="nav-link"><i
                                        class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Notification</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.customer.index') }}" class="nav-link"><i
                                        class="fas fa-users nav-icon"></i>
                                    <p>Customers</p>
                                </a>
                            </li>
                            @endif

                            <li
                                class="nav-item has-treeview
                                 {{ request()->segment(3) == 'category' ||
                                 request()->segment(3) == 'item' ||
                                 request()->segment(3) == 'without' ||
                                 request()->segment(3) == 'dough' ||
                                 request()->segment(3) == 'extra'
                                     ? 'menu-open'
                                     : '' }}
                                ">
                                <a href="#" class="nav-link"><i class="nav-icon fas fa-bars"></i>
                                    <p>Menu<i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    {{-- @if (auth()->user()->hasRole('admin')) --}}
                                    <li class="nav-item">
                                        <a href="{{ route('admin.category.index') }}" class="nav-link"><i
                                                class="fas fa-certificate nav-icon"></i>
                                            <p>Categories</p>
                                        </a>
                                    </li>
                                    {{-- @endif --}}
                                    <li class="nav-item">
                                        <a href="{{ route('admin.item.index') }}" class="nav-link"><i
                                                class="fas fa-certificate nav-icon"></i>
                                            <p>Items</p>
                                        </a>
                                    </li>
                                    {{-- @if (auth()->user()->hasRole('admin')) --}}
                                    <li class="nav-item">
                                        <a href="{{ route('admin.extra.index') }}" class="nav-link"><i
                                                class="fas fa-certificate nav-icon"></i>
                                            <p>Extra</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.without.index') }}" class="nav-link"><i
                                                class="fas fa-certificate nav-icon"></i>
                                            <p>Without</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.dough.index') }}" class="nav-link"><i
                                                class="fas fa-certificate nav-icon"></i>
                                            <p>Dough Types</p>
                                        </a>
                                    </li>
                                    {{-- @endif --}}
                                </ul>
                            </li>
                            @if (auth()->user()->hasRole('admin'))
                            <li
                                class="nav-item has-treeview
                                 {{ request()->segment(3) == 'points' ||
                                 request()->segment(3) == 'gift' ||
                                 request()->segment(3) == 'show-points-transactions' ||
                                 request()->segment(3) == 'show-gifts-orders'
                                     ? 'menu-open'
                                     : '' }}
                                ">
                                <a href="#" class="nav-link"><i class="nav-icon fas fa-bars"></i>
                                    <p>Loyalty System<i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if (auth()->user()->hasRole('admin'))
                                        <li class="nav-item">
                                            <a href="{{ route('admin.points.index') }}" class="nav-link"><i
                                                    class="fas fa-certificate nav-icon"></i>
                                                <p>Points</p>
                                            </a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a href="{{route('admin.gift.index')}}" class="nav-link"><i
                                                    class="fas fa-certificate nav-icon"></i>
                                                <p>Gifts</p>
                                            </a>
                                        </li> --}}
                                    @endif
                                    <li class="nav-item">
                                        <a href="{{ route('admin.showPointsTransactions') }}" class="nav-link"><i
                                                class="fas fa-certificate nav-icon"></i>
                                            <p>Points Transactions</p>
                                        </a>
                                    </li>
                                    {{-- @if (auth()->user()->hasRole('admin'))

                                        <li class="nav-item">
                                            <a href="{{route('admin.showGiftsOrders')}}" class="nav-link"><i
                                                    class="fas fa-certificate nav-icon"></i>
                                                <p>Gifts Orders</p>
                                            </a>
                                        </li>
                                    @endif --}}
                                </ul>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.order.index') }}" class="nav-link"><i
                                        class="fab fa-first-order nav-icon"></i>
                                    <p>Orders</p>
                                </a>
                            </li>
                            @if (auth()->user()->hasRole('branch_manager'))
                                <li
                                    class="nav-item has-treeview
                                 {{ request()->segment(3) == 'offers' ||
                                 request()->segment(3) == 'gallery' ||
                                 request()->segment(3) == 'media' ||
                                 //    request()->segment(3) == 'deal-of-week'||
                                 request()->segment(3) == 'contact' ||
                                 request()->segment(3) == 'careers' ||
                                 request()->segment(3) == 'news' ||
                                 request()->segment(3) == 'healthinfo'
                                     ? 'menu-open'
                                     : '' }}
                                ">
                                    <a href="#" class="nav-link"><i class="nav-icon fas fa-bars"></i>
                                        <p>Website<i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.offer.index') }}" class="nav-link"><i
                                                    class="fas fa-dice-three nav-icon"></i>
                                                <p>Offers</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                            @if (auth()->user()->hasRole('admin'))
                                <li
                                    class="nav-item has-treeview
                                 {{ request()->segment(3) == 'aboutUS' ||
                                 request()->segment(3) == 'gallery' ||
                                 request()->segment(3) == 'media' ||
                                 //    request()->segment(3) == 'deal-of-week'||
                                 request()->segment(3) == 'contact' ||
                                 request()->segment(3) == 'careers' ||
                                 request()->segment(3) == 'news' ||
                                 request()->segment(3) == 'healthinfo'
                                     ? 'menu-open'
                                     : '' }}
                                ">
                                    <a href="#" class="nav-link"><i class="nav-icon fas fa-bars"></i>
                                        <p>Website<i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href="{{ route('admin.homeitem.index') }}" class="nav-link"><i
                                                    class="fab fa-first-order nav-icon"></i>
                                                <p>Home Item</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.Anoucement.index') }}" class="nav-link"><i
                                                    class="fab fa-first-order nav-icon"></i>
                                                <p>Anoucement</p>
                                            </a>
                                        </li>
                                        {{-- <li class="nav-item">
                                        <a href="{{route('admin.hero.index')}}" class="nav-link"><i
                                                class="fab fa-first-order nav-icon"></i>
                                            <p>Hero Backgrounds</p>
                                        </a>
                                    </li> --}}
                                        {{-- <li class="nav-item">
                                        <a href="{{route('admin.itemDealOfWeek')}}" class="nav-link"><i
                                                class="fas fa-certificate nav-icon"></i>
                                            <p>Deal Of Week Items</p>
                                        </a>
                                    </li> --}}
                                        <li class="nav-item">
                                            <a href="{{ route('admin.aboutUS.index') }}" class="nav-link"><i
                                                    class="fab fa-first-order nav-icon"></i>
                                                <p>About US</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.gallery.index') }}" class="nav-link"><i
                                                    class="fab fa-first-order nav-icon"></i>
                                                <p>Gallery</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.media.index') }}" class="nav-link"><i
                                                    class="fab fa-first-order nav-icon"></i>
                                                <p>Media</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.careers.index') }}" class="nav-link"><i
                                                    class="fas fa-envelope-open-text nav-icon"></i>
                                                <p>Careers</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('admin.news.index') }}" class="nav-link"><i
                                                    class="fas fa-envelope-open-text nav-icon"></i>
                                                <p>News</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.healthinfo.index') }}" class="nav-link"><i
                                                    class="fas fa-envelope-open-text nav-icon"></i>
                                                <p>Health Info</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.contact.index') }}" class="nav-link"><i
                                                    class="fas fa-envelope-open-text nav-icon"></i>
                                                <p>Contact Us</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item has-treeview
                                 {{ request()->segment(3) == 'banner' ? 'menu-open' : '' }}
                                ">
                                    <a href="#" class="nav-link"><i class="nav-icon fas fa-bars"></i>
                                        <p>Mobile<i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.banner.index') }}" class="nav-link"><i
                                                    class="fas fa-images nav-icon"></i>
                                                <p>Banners</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.offer.index') }}" class="nav-link"><i
                                            class="fas fa-dice-three nav-icon"></i>
                                        <p>Offers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.branch.index') }}" class="nav-link"><i
                                            class="fas fa-code-branch nav-icon"></i>
                                        <p>Branches</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.reasons.index') }}" class="nav-link">
                                        <i class="fas fa-bars nav-icon"></i>
                                        <p>Deactivation Reasons</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.reasons-report.index') }}" class="nav-link">
                                        <i class="fas fa-code-branch nav-icon"></i>
                                        <p>Deactivated users Report</p>
                                    </a>
                                </li>
                                <li
                                    class="nav-item has-treeview
                                 {{ request()->segment(4) == 'customer' ||
                                 request()->segment(4) == 'order' ||
                                 request()->segment(4) == 'income' ||
                                 request()->segment(4) == 'item' ||
                                 request()->segment(4) == 'extra' ||
                                 request()->segment(4) == 'order-customer' ||
                                 request()->segment(4) == 'order-item' ||
                                 request()->segment(4) == 'payments' ||
                                 request()->segment(4) == 'order-status'
                                     ? 'menu-open'
                                     : '' }}
                                    ">
                                    <a href="#" class="nav-link"><i class="fas fa-chart-bar nav-icon"></i>
                                        <p>Reports<i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.report.customer') }}" class="nav-link"><i
                                                    class="fas fa-users nav-icon"></i>
                                                <p>Customers</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.report.order') }}" class="nav-link"><i
                                                    class="fas fa-certificate nav-icon"></i>
                                                <p>Orders</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.report.income') }}" class="nav-link"><i
                                                    class="fas fa-dollar-sign nav-icon"></i>
                                                <p>Income</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.report.item') }}" class="nav-link"><i
                                                    class="fab fa-first-order nav-icon"></i>
                                                <p>Items</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.report.extra') }}" class="nav-link"><i
                                                    class="fas fa-dice-three nav-icon"></i>
                                                <p>Extra</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.report.order-status') }}" class="nav-link"><i
                                                    class="fas fa-dice-three nav-icon"></i>
                                                <p>Order Status</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.report.order-customer') }}" class="nav-link"><i
                                                    class="fas fa-dice-three nav-icon"></i>
                                                <p>Order / Customer</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.report.order-item') }}" class="nav-link"><i
                                                    class="fas fa-dice-three nav-icon"></i>
                                                <p>Order / Item</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.report.payments') }}" class="nav-link"><i
                                                    class="fas fa-dice-three nav-icon"></i>
                                                <p>Payment Transaction</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item has-treeview
                                 {{ (request()->segment(3) == 'user') | (request()->segment(3) == 'role') ? 'menu-open' : '' }}
                                    ">
                                    <a href="#" class="nav-link"><i class="nav-icon fas fa-user-cog"></i>
                                        <p>Setting<i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.user.index') }}" class="nav-link"><i
                                                    class="fas fa-user-shield nav-icon"></i>
                                                <p>Users</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.role.index') }}" class="nav-link"><i
                                                    class="fas fa-key nav-icon"></i>
                                                <p>Roles</p>
                                            </a>
                                        </li>
                                    </ul>

                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="height: 27.2655%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar-corner"></div>
    </div>
</aside>
