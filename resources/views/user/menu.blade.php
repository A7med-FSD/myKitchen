<x-user.layout>
    <div class="py-8 space-y-16">
        {{-- Most Ordered Section --}}
        <section x-data="mostOrderedCarousel()" 
                class="relative">
            
            {{-- Carousel Header --}}
            <div class="mb-12 text-center header-animation">
                <div class="inline-flex items-center justify-center gap-3 mb-2">
                    <div class="p-2 bg-orange-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-orange-500">
                            <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.177 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight">Most Ordered</h2>
                </div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Customer favorites that keep everybody coming back for more!</p>
            </div>

            {{-- Carousel Background Wrapper --}}
            <div class="relative  max-w-8xl">
                
                {{-- Carousel Container --}}
                <div class="relative px-4 py-8">
                    {{-- Left Arrow --}}
                    <button @click="handleManualPrev()"
                            :disabled="!canGoPrev"
                            :class="canGoPrev ? 'translate-x-0 opacity-100 hover:bg-yellow-400 hover:text-gray-900 cursor-pointer shadow-lg' : '-translate-x-4 opacity-0 pointer-events-none'"
                            class="absolute left-30 top-1/2 -translate-y-1/2 z-20 bg-white text-gray-700 rounded-full p-4 transition-all duration-300 group border border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    {{-- Right Arrow --}}
                    <button @click="handleManualNext()"
                            :disabled="!canGoNext"
                            :class="canGoNext ? 'translate-x-0 opacity-100 hover:bg-yellow-400 hover:text-gray-900 cursor-pointer shadow-lg' : 'translate-x-4 opacity-0 pointer-events-none'"
                            class="absolute right-30 top-1/2 -translate-y-1/2 z-20 bg-white text-gray-700 rounded-full p-4 transition-all duration-300 group border border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>

                    {{-- Carousel Track Wrapper (overflow hidden) --}}
                    <div class="overflow-x-hidden rounded-2xl max-w-252 mx-auto h-104">
                        {{-- Carousel Track --}}
                        <div class="flex gap-4 transition-transform duration-500 ease-in-out"
                             :style="`transform: translateX(${translateX})`">
                            
                            {{-- Dish Cards --}}
                            <template x-for="(dish, index) in dishes" :key="dish.id">
                                <div class="flex-shrink-0 w-80">
                                    <x-user.menu.dish-card />
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Placeholder for future sections --}}
        {{-- Main Menu Section --}}
        <section id="main-menu" class="py-20 max-w-8xl px-10" x-data="mainMenuHandler()">
            {{-- Section Header --}}
            <div class="mb-12 text-center opacity-0"
                x-data="{ shown: false }" x-intersect.threshold.50="shown = true" 
                :class="shown ? 'header-animation' : 'opacity-0'">
                <div class="inline-flex items-center justify-center gap-3 mb-2">
                    <div class="p-2 bg-yellow-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-yellow-600">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight">Main Menu</h2>
                </div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Explore our diverse menu featuring daily specials and family favorites.</p>
            </div>

            {{-- Search and Badge Filter --}}
            <div class="px-6 xl:px-60 mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center">
                    {{-- Search Component --}}
                    <x-search :searchplacehold="'Search dishes...'" :filter="'filter in [\'All\', \'Name\', \'Description\']'" />
                    
                    {{-- Badge Dropdown --}}
                    <div x-data="{ badgeOpen: false }" class="relative">
                        <button @click="badgeOpen = !badgeOpen" 
                                type="button"
                                class="w-full md:w-auto px-6 py-3 rounded-full border border-gray-200 bg-white focus:ring-2 focus:ring-yellow-100 outline-none transition-all text-left flex items-center justify-between gap-3 cursor-pointer shadow-sm hover:border-yellow-300"
                                :class="selectedBadge ? 'border-yellow-400' : 'border-gray-200'">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                                    <path fill-rule="evenodd" d="M10 2c-1.716 0-3.408.106-5.07.31C3.806 2.45 3 3.414 3 4.517V17.25a.75.75 0 0 0 1.075.676L10 15.082l5.925 2.844A.75.75 0 0 0 17 17.25V4.517c0-1.103-.806-2.068-1.93-2.207A41.403 41.403 0 0 0 10 2Z" clip-rule="evenodd" />
                                </svg>
                                <span :class="selectedBadge ? 'text-gray-900 font-semibold' : 'text-gray-500'" x-text="selectedBadge ? selectedBadge.charAt(0).toUpperCase() + selectedBadge.slice(1) : 'Badge Filter'"></span>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400 transition-transform" :class="badgeOpen ? 'rotate-180' : ''">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="badgeOpen" 
                             @click.away="badgeOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute z-10 w-full md:w-56 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden"
                             style="display: none;">
                            <button @click="selectedBadge = null; badgeOpen = false"
                                    type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-gray-50 transition-colors cursor-pointer"
                                    :class="!selectedBadge ? 'bg-gray-50 text-gray-700 font-semibold' : 'text-gray-600'">
                                All
                            </button>
                            <button @click="selectedBadge = 'new'; badgeOpen = false"
                                    type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-green-50 transition-colors cursor-pointer"
                                    :class="selectedBadge === 'new' ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700'">
                                🆕 New
                            </button>
                            <button @click="selectedBadge = 'featured'; badgeOpen = false"
                                    type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-purple-50 transition-colors cursor-pointer"
                                    :class="selectedBadge === 'featured' ? 'bg-purple-50 text-purple-700 font-semibold' : 'text-gray-700'">
                                ⭐ Featured
                            </button>
                            <button @click="selectedBadge = 'recommended'; badgeOpen = false"
                                    type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-blue-50 transition-colors cursor-pointer"
                                    :class="selectedBadge === 'recommended' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700'">
                                👍 Recommended
                            </button>
                            <button @click="selectedBadge = 'special'; badgeOpen = false"
                                    type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-yellow-50 transition-colors cursor-pointer"
                                    :class="selectedBadge === 'special' ? 'bg-yellow-50 text-yellow-700 font-semibold' : 'text-gray-700'">
                                ✨ Special
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Category Filters --}}
            <div class="max-w-7xl px-6 mb-8">
                <x-user.menu.category-filter />
            </div>

            {{-- Menu Grid --}}
            <div class=" px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <template x-for="(dish, index) in filteredDishes" :key="dish.id">
                        <div x-data="{ shown: false }" 
                             x-intersect.threshold.10="shown = true"
                             :class="shown ? 'animate-entrance-card' : 'opacity-0'" 
                             :style="'animation-delay: ' + ((index % 4) * 100) + 'ms'">
                            <x-user.menu.dish-card />
                        </div>
                    </template>
                </div>

                {{-- No Results Message --}}
                <div x-show="filteredDishes.length === 0" 
                     x-transition
                     class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-gray-400">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No dishes found</h3>
                    <p class="text-gray-600">Try adjusting your filters or search terms.</p>
                </div>
            </div>
            
        </section>
        
        
        {{-- Customer Reviews Section --}}
        <section id="customer-reviews" class="py-20" x-data="customerReviews()">
            {{-- Section Header --}}
            <div class="mb-12 text-center opacity-0"
                x-data="{ shown: false }" x-intersect.threshold.50="shown = true" 
                :class="shown ? 'header-animation' : 'opacity-0'">
                <div class="inline-flex items-center justify-center gap-3 mb-2">
                    <div class="p-2 bg-purple-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-purple-600">
                            <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 00-1.032-.211 50.89 50.89 0 00-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 002.433 3.984L7.28 21.53A.75.75 0 016 21v-4.03a48.527 48.527 0 01-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979z" />
                            <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 001.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0015.75 7.5z" />
                        </svg>
                    </div>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight">Customer Reviews</h2>
                </div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">See what our happy customers are saying about their favorite dishes!</p>
            </div>

            {{-- Reviews Grid --}}
            <div class="px-3">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="(review, index) in reviews" :key="review.id">
                        <div x-data="{ shown: false }" 
                             x-intersect.threshold.10="shown = true"
                             :class="shown ? 'animate-entrance-card' : 'opacity-0'" 
                             :style="'animation-delay: ' + ((index % 3) * 100) + 'ms'">
                            <x-user.menu.review-card />
                        </div>
                    </template>
                </div>
            </div>
        </section>
    </div>

    {{-- Include menu.js --}}
    <script src="{{ asset('assets/js/user/menu.js') }}"></script>
</x-user.layout>
