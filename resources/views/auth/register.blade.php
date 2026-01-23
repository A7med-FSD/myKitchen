<x-auth.layout>
    <div class="w-full max-w-2xl" 
         x-data="registerHandler()"
         @keydown.enter="submitRegister()">
        
        {{-- Register Card --}}
        <div class="bg-white rounded-4xl shadow-2xl overflow-hidden opacity-0"
             x-data="{ shown: false }" 
             x-intersect.threshold.50="shown = true" 
             :class="shown ? 'animate-entrance-card' : 'opacity-0'">
            
            {{-- Header Section --}}
            <div class="bg-gradient-to-br from-yellow-200 to-yellow-50 p-8 text-center border-b border-yellow-200">
                {{-- Logo & Name --}}
                <div class="flex items-center justify-center gap-3 mb-6">
                    <img class="w-12 h-12" 
                         src="{{Vite::asset('resources/images/favicon_io/android-chrome-192x192.png')}}" 
                         alt="myKitchen Logo">
                    <span class="text-3xl font-black text-gray-900">my<span class="text-yellow-500">Kitchen</span></span>
                </div>
                
                {{-- Title --}}
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Create Your Account</h1>
                <p class="text-gray-600 font-medium">Join us today!</p>
            </div>
            
            {{-- Form Section --}}
            <div class="p-8 max-h-[70vh] overflow-y-auto">
                <form @submit.prevent="submitRegister()">
                    
                    {{-- Required Fields Section --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-yellow-500">
                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                            </svg>
                            Required Information
                        </h3>
                        
                        {{-- Name Field --}}
                        <div class="mb-4">
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
                                       placeholder="Enter your full name"
                                       autofocus>
                            </div>
                            <div x-show="errors.name" 
                                 x-transition
                                 class="form-error">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="errors.name"></span>
                            </div>
                        </div>

                        {{-- Phone Field --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="tel" 
                                       x-model="userData.phone"
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                       placeholder="01234567890">
                            </div>
                        </div>

                        {{-- Password Field --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" 
                                       x-model="userData.password"
                                       @input="errors.password = ''"
                                       class="w-full pl-12 pr-12 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                       :class="errors.password ? 'border-red-400' : ''"
                                       placeholder="Create a strong password">
                                
                                <button type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5" style="display: none;">
                                        <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38 1.651 1.651 0 000-1.185A10.004 10.004 0 009.999 3a9.956 9.956 0 00-4.744 1.194L3.28 2.22zM7.752 6.69l1.092 1.092a2.5 2.5 0 013.374 3.373l1.091 1.092a4 4 0 00-5.557-5.557z" clip-rule="evenodd" />
                                        <path d="M10.748 13.93l2.523 2.523a9.987 9.987 0 01-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 010-1.186A10.007 10.007 0 012.839 6.02L6.07 9.252a4 4 0 004.678 4.678z" />
                                    </svg>
                                </button>
                            </div>
                            <div x-show="errors.password" 
                                 x-transition
                                 class="form-error">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="errors.password"></span>
                            </div>
                        </div>

                        {{-- Confirm Password Field --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input :type="showConfirmPassword ? 'text' : 'password'" 
                                       x-model="userData.confirmPassword"
                                       @input="errors.confirmPassword = ''"
                                       class="w-full pl-12 pr-12 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                       :class="errors.confirmPassword ? 'border-red-400' : ''"
                                       placeholder="Re-enter your password">
                                
                                <button type="button"
                                        @click="showConfirmPassword = !showConfirmPassword"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5" style="display: none;">
                                        <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38 1.651 1.651 0 000-1.185A10.004 10.004 0 009.999 3a9.956 9.956 0 00-4.744 1.194L3.28 2.22zM7.752 6.69l1.092 1.092a2.5 2.5 0 013.374 3.373l1.091 1.092a4 4 0 00-5.557-5.557z" clip-rule="evenodd" />
                                        <path d="M10.748 13.93l2.523 2.523a9.987 9.987 0 01-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 010-1.186A10.007 10.007 0 012.839 6.02L6.07 9.252a4 4 0 004.678 4.678z" />
                                    </svg>
                                </button>
                            </div>
                            <div x-show="errors.confirmPassword" 
                                 x-transition
                                 class="form-error">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="errors.confirmPassword"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t-2 border-dashed border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-bold">Optional Information</span>
                        </div>
                    </div>

                    {{-- Helper Message --}}
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-amber-600 shrink-0 mt-0.5">
                            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-amber-800">Speed up your checkout!</p>
                            <p class="text-xs text-amber-700 mt-0.5">
                                Adding these optional details helps us auto-fill your order information, making future orders faster and easier.
                            </p>
                        </div>
                    </div>

                    {{-- Optional Fields --}}
                    <div class="space-y-4">
                        
                        {{-- Email Field --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                        <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                    </svg>
                                </div>
                                <input type="email" 
                                       x-model="userData.email"
                                       @input="errors.email = ''"
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                       :class="errors.email ? 'border-red-400' : ''"
                                       placeholder="your@email.com">
                            </div>
                            <div x-show="errors.email" 
                                 x-transition
                                 class="form-error">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="errors.email"></span>
                            </div>
                        </div>


                        {{-- Address Field --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Delivery Address</label>
                            <div class="relative">
                                <div class="absolute left-4 top-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <textarea x-model="userData.address"
                                          rows="3"
                                          class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium resize-none"
                                          placeholder="Enter your full delivery address"></textarea>
                            </div>
                        </div>

                        {{-- Google Map Link --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Google Maps Link</label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                                        <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="url" 
                                       x-model="userData.mapLink"
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                       placeholder="Paste your Google Maps location link">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Right-click on Google Maps → Share → Copy link</p>
                        </div>

                        {{-- Profile Image Upload --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Profile Picture</label>
                            <div class="relative">
                                {{-- Preview --}}
                                <div x-show="imagePreview" class="mb-3 flex justify-center">
                                    <div class="relative inline-block">
                                        <img :src="imagePreview" alt="Preview" class="w-24 h-24 rounded-full object-cover border-4 border-yellow-100">
                                        
                                        {{-- Remove Button --}}
                                        <button type="button"
                                                @click="removeImage()"
                                                class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                {{-- Upload Button --}}
                                <button type="button"
                                        @click="$refs.imageInput.click()"
                                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl hover:border-yellow-400 hover:bg-yellow-50 transition-all flex items-center justify-center gap-2 text-gray-600 hover:text-yellow-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path d="M1 8.25a1.25 1.25 0 112.5 0v7.5a1.25 1.25 0 11-2.5 0v-7.5zM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0114 3c0 .995-.182 1.948-.514 2.826-.204.54.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 01-1.341 5.974C17.153 16.323 16.072 17 14.9 17h-3.192a3 3 0 01-1.341-.317l-2.734-1.366A3 3 0 006.292 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 012.166-1.73c.432-.143.853-.386 1.011-.814.16-.432.248-.9.248-1.388z" />
                                    </svg>
                                    <span class="font-medium" x-text="imagePreview ? 'Change Picture' : 'Upload Picture'"></span>
                                </button>
                                <input type="file"
                                       x-ref="imageInput"
                                       @change="handleImageUpload($event)"
                                       accept="image/jpeg,image/png,image/webp"
                                       class="hidden">
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG or WebP (MAX. 2MB)</p>
                            </div>
                        </div>
                    </div>

                    {{-- Register Button --}}
                    <button type="submit"
                            :disabled="loading"
                            class="btn-primary w-full h-14 flex items-center justify-center gap-2 mt-8"
                            :class="loading ? 'opacity-75 cursor-not-allowed' : ''">
                        <template x-if="loading">
                            <svg class="animate-spin h-5 w-5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!loading">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-lg">Create Account</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                            </div>
                        </template>
                    </button>

                    {{-- Login Link --}}
                    <div class="text-center mt-4">
                        <p class="text-gray-600 text-sm">
                            Already have an account? 
                            <a href="/login" class="text-yellow-600 font-bold hover:text-yellow-700 transition-colors">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        {{-- Footer Text --}}
        <p class="text-center text-gray-600 text-sm mt-6">
            © 2024 Single Kitchen. All rights reserved.
        </p>
    </div>

    {{-- Include register.js --}}
    <script src="{{ asset('assets/js/auth/register.js') }}"></script>

</x-auth.layout>
