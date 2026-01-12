<div x-show="showAddItemModal" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="modal-backdrop"
    @click="closeAddItemModal()"
    style="display: none;">
    
    <div x-show="showAddItemModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
        class="modal-container"
        @click.stop>
        
        {{-- Modal Header --}}
        <div class="modal-header">
            <h3 class="modal-header-title">Add Inventory Item</h3>
            <p class="modal-header-subtitle">Add a new item to your stock</p>
            <button @click="closeAddItemModal()" class="modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="modal-body">
        {{-- Modal Body --}}
        <div class="modal-body-content">
            
            {{-- Item Name --}}
            <div>
                <label for="itemName" class="block text-sm font-medium text-gray-700 mb-1">
                    Item Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="itemName" 
                       x-model="newItem.name" 
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
                           x-model="newItem.category"
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
                        <template x-for="cat in categories.filter(c => c !== 'All' && c.toLowerCase().includes((newItem.category || '').toLowerCase()))" :key="cat">
                            <button @click="newItem.category = cat; categoryOpen = false; itemErrors.category = ''"
                                    type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-yellow-50 transition-colors cursor-pointer"
                                    :class="newItem.category === cat ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700'">
                                <span x-text="cat"></span>
                            </button>
                        </template>
                        <div x-show="categories.filter(c => c !== 'All' && c.toLowerCase().includes((newItem.category || '').toLowerCase())).length === 0" class="px-4 py-2 text-sm text-gray-400 italic">
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
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="quantity" 
                           x-model="newItem.quantity" 
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
                            <span class="text-gray-900" x-text="newItem.unit"></span>
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
                                <button @click="newItem.unit = unit; unitOpen = false"
                                        type="button"
                                        class="w-full px-4 py-2 text-left hover:bg-yellow-50 transition-colors cursor-pointer"
                                        :class="newItem.unit === unit ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700'">
                                    <span x-text="unit"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Price per Unit --}}
            <div>
                <label for="pricePerUnit" class="block text-sm font-medium text-gray-700 mb-1">
                    Price per Unit <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">$</span>
                    <input type="number" 
                           id="pricePerUnit" 
                           x-model="newItem.pricePerUnit" 
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
                <label for="lowStockThreshold" class="block text-sm font-medium text-gray-700 mb-1">
                    Low Stock Alert Threshold
                </label>
                <input type="number" 
                        id="lowStockThreshold" 
                        x-model="newItem.lowStockThreshold" 
                        placeholder="10"
                        min="0"
                        max="1000"
                        step="1"
                        class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-100 outline-none transition-all placeholder:text-gray-300">
                <p class="text-xs text-gray-400 mt-1">You'll be alerted when stock falls to or below this amount</p>
            </div>
        </div>
        </div>

        {{-- Modal Footer --}}
        <div class="modal-footer">
            <button @click="closeAddItemModal()" 
                    type="button"
                    class="modal-btn-cancel">
                Cancel
            </button>
            <button @click="saveItem()" 
                    type="button"
                    class="modal-btn-submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                </svg>
                Add Item
            </button>
        </div>
    </div>
</div>
