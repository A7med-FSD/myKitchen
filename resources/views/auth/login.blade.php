<x-auth.layout>
    <div class="w-full max-w-md" 
         x-data="loginHandler()"
         @keydown.enter="submitLogin()">
        
        {{-- Login Card --}}
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
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back!</h1>
                <p class="text-gray-600 font-medium">Sign in to your account</p>
            </div>
            
            {{-- Form Section --}}
            <div class="p-8">
                <form @submit.prevent="submitLogin()">
                    
                    {{-- Email/Phone Field --}}
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email or Phone</label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                    <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                </svg>
                            </div>
                            <input type="text" 
                                   x-model="credentials.identifier"
                                   x-ref="identifierInput"
                                   class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                   :class="errors.identifier ? 'border-red-400' : ''"
                                   placeholder="your@email.com or 01234567890"
                                   autofocus>
                        </div>
                        <div x-show="errors.identifier" 
                             x-transition
                             class="form-error">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                            </svg>
                            <span x-text="errors.identifier"></span>
                        </div>
                    </div>

                    {{-- Password Field --}}
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                                    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" 
                                   x-model="credentials.password"
                                   class="w-full pl-12 pr-12 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                   :class="errors.password ? 'border-red-400' : ''"
                                   placeholder="Enter your password">
                            
                            {{-- Show/Hide Password Toggle --}}
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

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   x-model="credentials.remember"
                                   class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-400 focus:ring-2 cursor-pointer">
                            <span class="ml-2 text-sm font-medium text-gray-700">Remember me</span>
                        </label>
                        
                        <a href="#" class="text-sm font-bold text-yellow-600 hover:text-yellow-700 transition-colors">
                            Forgot Password?
                        </a>
                    </div>

                    {{-- Login Button --}}
                    <button type="submit"
                            :disabled="loading"
                            class="btn-primary w-full h-14 flex items-center justify-center gap-2 mb-4"
                            :class="loading ? 'opacity-75 cursor-not-allowed' : ''">
                        <template x-if="loading">
                            <svg class="animate-spin h-5 w-5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!loading">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-lg">Login</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </template>
                    </button>

                    {{-- Sign Up Link --}}
                    <div class="text-center">
                        <p class="text-gray-600 text-sm">
                            Don't have an account? 
                            <a href="#" class="text-yellow-600 font-bold hover:text-yellow-700 transition-colors">Sign Up</a>
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

    {{-- Include login.js --}}
    <script src="{{ asset('assets/js/auth/login.js') }}"></script>

</x-auth.layout>
