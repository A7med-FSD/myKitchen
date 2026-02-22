{{-- Update Confirmation Modal --}}
<div x-show="showUpdateConfirmModal" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    @click="showUpdateConfirmModal = false"
    style="display: none;">
    
    <div x-show="showUpdateConfirmModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
        class="bg-white rounded-4xl shadow-2xl max-w-md w-full overflow-hidden"
        @click.stop>
        
        {{-- Modal Header with Gradient --}}
        <div class="relative p-6 pb-4 bg-gradient-to-br from-yellow-400 via-orange-400 to-orange-500">
            {{-- Update Icon --}}
            <div class="flex justify-center mb-4">
                <div class="relative">
                    {{-- Rotating Background --}}
                    <div class="absolute inset-0 bg-white/30 rounded-full animate-spin" style="animation-duration: 3s;"></div>
                    {{-- Icon Container --}}
                    <div class="relative bg-white/20 backdrop-blur-sm p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12 text-white drop-shadow-lg">
                            <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0015.059-4.035.75.75 0 00-.53-.918z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
            
            {{-- Title --}}
            <h3 class="text-2xl font-black text-white text-center drop-shadow-sm">
                Update Dish?
            </h3>
            <p class="text-white/90 text-center text-sm mt-2 font-medium">
                Review your changes before saving
            </p>
            
            {{-- Close Button --}}
            <button @click="showUpdateConfirmModal = false" 
                    class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors bg-white/10 hover:bg-white/20 rounded-full p-1.5 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="p-6 space-y-4">
            {{-- Updated Dish Preview Card --}}
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                <div class="flex items-start gap-4">
                    {{-- Dish Image --}}
                    <div class="relative w-20 h-20 rounded-xl overflow-hidden shrink-0 border-2 border-white shadow-sm">
                        <img :src="editDish.imagePreview" 
                             :alt="editDish.name" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-yellow-500/10"></div>
                    </div>
                    
                    {{-- Dish Info --}}
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-gray-900 text-lg leading-tight truncate" x-text="editDish.name"></h4>
                        <p class="text-sm text-gray-500 line-clamp-2 mt-1" x-text="editDish.description"></p>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-yellow-500 font-bold text-sm" x-text="'$' + editDish.price"></span>
                            <span class="text-xs text-gray-400">•</span>
                            <span class="text-xs text-gray-500" x-text="editDish.category"></span>
                            <span class="text-xs text-gray-400">•</span>
                            <span class="text-xs text-gray-500" x-text="editDish.prepTime + ' min'"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Message --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                <div class="flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-blue-500 shrink-0 mt-0.5">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-blue-800 mb-1">Ready to save?</p>
                        <p class="text-xs text-blue-600 leading-relaxed">
                            Your changes will be applied immediately and visible to customers on the menu.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Badge Preview (if set) --}}
            <div x-show="editDish.badge" class="flex items-center gap-2 text-xs">
                <span class="text-gray-500 font-medium">Badge:</span>
                <span class="px-2.5 py-1 rounded-full font-bold"
                      :class="{
                          'bg-emerald-100 text-emerald-600': editDish.badge === 'new',
                          'bg-violet-100 text-violet-600': editDish.badge === 'featured',
                          'bg-sky-100 text-sky-600': editDish.badge === 'recommended',
                          'bg-amber-100 text-amber-600': editDish.badge === 'special'
                      }"
                      x-text="editDish.badge ? editDish.badge.charAt(0).toUpperCase() + editDish.badge.slice(1) : ''"></span>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="p-6 pt-0 flex gap-3">
            {{-- Cancel Button --}}
            <button @click="showUpdateConfirmModal = false" 
                    type="button"
                    class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-full transition-all duration-300 hover:shadow-md cursor-pointer">
                Cancel
            </button>
            
            {{-- Update Button --}}
            <button @click="confirmUpdateDish()" 
                    type="button"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white font-bold rounded-full transition-all duration-300 hover:shadow-lg shadow-md hover:scale-105 cursor-pointer flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 15zM10 7a3 3 0 100 6 3 3 0 000-6zM15.657 5.404a.75.75 0 10-1.06-1.06l-1.061 1.06a.75.75 0 001.06 1.06l1.06-1.06zM6.464 14.596a.75.75 0 10-1.06-1.06l-1.06 1.06a.75.75 0 001.06 1.06l1.06-1.06zM18 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 0118 10zM5 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 015 10zM14.596 15.657a.75.75 0 001.06-1.06l-1.06-1.061a.75.75 0 10-1.06 1.06l1.06 1.06zM5.404 6.464a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.061 1.06l1.06 1.06z" />
                </svg>
                Update Dish
            </button>
        </div>
    </div>
</div>
