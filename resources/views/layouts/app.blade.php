<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        html, body {
            background-color: #fff;
            font-family: 'Raleway', sans-serif  !important;
            height: 100vh;
            margin: 0;
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px !important;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div id="app"></div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
