<x-user.layout>
    <div class="py-8 space-y-16" x-data="offersHandler()">
        {{-- Page Header --}}
        <div class="mb-12 text-center opacity-0"
            x-data="{ shown: false }" x-intersect.threshold.50="shown = true" 
            :class="shown ? 'header-animation' : 'opacity-0'">
            <div class="inline-flex items-center justify-center gap-3 mb-2">
                <div class="p-2 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
                        <path d="M9.375 3a1.875 1.875 0 000 3.75h1.875v4.5H3.375A1.875 1.875 0 011.5 9.375v-.75c0-1.036.84-1.875 1.875-1.875h3.193A3.375 3.375 0 0112 2.753a3.375 3.375 0 015.432 3.997h3.943c1.035 0 1.875.84 1.875 1.875v.75c0 1.036-.84 1.875-1.875 1.875H12.75v-4.5h1.875a1.875 1.875 0 10-1.875-1.875V6.75h-1.5V4.875C11.25 3.839 10.41 3 9.375 3zM11.25 12.75H3v6.75a2.25 2.25 0 002.25 2.25h6v-9zM12.75 12.75v9h6.75a2.25 2.25 0 002.25-2.25v-6.75h-9z" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight">Special Offers</h2>
            </div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Don't miss out on these amazing deals and limited-time promotions!</p>
        </div>

        {{-- Hero Offers Section --}}
        <section class="px-6 xl:px-20" x-show="filteredHeroOffers.length > 0"
                 x-data="{ shown: false }" x-intersect.threshold.20="shown = true" 
                 :class="shown ? 'opacity-100' : 'opacity-0'">
            <div class="mb-8" :class="shown ? 'animate-entrance-col1' : ''">
                <h3 class="text-3xl font-black text-gray-900 mb-2">🎉 Featured Deals</h3>
                <p class="text-gray-600">Exclusive offers on your entire order</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <template x-for="(offer, index) in filteredHeroOffers" :key="offer.id">
                    <x-user.offers.hero-card />
                </template>
            </div>
        </section>

        {{-- Category Offers Section --}}
        <section class="px-6 xl:px-20" x-show="filteredCategoryOffers.length > 0"
                 x-data="{ shown: false }" x-intersect.threshold.20="shown = true" 
                 :class="shown ? 'opacity-100' : 'opacity-0'">
            <div class="mb-8" :class="shown ? 'animate-entrance-col1' : ''">
                <h3 class="text-3xl font-black text-gray-900 mb-2">🍽️ Category Deals</h3>
                <p class="text-gray-600">Special discounts on your favorite categories</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <template x-for="(offer, index) in filteredCategoryOffers" :key="offer.id">
                    <x-user.offers.category-card />
                </template>
            </div>
        </section>

        {{-- Dish Offers Section (Carousel) --}}
        <section class="px-6 xl:px-20" x-show="filteredDishOffers.length > 0"
                 x-data="{ shown: false }" x-intersect.threshold.20="shown = true" 
                 :class="shown ? 'opacity-100' : 'opacity-0'">
            <div class="mb-8" :class="shown ? 'animate-entrance-col1' : ''">
                <h3 class="text-3xl font-black text-gray-900 mb-2">⚡ Limited Time Deals</h3>
                <p class="text-gray-600">Grab these discounted dishes before they're gone!</p>
            </div>
            
            {{-- Carousel Container --}}
            <div class="relative" 
                 x-data="{ 
                    scrollContainer: null,
                    canScrollLeft: false,
                    canScrollRight: true,
                    checkScroll() {
                        if (!this.scrollContainer) return;
                        this.canScrollLeft = this.scrollContainer.scrollLeft > 0;
                        this.canScrollRight = Math.ceil(this.scrollContainer.scrollLeft + this.scrollContainer.clientWidth) < this.scrollContainer.scrollWidth;
                    }
                 }" 
                 x-init="
                    scrollContainer = $refs.dishScroll;
                    $nextTick(() => checkScroll());
                 ">
                {{-- Left Arrow --}}
                <button @click="scrollContainer.scrollBy({ left: -300, behavior: 'smooth' })"
                        x-show="canScrollLeft"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-2"
                        class="absolute cursor-pointer left-0 top-1/2 -translate-y-1/2 z-10 bg-white hover:bg-yellow-400 text-gray-700 hover:text-gray-900 rounded-full p-4 shadow-lg transition-all duration-300 hover:scale-110 border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M15.75 19.5L8.25 12l7.5-7.5" stroke-width="2.5" />
                    </svg>
                </button>
                
                {{-- Right Arrow --}}
                <button @click="scrollContainer.scrollBy({ left: 300, behavior: 'smooth' })"
                        x-show="canScrollRight"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 translate-x-2"
                        class="absolute cursor-pointer right-0 top-1/2 -translate-y-1/2 z-10 bg-white hover:bg-yellow-400 text-gray-700 hover:text-gray-900 rounded-full p-4 shadow-lg transition-all duration-300 hover:scale-110 border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M8.25 4.5l7.5 7.5-7.5 7.5" stroke-width="2.5" />
                    </svg>
                </button>
                
                {{-- Scrollable Container --}}
                <div x-ref="dishScroll" 
                     @scroll.debounce.50ms="checkScroll()"
                     class="flex gap-6 overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 px-12">
                    <template x-for="(offer, index) in filteredDishOffers" :key="offer.id">
                        <x-user.offers.dish-card />
                    </template>
                </div>
            </div>
        </section>

        {{-- No Offers Message --}}
        <div x-show="filteredHeroOffers.length === 0 && filteredCategoryOffers.length === 0 && filteredDishOffers.length === 0" 
             x-transition
             class="text-center py-20 px-6">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-gray-400">
                    <path d="M9.375 3a1.875 1.875 0 000 3.75h1.875v4.5H3.375A1.875 1.875 0 011.5 9.375v-.75c0-1.036.84-1.875 1.875-1.875h3.193A3.375 3.375 0 0112 2.753a3.375 3.375 0 015.432 3.997h3.943c1.035 0 1.875.84 1.875 1.875v.75c0 1.036-.84 1.875-1.875 1.875H12.75v-4.5h1.875a1.875 1.875 0 10-1.875-1.875V6.75h-1.5V4.875C11.25 3.839 10.41 3 9.375 3zM11.25 12.75H3v6.75a2.25 2.25 0 002.25 2.25h6v-9zM12.75 12.75v9h6.75a2.25 2.25 0 002.25-2.25v-6.75h-9z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No active offers at the moment</h3>
            <p class="text-gray-600">Check back soon for exciting deals and promotions!</p>
        </div>
    </div>

    {{-- Include offers.js --}}
    <script src="{{ asset('assets/js/user/offers.js') }}"></script>
</x-user.layout>
