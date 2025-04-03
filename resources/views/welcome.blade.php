<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Restaurant Management System</title>

    <link rel="icon" href="{{ asset('icon.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/js/app.js','resources/css/app.css'])
    @else
        <style>
            /* Include your custom styles if Vite is not active */

            
        </style>
    @endif
</head>
<body class="bg-gray-50 text-gray-700 font-sans antialiased">

    <div class="min-h-screen flex flex-col justify-center items-center py-16">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-semibold text-gray-800">Welcome to the Restaurant Management System</h1>
        </div>

        <div class="max-w-3xl text-center px-4">
            <p class="text-xl text-gray-600 mb-6">
                This system is designed to streamline the process of managing restaurant concessions, orders, and kitchen activities.
                Whether you are an admin, manager, or staff member, you'll find an easy-to-use interface to handle various tasks with efficiency.
            </p>
            <p class="text-lg text-gray-600 mb-4">
                To get started, please choose one of the options below to either log in or register a new account.
            </p>
        </div>

        <div class="flex justify-center gap-4">
            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-3 rounded-md text-lg hover:bg-blue-600 transition">
                Login
            </a>
            <a href="{{ route('register') }}" class="bg-green-500 text-white px-6 py-3 rounded-md text-lg hover:bg-green-600 transition">
                Register
            </a>
        </div>
    </div>

</body>
</html>
