<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/admin/favicon.ico') }}" type="image/x-icon"/>
    <title>@yield('title')</title>
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/admin/layui.css') }}">
    @show
</head>
<body>
    @yield('content')
</body>
@section('js')
    <script src="{{ asset('js/admin/layui.js') }}"></script>
@show
</html>