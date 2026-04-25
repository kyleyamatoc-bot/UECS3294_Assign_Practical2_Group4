<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <title>@yield('title', 'BowlZone')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>

<body class="@yield('bodyClass')">
    @include('partials.header')
    @include('partials.navigation')

    <main>
        @if(session('status'))
        <div class="message success" style="max-width:900px; margin:16px auto;">{{ session('status') }}</div>
        @endif
        @if($errors->any())
        <div class="message error" style="max-width:900px; margin:16px auto;">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
    <script>
        document.querySelectorAll('.message').forEach(function(msg) {
            setTimeout(function() {
                msg.style.opacity = '0';
                setTimeout(function() {
                    msg.remove();
                }, 500);
            }, 3000);
        });
    </script>
</body>

</html>