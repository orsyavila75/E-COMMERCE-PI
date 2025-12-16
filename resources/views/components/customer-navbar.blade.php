<nav class="bg-white border-b border-gray-200 shadow-sm rounded-lg m-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Left Section -->
            <div class="flex items-center space-x-8">
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ url('/') }}"
                       class="text-gray-800 font-semibold hover:text-[#7A3E10]">
                        Beranda
                    </a>

                    <a href="{{ url('/products') }}"
                       class="text-gray-800 font-semibold hover:text-[#7A3E10]">
                        Produk
                    </a>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-5">

                <!-- Cart Icon -->
                <button class="text-gray-700 hover:text-[#7A3E10]">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 5h2l1.2 9h11.6L20 8H7.4M9 20a1 1 0 11-2 0 1 1 0 012 0zm9 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                </button>

                <!-- Chat Icon -->
                <button class="text-gray-700 hover:text-[#7A3E10]">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 5h14a2 2 0 012 2v7a2 2 0 01-2 2h-6l-4 3v-3H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                    </svg>
                </button>

                <!-- Search -->
                <form action="{{ route('products.page') }}" method="GET" class="relative flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-black absolute left-3"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>

                    <input
                        type="text"
                        name="q"
                        placeholder="Search produk..."
                        class="pl-10 pr-4 py-2 text-sm font-medium bg-white
                               text-black placeholder:text-black placeholder-black
                               border-2 border-black rounded-lg"
                        style="--tw-placeholder-opacity:1;"
                    />
                </form>

                <!-- Profile -->
                <div class="w-9 h-9 rounded-full border border-gray-300 bg-gray-100
                            flex items-center justify-center overflow-hidden cursor-pointer">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-gray-500"
                        viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12a3 3 0 100-6 3 3 0 000 6z" />
                        <path fill-rule="evenodd"
                              d="M4.5 18.75A4.75 4.75 0 019.25 14h5.5a4.75 4.75 0 014.75 4.75V19.5a.75.75 0 01-.75.75h-13a.75.75 0 01-.75-.75v-.75z"
                              clip-rule="evenodd" />
                    </svg>

                </div>

            </div>

        </div>
    </div>
</nav>
