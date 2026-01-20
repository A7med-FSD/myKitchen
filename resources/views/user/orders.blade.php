<x-user.layout>
    <div class="py-8 space-y-16" x-data="ordersHandler()">
        {{-- Page Header --}}
        <div class="mb-12 text-center opacity-0"
            x-data="{ shown: false }" x-intersect.threshold.50="shown = true" 
            :class="shown ? 'header-animation' : 'opacity-0'">
            <div class="inline-flex items-center justify-center gap-3 mb-2">
                <div class="p-2 bg-yellow-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-yellow-600">
                        <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                        <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight">My Orders</h2>
            </div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Track your order history and reorder your favorite meals with one click!</p>
        </div>

        {{-- Search and Period Filter --}}
        <div class="px-6 xl:px-60 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center">
                {{-- Search Component --}}
                <x-search :searchplacehold="'Search by order number...'" />
                
                {{-- Period Dropdown --}}
                <div x-data="{ periodOpen: false }" class="relative animate-entrance-search z-20">
                    <button @click="periodOpen = !periodOpen" 
                            type="button"
                            class="w-full md:w-auto px-6 py-3 rounded-full border border-gray-200 bg-white focus:ring-2 focus:ring-yellow-100 outline-none transition-all text-left flex items-center justify-between gap-3 cursor-pointer shadow-sm hover:border-yellow-300 min-w-[200px]"
                            :class="selectedPeriod !== 'All' ? 'border-yellow-400' : 'border-gray-200'">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                                <path d="M5.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H6a.75.75 0 01-.75-.75V12zM6 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H6zM7.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H8a.75.75 0 01-.75-.75V12zM8 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H8zM9.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V10zM10 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H10zM9.25 14a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V14zM12 9.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V10a.75.75 0 00-.75-.75H12zM11.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12zM12 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H12zM13.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H14a.75.75 0 01-.75-.75V10zM14 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H14z" />
                                <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                            </svg>
                            <span :class="selectedPeriod !== 'All' ? 'text-gray-900 font-semibold' : 'text-gray-500'" x-text="selectedPeriod"></span>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400 transition-transform" :class="periodOpen ? 'rotate-180' : ''">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div x-show="periodOpen" 
                         @click.away="periodOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute z-10 w-full mt-2 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden"
                         style="display: none;">
                        <button @click="selectedPeriod = 'All'; periodOpen = false"
                                type="button"
                                class="w-full px-4 py-2 text-left hover:bg-gray-50 transition-colors cursor-pointer"
                                :class="selectedPeriod === 'All' ? 'bg-gray-50 text-gray-700 font-semibold' : 'text-gray-600'">
                            All Time
                        </button>
                        <button @click="selectedPeriod = 'Last Week'; periodOpen = false"
                                type="button"
                                class="w-full px-4 py-2 text-left hover:bg-yellow-50 transition-colors cursor-pointer"
                                :class="selectedPeriod === 'Last Week' ? 'bg-yellow-50 text-yellow-700 font-semibold' : 'text-gray-700'">
                            Last Week
                        </button>
                        <button @click="selectedPeriod = 'Last Month'; periodOpen = false"
                                type="button"
                                class="w-full px-4 py-2 text-left hover:bg-yellow-50 transition-colors cursor-pointer"
                                :class="selectedPeriod === 'Last Month' ? 'bg-yellow-50 text-yellow-700 font-semibold' : 'text-gray-700'">
                            Last Month
                        </button>
                        <button @click="selectedPeriod = 'Last Year'; periodOpen = false"
                                type="button"
                                class="w-full px-4 py-2 text-left hover:bg-yellow-50 transition-colors cursor-pointer"
                                :class="selectedPeriod === 'Last Year' ? 'bg-yellow-50 text-yellow-700 font-semibold' : 'text-gray-700'">
                            Last Year
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Orders Grid --}}
        <div class="px-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="(order, index) in filteredOrders" :key="order.id">
                    <div x-data="{ shown: false }" 
                         x-intersect.threshold.20="shown = true"
                         :class="shown ? 'animate-entrance-card' : 'opacity-0'" 
                         :style="'animation-delay: ' + ((index % 3) * 100) + 'ms'">
                        <x-user.orders.order-card />
                    </div>
                </template>
            </div>

            {{-- No Results Message --}}
            <div x-show="filteredOrders.length === 0" 
                 x-transition
                 class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-gray-400">
                        <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                        <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No orders found</h3>
                <p class="text-gray-600">Try adjusting your search or time period filter.</p>
            </div>
        </div>

        {{-- Order Details Modal --}}
        <x-user.orders.view-order-modal />
    </div>

    {{-- Include orders.js --}}
    <script src="{{ asset('assets/js/user/orders.js') }}"></script>
</x-user.layout>
