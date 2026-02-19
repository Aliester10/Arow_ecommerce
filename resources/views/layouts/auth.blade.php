<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Auth' }} | {{ $perusahaan?->nama_perusahaan ?? 'Arow Ecommerce' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="shortcut icon" href="{{ asset('fav.png') }}" type="image/png">

    <style>
        .auth-wave-card {
            position: relative;
        }

        @media (min-width: 768px) {
            .auth-wave-card::before {
                content: '';
                position: absolute;
                left: -70px;
                top: 0;
                bottom: 0;
                width: 140px;
                background: #ffffff;
                border-top-right-radius: 9999px;
                border-bottom-right-radius: 9999px;
                box-shadow: -24px 0 40px rgba(0, 0, 0, 0.06);
            }
        }
    </style>
</head>

<body class="antialiased" style="background: linear-gradient(90deg, #ec4a0a 0%, #fb6514 50%, #ec4a0a 100%);">
    <main class="min-h-screen flex items-center justify-center px-4 py-10">
        @yield('content')
    </main>
</body>

</html>
