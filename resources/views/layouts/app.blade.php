<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>My Colleagues</title>
        <!-- Include Bootstrap for Styling -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen d-flex">
            <!-- Sidebar -->
            <nav class="bg-dark text-white p-3 vh-100" style="width: 250px;">
                <h4>Sidebar</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('colleagues.index') }}" class="nav-link text-white">Colleagues</a>
                    </li>
                    <!-- Add other links as needed -->
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="flex-grow-1 bg-gray-100 dark:bg-gray-900">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    @yield('content') <!-- Content injected here -->
                </main>
            </div>
        </div>

        <!-- Scripts Section -->
        @yield('scripts') <!-- Custom scripts from individual views will go here -->
    </body>
</html>
