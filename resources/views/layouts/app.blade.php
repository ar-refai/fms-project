<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkMode" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Dynamic Page Title -->
        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
        <!-- DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

        <!-- Laravel Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Additional Style   s -->
        @stack('styles')

        <style>
            body {
                font-family: 'Figtree', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            }

            /* DataTables Custom Styles */
            .dataTables_wrapper .dataTables_length label {
                display: flex;
                align-items: center;
                gap: 0.5rem; /* Tailwind space-x-2 */
                font-size: 0.875rem; /* Tailwind text-sm */
                color: #4b5563; /* Tailwind text-gray-700 */
                font-weight: 500; /* Tailwind font-medium */
            }
            .dataTables_wrapper .dataTables_length select {
                padding: 0.5rem; /* Tailwind p-2 */
                border: 1px solid #d1d5db; /* Tailwind border-gray-300 */
                border-radius: 0.375rem; /* Tailwind rounded-md */
                font-size: 0.875rem; /* Tailwind text-sm */
                color: #4b5563; /* Tailwind text-gray-700 */
            }
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                color: #6b7280; /* Tailwind text-gray-500 */
                background-color: transparent;
                border: none;
                padding: 0.375rem 0.75rem; /* Tailwind px-3 py-1.5 */
                margin: 0 0.25rem; /* Tailwind mx-1 */
                transition: all 0.2s ease;
            }
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background-color: #4f46e5; /* Tailwind bg-indigo-500 */
                color: white; /* Tailwind text-white */
                border-radius: 0.375rem; /* Tailwind rounded-md */
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow dark:bg-gray-800">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <!-- Additional Scripts -->
        @stack('scripts')

        <!-- DataTables Initialization -->
        <script>
            $(document).ready(function () {
                // Initialize all tables with the class `data-table`
                $('.data-table').DataTable();
            });

            // Alpine.js for Dark Mode
            document.addEventListener('alpine:init', () => {
                Alpine.data('darkMode', () => ({
                    darkMode: localStorage.getItem('dark-mode') === 'true' || false,
                    toggle() {
                        this.darkMode = !this.darkMode;
                        localStorage.setItem('dark-mode', this.darkMode);
                    }
                }));
            });
        </script>
    </body>
</html>
