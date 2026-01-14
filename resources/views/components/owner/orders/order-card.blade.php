{{-- Order Card Component --}}
{{-- This component is used inside x-for loop, so 'order' and 'index' are available from Alpine.js scope --}}

<div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-entrance-card flex flex-col h-[420px] cursor-pointer border border-transparent hover:border-yellow-200"
     :class="'animate-delay-' + ((index % 6) * 100)"
     @click="openOrderModal(order)">
    
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


    {{-- Delivery Address (if available) --}}
    <template x-if="order.address">
        <div class="mb-4 p-3 bg-gray-50 rounded-xl">
            <div class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400 mt-0.5 shrink-0">
                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.625a19.055 19.055 0 0 0 2.274 1.765 11.055 11.055 0 0 0 1.058.583c.013.006.026.01.038.016l.001.001ZM11.165 9.167a1.166 1.166 0 1 1-2.33 0 1.166 1.166 0 0 1 2.33 0Z" clip-rule="evenodd" />
                </svg>
                <p class="text-xs text-gray-600 overflow-hidden text-ellipsis leading-relaxed line-clamp-2 flex-1" x-text="order.address"></p>
            </div>
        </div>
    </template>


    {{-- Items List - Scrollable with fixed height --}}
    <div class="flex-1 overflow-y-auto mb-4 space-y-2 noscroll">
        <template x-for="(item, itemIndex) in order.items" :key="itemIndex">
            <div class="flex justify-between text-sm" x-show="itemIndex < 3">
                <div class="flex items-center gap-2">
                    <span class="text-gray-700">
                        <span class="font-semibold" x-text="item.qty"></span>x 
                        <span x-text="item.name"></span>
                    </span>
                    {{-- Discount Badge (Mini) --}}
                    <template x-if="item.originalPrice && item.originalPrice > item.price">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-orange-50 text-orange-600 border border-orange-100">
                            Sale
                        </span>
                    </template>
                </div>
                
                <div class="flex items-center gap-2">
                    {{-- Original Price --}}
                    <template x-if="item.originalPrice && item.originalPrice > item.price">
                        <span class="text-xs text-gray-400 line-through decoration-orange-400 decoration-2" x-text="'$' + item.originalPrice"></span>
                    </template>
                    {{-- Current Price --}}
                    <span class="font-semibold text-gray-900" :class="{'text-orange-600': item.originalPrice && item.originalPrice > item.price}">
                        $<span x-text="item.price"></span>
                    </span>
                </div>
            </div>
        </template>
        
        {{-- More Items Indicator --}}
        <div x-show="order.items.length > 3" class="text-xs text-gray-500 font-medium mt-2">
            +<span x-text="order.items.length - 3"></span> more items
        </div>
    </div>

    {{-- Total --}}
    <div class="flex justify-between items-center pt-4 border-t border-gray-200 mb-4">
        <span class="font-bold text-gray-900">Total</span>
        <span class="text-xl font-black text-gray-900">$<span x-text="order.total"></span></span>
    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-2" x-show="order.status === 'Pending' || order.status === 'In Progress'" @click.stop>
        <button x-show="order.status === 'Pending'" 
                @click="acceptOrder(order.id)"
                class="flex-1 cursor-pointer bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-full transition-colors">
            Accept
        </button>
        <button x-show="order.status === 'In Progress'" 
                @click="markReady(order.id)"
                class="flex-1 cursor-pointer bg-blue-500 hover:bg-blue-600 text-white font-bold py-2.5 rounded-full transition-colors">
            Mark Ready
        </button>
        <button @click="cancelOrder(order.id)"
                class="px-4 cursor-pointer bg-red-100 hover:bg-red-200 text-red-600 font-bold py-2.5 rounded-full transition-colors">
            Cancel
        </button>
    </div>
</div>
