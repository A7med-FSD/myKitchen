<x-owner.layout>
    <link rel="stylesheet" href="{{ asset('assets/css/entrance.css') }}">

    <div class="space-y-6" x-data="ordersHandler()">

        <x-owner.heading>
            <x-slot:title>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-yellow-500">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.50183 6H11.2477L11.25 6H14.6299C16.4915 6.00268 17.9999 7.51269 17.9999 9.375V18.75C19.6567 18.75 20.9999 17.4068 20.9999 15.75V6.10821C20.9999 4.60282 19.8751 3.2966 18.3358 3.16884C18.1121 3.15027 17.8879 3.13321 17.6632 3.11767C17.1633 2.15647 16.1583 1.5 15 1.5H13.5C12.3417 1.5 11.3367 2.15647 10.8368 3.11765C10.6121 3.13319 10.3878 3.15026 10.1639 3.16884C8.66165 3.29353 7.55421 4.54069 7.50183 6ZM13.5 3C12.6716 3 12 3.67157 12 4.5H16.5C16.5 3.67157 15.8284 3 15 3H13.5Z" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 9.375C3 8.33947 3.83947 7.5 4.875 7.5H14.625C15.6605 7.5 16.5 8.33947 16.5 9.375V20.625C16.5 21.6605 15.6605 22.5 14.625 22.5H4.875C3.83947 22.5 3 21.6605 3 20.625V9.375ZM6 12C6 11.5858 6.33579 11.25 6.75 11.25H6.7575C7.17171 11.25 7.5075 11.5858 7.5075 12V12.0075C7.5075 12.4217 7.17171 12.7575 6.7575 12.7575H6.75C6.33579 12.7575 6 12.4217 6 12.0075V12ZM8.25 12C8.25 11.5858 8.58579 11.25 9 11.25H12.75C13.1642 11.25 13.5 11.5858 13.5 12C13.5 12.4142 13.1642 12.75 12.75 12.75H9C8.58579 12.75 8.25 12.4142 8.25 12Z" />
                </svg>
                Orders Management
            </x-slot:title>
            <x-slot:subtitle>Track and manage customer orders</x-slot:subtitle>

            <x-slot:searchplacehold>Search orders, customers...</x-slot:searchplacehold>
            <x-slot:filter>filter in ['All', 'Order ID', 'Customer Name', 'Customer Number']</x-slot:filter>
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
        </x-owner.heading>

        {{-- Status Filter Component --}}
        <x-owner.status-filter />

        {{-- Orders Grid --}}
        <div class="grid grid-cols-[repeat(auto-fill,minmax(400px,1fr))] gap-6" x-ref="ordersGrid">
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
        <x-owner.order-modal/>
    </div>

    <script src="{{asset('assets/js/owner/orders.js')}}"></script>
</x-owner.layout>
