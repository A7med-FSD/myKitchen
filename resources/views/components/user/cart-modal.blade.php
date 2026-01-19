{{-- Cart Modal --}}
<div x-data
    x-init="$watch('$store.cart.isOpen', value => document.body.style.overflow = value ? 'hidden' : '')"
    x-show="$store.cart.isOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="$store.cart.toggleModal()"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
    style="display: none;">
    
    {{-- Modal Content --}}
    <div @click.stop
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
        
        {{-- Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-200 shrink-0">
            <h2 class="text-2xl font-black text-gray-900">Your Cart</h2>
            <button @click="$store.cart.toggleModal()" 
                    class="p-2 hover:bg-gray-100 rounded-full transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-gray-500">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                </svg>
            </button>
        </div>
        
        {{-- Body --}}
        <div class="flex-1 overflow-y-auto p-6 overscroll-y-contain scroll-smooth">
            {{-- Empty State --}}
            <template x-if="$store.cart.items.length === 0">
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-500 mb-4">Add some delicious items from our menu!</p>
                    <button @click="$store.cart.toggleModal()" 
                            class="px-6 py-3 cursor-pointer bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded-full transition-colors">
                        Browse Menu
                    </button>
                </div>
            </template>
            
            {{-- Items List --}}
            <template x-if="$store.cart.items.length > 0">
                <div class="space-y-4">
                    <template x-for="item in $store.cart.items" :key="item.id">
                        <div class="flex gap-4 p-4 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors">
                            {{-- Image --}}
                            <img :src="item.image" 
                                 :alt="item.name" 
                                 class="w-20 h-20 object-cover rounded-xl shrink-0">
                            
                            {{-- Details --}}
                            <div class="grow space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="font-bold text-gray-900" x-text="item.name"></h4>
                                    <button @click="$store.cart.remove(item.id)"
                                            class="p-1 hover:bg-red-100 rounded-full transition-colors shrink-0 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-500">
                                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                        </svg>
                                    </button>
                                </div>
                                
                                {{-- Price --}}
                                <div class="flex items-center gap-2">
                                    <template x-if="item.discount">
                                        <div class="flex items-center gap-2">
                                            <span class="text-orange-400 line-through text-sm" x-text="'$' + item.price"></span>
                                            <span class="text-gray-900 font-bold" x-text="'$' + $store.cart.getItemPrice(item)"></span>
                                            <span class="text-xs bg-orange-500 text-white px-2 py-0.5 rounded-full font-bold" x-text="item.discount + '% OFF'"></span>
                                        </div>
                                    </template>
                                    <template x-if="!item.discount">
                                        <span class="text-gray-900 font-bold" x-text="'$' + item.price"></span>
                                    </template>
                                </div>
                                
                                {{-- Quantity Controls --}}
                                <div class="flex items-center gap-3">
                                    <button @click="$store.cart.updateQuantity(item.id, item.quantity - 1)"
                                            :disabled="item.quantity <= 1"
                                            :class="item.quantity <= 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-200'"
                                            class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full transition-colors cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <span class="w-8 text-center font-bold" x-text="item.quantity"></span>
                                    <button @click="$store.cart.updateQuantity(item.id, item.quantity + 1)"
                                            class="w-8 h-8 flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 rounded-full transition-colors cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
        
        {{-- Footer --}}
        <div class="border-t border-gray-200 p-6 space-y-4">
            {{-- Total --}}
            <div class="flex items-center justify-between text-xl font-black">
                <span class="text-gray-600">Total:</span>
                <span class="text-gray-900" x-text="'$' + $store.cart.getTotal()"></span>
            </div>
            
            {{-- Actions --}}
            <div class="flex gap-3">
                <button @click="$store.cart.clear()" 
                        :disabled="!$store.cart.canPlaceOrder()"
                        :class="!$store.cart.canPlaceOrder() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-600'"
                        class="flex-1 px-6 py-3 bg-red-500 text-white font-bold rounded-full transition-colors cursor-pointer">
                    Clear Cart
                </button>
                <button :disabled="!$store.cart.canPlaceOrder()"
                        :class="!$store.cart.canPlaceOrder() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-yellow-500'"
                        class="flex-[2] px-6 py-3 bg-yellow-400 text-gray-900 font-bold rounded-full transition-colors shadow-lg cursor-pointer">
                    Make Order
                </button>
            </div>
        </div>
    </div>
</div>
