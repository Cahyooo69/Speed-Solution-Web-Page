<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Speed Solution')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Force refresh with timestamp -->
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <style>
        /* Force override any conflicting styles */
        .floating-btn {
            position: fixed !important;
            bottom: 30px !important;
            right: 30px !important;
            width: 80px !important;
            height: 80px !important;
            z-index: 9999 !important;
            display: flex !important;
        }
    </style>
</head>
<body>    <div id="app">
        <!-- Use Vue Header Component for dynamic auth state -->
        <header-component></header-component>
        
        <main>
            @yield('content')
        </main>
    </div>
    
    <!-- Chat Widget - Available on all pages -->
    @include('partials.chat_simple')
</body>
</html>