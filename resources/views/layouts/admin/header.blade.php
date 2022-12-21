<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav @if(LaravelLocalization::getCurrentLocaleName() == 'English') ml-auto @endif " @if(LaravelLocalization::getCurrentLocaleName() == 'Arabic') style="margin-right: auto" @endif>
        <li class="dropdown dropdown-language nav-item">
            <a class="dropdown-toggle nav-link" id="dropdown-flag" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), null, [], true) }}" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <!-- @if(LaravelLocalization::getCurrentLocaleName() == 'Arabic')
                    <i class="flag-icon flag-icon-sa"></i><span class="selected-language"> العربية </span>
                @else -->
                    <i class="flag-icon flag-icon-us"></i><span class="selected-language"> English </span>
                <!-- @endif -->
            </a>
            <!-- <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                @if(LaravelLocalization::getCurrentLocaleName() == 'Arabic')
                    <a class="dropdown-item" rel="alternate" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                        <i class="flag-icon flag-icon-us"></i><span> English </span></a>
                @else
                    <a class="dropdown-item" rel="alternate" hreflang="ar" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                        <i class="flag-icon flag-icon-sa"></i><span> العربية </span></a>
                @endif
            </div> -->
        </li>
    {{-- <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">6</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">6 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li> --}}
    <li class="nav-item">
      <a href="javascript:void()" onclick="$('#logout-form').submit();" class="nav-link">Logout</a>
    </li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

  </ul>
</nav>
