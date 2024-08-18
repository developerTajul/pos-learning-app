<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Default Title')</title>
        @include('layouts.styles')
        @yield('styles')
    </head>
    <body>

        @include('components.loading')

        @yield('content')

        @include('layouts.scripts')
        @yield('scripts')
    </body>
</html>