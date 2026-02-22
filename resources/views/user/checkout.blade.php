<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - myKitchen</title>
    
    {{-- Main font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{Vite::asset('resources/images/favicon_io/favicon-32x32.png')}}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="bg-gray-50 min-h-screen">
    
    {{-- Simple Header --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                {{-- Logo --}}
                <a href="/menu" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <img class="w-10 h-10" 
                         src="{{Vite::asset('resources/images/favicon_io/android-chrome-192x192.png')}}" 
                         alt="myKitchen Logo">
                    <span class="text-2xl font-black text-gray-900">my<span class="text-yellow-500">Kitchen</span></span>
                </a>
                
                {{-- Back to Menu --}}
                <a href="/menu" class="flex items-center gap-2 text-gray-600 hover:text-yellow-600 transition-colors font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                    </svg>
                    Back to Menu
                </a>
            </div>
        </div>
    </nav>

    {{-- Progress Indicator --}}
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="flex items-center justify-center gap-3 md:gap-4">
                {{-- Step 1: Cart (completed) --}}
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-green-500 flex items-center justify-center text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="hidden md:block font-bold text-green-600 text-sm">Cart</span>
                </div>
                
                <div class="w-12 md:w-16 h-1 bg-yellow-400 rounded-full"></div>
                
                {{-- Step 2: Checkout (current) --}}
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-yellow-400 flex items-center justify-center animate-pulse shadow-lg">
                        <div class="w-3 h-3 bg-white rounded-full"></div>
                    </div>
                    <span class="font-bold text-yellow-600 text-sm">Checkout</span>
                </div>
                
                <div class="w-12 md:w-16 h-1 bg-gray-200 rounded-full"></div>
                
                {{-- Step 3: Payment (pending) --}}
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                    </div>
                    <span class="hidden md:block font-medium text-gray-400 text-sm">Payment</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-6 py-8" x-data="checkoutHandler()">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Left Column - Form --}}
            <div class="lg:col-span-8 space-y-6">
                
                {{-- Section 1: User Information --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-yellow-500">
                            <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                        </svg>
                        Contact Information
                    </h2>
                    
                    <div class="space-y-4">
                        {{-- Full Name --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                    </svg>
                                </div>
                                <input type="text" 
                                       x-model="userData.name"
                                       @input="errors.name = ''"
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                       :class="errors.name ? 'border-red-400' : ''"
                                       placeholder="Enter your full name">
                            </div>
                            <div x-show="errors.name" x-transition class="form-error">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="errors.name"></span>
                            </div>
                        </div>

                        {{-- Phone Number --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="tel" 
                                       x-model="userData.phone"
                                       @input="errors.phone = ''"
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                       :class="errors.phone ? 'border-red-400' : ''"
                                       placeholder="01234567890">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">We'll call you if needed</p>
                            <div x-show="errors.phone" x-transition class="form-error">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="errors.phone"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Delivery Details --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-yellow-500">
                            <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                        </svg>
                        Delivery Details
                    </h2>
                    
                    <div class="space-y-4">
                        {{-- Address --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Delivery Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute left-4 top-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <textarea x-model="userData.address"
                                          @input="errors.address = ''"
                                          rows="4"
                                          class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium resize-none"
                                          :class="errors.address ? 'border-red-400' : ''"
                                          placeholder="Enter your full delivery address (Building, Floor, Apartment)"></textarea>
                            </div>
                            <div x-show="errors.address" x-transition class="form-error">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="errors.address"></span>
                            </div>
                        </div>

                        {{-- Google Maps Link --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Google Maps Link <span class="text-gray-400 font-normal">(Optional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                                        <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="url" 
                                       x-model="userData.locationLink"
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                       placeholder="Paste your Google Maps location link">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">📍 Right-click on Google Maps → Share → Copy link</p>
                        </div>

                        {{-- Delivery Notes --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Delivery Notes <span class="text-gray-400 font-normal">(Optional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute left-4 top-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd" d="M3 3.5A1.5 1.5 0 014.5 2h6.879a1.5 1.5 0 011.06.44l4.122 4.12A1.5 1.5 0 0117 7.622V16.5a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 013 16.5v-13zm10.857 5.691a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 00-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <textarea x-model="userData.deliveryNotes"
                                          rows="3"
                                          class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium resize-none"
                                          placeholder="Special instructions (e.g., Gate code, landmarks...)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Payment Method --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-yellow-500">
                            <path d="M1 4.25a3.733 3.733 0 012.25-.75h13.5c.844 0 1.623.279 2.25.75A2.25 2.25 0 0016.75 2H3.25A2.25 2.25 0 001 4.25zM1 7.25a3.733 3.733 0 012.25-.75h13.5c.844 0 1.623.279 2.25.75A2.25 2.25 0 0016.75 5H3.25A2.25 2.25 0 001 7.25zM7 8a1 1 0 011 1 2 2 0 104 0 1 1 0 112 0 4 4 0 11-8 0 1 1 0 011-1z" />
                        </svg>
                        Payment Method
                    </h2>
                    
                    <div class="space-y-3">
                        {{-- Visa/Mastercard --}}
                        <div class="cursor-pointer p-4 border-2 rounded-xl transition-all"
                             :class="userData.paymentMethod === 'visa' 
                               ? 'border-blue-500 bg-blue-50' 
                               : 'border-gray-200 hover:border-blue-300'"
                             @click="userData.paymentMethod = 'visa'; errors.payment = ''">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-10  flex items-center justify-center">
                                    <img src="https://static.vecteezy.com/system/resources/previews/020/335/998/non_2x/visa-logo-visa-icon-free-free-vector.jpg" class="h-full w-auto object-contain" alt="Visa">
                                </div>
                                <div class="w-14 h-10  flex items-center justify-center -ml-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-full w-auto object-contain" alt="Mastercard">
                                </div>
                                <div class="flex-1 ml-2">
                                    <p class="font-bold text-gray-900">Credit / Debit Card</p>
                                    <p class="text-xs text-gray-500">Pay securely with your card</p>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                     :class="userData.paymentMethod === 'visa' ? 'border-blue-500' : 'border-gray-300'">
                                    <div class="w-3 h-3 rounded-full"
                                         :class="userData.paymentMethod === 'visa' ? 'bg-blue-500' : ''"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Vodafone Cash --}}
                        <div class="cursor-pointer p-4 border-2 rounded-xl transition-all"
                             :class="userData.paymentMethod === 'vodafone' 
                               ? 'border-red-500 bg-red-50' 
                               : 'border-gray-200 hover:border-red-300'"
                             @click="userData.paymentMethod = 'vodafone'; errors.payment = ''">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-10  flex items-center justify-center">
                                    <img src="https://norvanreports.com/wp-content/uploads/2022/03/Vodafone-Cash-Logo.jpg" class="h-8 w-auto object-contain" alt="Vodafone">
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900">Vodafone Cash</p>
                                    <p class="text-xs text-gray-500">Pay via Vodafone wallet</p>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                     :class="userData.paymentMethod === 'vodafone' ? 'border-red-500' : 'border-gray-300'">
                                    <div class="w-3 h-3 rounded-full"
                                         :class="userData.paymentMethod === 'vodafone' ? 'bg-red-500' : ''"></div>
                                </div>
                            </div>
                        </div>

                        {{-- InstaPay --}}
                        <div class="cursor-pointer p-4 border-2 rounded-xl transition-all"
                             :class="userData.paymentMethod === 'instapay' 
                               ? 'border-purple-500 bg-purple-50' 
                               : 'border-gray-200 hover:border-purple-300'"
                             @click="userData.paymentMethod = 'instapay'; errors.payment = ''">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-10  flex items-center justify-center">
                                    <img src="https://is1-ssl.mzstatic.com/image/thumb/Purple126/v4/2d/49/d9/2d49d99e-e2f1-4272-2f11-180f9176c9f2/AppIcon-0-1x_U007emarketing-0-10-0-sRGB-0-85-220-0.png/246x0w.webp" 
                                         class="h-full w-auto object-contain" 
                                         alt="InstaPay"
                                         onerror="this.src='https://placehold.co/60x40/4c1d95/white?text=InstaPay'">
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900">InstaPay</p>
                                    <p class="text-xs text-gray-500">Instant bank transfer</p>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                     :class="userData.paymentMethod === 'instapay' ? 'border-purple-500' : 'border-gray-300'">
                                    <div class="w-3 h-3 rounded-full"
                                         :class="userData.paymentMethod === 'instapay' ? 'bg-purple-500' : ''"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Fawry Pay --}}
                        <div class="cursor-pointer p-4 border-2 rounded-xl transition-all"
                             :class="userData.paymentMethod === 'fawry' 
                               ? 'border-yellow-400 bg-yellow-50' 
                               : 'border-gray-200 hover:border-yellow-300'"
                             @click="userData.paymentMethod = 'fawry'; errors.payment = ''">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-10  flex items-center justify-center">
                                    <img src="https://www.hallaagency.com/Admin/Uploads/EN/202012311530007964.jpg" 
                                         class="h-full w-auto object-contain" 
                                         alt="Fawry"
                                         onerror="this.src='https://placehold.co/60x40/0284c7/white?text=Fawry'">
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900">Fawry Pay</p>
                                    <p class="text-xs text-gray-500">Pay at any Fawry store</p>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                     :class="userData.paymentMethod === 'fawry' ? 'border-yellow-400' : 'border-gray-300'">
                                    <div class="w-3 h-3 rounded-full"
                                         :class="userData.paymentMethod === 'fawry' ? 'bg-yellow-400' : ''"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="errors.payment" x-transition class="form-error mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <span x-text="errors.payment"></span>
                    </div>
                </div>
            </div>

            {{-- Right Column - Order Summary --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-yellow-500">
                            <path d="M1 1.75A.75.75 0 011.75 1h1.628a1.75 1.75 0 011.734 1.51L5.18 3a65.25 65.25 0 0113.36 1.412.75.75 0 01.58.875 48.645 48.645 0 01-1.618 6.2.75.75 0 01-.712.513H6a2.503 2.503 0 00-2.292 1.5H17.25a.75.75 0 010 1.5H2.76a.75.75 0 01-.748-.807 4.002 4.002 0 012.716-3.486L3.626 2.716a.25.25 0 00-.248-.216H1.75A.75.75 0 011 1.75zM6 17.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15.5 19a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        Order Summary
                    </h3>
                    
                    {{-- Items List (Mock Data) --}}
                    <div class="space-y-3 mb-4 border-b border-gray-200 pb-4">
                        {{-- Mock Item 1 --}}
                        <div class="flex gap-3">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-2xl">🍔</div>
                            <div class="flex-1">
                                <p class="font-bold text-sm">Classic Burger</p>
                                <p class="text-xs text-gray-500">2 × $12.99</p>
                            </div>
                            <p class="font-bold text-yellow-600">$25.98</p>
                        </div>
                        
                        {{-- Mock Item 2 --}}
                        <div class="flex gap-3">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-2xl">🍕</div>
                            <div class="flex-1">
                                <p class="font-bold text-sm">Margherita Pizza</p>
                                <p class="text-xs text-gray-500">1 × $15.99</p>
                            </div>
                            <p class="font-bold text-yellow-600">$15.99</p>
                        </div>
                    </div>

                    {{-- Promo Code --}}
                    <div class="mb-4 pt-4 border-t border-gray-100">
                        <button type="button" 
                                @click="showPromo = !showPromo"
                                class="text-yellow-600 cursor-pointer font-bold text-sm flex items-center gap-2 hover:text-yellow-700 transition-colors w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                            </svg>
                            Add Promo Code
                            <svg class="w-4 h-4 ml-auto transition-transform duration-200" 
                                 :class="showPromo ? 'rotate-180' : ''"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="showPromo" 
                             x-transition.origin.top
                             class="mt-3 flex gap-2">
                            <input type="text" 
                                   x-model="promoCode" 
                                   placeholder="Enter code"
                                   class="flex-1 px-3 py-2 border-2 border-gray-200 rounded-lg text-sm focus:border-yellow-400 focus:outline-none uppercase">
                            <button type="button" 
                                    @click="applyPromo()"
                                    class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-bold hover:bg-gray-800 transition-colors">
                                Apply
                            </button>
                        </div>
                        
                        {{-- Promo Success Message --}}
                        <div x-show="promoApplied" x-transition class="mt-2 text-xs font-bold text-green-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            Code applied successfully!
                        </div>
                        
                        {{-- Promo Error Message --}}
                        <div x-show="promoError" x-transition class="mt-2 text-xs font-bold text-red-500 flex items-center gap-1">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                            <span x-text="promoError"></span>
                        </div>
                    </div>

                    {{-- Price Breakdown --}}
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">$<span x-text="subtotal.toFixed(2)">41.97</span></span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Delivery Fee</span>
                            <span class="font-medium">$<span x-text="deliveryFee.toFixed(2)">5.00</span></span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax (14%)</span>
                            <span class="font-medium">$<span x-text="tax.toFixed(2)">5.88</span></span>
                        </div>
                        
                        <div x-show="promoApplied" class="flex justify-between text-sm text-green-600">
                            <span class="font-medium">Discount</span>
                            <span class="font-bold">-$<span x-text="discountAmount.toFixed(2)">0.00</span></span>
                        </div>
                        
                        <div class="border-t-2 border-gray-300 pt-2 flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-2xl font-black text-yellow-600">
                                $<span x-text="grandTotal.toFixed(2)">52.85</span>
                            </span>
                        </div>
                    </div>

                    {{-- Place Order Button --}}
                    <button @click="placeOrder()"
                            :disabled="!isFormValid || loading"
                            class="btn-primary w-full h-14 mt-4 transition-all"
                            :class="{
                                'opacity-50 cursor-not-allowed pointer-events-none': loading,
                                'opacity-60 cursor-not-allowed pointer-events-none': !isFormValid && !loading
                            }">
                        <template x-if="loading">
                            <svg class="animate-spin h-5 w-5 text-gray-900 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!loading">
                            <div class="flex items-center justify-center gap-2">
                                <span class="font-bold text-lg">Place Order</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </template>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Include checkout.js --}}
    <script src="{{ asset('assets/js/user/checkout.js') }}"></script>

</body>
</html>
