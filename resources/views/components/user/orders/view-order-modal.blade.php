{{-- User Order Details Modal --}}
<div x-show="showModal" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="modal-backdrop"
    @click="closeOrderModal()"
    style="display: none;">
    
    <div x-show="showModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
        class="modal-container max-w-2xl"
        @click.stop>
        
        <template x-if="selectedOrder">
            <div>
                {{-- Modal Header --}}
                <div class="modal-header">
                    <div class="relative flex items-center justify-between w-full">
                        <div>
                            <h3 class="modal-header-title" x-text="'Order #' + selectedOrder.id"></h3>
                            <p class="modal-header-subtitle text-gray-700" x-text="selectedOrder.time"></p>
                        </div>
                        <button @click="closeOrderModal()" class="modal-close static">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body-content space-y-6">
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

                    {{-- Order Type --}}
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <h4 class="font-bold text-gray-900 mb-2">Order Details</h4>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Order Type:</span>
                            <span class="text-sm font-semibold text-gray-900" x-text="selectedOrder.type"></span>
                        </div>
                    </div>

                    {{-- Address Section (if delivery) --}}
                    <template x-if="selectedOrder.address">
                        <div class="bg-yellow-50/50 rounded-xl p-4 border border-yellow-100" x-data="{ showMap: false }">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-1">Delivery Address</h4>
                                    <p class="text-xs text-gray-600 leading-relaxed" x-text="selectedOrder.address"></p>
                                </div>
                                <button @click="showMap = !showMap" 
                                        class="text-xs font-bold text-yellow-700 bg-yellow-100 hover:bg-yellow-200 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.625a19.055 19.055 0 0 0 2.274 1.765 11.055 11.055 0 0 0 1.058.583c.013.006.026.01.038.016l.001.001ZM11.165 9.167a1.166 1.166 0 1 1-2.33 0 1.166 1.166 0 0 1 2.33 0Z" clip-rule="evenodd" />
                                    </svg>
                                    <span x-text="showMap ? 'Hide Map' : 'View Map'"></span>
                                </button>
                            </div>
                            
                            {{-- Map with Transition --}}
                            <div x-show="showMap"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="mt-4 rounded-lg overflow-hidden shadow-sm border border-yellow-200"
                                style="display: none;">
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
                    </template>

                    {{-- All Items --}}
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3">Order Items</h4>
                        <div class="space-y-2">
                            <template x-for="(item, index) in selectedOrder.items" :key="index">
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-900" x-text="item.qty"></span>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-900" x-text="item.name"></span>
                                            {{-- Discount Badge --}}
                                            <template x-if="item.originalPrice && item.originalPrice > item.price">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-orange-50 text-orange-600 border border-orange-100">
                                                    Sale
                                                </span>
                                            </template>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        {{-- Original Price --}}
                                        <template x-if="item.originalPrice && item.originalPrice > item.price">
                                            <span class="text-sm text-gray-400 line-through decoration-orange-400 decoration-2" x-text="'$' + item.originalPrice"></span>
                                        </template>
                                        {{-- Current Price --}}
                                        <span class="font-bold text-gray-900" :class="{'text-orange-600': item.originalPrice && item.originalPrice > item.price}">
                                            $<span x-text="item.price"></span>
                                        </span>
                                    </div>
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
                <div class="modal-footer">
                    <button @click="reorderItems(selectedOrder); closeOrderModal()"
                            class="w-full bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-3 rounded-full transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M1 1.75A.75.75 0 011.75 1h1.628a1.75 1.75 0 011.734 1.51L5.18 3a65.25 65.25 0 0113.36 1.412.75.75 0 01.58.875 48.645 48.645 0 01-1.618 6.2.75.75 0 01-.712.513H6a2.503 2.503 0 00-2.292 1.5H17.25a.75.75 0 010 1.5H2.76a.75.75 0 01-.748-.807 4.002 4.002 0 012.716-3.486L3.626 2.716a.25.25 0 00-.248-.216H1.75A.75.75 0 011 1.75zM6 17.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15.5 19a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        Reorder
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
