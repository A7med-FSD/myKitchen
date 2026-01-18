{{-- Profile Modal --}}
<div x-data="{ 
    open: false,
    userData: {
        name: 'Ahmed Hassan',
        phone: '01234567890',
        email: 'ahmed@email.com',
        address: 'Nasr City',
        vip: true,
        orders: 12,
        favorite: 'Burgers',
        lastOrder: '3 days ago'
    }
}"
    @open-profile-modal.window="open = true"
    x-show="open"
    x-cloak
    style="display: none;"
    class="fixed inset-0 z-100 overflow-y-auto">
    
    {{-- Backdrop --}}
    <div @click="open = false"
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-backdrop">
    </div>

    {{-- Modal Positioning Wrapper --}}
    <div class="fixed inset-0 z-100 flex items-center justify-center p-4 pointer-events-none">
        
        {{-- Modal Container --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4 sm:translate-y-0"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4 sm:translate-y-0"
             @click.stop
             class="pointer-events-auto modal-container max-w-md rounded-4xl overflow-hidden shadow-2xl">
            
            {{-- Header with Gradient Background --}}
            <div class="modal-header p-8 text-center border-none shrink-0 relative">
                {{-- Settings Button --}}
                <a href="/settings" 
                    class="absolute top-4 left-4 p-2 text-gray-700 hover:text-white hover:bg-white/20 rounded-full"
                    title="Personal Settings">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </a>

                {{-- Close Button --}}
                <button @click="open = false"
                        class="modal-close top-4 right-4 text-white/80 hover:text-white hover:bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- Profile Photo --}}
                <div class="relative inline-block mb-4">
                    <img src="{{Vite::asset('resources/images/3d-portrait-people.jpg')}}" 
                        alt="Profile" 
                        class="w-28 h-28 rounded-full border-2 border-white shadow-2xl object-cover mx-auto">
                    <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-yellow-500">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                {{-- Name & VIP Badge --}}
                <h2 class="text-2xl font-black text-white mb-2" x-text="userData.name"></h2>
                
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white rounded-full shadow-md shadow-orange-500/20 max-w-fit mx-auto">
                    <span class="text-yellow-700 font-bold text-xs tracking-wide">VIP</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-yellow-500">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <div class="modal-body-content space-y-6">
                    <div class="border-t-2 border-dashed border-gray-200"></div>
                    
                    {{-- Contact Information --}}
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-gray-700">
                            <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-600">
                                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-medium" x-text="userData.phone"></span>
                        </div>

                        <div class="flex items-center gap-3 text-gray-700">
                            <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600">
                                    <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                                    <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                                </svg>
                            </div>
                            <span class="font-medium break-all" x-text="userData.email"></span>
                        </div>

                        <div class="flex items-center gap-3 text-gray-700">
                            <div class="w-10 h-10 bg-orange-50 rounded-full flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-orange-600">
                                    <path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 0 0 2.273 1.765 11.842 11.842 0 0 0 .976.544l.062.029.018.008.006.003ZM10 11.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-medium" x-text="userData.address"></span>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t-2 border-dashed border-gray-200"></div>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-purple-50 rounded-2xl p-4 text-center">
                            <div class="text-2xl font-black text-purple-600" x-text="userData.orders"></div>
                            <div class="text-xs text-gray-600 font-medium mt-1">Orders</div>
                        </div>
                        <div class="bg-pink-50 rounded-2xl p-4 text-center col-span-2">
                            <div class="text-lg font-black text-pink-600" x-text="userData.favorite"></div>
                            <div class="text-xs text-gray-600 font-medium mt-1">Favorite Dish</div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500 font-medium">Last Order</div>
                            <div class="text-sm font-bold text-gray-700" x-text="userData.lastOrder"></div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="space-y-2">
                        <a href="/orders" 
                           class="btn-primary h-14">
                            <span class="text-base font-bold">My Orders</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                            </svg>
                        </a>

                        <button @click="open = false" 
                                class="flex items-center justify-center w-full h-14 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl transition-all cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                                <path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z" clip-rule="evenodd" />
                            </svg>
                            Reorder Last Meal
                        </button>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
