<div x-show="showCustomerModal" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     x-cloak
     style="display: none;"
     x-data="{ showMap: false }">
    
    <!-- Backdrop -->
    <div x-show="showCustomerModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 transition-opacity bg-black/50" 
         
         @click="showCustomerModal = false; selectedCustomer = null">
    </div>

    <!-- Modal Panel -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="showCustomerModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-2xl bg-white shadow-xl transition-all w-full max-w-lg border border-gray-100">

            <!-- Close Button -->
            <button @click="showCustomerModal = false; selectedCustomer = null" 
                    class="absolute top-4 right-4 p-2 text-white/80 hover:text-white hover:bg-white/20 rounded-full transition-colors z-20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Content -->
            <template x-if="selectedCustomer">
                <div class="flex flex-col">
                    <!-- Header Section with Gradient -->
                    <div class="relative h-40 w-full shrink-0">
                         <!-- Background with Overflow Hidden (for blur effects) -->
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-500 overflow-hidden">
                            <!-- Decorative Circle -->
                            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
                            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
                        </div>
                        
                        <!-- Avatar (positioned absolute relative to the height container, not clipped) -->
                        <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2 z-10">
                            <div class="relative">
                                <img :src="selectedCustomer.image" 
                                     :alt="selectedCustomer.name"
                                     class="w-32 h-32 rounded-full object-cover border-[3px] border-white shadow-xl bg-white">
                                     
                                <!-- Active Status Indicator -->
                                <template x-if="activityStatus(selectedCustomer) !== 'inactive'">
                                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-4 border-white rounded-full shadow-sm" title="Active"></div>
                                </template>
                                <template x-if="activityStatus(selectedCustomer) === 'inactive'">
                                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-gray-300 border-4 border-white rounded-full shadow-sm" title="Inactive"></div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Identity -->
                    <div class="pt-20 pb-6 px-6 text-center">
                        <h3 class="text-2xl font-bold text-gray-900" x-text="selectedCustomer.name"></h3>
                        <p class="text-base text-gray-500 font-medium mt-1" x-text="selectedCustomer.email"></p>

                        <!-- Customer Tag Badge -->
                         <div class="mt-4 flex justify-center gap-2">
                            <template x-if="customerTag(selectedCustomer) === 'VIP'">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-700 text-xs font-bold rounded-full border border-yellow-200 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                                    </svg>
                                    VIP Customer
                                </span>
                            </template>
                            <template x-if="customerTag(selectedCustomer) === 'Regular'">
                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full border border-gray-300">
                                    Regular Customer
                                </span>
                            </template>
                           <template x-if="customerTag(selectedCustomer) === 'NEW'">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full border border-green-200 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                    </svg>
                                    New Customer
                                </span>
                            </template>
                        </div>
                    </div>

                    <div class="px-8 pb-8 space-y-8">
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 text-center hover:bg-yellow-50/50 transition-colors duration-300">
                                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1.5">Total Spent</div>
                                <div class="text-xl font-black text-gray-900" x-text="'$' + selectedCustomer.totalSpent.toLocaleString()"></div>
                            </div>
                            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 text-center hover:bg-yellow-50/50 transition-colors duration-300">
                                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1.5">Total Orders</div>
                                <div class="text-xl font-black text-gray-900" x-text="selectedCustomer.totalOrders"></div>
                            </div>
                        </div>

                         <!-- Details List -->
                        <div class="space-y-4 px-2">
                             <div class="flex items-center justify-between py-3 border-b border-gray-50 group hover:bg-gray-50/50 rounded-lg px-2 -mx-2 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-500 font-medium">Contact</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 font-mono tracking-tight" x-text="formatPhone(selectedCustomer.phone)"></span>
                            </div>

                             <div class="flex items-center justify-between py-3 border-b border-gray-50 group hover:bg-gray-50/50 rounded-lg px-2 -mx-2 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-500 font-medium">Joined Date</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900" x-text="formatDate(selectedCustomer.joinedDate)"></span>
                            </div>

                            <div class="flex items-center justify-between py-3 border-b border-gray-50 group hover:bg-gray-50/50 rounded-lg px-2 -mx-2 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-500 font-medium">Last Order</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-sm font-bold text-gray-900" x-text="formatDate(selectedCustomer.lastOrderDate)"></span>
                                    <span class="block text-xs text-gray-400 font-medium" x-text="getDaysSince(selectedCustomer.lastOrderDate) + ' days ago'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Address & Map Section -->
                        <div class="bg-yellow-50/50 rounded-xl p-4 border border-yellow-100">
                           <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-1">Usage Address</h4>
                                    <!-- Static Address for now, can be dynamic later -->
                                    <p class="text-xs text-gray-600 leading-relaxed" x-text="selectedCustomer.address || '123 Smart Village, Giza, Egypt'"></p>
                                </div>
                                <button @click="showMap = !showMap" 
                                        class="text-xs font-bold text-yellow-700 bg-yellow-100 hover:bg-yellow-200 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.625a19.055 19.055 0 0 0 2.274 1.765 11.055 11.055 0 0 0 1.058.583c.013.006.026.01.038.016l.001.001ZM11.165 9.167a1.166 1.166 0 1 1-2.33 0 1.166 1.166 0 0 1 2.33 0Z" clip-rule="evenodd" />
                                    </svg>
                                    <span x-text="showMap ? 'Hide Map' : 'View Map'"></span>
                                </button>
                           </div>
                           
                           <!-- Map Collapse -->
                           <div x-show="showMap" 
                                x-collapse
                                class="mt-4 rounded-lg overflow-hidden shadow-sm border border-yellow-200">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3454.244363297376!2d31.0201463!3d30.0631885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14585a21c2e74241%3A0x2bd03f74577f8051!2sSmart%20Village!5e0!3m2!1sen!2seg!4v1695555555555!5m2!1sen!2seg" 
                                    width="100%" 
                                    height="200" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                           </div>
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
