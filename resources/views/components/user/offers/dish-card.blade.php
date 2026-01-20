{{-- Dish Offer Card Component - Compact for Carousel --}}
{{-- Used in x-for loop, 'offer' and 'index' available from Alpine scope --}}

<div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 group overflow-hidden min-w-[280px]"
     :class="'animate-entrance-card animate-delay-' + (index * 100)"
     x-data="{ shown: false }" 
     x-intersect.threshold.20="shown = true"
     :class="shown ? 'opacity-100' : 'opacity-0'">
    
    {{-- Dish Image --}}
    <div class="relative h-48 overflow-hidden">
        <img :src="offer.image" :alt="offer.dishName" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        
        {{-- Overlay gradient for better text readability if needed --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
        
        {{-- Discount Badge --}}
        <div class="absolute top-3 right-3">
            <div class="bg-orange-500 text-white rounded-full px-3 py-1.5 shadow-lg animate-pulse">
                <span class="text-sm font-black" x-text="offer.discount + '% OFF'"></span>
            </div>
        </div>
        
        {{-- Countdown Badge --}}
        <div class="absolute bottom-3 left-3">
            <div class="bg-black/70 backdrop-blur-sm text-white rounded-lg px-2 py-1 text-xs font-bold" :class="isExpiringSoon(offer.validUntil) ? 'bg-red-600' : ''">
                <span x-text="getCountdown(offer.validUntil)"></span>
            </div>
        </div>
    </div>
    
    {{-- Content --}}
    <div class="p-5 space-y-4">
        {{-- Dish Name --}}
        <h4 class="text-lg font-bold text-gray-900 line-clamp-2" x-text="offer.dishName"></h4>
        
        {{-- Pricing --}}
        <div class="flex items-end gap-3">
            <div class="text-3xl font-black text-yellow-500" x-text="'$' + offer.discountedPrice.toFixed(2)"></div>
            <div class="text-lg text-gray-400 line-through decoration-2 mb-1" x-text="'$' + offer.originalPrice.toFixed(2)"></div>
        </div>
        
        {{-- Savings Badge --}}
        <div class="inline-flex items-center gap-1 bg-green-50 text-green-700 rounded-full px-3 py-1 text-sm font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            <span x-text="'Save $' + (offer.originalPrice - offer.discountedPrice).toFixed(2)"></span>
        </div>
        
        {{-- Add to Cart Button --}}
        <button @click.stop="
                    const cartItem = {
                        id: 'offer-' + offer.id,
                        name: offer.dishName,
                        price: offer.discountedPrice,
                        image: offer.image,
                        discount: 0
                    };
                    $store.cart.add(cartItem);
                "
                :class="$store.cart.has('offer-' + offer.id) 
                    ? 'bg-green-500 text-white cursor-default shadow-md' 
                    : 'bg-yellow-400 hover:bg-yellow-500 text-gray-900 cursor-pointer shadow-md hover:scale-105'"
                class="w-40 h-12 m-auto flex items-center justify-center gap-2 rounded-full transition-all duration-300 font-bold"
                :disabled="$store.cart.has('offer-' + offer.id)">
            
            <template x-if="!$store.cart.has('offer-' + offer.id)">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path d="M1 1.75A.75.75 0 011.75 1h1.628a1.75 1.75 0 011.734 1.51L5.18 3a65.25 65.25 0 0113.36 1.412.75.75 0 01.58.875 48.645 48.645 0 01-1.618 6.2.75.75 0 01-.712.513H6a2.503 2.503 0 00-2.292 1.5H17.25a.75.75 0 010 1.5H2.76a.75.75 0 01-.748-.807 4.002 4.002 0 012.716-3.486L3.626 2.716a.25.25 0 00-.248-.216H1.75A.75.75 0 011 1.75zM6 17.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15.5 19a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                    <span>Add to Cart</span>
                </div>
            </template>
            
            <template x-if="$store.cart.has('offer-' + offer.id)">
                <div class="flex items-center gap-2">
                    <span x-text="'Added'"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </template>
        </button>
    </div>
</div>
