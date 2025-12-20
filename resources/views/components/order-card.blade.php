{{-- Order Card Component --}}
{{-- This component is used inside x-for loop, so 'order' and 'index' are available from Alpine.js scope --}}

<div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-entrance-card flex flex-col h-[420px]"
     :class="'animate-delay-' + ((index % 6) * 100)">
    
    {{-- Order Header --}}
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

    {{-- Customer Info --}}
    <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-2xl">
        <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center font-bold text-gray-900" x-text="order.customer.charAt(0)"></div>
        <div class="flex-1">
            <p class="font-semibold text-sm text-gray-900" x-text="order.customer"></p>
            <p class="text-xs text-gray-500" x-text="order.phone"></p>
        </div>
        <div class="text-xs text-gray-400" x-text="order.type"></div>
    </div>

    {{-- Items List - Scrollable with fixed height --}}
    <div class="flex-1 overflow-y-auto mb-4 space-y-2 noscroll">
        <template x-for="(item, itemIndex) in order.items" :key="itemIndex">
            <div class="flex justify-between text-sm" x-show="itemIndex < 3">
                <span class="text-gray-700"><span class="font-semibold" x-text="item.qty"></span>x <span x-text="item.name"></span></span>
                <span class="font-semibold text-gray-900">$<span x-text="item.price"></span></span>
            </div>
        </template>
        
        {{-- Show More Button --}}
        <button x-show="order.items.length > 3" 
                @click="openOrderModal(order)"
                class="text-gray-800 hover:text-black cursor-pointer font-semibold text-sm flex items-center gap-1 transition-colors mt-2">
            <span>Show More (</span><span x-text="order.items.length - 3"></span><span> more items)</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    {{-- Total --}}
    <div class="flex justify-between items-center pt-4 border-t border-gray-200 mb-4">
        <span class="font-bold text-gray-900">Total</span>
        <span class="text-xl font-black text-gray-900">$<span x-text="order.total"></span></span>
    </div>

    {{-- Action Buttons --}}
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
