<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brown-50 text-gray-800">

    @include('components.seller-navbar')

    <main>
        @if(session('success'))
            <div class="max-w-6xl mx-auto px-4 pt-4">
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-2 rounded-xl">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
