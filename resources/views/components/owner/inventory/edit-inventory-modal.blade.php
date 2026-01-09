<div x-show="showEditItemModal" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
    @click="closeEditItemModal()"
    style="display: none;">
    
    <div x-show="showEditItemModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
        class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden flex flex-col max-h-[90vh]"
        @click.stop>
        
        {{-- Modal Header --}}
        <div class="bg-linear-to-r from-yellow-400 to-orange-400 p-6 relative">
            <h3 class="text-2xl font-bold text-gray-900">Edit Inventory Item</h3>
            <p class="text-gray-900/80 text-sm mt-1">Update item details and stock</p>
            <button @click="closeEditItemModal()" class="absolute top-4 right-4 text-gray-900/60 hover:text-gray-900 hover:bg-white/20 rounded-full p-2 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="overflow-y-auto flex-1">
        {{-- Modal Body --}}
        <div class="p-6 space-y-5">
            
            {{-- Item Name --}}
            <div>
                <label for="editItemName" class="block text-sm font-medium text-gray-700 mb-1">
                    Item Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="editItemName" 
                       x-model="editItem.name" 
                       @input="itemErrors.name = ''"
                       placeholder="e.g., Tomatoes, Chicken, Rice..."
                       :class="itemErrors.name ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                       class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                
                <div x-show="itemErrors.name" 
                     x-transition
                     class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="itemErrors.name"></span>
                </div>
            </div>

            {{-- Category Input (Autocomplete) --}}
            <div x-data="{ categoryOpen: false }">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Category <span class="text-red-500">*</span>
                </label>
                <div class="relative" @click.away="categoryOpen = false">
                    <input type="text"
                           x-model="editItem.category"
                           @focus="categoryOpen = true"
                           @input="categoryOpen = true; itemErrors.category = ''"
                           placeholder="Type to search or add new..."
                           :class="itemErrors.category ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                           class="w-full pl-4 pr-10 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                    
                    <!-- Dropdown Arrow -->
                    <button @click="categoryOpen = !categoryOpen" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 transition-transform" :class="categoryOpen ? 'rotate-180' : ''">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div x-show="categoryOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                        <template x-for="cat in categories.filter(c => c !== 'All' && c.toLowerCase().includes((editItem.category || '').toLowerCase()))" :key="cat">
                            <button @click="editItem.category = cat; categoryOpen = false; itemErrors.category = ''"
                                    type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-yellow-50 transition-colors cursor-pointer"
                                    :class="editItem.category === cat ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700'">
                                <span x-text="cat"></span>
                            </button>
                        </template>
                        <div x-show="categories.filter(c => c !== 'All' && c.toLowerCase().includes((editItem.category || '').toLowerCase())).length === 0" class="px-4 py-2 text-sm text-gray-400 italic">
                            New category will be created
                        </div>
                    </div>
                </div>
                
                <div x-show="itemErrors.category" 
                     x-transition
                     class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="itemErrors.category"></span>
                </div>
            </div>

            {{-- Quantity & Unit --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="editQuantity" class="block text-sm font-medium text-gray-700 mb-1">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="editQuantity" 
                           x-model="editItem.quantity" 
                           @input="itemErrors.quantity = ''"
                           placeholder="0"
                           min="0"
                           step="0.1"
                           :class="itemErrors.quantity ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                           class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                    
                    <div x-show="itemErrors.quantity" 
                         x-transition
                         class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <span x-text="itemErrors.quantity"></span>
                    </div>
                </div>

                <div x-data="{ unitOpen: false }">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Unit <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <button @click="unitOpen = !unitOpen" 
                                type="button"
                                class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-yellow-100 outline-none transition-all bg-white text-left flex items-center justify-between cursor-pointer">
                            <span class="text-gray-900" x-text="editItem.unit"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400 transition-transform" :class="unitOpen ? 'rotate-180' : ''">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="unitOpen" 
                             @click.away="unitOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                            <template x-for="unit in units" :key="unit">
                                <button @click="editItem.unit = unit; unitOpen = false"
                                        type="button"
                                        class="w-full px-4 py-2 text-left hover:bg-yellow-50 transition-colors cursor-pointer"
                                        :class="editItem.unit === unit ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700'">
                                    <span x-text="unit"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Price per Unit --}}
            <div>
                <label for="editPricePerUnit" class="block text-sm font-medium text-gray-700 mb-1">
                    Price per Unit <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">$</span>
                    <input type="number" 
                           id="editPricePerUnit" 
                           x-model="editItem.pricePerUnit" 
                           @input="itemErrors.pricePerUnit = ''"
                           placeholder="0.00"
                           min="0"
                           step="0.01"
                           :class="itemErrors.pricePerUnit ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                           class="w-full pl-8 pr-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                </div>
                
                <div x-show="itemErrors.pricePerUnit" 
                     x-transition
                     class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="itemErrors.pricePerUnit"></span>
                </div>
            </div>

            {{-- Low Stock Threshold --}}
            <div>
                <label for="editLowStockThreshold" class="block text-sm font-medium text-gray-700 mb-1">
                    Low Stock Alert Threshold
                </label>
                <input type="number" 
                       id="editLowStockThreshold" 
                       x-model="editItem.lowStockThreshold" 
                       placeholder="10"
                       min="0"
                       step="1"
                       class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-100 outline-none transition-all placeholder:text-gray-300">
                <p class="text-xs text-gray-400 mt-1">You'll be alerted when stock falls to or below this amount</p>
            </div>
        </div>
        </div>

        {{-- Modal Footer --}}
        <div class="p-6 bg-gray-50 border-t border-gray-200 flex gap-3">
            <button @click="deleteItem()" 
                    type="button"
                    class="px-4 py-2.5 rounded-full font-bold text-red-600 hover:bg-red-50 transition-colors cursor-pointer flex items-center gap-2 border-2 border-red-200 hover:border-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                </svg>
                Delete
            </button>
            <button @click="closeEditItemModal()" 
                    type="button"
                    class="flex-1 px-4 py-2.5 rounded-full font-bold text-gray-500 hover:bg-gray-200 hover:text-gray-700 transition-colors cursor-pointer">
                Cancel
            </button>
            <button @click="updateItem()" 
                    type="button"
                    class="flex-1 px-4 py-2.5 rounded-full font-bold bg-yellow-400 text-gray-900 hover:bg-yellow-500 transition-colors shadow-lg shadow-yellow-200 cursor-pointer flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 15zM10 7a3 3 0 100 6 3 3 0 000-6zM15.657 5.404a.75.75 0 10-1.06-1.06l-1.061 1.06a.75.75 0 001.06 1.06l1.06-1.06zM6.464 14.596a.75.75 0 10-1.06-1.06l-1.06 1.06a.75.75 0 001.06 1.06l1.06-1.06zM18 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 0118 10zM5 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 015 10zM14.596 15.657a.75.75 0 001.06-1.06l-1.06-1.061a.75.75 0 10-1.06 1.06l1.06 1.06zM5.404 6.464a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.061 1.06l1.06 1.06z" />
                </svg>
                Update Item
            </button>
        </div>
    </div>
</div>
