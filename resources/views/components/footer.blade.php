{{-- Footer Component --}}
<footer class="bg-primary-900 text-white mt-auto">
    {{-- Main Footer --}}
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            
            {{-- Brand Section --}}
            <div class="lg:col-span-1">
                <h3 class="font-display text-2xl font-bold mb-4">Kerajinan Nusantara</h3>
                <p class="text-primary-200 text-sm leading-relaxed mb-6">
                    Platform e-commerce terpercaya untuk produk kerajinan tangan asli Indonesia. 
                    Mendukung pengrajin lokal, melestarikan budaya Nusantara.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-primary-800 hover:bg-primary-700 rounded-full flex items-center justify-center transition-colors">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-primary-800 hover:bg-primary-700 rounded-full flex items-center justify-center transition-colors">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-primary-800 hover:bg-primary-700 rounded-full flex items-center justify-center transition-colors">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-semibold text-lg mb-4">Menu Cepat</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ url('/') }}" class="text-primary-200 hover:text-white transition-colors flex items-center gap-2">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/products') }}" class="text-primary-200 hover:text-white transition-colors flex items-center gap-2">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            Produk
                        </a>
                    </li>
                    <li>
                        <a href="#kategori" class="text-primary-200 hover:text-white transition-colors flex items-center gap-2">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            Kategori
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Categories --}}
            <div>
                <h4 class="font-semibold text-lg mb-4">Kategori</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ url('/products?kategori=anyaman') }}" class="text-primary-200 hover:text-white transition-colors flex items-center gap-2">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            Anyaman
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/products?kategori=ukiran') }}" class="text-primary-200 hover:text-white transition-colors flex items-center gap-2">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            Ukiran
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/products?kategori=batik') }}" class="text-primary-200 hover:text-white transition-colors flex items-center gap-2">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            Batik
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/products?kategori=rajutan') }}" class="text-primary-200 hover:text-white transition-colors flex items-center gap-2">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            Rajutan
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-semibold text-lg mb-4">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-primary-400 mt-0.5"></i>
                        <span class="text-primary-200 text-sm">Jl. Kerajinan No. 123, Yogyakarta, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-primary-400"></i>
                        <span class="text-primary-200 text-sm">+62 812 3456 7890</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-primary-400"></i>
                        <span class="text-primary-200 text-sm">info@kerajinannusantara.id</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom Footer --}}
    <div class="border-t border-primary-800">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-primary-300 text-sm">
                    &copy; {{ date('Y') }} Kerajinan Nusantara. All rights reserved.
                </p>
                <div class="flex items-center gap-6 text-sm">
                    <a href="#" class="text-primary-300 hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="text-primary-300 hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </div>
</footer>
