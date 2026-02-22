<x-owner.layout>
    <!-- Alpine.js Component -->
    <script src="{{ asset('assets/js/owner/menu.js') }}"></script>

    <div class="space-y-6 pb-20" x-data="menuHandler()">
        <!-- Header with Heading and Search -->
        <x-owner.heading>
            <x-slot:title>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-yellow-500">
                    <path d="M11.25 4.53286C9.73455 3.56279 7.93246 3 6 3C4.86178 3 3.76756 3.19535 2.75007 3.55499C2.45037 3.66091 2.25 3.94425 2.25 4.26212V18.5121C2.25 18.7556 2.36818 18.9839 2.56696 19.1245C2.76574 19.265 3.02039 19.3004 3.24993 19.2192C4.10911 18.9156 5.03441 18.75 6 18.75C7.99502 18.75 9.82325 19.4573 11.25 20.6357V4.53286Z" />
                    <path d="M12.75 20.6357C14.1768 19.4573 16.005 18.75 18 18.75C18.9656 18.75 19.8909 18.9156 20.7501 19.2192C20.9796 19.3004 21.2343 19.265 21.433 19.1245C21.6318 18.9839 21.75 18.7556 21.75 18.5121V4.26212C21.75 3.94425 21.5496 3.66091 21.2499 3.55499C20.2324 3.19535 19.1382 3 18 3C16.0675 3 14.2655 3.56279 12.75 4.53286V20.6357Z" />
                </svg>
                Menu Management
            </x-slot:title>
            <x-slot:subtitle>Manage your restaurant menu items</x-slot:subtitle>
            
            <x-slot:searchplacehold>Search menu....</x-slot:searchplacehold>
            <x-slot:filter>filter in searchFilters</x-slot:filter>
            
            {{-- Badge Filter Dropdown --}}
            <div class="relative w-full md:w-52" x-data="{ badgeOpen: false }">
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
        </x-owner.heading>
        <!-- Category Filters -->
        <x-owner.menu.filter-category />

        <!-- Menu Items Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Item Card Component (Now handles the loop internally) -->
            <x-owner.menu.item-card />
        </div>

        <!-- Empty State -->
        <div x-show="filteredDishes.length === 0" class="text-center py-20" style="display: none;">
            <div class="text-6xl mb-4">🍽️</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No dishes found</h3>
            <p class="text-gray-500 mb-6">Try selecting a different category or search term</p>
            
            <!-- Add Items Button (When search is empty and no items) -->
            <div x-show="searchQuery.trim() === '' && filteredDishes.length === 0" class="mb-4">
                <button @click="openAddDishModal()" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Add Items
                </button>
            </div>
            
            <!-- Remove Category Button (Only for empty custom categories) -->
            <div x-show="selectedCategory !== 'All' && filteredDishes.length === 0 && searchQuery.trim() === ''">
                <button @click="removeCategory()" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-50 text-red-600 rounded-full font-semibold hover:bg-red-100 hover:text-red-700 transition-all border-2 border-red-200 hover:border-red-300 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                    </svg>
                    Remove This Category
                </button>
                <p class="text-xs text-gray-400 mt-3">This will permanently delete the "<span x-text="selectedCategory"></span>" category</p>
            </div>
        </div>

        <!-- Floating Add Dish Button -->
        <button @click="openAddDishModal()" 
                class="btn-primary fixed bottom-8 left-8 p-4 shadow-2xl hover:scale-110 z-40 group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 group-hover:rotate-90 transition-transform duration-300">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
            </svg>
        </button>
        
        <!-- Add Category Modal -->
        <x-owner.menu.add-category-modal />
        
        <!-- Add Dish Modal -->
        <x-owner.menu.add-dish-modal />
        
        <!-- Edit Dish Modal -->
        <x-owner.menu.edit-dish-modal />
        
        <!-- Delete Confirmation Modal -->
        <x-owner.menu.delete-confirmation-modal />
        
        <!-- Update Confirmation Modal -->
        <x-owner.menu.update-confirmation-modal />
    </div>
</x-owner.layout>
