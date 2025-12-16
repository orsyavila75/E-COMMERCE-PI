<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Kerajinan Nusantara - E-Commerce Kerajinan Lokal Indonesia')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fdf8f6',
                            100: '#f9ebe4',
                            200: '#f3d5c8',
                            300: '#e9b8a3',
                            400: '#dc9275',
                            500: '#cf7352',
                            600: '#b85a3a',
                            700: '#9a4a30',
                            800: '#7d3f2b',
                            900: '#683727',
                            950: '#381a12',
                        },
                        accent: {
                            50: '#f6f5f0',
                            100: '#e8e6d9',
                            200: '#d3ceb6',
                            300: '#b9b18c',
                            400: '#a49a6c',
                            500: '#958a5d',
                            600: '#7f724e',
                            700: '#675b41',
                            800: '#574c39',
                            900: '#4b4233',
                            950: '#2a241b',
                        },
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'body': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    {{-- AOS CSS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #9a4a30; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #7d3f2b; }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #9a4a30 0%, #cf7352 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Glass effect */
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Hover card effect */
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(122, 62, 16, 0.15);
        }

        /* Button shine effect */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to right,
                rgba(255,255,255,0) 0%,
                rgba(255,255,255,0.3) 50%,
                rgba(255,255,255,0) 100%
            );
            transform: rotate(45deg);
            transition: all 0.5s;
            opacity: 0;
        }
        .btn-shine:hover::after {
            animation: shine 0.7s ease-in-out;
        }
        @keyframes shine {
            0% { left: -100%; opacity: 1; }
            100% { left: 100%; opacity: 0; }
        }

        /* Pattern background */
        .pattern-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239a4a30' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="antialiased bg-primary-50 min-h-screen">
    @include('components.navbar')
    
    <main>
        @yield('content')
    </main>

    @include('components.footer')

    {{-- AOS Script --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });
        lucide.createIcons();
    </script>
</body>
</html>
