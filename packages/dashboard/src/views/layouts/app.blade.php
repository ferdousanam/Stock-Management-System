<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{isset($pageTitle) ? $pageTitle :''}} || {{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    @livewireStyles

    <!-- Styles -->
    <link href="{{ mix('assets/admin/css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <script> var base_url = '{{ url("/") }}'; </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="app" class="wrapper">

@include('admin::layouts.inc.header')

@include('admin.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header"></div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
            @yield('content')
            <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('admin::layouts.inc.footer')
</div>
<!-- ./wrapper -->

@livewireScripts

<!-- Scripts -->
<script src="{{ mix('assets/admin/js/app.js') }}"></script>

{{--@include('admin::layouts.inc.scripts')--}}
<script>
    $(document).ready(function () {
        @if (isset($activeNavSelector))
        $("{{$activeNavSelector}}").addClass('active');
        @endif
        @if (isset($activeNavParentSelector))
        $("{{$activeNavParentSelector}}").addClass('menu-open').find('.tree-opener').addClass('active');
        @endif
    });
</script>
@stack('scripts')
<script>
    $(document).ready(function () {
        $('.nav-item').click(function () {
            // $('.preloader').show();
        });
    });
    $(window).on('load', function () {
        $('.preloader').fadeOut('slow');
    });
</script>
</body>
</html>
