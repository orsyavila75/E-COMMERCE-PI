@extends('template.auth-template')

@section('title', 'Login - Kerajinan Nusantara')

@section('content')
<div class="min-h-screen w-full flex">
    
    {{-- Left Side - Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16 bg-white relative overflow-hidden">
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary-50 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[10%] right-[10%] w-[30%] h-[30%] bg-secondary-50 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full max-w-md relative z-10">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 mb-10 group">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="leaf" class="w-6 h-6 text-white"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-display text-xl font-bold text-primary-900 leading-none">Kerajinan</span>
                    <span class="font-display text-xl font-bold text-primary-600 leading-none">Nusantara</span>
                </div>
            </a>

            {{-- Welcome Text --}}
            <div class="mb-10">
                <h1 class="font-display text-4xl font-bold text-primary-900 mb-3">Selamat Datang!</h1>
                <p class="text-primary-500 text-lg">Silakan masuk untuk melanjutkan perjalanan Anda.</p>
            </div>

            {{-- Error Messages --}}
            @if (isset($errors) && $errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-8 animate-fade-in-down">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mt-0.5"></i>
                        <div>
                            <h3 class="font-medium text-red-900 text-sm">Gagal Masuk</h3>
                            <ul class="mt-1 text-red-600 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-primary-700 ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-5 h-5 text-primary-400 group-focus-within:text-primary-600 transition-colors"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-primary-900 placeholder-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 focus:bg-white transition-all duration-300"
                               placeholder="nama@email.com" />
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between ml-1">
                        <label class="text-sm font-medium text-primary-700">Password</label>
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors">Lupa Password?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-primary-400 group-focus-within:text-primary-600 transition-colors"></i>
                        </div>
                        <input type="password" name="password" required
                               class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-primary-900 placeholder-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 focus:bg-white transition-all duration-300"
                               placeholder="••••••••" />
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="remember" id="remember-me" 
                                   class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-300 transition-all checked:border-primary-600 checked:bg-primary-600 hover:border-primary-400">
                            <i data-lucide="check" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></i>
                        </div>
                        <span class="text-sm text-gray-600 group-hover:text-primary-700 transition-colors">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-bold rounded-xl hover:from-primary-700 hover:to-primary-800 focus:ring-4 focus:ring-primary-500/30 transition-all duration-300 shadow-lg shadow-primary-500/30 flex items-center justify-center gap-2 group transform active:scale-[0.98]">
                    <span>Masuk Sekarang</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            {{-- Register Link --}}
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="font-bold text-primary-600 hover:text-primary-800 transition-colors hover:underline decoration-2 underline-offset-4">
                        Daftar Gratis
                    </a>
                </p>
            </div>
        </div>
    </div>

    {{-- Right Side - Branding --}}
    <div class="hidden lg:flex w-1/2 bg-primary-950 relative overflow-hidden items-center justify-center">
        {{-- Artistic Canvas Background --}}
        <canvas id="artisticCanvas" class="absolute inset-0 w-full h-full z-0"></canvas>
        
        {{-- Overlay Gradient for depth --}}
        <div class="absolute inset-0 bg-gradient-to-t from-primary-950/90 via-primary-900/40 to-primary-950/90 z-0 pointer-events-none"></div>

        {{-- Content Card Removed --}}
    </div>
</div>

<script>
    /**
     * Artistic "Golden Weaving" Particle Animation
     * Represents the connection between artisans and the world.
     */
    const canvas = document.getElementById('artisticCanvas');
    const ctx = canvas.getContext('2d');
    
    let width, height;
    let particles = [];
    
    // Configuration
    const particleCount = 60;
    const connectionDistance = 150;
    const mouseDistance = 200;
    
    // Resize handling
    function resize() {
        width = canvas.width = canvas.parentElement.offsetWidth;
        height = canvas.height = canvas.parentElement.offsetHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    // Mouse tracking
    let mouse = { x: null, y: null };
    canvas.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });
    canvas.addEventListener('mouseleave', () => {
        mouse.x = null;
        mouse.y = null;
    });

    class Particle {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.vx = (Math.random() - 0.5) * 0.5;
            this.vy = (Math.random() - 0.5) * 0.5;
            this.size = Math.random() * 2 + 1;
            this.baseColor = `rgba(255, 200, 150, ${Math.random() * 0.5 + 0.1})`; // Gold/Skin tone
        }

        update() {
            this.x += this.vx;
            this.y += this.vy;

            // Bounce off edges
            if (this.x < 0 || this.x > width) this.vx *= -1;
            if (this.y < 0 || this.y > height) this.vy *= -1;

            // Mouse interaction
            if (mouse.x != null) {
                let dx = mouse.x - this.x;
                let dy = mouse.y - this.y;
                let distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < mouseDistance) {
                    const forceDirectionX = dx / distance;
                    const forceDirectionY = dy / distance;
                    const force = (mouseDistance - distance) / mouseDistance;
                    const directionX = forceDirectionX * force * this.size;
                    const directionY = forceDirectionY * force * this.size;
                    
                    // Gentle push away
                    this.x -= directionX * 0.5;
                    this.y -= directionY * 0.5;
                }
            }
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = this.baseColor;
            ctx.fill();
        }
    }

    function init() {
        particles = [];
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);
        
        // Update and draw particles
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();

            // Draw connections
            for (let j = i; j < particles.length; j++) {
                let dx = particles[i].x - particles[j].x;
                let dy = particles[i].y - particles[j].y;
                let distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < connectionDistance) {
                    ctx.beginPath();
                    let opacity = 1 - (distance / connectionDistance);
                    ctx.strokeStyle = `rgba(255, 220, 180, ${opacity * 0.15})`; // Faint gold lines
                    ctx.lineWidth = 1;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(animate);
    }

    init();
    animate();
</script>
@endsection
