<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}"/>

    <link href="{{asset('bootstrap-3.3.7-dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-3.1.0.min.js')}}"></script>
    <script src="{{asset('bootstrap-3.3.7-dist/js/bootstrap.min.js')}}"></script>

    @stack('scripts')
</head>
<body>

@yield('content')

</body>
</html>