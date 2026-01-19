{{-- User Order Card Component --}}
{{-- This component is used inside x-for loop, so 'order' and 'index' are available from Alpine.js scope --}}

<div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-entrance-card flex flex-col min-h-105 cursor-pointer border border-transparent hover:border-yellow-200"
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

    {{-- Order Type --}}
    <div class="flex items-center gap-2 mb-3">
        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-500">
                <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
            </svg>
            <span class="text-xs font-medium text-gray-600" x-text="order.type"></span>
        </div>
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
    <div class="flex-1 overflow-y-auto mb-4 space-y-2 noscroll max-h-40">
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

    {{-- Reorder Button --}}
    <button @click.stop="reorderItems(order)"
            class="w-full cursor-pointer bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-3 rounded-full transition-colors flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
            <path d="M1 1.75A.75.75 0 011.75 1h1.628a1.75 1.75 0 011.734 1.51L5.18 3a65.25 65.25 0 0113.36 1.412.75.75 0 01.58.875 48.645 48.645 0 01-1.618 6.2.75.75 0 01-.712.513H6a2.503 2.503 0 00-2.292 1.5H17.25a.75.75 0 010 1.5H2.76a.75.75 0 01-.748-.807 4.002 4.002 0 012.716-3.486L3.626 2.716a.25.25 0 00-.248-.216H1.75A.75.75 0 011 1.75zM6 17.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15.5 19a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
        </svg>
        Reorder
    </button>
</div>
