<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('public/templates/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/templates/css/sb-admin-2.min.css')}}" rel="stylesheet" type="text/css">
    <link rel='icon' href='{{url('public/images/logo/favicon.ico')}}' type='image/x-icon'>
    <title>@yield('title')</title>
    @yield('styles')
</head>
<body>
    <div id="wrapper">
        @include('layouts.dashboard.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.dashboard.header')
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{asset('public/templates/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/templates/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/templates/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('public/templates/js/sb-admin-2.min.js')}}"></script>
    @yield('scripts')
</body>
</html>