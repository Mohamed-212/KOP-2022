<!DOCTYPE html>
<html class="fontawesome-i2svg-active fontawesome-i2svg-complete" @if (app()->getLocale() == 'ar') dir="rtl" @endif>

@include('layouts.website.head')

{{-- @yield('pageName') --}}

<div class="page-wrapper">

    {{-- @include('layouts.website.header') --}}

    @yield('content')

    @include('layouts.website.footer')

</div>
</body>

</html>
