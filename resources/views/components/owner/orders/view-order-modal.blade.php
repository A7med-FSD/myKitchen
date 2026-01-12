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
                        <div class="modal-footer">
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