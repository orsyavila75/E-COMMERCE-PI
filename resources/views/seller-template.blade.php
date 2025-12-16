{{-- resources/views/template/seller-template.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brown-50">

    {{-- NAVBAR KHUSUS SELLER --}}
    @include('components.seller-navbar')

    {{-- KONTEN HALAMAN --}}
    <main>
        @yield('content')
    </main>

</body>
</html>
