<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
<head>
    @routes()
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <meta name="description" content="Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{ asset('admin_template/apple-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('admin_template/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="shortcut icon" href="favicon.ico">

    <link href="{{ asset('css/admin_style.css') }}" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ asset('admin_template/assets/css/themify-icons.css') }}"> --}}

    @yield('css')


    {{-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'> --}}

</head>
<body>
    @include('layouts.left_panel')

    <div id="right-panel" class="right-panel">

        @include('layouts.header')

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            @yield('page-title')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            @include('toast::messages')
            @yield('content')
        </div>
    </div>

    @include('sweetalert::alert')`

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>

    @yield('script')
</body>
</html>
