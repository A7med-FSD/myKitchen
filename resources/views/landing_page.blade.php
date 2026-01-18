<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>myKitchen - Fresh Home-Cooked Meals</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{Vite::asset('resources/images/favicon_io/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{Vite::asset('resources/images/favicon_io/favicon-16x16.png')}}">
    <link rel="manifest" href="/site.webmanifest">

    {{-- Custom Entrance CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/entrance.css') }}">
    
    {{-- Touch Hover Effect CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/touch-hover-effect.css') }}">

    {{-- Alpine Plugins --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- Home Page Script --}}
    <script src="{{ asset('assets/js/landing.js') }}"></script>

    {{-- Cart Script --}}
    <script src="{{ asset('assets/js/cart.js') }}"></script>
</head>
<body class="bg-gray-50 font-family-inter">

<nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
    @scroll.window="scrolled = window.scrollY > 20"
    :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md' : 'bg-white/90 backdrop-blur-sm shadow-sm'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 group">
                <img class="w-10 h-10 transition-transform group-hover:scale-110" 
                    src="{{Vite::asset('resources/images/favicon_io/android-chrome-192x192.png')}}" 
                    alt="myKitchen Logo">
                <span class="text-xl font-bold text-gray-900">my<span class="text-yellow-500">Kitchen</span></span>
            </a>
            
            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="#menu" class="text-gray-700 hover:text-yellow-600 font-medium transition-colors">Menu</a>
                <a href="#how-it-works" class="text-gray-700 hover:text-yellow-600 font-medium transition-colors">How it Works</a>
                <a href="#about" class="text-gray-700 hover:text-yellow-600 font-medium transition-colors">About</a>
                <a href="#contact" class="text-gray-700 hover:text-yellow-600 font-medium transition-colors">Contact</a>
            </div>
            

            {{-- CTA Button (Desktop) --}}
            <div class="hidden md:block">
                <a href="#menu" 
                    class="btn-primary gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path d="M1 1.75A.75.75 0 0 1 1.75 1h1.628a1.75 1.75 0 0 1 1.734 1.51L5.18 3a65.25 65.25 0 0 1 13.36 1.412.75.75 0 0 1 .58.875 48.645 48.645 0 0 1-1.618 6.2.75.75 0 0 1-.712.513H6a2.503 2.503 0 0 0-2.292 1.5H17.25a.75.75 0 0 1 0 1.5H2.76a.75.75 0 0 1-.748-.807 4.002 4.002 0 0 1 2.716-3.486L3.626 2.716a.25.25 0 0 0-.248-.216H1.75A.75.75 0 0 1 1 1.75ZM6 17.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM15.5 19a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                    </svg>
                    Order Now
                </a>
            </div>
            
            {{-- Mobile Menu Button --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="md:hidden p-2 text-gray-700 hover:text-gray-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu Overlay --}}
    <div x-show="mobileMenuOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="mobileMenuOpen = false"
        class="md:hidden fixed inset-0 z-40"
        style="display: none;">
    </div>
    
    {{-- Mobile Menu Panel --}}
    <div x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="md:hidden fixed top-0 right-0 w-80 bg-white shadow-2xl z-50 overflow-y-auto"
        style="display: none;">
        
        {{-- Mobile Menu Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <span class="text-xl font-bold text-gray-900">Menu</span>
            <button @click="mobileMenuOpen = false" class="p-2 text-gray-500 hover:text-gray-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        {{-- Mobile Menu Links --}}
        <div class="py-6 space-y-1">
            <a href="#menu" @click="mobileMenuOpen = false" 
            class="block px-6 py-3 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 font-medium transition-colors">
                Menu
            </a>
            <a href="#how-it-works" @click="mobileMenuOpen = false"
            class="block px-6 py-3 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 font-medium transition-colors">
                How it Works
            </a>
            <a href="#about" @click="mobileMenuOpen = false"
            class="block px-6 py-3 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 font-medium transition-colors">
                About
            </a>
            <a href="#contact" @click="mobileMenuOpen = false"
            class="block px-6 py-3 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 font-medium transition-colors">
                Contact
            </a>
        </div>
        
        {{-- Mobile CTA --}}
        <div class="p-6">
            <a href="#menu" @click="mobileMenuOpen = false"
            class="btn-primary w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path d="M1 1.75A.75.75 0 0 1 1.75 1h1.628a1.75 1.75 0 0 1 1.734 1.51L5.18 3a65.25 65.25 0 0 1 13.36 1.412.75.75 0 0 1 .58.875 48.645 48.645 0 0 1-1.618 6.2.75.75 0 0 1-.712.513H6a2.503 2.503 0 0 0-2.292 1.5H17.25a.75.75 0 0 1 0 1.5H2.76a.75.75 0 0 1-.748-.807 4.002 4.002 0 0 1 2.716-3.486L3.626 2.716a.25.25 0 0 0-.248-.216H1.75A.75.75 0 0 1 1 1.75ZM6 17.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM15.5 19a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                </svg>
                Order Now
            </a>
        </div>
    </div>
</nav>

<main x-data="homeHandler()" class="mt-10">
    
    {{-- Hero Section --}}
    <section class="min-h-screen flex items-center bg-gradient-to-br from-yellow-50 via-orange-50 to-yellow-50 relative overflow-hidden">
        {{-- Decorative Shapes --}}
        <div class="absolute top-20 right-10 w-72 h-72 bg-yellow-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-orange-200/20 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-center relative z-10">
            {{-- Hero Content --}}
            <div class="animate-entrance-col1">
                <div class="inline-block mb-4">
                    <span class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                        🎉 Fresh & Homemade Daily
                    </span>
                </div>
                
                <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 leading-tight">
                    Fresh Home-Cooked <span class="text-yellow-500 underline decoration-wavy decoration-4 underline-offset-8">Meals</span>, Delivered
                </h1>
                
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Experience the warmth of home-cooked food, prepared with love and delivered fresh to your doorstep. Healthy, delicious, and made just for you.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#menu" class="btn-primary px-8 py-4 text-base shadow-xl hover:shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                        <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                    </svg>
                    Browse Menu
                    </a>
                    <a href="#how-it-works" class="px-8 py-4 border-2 border-yellow-400 text-yellow-700 hover:bg-yellow-50 rounded-full font-bold transition-colors text-center">
                        Learn More
                    </a>
                </div>
                
                {{-- Trust Badges --}}
                <div class="flex flex-wrap gap-8 mt-12">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-2xl">👨‍🍳</span>
                        </div>
                        <div>
                            <div class="font-black text-gray-900">5+ Years</div>
                            <div class="text-xs text-gray-500">Experience</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-2xl">⭐</span>
                        </div>
                        <div>
                            <div class="font-black text-gray-900">4.9/5.0</div>
                            <div class="text-xs text-gray-500">Rating</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-2xl">🚀</span>
                        </div>
                        <div>
                            <div class="font-black text-gray-900">500+</div>
                            <div class="text-xs text-gray-500">Happy Customers</div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Hero Image --}}
            <div class="relative animate-entrance-col3">
                <div class="relative z-10">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800&h=800&fit=crop" 
                        alt="Delicious Food" 
                        class="rounded-[3rem] shadow-2xl object-cover w-full h-[600px]">
                </div>
                {{-- Floating Card --}}
                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-6 shadow-2xl z-20 hidden md:block">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-green-600">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Fresh Ingredients</div>
                            <div class="text-sm text-gray-500">100% Organic</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Menu Section --}}
    <section id="menu" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Our Most Popular Dishes</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Handpicked favorites loved by our customers. Fresh, delicious, and made with care.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="(dish, index) in featuredDishes.slice(0, visibleCount)" :key="dish.id">
                    <div x-data="{ shown: false }" x-intersect.threshold.20="shown = true"
                        :class="shown ? 'animate-entrance-card' : 'opacity-0'" 
                        :style="'animation-delay: ' + ((index % 3) * 100) + 'ms'">
                        <x-user.menu.dish-card />
                    </div>
                </template>
            </div>
            
            <div class="text-center mt-12 opacity-0" 
                x-data="{ shown: false }" x-intersect.threshold.50="shown = true" 
                :class="shown ? 'button-animation' : 'opacity-0'">
                <button @click="loadMore()" class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-full transition-colors shadow-lg cursor-pointer">
                    <span x-text="buttonText"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- How It Works Section --}}
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Order in 3 Simple Steps</h2>
                <p class="text-gray-600">Fresh meals delivered to your door in no time</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                {{-- Step 1 --}}
                <div class="text-center group opacity-0" 
                     x-data="{ shown: false }" 
                     x-intersect.threshold.50="shown = true"
                     :class="shown ? 'animate-entrance-col1' : ''">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto group-hover:bg-yellow-400 transition-colors duration-300 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-yellow-600 group-hover:text-gray-900 transition-colors">
                                <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center font-black text-gray-900 shadow-lg">
                            1
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Browse Menu</h3>
                    <p class="text-gray-600">Explore our delicious selection of fresh, home-cooked meals</p>
                </div>
                
                {{-- Step 2 --}}
                <div class="text-center group opacity-0" 
                     x-data="{ shown: false }" 
                     x-intersect.threshold.50="shown = true"
                     :class="shown ? 'animate-entrance-col2' : ''">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto group-hover:bg-orange-400 transition-colors duration-300 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-orange-600 group-hover:text-white transition-colors">
                                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-orange-400 rounded-full flex items-center justify-center font-black text-white shadow-lg">
                            2
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Place Order</h3>
                    <p class="text-gray-600">Add your favorites to cart and checkout in seconds</p>
                </div>
                
                {{-- Step 3 --}}
                <div class="text-center group opacity-0" 
                     x-data="{ shown: false }" 
                     x-intersect.threshold.50="shown = true"
                     :class="shown ? 'animate-entrance-col3' : ''">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto group-hover:bg-green-400 transition-colors duration-300 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-green-600 group-hover:text-white transition-colors">
                                <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15Z" />
                                <path d="M8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75Z" />
                                <path d="M19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-green-400 rounded-full flex items-center justify-center font-black text-white shadow-lg">
                            3
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Enjoy!</h3>
                    <p class="text-gray-600">Receive fresh, hot meals delivered right to your door</p>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="py-20 bg-yellow-50/30">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                {{-- Image --}}
                <div class="relative opacity-0" 
                     x-data="{ shown: false }" 
                     x-intersect.threshold.40="shown = true"
                     :class="shown ? 'animate-entrance-col1' : ''">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=800&h=600&fit=crop" 
                        alt="Chef in Kitchen" 
                        class="rounded-3xl shadow-2xl object-cover w-full h-[500px]">
                    <div class="absolute -bottom-6 -right-6 bg-yellow-400 rounded-2xl p-6 shadow-2xl hidden md:block">
                        <div class="text-center">
                            <div class="text-4xl font-black text-gray-900">10k+</div>
                            <div class="text-sm font-bold text-gray-700">Meals Served</div>
                        </div>
                    </div>
                </div>
                
                {{-- Content --}}
                <div class="opacity-0" 
                     x-data="{ shown: false }" 
                     x-intersect.threshold.40="shown = true"
                     :class="shown ? 'animate-entrance-col3' : ''">
                    <div class="inline-block mb-4">
                        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold">
                            Our Story
                        </span>
                    </div>
                    <h2 class="text-4xl font-black text-gray-900 mb-6">Made with Love, Delivered with Care</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        At myKitchen, we believe that everyone deserves access to fresh, home-cooked meals. Our journey started 5 years ago with a simple mission: to bring the warmth and comfort of homemade food to busy families and individuals.
                    </p>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Every dish is prepared by our experienced chefs using only the freshest, locally-sourced ingredients. We take pride in creating meals that not only taste amazing but also nourish your body and soul.
                    </p>
                    
                    <div class="flex flex-wrap gap-6 mb-8">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-green-500">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium text-gray-700">100% Fresh Ingredients</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-green-500">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium text-gray-700">No Preservatives</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-green-500">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium text-gray-700">Made Daily</span>
                        </div>
                    </div>
                    
                    <a href="#contact" class="inline-flex items-center gap-2 text-yellow-700 font-bold hover:text-yellow-600 transition-colors">
                        Learn More About Us
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    
</main>

{{-- Footer --}}
<footer id="contact" class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img class="w-10 h-10" 
                        src="{{Vite::asset('resources/images/favicon_io/android-chrome-192x192.png')}}" 
                        alt="myKitchen">
                    <span class="text-xl font-bold">my<span class="text-yellow-400">Kitchen</span></span>
                </div>
                <p class="text-gray-400 text-sm">
                    Fresh home-cooked meals, delivered with love.
                </p>
            </div>
            
            {{-- Quick Links --}}
            <div>
                <h3 class="font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#menu" class="hover:text-yellow-400 transition-colors">Menu</a></li>
                    <li><a href="#how-it-works" class="hover:text-yellow-400 transition-colors">How it Works</a></li>
                    <li><a href="#about" class="hover:text-yellow-400 transition-colors">About Us</a></li>
                </ul>
            </div>
            
            {{-- Contact --}}
            <div>
                <h3 class="font-bold mb-4">Contact Us</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>📞 +20 123 456 789</li>
                    <li>📧 info@mykitchen.com</li>
                    <li>📍 Cairo, Egypt</li>
                </ul>
            </div>
            
            {{-- Social --}}
            <div>
                <h3 class="font-bold mb-4">Follow Us</h3>
                <div class="flex gap-4">
                    {{-- Facebook --}}
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 text-white rounded-full flex items-center justify-center transition-all duration-300 hover:-translate-y-1 shadow-md hover:shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    
                    {{-- Instagram --}}
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-pink-600 text-white rounded-full flex items-center justify-center transition-all duration-300 hover:-translate-y-1 shadow-md hover:shadow-pink-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    
                    {{-- WhatsApp --}}
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-green-500 text-white rounded-full flex items-center justify-center transition-all duration-300 hover:-translate-y-1 shadow-md hover:shadow-green-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-400">
            <p>&copy; 2026 myKitchen. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Floating Action Buttons -->
<div x-data="{ showButtons: false }"
    x-on:scroll.window="showButtons = (window.pageYOffset > 300)"
    class="fixed bottom-6 right-6 z-50 flex flex-col gap-4">

    <div class="flex gap-3">
        {{-- Cart Button --}}
        <button x-show="showButtons"
                @click="$store.cart.toggleModal()"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="bg-white/90 backdrop-blur-sm border border-gray-200 text-gray-700 hover:text-yellow-600 hover:border-yellow-400 rounded-full p-3 shadow-lg cursor-pointer transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 relative group">
            
            {{-- Cart Icon (Supermarket Trolley Outline) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>

            {{-- Badge Count --}}
            <span x-data="{ animating: false }"
                x-effect="$store.cart.count; animating = true; setTimeout(() => animating = false, 300)"
                :class="animating ? 'scale-125 bg-yellow-400 text-gray-900 border-yellow-500' : 'scale-100 bg-gray-100 text-gray-900 border-gray-200'"
                class="absolute -top-1 -right-1 text-[10px] font-bold px-1.5 py-0.5 rounded-full border shadow-sm transition-all duration-300 transform"
                x-text="$store.cart.count">
            </span>
        </button>

        {{-- Back to Top --}}
        <button x-show="showButtons"
                x-on:click="window.scrollTo({top: 0, behavior: 'smooth'})"
                x-transition:enter="transition ease-out duration-300 delay-100"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-full p-3 shadow-lg cursor-pointer transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06l-6.22-6.22V21a.75.75 0 0 1-1.5 0V4.81l-6.22 6.22a.75.75 0 1 1-1.06-1.06l7.5-7.5Z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>

{{-- Cart Modal --}}
<x-user.cart-modal />

</body>
</html>
