<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale() == 'en') ? 'ltr' : 'rtl' }}">

<head>
    @include('layouts.admin.head')
</head>

<body class="hold-transition skin-blue sidebar-mini">

{{--@if (count($errors) > 0)--}}
{{--     <div class = "alert alert-danger">--}}
{{--        <ul>--}}
{{--            @foreach ($errors->all() as $error)--}}
{{--                <li>{{ $error }}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@endif--}}

<div class="wrapper">

    @include('layouts.admin.header')

    @include('layouts.admin.sidebar')

    <div id="app">
        @yield('content')
    </div>

</div>

@include('layouts.admin.scripts')

<script>
    $(document).ready(function() {
      $('form').on('submit', function() {
        window.onbeforeunload = null;
      });
    });
  </script>
</body>

</html>
