<x-layout>
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    <div class="space-y-6" x-data="ordersHandler()">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 animate-entrance-header">
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

            <!-- Quick Stats -->
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

        <!-- Status Filters -->
        <div class="flex flex-wrap gap-3 animate-entrance-search">
            <template x-for="status in statuses" :key="status.name">
                <button @click="selectedStatus = status.name"
                        class="px-4 py-2 rounded-full font-semibold transition-all duration-300 flex items-center gap-2"
                        :class="selectedStatus === status.name ? 'bg-yellow-400 text-gray-900 shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-100'">
                    <span x-text="status.icon"></span>
                    <span x-text="status.name"></span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-black/10" x-text="status.count"></span>
                </button>
            </template>
        </div>

        <!-- Orders List -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            <template x-for="(order, index) in filteredOrders" :key="order.id">
                <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-entrance-card"
                     :class="'animate-delay-' + ((index % 6) * 100)">
                    <!-- Order Header -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" x-text="'#' + order.id"></h3>
                            <p class="text-xs text-gray-500" x-text="order.time"></p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold"
                              :class="{
                                  'bg-yellow-100 text-yellow-700': order.status === 'Pending',
                                  'bg-blue-100 text-blue-700': order.status === 'In Progress',
                                  'bg-green-100 text-green-700': order.status === 'Ready',
                                  'bg-purple-100 text-purple-700': order.status === 'Delivered',
                                  'bg-red-100 text-red-700': order.status === 'Cancelled'
                              }"
                              x-text="order.status"></span>
                    </div>

                    <!-- Customer Info -->
                    <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-2xl">
                        <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center font-bold text-gray-900" x-text="order.customer.charAt(0)"></div>
                        <div class="flex-1">
                            <p class="font-semibold text-sm text-gray-900" x-text="order.customer"></p>
                            <p class="text-xs text-gray-500" x-text="order.phone"></p>
                        </div>
                        <div class="text-xs text-gray-400" x-text="order.type"></div>
                    </div>

                    <!-- Items List -->
                    <div class="space-y-2 mb-4">
                        <template x-for="item in order.items" :key="item.name">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-700"><span class="font-semibold" x-text="item.qty"></span>x <span x-text="item.name"></span></span>
                                <span class="font-semibold text-gray-900">$<span x-text="item.price"></span></span>
                            </div>
                        </template>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200 mb-4">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="text-xl font-black text-gray-900">$<span x-text="order.total"></span></span>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2" x-show="order.status === 'Pending' || order.status === 'In Progress'">
                        <button x-show="order.status === 'Pending'" 
                                @click="acceptOrder(order.id)"
                                class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-full transition-colors">
                            Accept
                        </button>
                        <button x-show="order.status === 'In Progress'" 
                                @click="markReady(order.id)"
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2.5 rounded-full transition-colors">
                            Mark Ready
                        </button>
                        <button @click="cancelOrder(order.id)"
                                class="px-4 bg-red-100 hover:bg-red-200 text-red-600 font-bold py-2.5 rounded-full transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State -->
        <div x-show="filteredOrders.length === 0" class="text-center py-20">
            <div class="text-6xl mb-4">📋</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No orders found</h3>
            <p class="text-gray-500">Try selecting a different status filter</p>
        </div>
    </div>

    <script>
        function ordersHandler() {
            return {
                selectedStatus: 'All',
                todayOrders: 24,
                todayRevenue: 456.80,
                statuses: [
                    { name: 'All', icon: '📋', count: 24 },
                    { name: 'Pending', icon: '⏰', count: 8 },
                    { name: 'In Progress', icon: '🔄', count: 6 },
                    { name: 'Ready', icon: '✅', count: 5 },
                    { name: 'Delivered', icon: '🚗', count: 4 },
                    { name: 'Cancelled', icon: '❌', count: 1 }
                ],
                orders: [
                    { id: '1024', time: '10:30 AM', customer: 'Ahmed Hassan', phone: '0123456789', type: 'Delivery', status: 'Pending', items: [{name: 'Burger', qty: 2, price: 12.99}, {name: 'Fries', qty: 1, price: 4.99}], total: 30.97 },
                    { id: '1025', time: '10:45 AM', customer: 'Sara Mohamed', phone: '0987654321', type: 'Pickup', status: 'In Progress', items: [{name: 'Pizza', qty: 1, price: 18.99}], total: 18.99 },
                    { id: '1026', time: '11:00 AM', customer: 'Khaled Ali', phone: '0111222333', type: 'Delivery', status: 'Pending', items: [{name: 'Pasta', qty: 3, price: 16.99}], total: 50.97 },
                    { id: '1027', time: '11:15 AM', customer: 'Nour Ibrahim', phone: '0444555666', type: 'Dine-in', status: 'Ready', items: [{name: 'Steak', qty: 2, price: 28.99}], total: 57.98 },
                    { id: '1028', time: '11:30 AM', customer: 'Omar Youssef', phone: '0777888999', type: 'Delivery', status: 'In Progress', items: [{name: 'Salad', qty: 1, price: 8.99}, {name: 'Juice', qty: 2, price: 4.99}], total: 18.97 },
                    { id: '1029', time: '11:45 AM', customer: 'Layla Mahmoud', phone: '0555444333', type: 'Pickup', status: 'Delivered', items: [{name: 'Smoothie Bowl', qty: 1, price: 7.99}], total: 7.99 },
                    { id: '1030', time: '12:00 PM', customer: 'Youssef Kamal', phone: '0666777888', type: 'Delivery', status: 'Pending', items: [{name: 'Shrimp Stir-Fry', qty: 2, price: 18.99}], total: 37.98 },
                    { id: '1031', time: '12:15 PM', customer: 'Mariam Adel', phone: '0888999000', type: 'Dine-in', status: 'Ready', items: [{name: 'Alfredo Pasta', qty: 1, price: 16.99}], total: 16.99 },
                    { id: '1032', time: '12:30 PM', customer: 'Hassan Tarek', phone: '0123987654', type: 'Delivery', status: 'In Progress', items: [{name: 'Veggie Burger', qty: 3, price: 12.99}], total: 38.97 },
                    { id: '1033', time: '12:45 PM', customer: 'Dina Sameh', phone: '0456789123', type: 'Pickup', status: 'Cancelled', items: [{name: 'Caesar Salad', qty: 2, price: 8.99}], total: 17.98 }
                ],
                get filteredOrders() {
                    if (this.selectedStatus === 'All') {
                        return this.orders;
                    }
                    return this.orders.filter(order => order.status === this.selectedStatus);
                },
                acceptOrder(id) {
                    const order = this.orders.find(o => o.id === id);
                    if (order) order.status = 'In Progress';
                },
                markReady(id) {
                    const order = this.orders.find(o => o.id === id);
                    if (order) order.status = 'Ready';
                },
                cancelOrder(id) {
                    const order = this.orders.find(o => o.id === id);
                    if (order) order.status = 'Cancelled';
                }
            }
        }
    </script>
</x-layout>
