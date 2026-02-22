{{-- Delete Confirmation Modal --}}
<div x-show="showDeleteConfirmModal" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    @click="showDeleteConfirmModal = false"
    style="display: none;">
    
    <div x-show="showDeleteConfirmModal"
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
            {{-- Warning Icon --}}
            <div class="flex justify-center mb-4">
                <div class="relative">
                    {{-- Pulsing Background --}}
                    <div class="absolute inset-0 bg-white/30 rounded-full animate-ping"></div>
                    {{-- Icon Container --}}
                    <div class="relative bg-white/20 backdrop-blur-sm p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12 text-white drop-shadow-lg">
                            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
            
            {{-- Title --}}
            <h3 class="text-2xl font-black text-white text-center drop-shadow-sm">
                Delete Dish?
            </h3>
            <p class="text-white/90 text-center text-sm mt-2 font-medium">
                This action cannot be undone
            </p>
            
            {{-- Close Button --}}
            <button @click="showDeleteConfirmModal = false" 
                    class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors bg-white/10 hover:bg-white/20 rounded-full p-1.5 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="p-6 space-y-4">
            {{-- Dish Preview Card --}}
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100" x-show="dishToDelete">
                <div class="flex items-start gap-4">
                    {{-- Dish Image --}}
                    <div class="relative w-20 h-20 rounded-xl overflow-hidden shrink-0 border-2 border-white shadow-sm">
                        <img :src="dishToDelete?.image" 
                             :alt="dishToDelete?.name" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-red-500/10"></div>
                    </div>
                    
                    {{-- Dish Info --}}
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-gray-900 text-lg leading-tight truncate" x-text="dishToDelete?.name"></h4>
                        <p class="text-sm text-gray-500 line-clamp-2 mt-1" x-text="dishToDelete?.description"></p>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-yellow-500 font-bold text-sm" x-text="'$' + dishToDelete?.price"></span>
                            <span class="text-xs text-gray-400">•</span>
                            <span class="text-xs text-gray-500" x-text="dishToDelete?.category"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Warning Message --}}
            <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                <div class="flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-red-500 shrink-0 mt-0.5">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-red-800 mb-1">Are you absolutely sure?</p>
                        <p class="text-xs text-red-600 leading-relaxed">
                            This dish will be permanently removed from your menu. This action cannot be reversed.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="p-6 pt-0 flex gap-3">
            {{-- Cancel Button --}}
            <button @click="showDeleteConfirmModal = false" 
                    type="button"
                    class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-full transition-all duration-300 hover:shadow-md cursor-pointer">
                Cancel
            </button>
            
            {{-- Delete Button --}}
            <button @click="confirmDeleteDish()" 
                    type="button"
                    class="flex-1 px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-full transition-all duration-300 hover:shadow-lg shadow-md hover:scale-105 cursor-pointer flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5z" clip-rule="evenodd" />
                </svg>
                Delete Dish
            </button>
        </div>
    </div>
</div>
