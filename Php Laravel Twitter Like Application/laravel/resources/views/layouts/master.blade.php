<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="icon" href="{{ URL::to('favicon.ico') }}" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::to('css/main.css') }}">

</head>

<body>
    @include('includes.header')
    <div class="container">
        @yield('content')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ URL::to('js/app2.js') }}"></script>
    <script src="{{ URL::to('js/loginJS.js') }}"></script>
</body>
</html>
