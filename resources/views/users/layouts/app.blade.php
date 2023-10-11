<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel | User</title>
      
         <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('template_adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font/fontawesome/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template_adminlte/dist/css/adminlte.min.css') }}">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/manager.css') }}">


    </head>
    <body class="hold-transition sidebar-mini">
        @include('users.layouts.header')
        @include('users.layouts.sidebar')
        <div class="main">
            @if (session('success'))
                @php
                    Alert::success(session('success'));
                @endphp
            @elseif (session('error'))
                @php
                    Alert::error(session('error'));
                @endphp
            @endif
            @yield('content')
        </div>

        @include('users.layouts.footer')
         @include('sweetalert::alert')
            <!-- Js-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('vendor/jquery/jquery-3.6.1.min.js')}}"></script>
        <script  type ="text/javascript"  src="{{ asset('assets/js/app.js')}}"></script>
    </body>
</html>
