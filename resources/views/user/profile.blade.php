<x-user.layout>
    <div class="min-h-screen py-8" x-data="profileHandler()">
        
        {{-- Page Header --}}
        <div class="mb-12 text-center opacity-0"
            x-data="{ shown: false }" 
            x-intersect.threshold.50="shown = true" 
            :class="shown ? 'header-animation' : 'opacity-0'">
            <div class="inline-flex items-center justify-center gap-3 mb-2">
                <div class="p-2 bg-yellow-400 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight">My Profile</h2>
            </div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Manage your personal information and preferences</p>
        </div>

        {{-- Profile Card --}}
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white rounded-4xl shadow-xl overflow-hidden">
                
                {{-- Header Section with Gradient --}}
                <div class="bg-gradient-to-br from-yellow-400 via-orange-400 to-pink-400 p-8 text-center relative">
                    {{-- Profile Photo --}}
                    <div class="relative inline-block mb-4 group" @click="changeProfilePhoto()">
                        <img :src="profileImagePreview || '{{Vite::asset('resources/images/3d-portrait-people.jpg')}}'" 
                            alt="Profile" 
                            class="w-32 h-32 rounded-full border-4 border-white shadow-2xl object-cover mx-auto">
                        
                        {{-- Change Photo Overlay (on hover) --}}
                        <div class="absolute inset-0 bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
                                <path d="M12 9a3.75 3.75 0 100 7.5A3.75 3.75 0 0012 9z" />
                                <path fill-rule="evenodd" d="M9.344 3.071a49.52 49.52 0 015.312 0c.967.052 1.83.585 2.332 1.39l.821 1.317c.24.383.645.643 1.11.71.386.054.77.113 1.152.177 1.432.239 2.429 1.493 2.429 2.909V18a3 3 0 01-3 3h-15a3 3 0 01-3-3V9.574c0-1.416.997-2.67 2.429-2.909.382-.064.766-.123 1.151-.178a1.56 1.56 0 001.11-.71l.822-1.315a2.942 2.942 0 012.332-1.39zM6.75 12.75a5.25 5.25 0 1110.5 0 5.25 5.25 0 01-10.5 0zm12-1.5a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    {{-- Name --}}
                    <h2 class="text-3xl font-black text-white mb-3" x-text="formData.name"></h2>
                    
                    {{-- VIP Badge --}}
                    <div class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-white rounded-full shadow-lg max-w-fit mx-auto">
                        <span class="text-yellow-700 font-bold text-sm tracking-wide">VIP MEMBER</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-500">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                {{-- Form Section --}}
                <div class="p-8 space-y-6">
                    
                    {{-- Personal Information --}}
                    <div>
                        <h3 class="text-xl font-black text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-yellow-500">
                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                            </svg>
                            Personal Information
                        </h3>
                        
                        <div class="space-y-4">
                            {{-- Name Field --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                                <input type="text" 
                                       x-model="formData.name"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                       placeholder="Enter your full name">
                            </div>

                            {{-- Phone Field --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-500">
                                            <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="tel" 
                                           x-model="formData.phone"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                           placeholder="01234567890">
                                </div>
                            </div>

                            {{-- Email Field --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-500">
                                            <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                            <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                        </svg>
                                    </div>
                                    <input type="email" 
                                           x-model="formData.email"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium"
                                           placeholder="your@email.com">
                                </div>
                            </div>

                            {{-- Address Field with Map --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Delivery Address</label>
                                <div class="relative">
                                    <div class="absolute left-4 top-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-orange-500">
                                            <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <textarea x-model="formData.address"
                                              rows="3"
                                              class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none font-medium resize-none"
                                              placeholder="Enter your full delivery address"></textarea>
                                </div>
                                
                                {{-- Map Toggle Button --}}
                                <button @click="showMap = !showMap" 
                                        type="button"
                                        class="cursor-pointer mt-2 text-sm font-bold text-yellow-700 bg-yellow-50 hover:bg-yellow-100 px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.625a19.055 19.055 0 002.274 1.765 11.055 11.055 0 001.058.583c.013.006.026.01.038.016l.001.001zM11.165 9.167a1.166 1.166 0 11-2.33 0 1.166 1.166 0 012.33 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span x-text="showMap ? 'Hide Map' : 'View Map'"></span>
                                </button>
                                
                                {{-- Google Map --}}
                                <div x-show="showMap"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="mt-4 rounded-xl overflow-hidden shadow-lg border-2 border-yellow-100"
                                     style="display: none;">
                                    <iframe 
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3454.244363297376!2d31.0201463!3d30.0631885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14585a21c2e74241%3A0x2bd03f74577f8051!2sSmart%20Village!5e0!3m2!1sen!2seg!4v1695555555555!5m2!1sen!2seg" 
                                        width="100%" 
                                        height="300" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t-2 border-dashed border-gray-200"></div>

                    {{-- Stats Section (Read-Only) --}}
                    <div>
                        <h3 class="text-xl font-black text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-purple-500">
                                <path d="M15.98 1.804a1 1 0 00-1.96 0l-.24 1.192a1 1 0 01-.784.785l-1.192.238a1 1 0 000 1.962l1.192.238a1 1 0 01.785.785l.238 1.192a1 1 0 001.962 0l.238-1.192a1 1 0 01.785-.785l1.192-.238a1 1 0 000-1.962l-1.192-.238a1 1 0 01-.785-.785l-.238-1.192zM6.949 5.684a1 1 0 00-1.898 0l-.683 2.051a1 1 0 01-.633.633l-2.051.683a1 1 0 000 1.898l2.051.684a1 1 0 01.633.632l.683 2.051a1 1 0 001.898 0l.683-2.051a1 1 0 01.633-.633l2.051-.683a1 1 0 000-1.898l-2.051-.683a1 1 0 01-.633-.633L6.95 5.684zM13.949 13.684a1 1 0 00-1.898 0l-.184.551a1 1 0 01-.632.633l-.551.183a1 1 0 000 1.898l.551.183a1 1 0 01.633.633l.183.551a1 1 0 001.898 0l.184-.551a1 1 0 01.632-.633l.551-.183a1 1 0 000-1.898l-.551-.184a1 1 0 01-.633-.632l-.183-.551z" />
                            </svg>
                            Your Stats
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Orders Count --}}
                            <div class="bg-purple-50 rounded-2xl p-5 text-center">
                                <div class="text-3xl font-black text-purple-600" x-text="originalData.orders"></div>
                                <div class="text-sm text-gray-600 font-medium mt-1">Total Orders</div>
                            </div>
                            
                            {{-- Favorite Dish --}}
                            <div class="bg-pink-50 rounded-2xl p-5 text-center">
                                <div class="text-xl font-black text-pink-600" x-text="originalData.favorite"></div>
                                <div class="text-sm text-gray-600 font-medium mt-1">Favorite Dish</div>
                            </div>
                            
                            {{-- Last Order --}}
                            <div class="bg-blue-50 rounded-2xl p-5 text-center">
                                <div class="text-lg font-black text-blue-600" x-text="originalData.lastOrder"></div>
                                <div class="text-sm text-gray-600 font-medium mt-1">Last Order</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Update Button (Fixed at bottom, shows when hasChanges) --}}
        <div x-show="hasChanges"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-8"
             style="display: none;"
             class="fixed bottom-8 left-0 right-0 z-50 flex justify-center px-6">
            <div class="bg-white rounded-3xl shadow-2xl border-2 border-yellow-200 p-4 flex gap-3 max-w-md w-full">
                <button @click="saveProfile()" 
                        :disabled="saving"
                        class="flex-1 btn-primary h-14 flex items-center justify-center gap-2 relative">
                    <template x-if="saving">
                        <svg class="animate-spin h-5 w-5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <template x-if="!saving">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            <span class="font-bold">Save Changes</span>
                        </div>
                    </template>
                </button>
                
                <button @click="cancelChanges()" 
                        class="px-6 h-14 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- Include profile.js --}}
    <script src="{{ asset('assets/js/user/profile.js') }}"></script>
</x-user.layout>