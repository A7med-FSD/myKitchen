<div x-show="showAddDishModal" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
    @click="closeAddDishModal()"
    style="display: none;">
    
    <div x-show="showAddDishModal"
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
            <h3 class="text-2xl font-bold text-gray-900">Add New Dish</h3>
            <p class="text-gray-900/80 text-sm mt-1">Add a delicious item to your menu</p>
            <button @click="closeAddDishModal()" class="absolute top-4 right-4 text-gray-900/60 hover:text-gray-900 hover:bg-white/20 rounded-full p-2 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="overflow-y-auto flex-1">
        {{-- Modal Body --}}
        <div class="p-6 space-y-5">
            
            {{-- Image Upload Section --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Dish Image <span class="text-red-500">*</span>
                </label>
                
                {{-- Upload Area --}}
                <div x-data="{ isDragging: false }"
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    @drop.prevent="isDragging = false; handleImageUpload($event)"
                    :class="isDragging ? 'border-yellow-400 bg-yellow-50' : dishErrors.image ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-gray-50'"
                    class="relative border-2 border-dashed rounded-2xl transition-all duration-300 overflow-hidden hover:border-yellow-400 hover:text-yellow-600 hover:bg-yellow-50">
                    
                    {{-- Preview --}}
                    <div x-show="newDish.imagePreview" class="relative">
                        <img :src="newDish.imagePreview" alt="Preview" class="w-full h-64 rounded-4xl p-5 object-cover">
                        <div class="absolute inset-0"></div>
                        <button @click="removeImage()" 
                                type="button"
                                class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full transition-colors cursor-pointer shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    
                    {{-- Upload Prompt --}}
                    <div x-show="!newDish.imagePreview" 
                         class="p-8 text-center cursor-pointer"
                         @click="$refs.fileInput.click()">
                        <div class="mx-auto w-16 h-16 mb-4 text-gray-400 transition-transform duration-300"
                             :class="isDragging ? 'scale-110 text-yellow-500' : ''">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>
                        <p class="text-base font-medium text-gray-700 mb-1">
                            <span class="text-yellow-600">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500">JPG, PNG or WebP (MAX. 5MB)</p>
                    </div>
                    
                    <input type="file" 
                           x-ref="fileInput"
                           @change="handleImageUpload($event)"
                           accept="image/jpeg,image/png,image/webp"
                           class="hidden">
                </div>
                
                {{-- Error Message --}}
                <div x-show="dishErrors.image" 
                     x-transition
                     class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="dishErrors.image"></span>
                </div>
            </div>

            {{-- Dish Name --}}
            <div>
                <label for="dishName" class="block text-sm font-medium text-gray-700 mb-1">
                    Dish Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="dishName" 
                       x-model="newDish.name" 
                       @input="dishErrors.name = ''"
                       placeholder="e.g., Grilled Salmon, Chocolate Cake..."
                       :class="dishErrors.name ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                       class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                
                <div x-show="dishErrors.name" 
                     x-transition
                     class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="dishErrors.name"></span>
                </div>
            </div>

            {{-- Price --}}
            <div>
                <label for="dishPrice" class="block text-sm font-medium text-gray-700 mb-1">
                    Price <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">$</span>
                    <input type="number" 
                           id="dishPrice" 
                           x-model="newDish.price" 
                           @input="dishErrors.price = ''"
                           placeholder="0.00"
                           min="0"
                           step="1"
                           :class="dishErrors.price ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                           class="w-full pl-8 pr-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                </div>
                
                <div x-show="dishErrors.price" 
                     x-transition
                     class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="dishErrors.price"></span>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label for="dishDescription" class="block text-sm font-medium text-gray-700 mb-1">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="dishDescription" 
                          x-model="newDish.description" 
                          @input="dishErrors.description = ''"
                          placeholder="Describe your dish in a few words..."
                          maxlength="200"
                          rows="3"
                          :class="dishErrors.description ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                          class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300 resize-none"></textarea>
                <div class="flex items-center justify-between mt-1">
                    <div x-show="dishErrors.description" 
                         x-transition
                         class="flex items-center gap-2 text-xs text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <span x-text="dishErrors.description"></span>
                    </div>
                    <span class="text-xs text-gray-400" x-text="(newDish.description?.length || 0) + '/200'"></span>
                </div>
            </div>

            {{-- Category Dropdown --}}
            <div x-data="{ categoryOpen: false }">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Category <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <button @click="categoryOpen = !categoryOpen" 
                            type="button"
                            :class="dishErrors.category ? 'border-red-400' : newDish.category ? 'border-yellow-400' : 'border-gray-200'"
                            class="w-full px-4 py-2 rounded-xl border focus:ring-2 focus:ring-yellow-100 outline-none transition-all bg-white text-left flex items-center justify-between cursor-pointer">
                        <span :class="newDish.category ? 'text-gray-900' : 'text-gray-400'" x-text="newDish.category || 'Select Category'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400 transition-transform" :class="categoryOpen ? 'rotate-180' : ''">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div x-show="categoryOpen" 
                         @click.away="categoryOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                        <template x-for="cat in categories.filter(c => c.name !== 'All')" :key="cat.name">
                            <button @click="newDish.category = cat.name; categoryOpen = false; dishErrors.category = ''"
                                    type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-yellow-50 transition-colors flex items-center gap-2 cursor-pointer"
                                    :class="newDish.category === cat.name ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700'">
                                <span class="text-xl" x-text="cat.icon"></span>
                                <span x-text="cat.name"></span>
                            </button>
                        </template>
                    </div>
                </div>
                
                <div x-show="dishErrors.category" 
                     x-transition
                     class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="dishErrors.category"></span>
                </div>
            </div>

            {{-- Prep Time --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Preparation Time <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2 mb-2">
                    <button @click="newDish.prepTime = 15" 
                            type="button"
                            :class="newDish.prepTime === 15 ? 'bg-yellow-400 text-gray-900 border-yellow-400' : 'bg-white text-gray-600 border-gray-200 hover:border-yellow-300'"
                            class="flex-1 px-3 py-2 rounded-lg border-2 font-medium transition-all cursor-pointer">15 min</button>
                    <button @click="newDish.prepTime = 30" 
                            type="button"
                            :class="newDish.prepTime === 30 ? 'bg-yellow-400 text-gray-900 border-yellow-400' : 'bg-white text-gray-600 border-gray-200 hover:border-yellow-300'"
                            class="flex-1 px-3 py-2 rounded-lg border-2 font-medium transition-all cursor-pointer">30 min</button>
                    <button @click="newDish.prepTime = 45" 
                            type="button"
                            :class="newDish.prepTime === 45 ? 'bg-yellow-400 text-gray-900 border-yellow-400' : 'bg-white text-gray-600 border-gray-200 hover:border-yellow-300'"
                            class="flex-1 px-3 py-2 rounded-lg border-2 font-medium transition-all cursor-pointer">45 min</button>
                    <button @click="newDish.prepTime = 60" 
                            type="button"
                            :class="newDish.prepTime === 60 ? 'bg-yellow-400 text-gray-900 border-yellow-400' : 'bg-white text-gray-600 border-gray-200 hover:border-yellow-300'"
                            class="flex-1 px-3 py-2 rounded-lg border-2 font-medium transition-all cursor-pointer">60 min</button>
                </div>
                <div class="relative">
                    <input type="number" 
                           x-model="newDish.prepTime" 
                           min="1"
                           step="5"
                           placeholder="Custom time"
                           class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-100 outline-none transition-all placeholder:text-gray-300">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">minutes</span>
                </div>
            </div>

            {{-- Badge Dropdown --}}
            <div x-data="{ badgeOpen: false }">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Badge <span class="text-gray-400 text-xs">(Optional)</span>
                </label>
                <div class="relative">
                    <button @click="badgeOpen = !badgeOpen" 
                            type="button"
                            class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-yellow-100 outline-none transition-all bg-white text-left flex items-center justify-between cursor-pointer">
                        <span :class="newDish.badge ? 'text-gray-900' : 'text-gray-400'" x-text="newDish.badge || 'None'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400 transition-transform" :class="badgeOpen ? 'rotate-180' : ''">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div x-show="badgeOpen" 
                         @click.away="badgeOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                        <button @click="newDish.badge = null; badgeOpen = false"
                                type="button"
                                class="w-full px-4 py-2 text-left hover:bg-gray-50 transition-colors cursor-pointer"
                                :class="!newDish.badge ? 'bg-gray-50 text-gray-700' : 'text-gray-600'">
                            None
                        </button>
                        <button @click="newDish.badge = 'new'; badgeOpen = false"
                                type="button"
                                class="w-full px-4 py-2 text-left hover:bg-blue-50 transition-colors cursor-pointer"
                                :class="newDish.badge === 'new' ? 'bg-blue-50 text-blue-700' : 'text-gray-700'">
                            🆕 New
                        </button>
                        <button @click="newDish.badge = 'featured'; badgeOpen = false"
                                type="button"
                                class="w-full px-4 py-2 text-left hover:bg-purple-50 transition-colors cursor-pointer"
                                :class="newDish.badge === 'featured' ? 'bg-purple-50 text-purple-700' : 'text-gray-700'">
                            ⭐ Featured
                        </button>
                        <button @click="newDish.badge = 'recommended'; badgeOpen = false"
                                type="button"
                                class="w-full px-4 py-2 text-left hover:bg-green-50 transition-colors cursor-pointer"
                                :class="newDish.badge === 'recommended' ? 'bg-green-50 text-green-700' : 'text-gray-700'">
                            👍 Recommended
                        </button>
                        <button @click="newDish.badge = 'special'; badgeOpen = false"
                                type="button"
                                class="w-full px-4 py-2 text-left hover:bg-orange-50 transition-colors cursor-pointer"
                                :class="newDish.badge === 'special' ? 'bg-orange-50 text-orange-700' : 'text-gray-700'">
                            ✨ Special
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        {{-- Modal Footer --}}
        <div class="p-6 bg-gray-50 border-t border-gray-200 flex gap-3">
            <button @click="closeAddDishModal()" 
                    type="button"
                    class="flex-1 px-4 py-2.5 rounded-full font-bold text-gray-500 hover:bg-gray-200 hover:text-gray-700 transition-colors cursor-pointer">
                Cancel
            </button>
            <button @click="saveDish()" 
                    type="button"
                    class="flex-1 px-4 py-2.5 rounded-full font-bold bg-yellow-400 text-gray-900 hover:bg-yellow-500 transition-colors shadow-lg shadow-yellow-200 cursor-pointer flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Add Dish
            </button>
        </div>
    </div>
</div>
