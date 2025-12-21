<x-owner.layout>
    <link rel="stylesheet" href="{{ asset('assets/css/entrance.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    <div class="space-y-6" x-data="ordersHandler()">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 animate-entrance-header relative z-50">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-yellow-500">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.50183 6H11.2477L11.25 6H14.6299C16.4915 6.00268 17.9999 7.51269 17.9999 9.375V18.75C19.6567 18.75 20.9999 17.4068 20.9999 15.75V6.10821C20.9999 4.60282 19.8751 3.2966 18.3358 3.16884C18.1121 3.15027 17.8879 3.13321 17.6632 3.11767C17.1633 2.15647 16.1583 1.5 15 1.5H13.5C12.3417 1.5 11.3367 2.15647 10.8368 3.11765C10.6121 3.13319 10.3878 3.15026 10.1639 3.16884C8.66165 3.29353 7.55421 4.54069 7.50183 6ZM13.5 3C12.6716 3 12 3.67157 12 4.5H16.5C16.5 3.67157 15.8284 3 15 3H13.5Z" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3 9.375C3 8.33947 3.83947 7.5 4.875 7.5H14.625C15.6605 7.5 16.5 8.33947 16.5 9.375V20.625C16.5 21.6605 15.6605 22.5 14.625 22.5H4.875C3.83947 22.5 3 21.6605 3 20.625V9.375ZM6 12C6 11.5858 6.33579 11.25 6.75 11.25H6.7575C7.17171 11.25 7.5075 11.5858 7.5075 12V12.0075C7.5075 12.4217 7.17171 12.7575 6.7575 12.7575H6.75C6.33579 12.7575 6 12.4217 6 12.0075V12ZM8.25 12C8.25 11.5858 8.58579 11.25 9 11.25H12.75C13.1642 11.25 13.5 11.5858 13.5 12C13.5 12.4142 13.1642 12.75 12.75 12.75H9C8.58579 12.75 8.25 12.4142 8.25 12Z" />
                    </svg>
                    Orders Management
                </h1>
                <p class="text-gray-500 mt-2 font-medium">Track and manage customer orders</p>
            </div>

            {{-- Search Bar --}}
            <div class="w-full max-w-2xl md:w-96 relative group grow animate-entrance-search z-50">
                <input type="text" 
                    x-model="searchQuery"
                    placeholder="Search orders, customers..." 
                    class="w-full bg-white border-none outline-none rounded-full py-3 pl-12 pr-20 shadow-sm focus:ring-2 focus:ring-gray-200 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-4 top-3.5 text-gray-400 size-5 group-focus-within:text-gray-600 transition-colors">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" />
                </svg>
                <svg x-show="searchQuery" 
                    @click="searchQuery = ''"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                    class="absolute right-12 top-3.5 z-50 text-gray-400 size-5 cursor-pointer hover:text-gray-600 transition-colors">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>

                {{-- Search Filter Dropdown --}}
                <div x-data="{ showFilter: false }" class="absolute z-50 right-4 top-3.5">
                    <svg @click="showFilter = !showFilter" @click.outside="showFilter = false" 
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                        class="text-gray-400 size-5 cursor-pointer hover:text-gray-600 transition-colors z-50"
                        :class="searchFilter !== 'All' ? 'text-yellow-500 hover:text-yellow-600' : ''">
                        <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                    </svg>
                    
                    {{-- Dropdown Menu --}}
                    <div x-show="showFilter" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 top-8 w-48 bg-white rounded-2xl overflow-hidden shadow-xl py-2 border z-50 border-gray-100 dark:border-gray-800"
                        style="display: none;">
                        
                        <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Search By</div>
                        
                        <template x-for="filter in ['All', 'Order ID', 'Customer Name', 'Customer Number']">
                            <button @click="searchFilter = filter; showFilter = false"
                                    class="w-full text-left px-4 py-2.5 text-sm font-medium hover:bg-yellow-50 hover:text-yellow-700 transition-colors flex items-center justify-between"
                                    :class="searchFilter === filter ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600'">
                                <span x-text="filter"></span>
                                <svg x-show="searchFilter === filter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-yellow-500">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="flex gap-3">
                <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                    <div class="text-2xl font-bold text-gray-900" x-text="todayOrders"></div>
                    <div class="text-xs text-gray-500">Today's Orders</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                    <div class="text-2xl font-bold text-green-600">$<span x-text="todayRevenue"></span></div>
                    <div class="text-xs text-gray-500">Revenue</div>
                </div>
            </div>
        </div>

        {{-- Status Filter Component --}}
        <x-owner.status-filter />

        {{-- Orders Grid --}}
        <div class="grid grid-cols-[repeat(auto-fit,minmax(400px,1fr))] gap-6" x-ref="ordersGrid">
            <template x-for="(order, index) in filteredOrders" :key="order.id">
                <x-owner.order-card />
            </template>
        </div>

        {{-- Empty State --}}
        <div x-show="filteredOrders.length === 0" class="text-center py-20">
            <div class="text-6xl mb-4">📋</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No orders found</h3>
            <p class="text-gray-500">Try selecting a different status filter or adjust your search</p>
        </div>

        {{-- Order Detail Modal --}}
        <div x-show="showModal" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
            @click="closeOrderModal()"
            style="display: none;">
            
            <div x-show="showModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
                class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                @click.stop>
                
                <template x-if="selectedOrder">
                    <div>
                        {{-- Modal Header --}}
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-400 p-6 relative overflow-hidden">
                            <div class="relative flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900" x-text="'Order #' + selectedOrder.id"></h3>
                                    <p class="text-gray-700 text-sm" x-text="selectedOrder.time"></p>
                                </div>
                                <button @click="closeOrderModal()" class="text-gray-700 cursor-pointer hover:text-gray-900 hover:bg-white/20 rounded-full p-2 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Modal Body --}}
                        <div class="p-6 space-y-6">
                            {{-- Status Badge --}}
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-semibold">Status:</span>
                                <span class="px-4 py-2 rounded-full text-sm font-bold"
                                    :class="{
                                        'bg-yellow-100 text-yellow-700': selectedOrder.status === 'Pending',
                                        'bg-blue-100 text-blue-700': selectedOrder.status === 'In Progress',
                                        'bg-green-100 text-green-700': selectedOrder.status === 'Ready',
                                        'bg-purple-100 text-purple-700': selectedOrder.status === 'Delivered',
                                        'bg-red-100 text-red-700': selectedOrder.status === 'Cancelled'
                                    }"
                                    x-text="selectedOrder.status"></span>
                            </div>

                            {{-- Customer Info --}}
                            <div class="bg-gray-50 rounded-2xl p-4">
                                <h4 class="font-bold text-gray-900 mb-3">Customer Information</h4>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-12 h-12 rounded-full bg-yellow-400 flex items-center justify-center font-bold text-gray-900 text-lg" x-text="selectedOrder.customer.charAt(0)"></div>
                                    <div>
                                        <p class="font-semibold text-gray-900" x-text="selectedOrder.customer"></p>
                                        <p class="text-sm text-gray-500" x-text="selectedOrder.phone"></p>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <span class="text-sm text-gray-600">Order Type: </span>
                                    <span class="text-sm font-semibold text-gray-900" x-text="selectedOrder.type"></span>
                                </div>
                            </div>

                            {{-- All Items --}}
                            <div>
                                <h4 class="font-bold text-gray-900 mb-3">Order Items</h4>
                                <div class="space-y-2">
                                    <template x-for="(item, index) in selectedOrder.items" :key="index">
                                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                            <div class="flex items-center gap-2">
                                                <span class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-900" x-text="item.qty"></span>
                                                <span class="font-semibold text-gray-900" x-text="item.name"></span>
                                            </div>
                                            <span class="font-bold text-gray-900">$<span x-text="item.price"></span></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="flex justify-between items-center pt-4 border-t-2 border-gray-200">
                                <span class="text-xl font-bold text-gray-900">Total</span>
                                <span class="text-3xl font-black text-gray-900">$<span x-text="selectedOrder.total"></span></span>
                            </div>
                        </div>

                        {{-- Modal Footer --}}
                        <div class="p-6 bg-gray-50 border-t border-gray-200">
                            <div class="flex gap-2" x-show="selectedOrder.status === 'Pending' || selectedOrder.status === 'In Progress'">
                                <button x-show="selectedOrder.status === 'Pending'" 
                                        @click="acceptOrder(selectedOrder.id); closeOrderModal()"
                                        class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-full transition-colors">
                                    Accept
                                </button>
                                <button x-show="selectedOrder.status === 'In Progress'" 
                                        @click="markReady(selectedOrder.id); closeOrderModal()"
                                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2.5 rounded-full transition-colors">
                                    Mark Ready
                                </button>
                                <button @click="cancelOrder(selectedOrder.id); closeOrderModal()"
                                        class="px-4 bg-red-100 hover:bg-red-200 text-red-600 font-bold py-2.5 rounded-full transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/owner/orders.js')}}"></script>
</x-owner.layout>
