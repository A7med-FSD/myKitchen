<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>myKitchen - User Panel</title>
  
  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  
  {{-- Favicon --}}
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="{{Vite::asset('resources/images/favicon_io/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{Vite::asset('resources/images/favicon_io/favicon-16x16.png')}}">
  <link rel="manifest" href="/site.webmanifest">
  
  {{-- Entrance CSS --}}
  <link rel="stylesheet" href="{{ asset('assets/css/entrance.css') }}">
  
  {{-- Alpine Plugins --}}
  <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
  {{-- Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  {{-- Cart Script --}}
  <script src="{{ asset('assets/js/user/cart.js') }}"></script>

</head>
<body class="pb-20 bg-gray-100 font-family-inter" x-data="{ mobileMenuOpen: false, scrolled: false }" 
     @scroll.window="scrolled = window.scrollY > 20">

  {{-- Navbar --}}
  <nav :class="scrolled ? 'bg-white/95 backdrop-blur-lg shadow-lg' : 'bg-white/90 backdrop-blur-sm shadow-sm'"
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
        <div class="hidden lg:flex items-center gap-2">
          <x-user.nav-link href="/menu" :active="request()->is('menu')">
            Menu
          </x-user.nav-link>

          <x-user.nav-link href="/orders" :active="request()->is('orders')">
            Orders
          </x-user.nav-link>

          <x-user.nav-link href="/offers" :active="request()->is('offers')">
            Offers
          </x-user.nav-link>

          <x-user.nav-link href="/profile" :active="request()->is('profile')">            
            Profile
          </x-user.nav-link>

          <x-user.nav-link href="/support" :active="request()->is('support')">
            Support
          </x-user.nav-link>
        </div>
        
        {{-- Right Section: Profile --}}
        <button @click="$dispatch('open-profile-modal')" 
                class="hidden lg:flex items-center gap-3 hover:bg-gray-50 rounded-2xl p-2 -m-2 transition-colors group cursor-pointer">
          <img class="rounded-3xl h-11 w-11 group-hover:scale-105 transition-transform" 
               src="{{Vite::asset('resources/images/3d-portrait-people.jpg')}}" 
               alt="User Profile">
          <div class="grid">
            <p class="font-semibold group-hover:text-yellow-600 transition-colors">Ahmed</p>
            <p class="text-gray-400 text-xs truncate w-28">ahmednsfdj@gmail.com</p>
          </div>
        </button>
        
        {{-- Mobile Menu Button --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen" 
                class="lg:hidden p-2 text-gray-700 hover:text-gray-900 transition-colors cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>
    </div>
  </nav>

  {{-- Mobile Menu Overlay --}}
  <div x-show="mobileMenuOpen" 
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      @click="mobileMenuOpen = false"
      class="lg:hidden fixed inset-0 bg-black/40 z-40"
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
      class="lg:hidden fixed top-0 right-0 w-80 h-full bg-white shadow-2xl z-50 overflow-y-auto"
      style="display: none;">
    
    {{-- Mobile Header (Profile Section) --}}
    <div class="flex items-center justify-between p-6 border-b border-gray-100">
      <button @click="mobileMenuOpen = false; $dispatch('open-profile-modal')" class="flex items-center gap-3 group cursor-pointer">
        <img class="rounded-3xl h-11 w-11 shadow-sm group-hover:scale-105 transition-transform" src="{{Vite::asset('resources/images/3d-portrait-people.jpg')}}" alt="">
        <div>
          <p class="font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">Ahmed</p>
          <p class="text-xs text-gray-500 truncate w-32">ahmednsfdj@gmail.com</p>
        </div>
      </button>
      <button @click="mobileMenuOpen = false" class="p-2 text-gray-400 hover:text-gray-900 transition-colors cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    {{-- Mobile Navigation Links --}}
    <div class="py-6">
      <x-user.mobile-nav-link href="/menu" :active="request()->is('menu')">
        Menu
      </x-user.mobile-nav-link>

      <x-user.mobile-nav-link href="/orders" :active="request()->is('orders')">
        Orders
      </x-user.mobile-nav-link>

      <x-user.mobile-nav-link href="/offers" :active="request()->is('offers')">
        Offers
      </x-user.mobile-nav-link>

      <x-user.mobile-nav-link href="/profile" :active="request()->is('profile')">
        Profile
      </x-user.mobile-nav-link>

      <x-user.mobile-nav-link href="/support" :active="request()->is('support')">
        Support
      </x-user.mobile-nav-link>
    </div>

    {{-- Mobile CTA --}}
    <div class="p-6 mt-auto">
      <a href="/checkout" 
         class="btn-primary flex items-center gap-2">
        <span>Place Order</span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
          <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z" clip-rule="evenodd" />
        </svg>
      </a>
    </div>
  </div>

  {{-- Main Content (with padding for fixed navbar) --}}
  <main class="pt-24 px-5 sm:px-10">
    {{$slot}}
  </main>

  {{-- Cart Modal --}}
  <x-user.cart-modal />
  
  {{-- Profile Modal --}}
  <x-user.profile-modal />

  <!-- Floating Action Buttons -->
  <div class="fixed bottom-6 right-6 z-50 flex flex-col gap-4">
    <div class="flex gap-3">
      {{-- Cart Button --}}
      <button 
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

    </div>
  </div>

  {{-- Rating Modal --}}
  <x-user.rating-modal />

  {{-- Test Button for Rating Modal --}}
  <button @click="$store.ratingModal.open({
      orderId: 'ORD-TEST-123',
      items: [
          {id: 1, name: 'Pizza Margherita', image: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400'},
          {id: 2, name: 'Chicken Burger', image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400'},
          {id: 3, name: 'Caesar Salad', image: 'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=400'}
      ]
  })"
  class="fixed bottom-24 right-6 bg-purple-500 hover:bg-purple-600 text-white px-4 py-3 rounded-full font-bold shadow-lg transition-all z-40 flex items-center gap-2">
      <span class="text-xl">🎯</span>
      <span class="hidden sm:inline">Test Rating</span>
  </button>

</body>
</html>
