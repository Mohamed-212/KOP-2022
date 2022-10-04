<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title>{{ config('app.name') }}</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
<link rel="stylesheet" href="{{ asset('admin-assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin-assets/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.0/css/jquery.dataTables_themeroller.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('admin-assets/css/icheck-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin-assets/css/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin-assets/css/OverlayScrollbars.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link rel="stylesheet" href="{{ asset('admin-assets/css/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('admin-assets/css/jquery.datetimepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin-assets/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin-assets/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin-assets/css/daterangepicker.css') }}">
<!-- Flag Icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" integrity="sha512-Cv93isQdFwaKBV+Z4X8kaVBYWHST58Xb/jVOcV9aRsGSArZsgAnFIhMpDoMDcFNoUtday1hdjn0nGp3+KZyyFw==" crossorigin="anonymous" />
<!-- Bootstrap RTL -->
@if(LaravelLocalization::getCurrentLocaleName() == 'Arabic')
    <link
        rel="stylesheet"
        href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css"
        integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('adminlte/bootstrapRtl/rtl.css') }}">
@endif
<style type="text/css">
  .error
  {
    color: red;
    border-color: red;
  }
  .content-wrapper {
    background-color: white;
  }

.help-block{
    color: red;
    font-weight: bold;
}
</style>
@stack('css')
