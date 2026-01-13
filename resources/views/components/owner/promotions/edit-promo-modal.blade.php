<div x-show="showEditPromoModal" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="modal-backdrop"
    @click.self="closeEditPromoModal()"
    style="display: none;">
    
    <div x-show="showEditPromoModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
        class="modal-container">
        
        {{-- Modal Header --}}
        <div class="modal-header">
            <h3 class="modal-header-title">Edit Promotion</h3>
            <p class="modal-header-subtitle">Update promotion details</p>
            <button @click="closeEditPromoModal()" class="modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="modal-body">
        {{-- Modal Body --}}
        <div class="modal-body-content">
            
            {{-- Promo Title --}}
            <div>
                <label for="editPromoTitle" class="block text-sm font-medium text-gray-700 mb-1">
                    Promotion Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="editPromoTitle" 
                       x-model="editPromo.title" 
                       @input="promoErrors.title = ''"
                       placeholder="e.g., Weekend Special, New Year Sale..."
                       :class="promoErrors.title ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                       class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                
                <div x-show="promoErrors.title" 
                     x-transition
                     class="form-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="promoErrors.title"></span>
                </div>
            </div>

            {{-- Promo Code --}}
            <div>
                <label for="editPromoCode" class="block text-sm font-medium text-gray-700 mb-1">
                    Promo Code <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="editPromoCode" 
                       x-model="editPromo.code" 
                       @input="editPromo.code = editPromo.code.toUpperCase(); promoErrors.code = ''"
                       placeholder="e.g., WEEKEND25, SAVE20..."
                       :class="promoErrors.code ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                       class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300 font-mono">
                
                <div x-show="promoErrors.code" 
                     x-transition
                     class="form-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="promoErrors.code"></span>
                </div>
            </div>

            {{-- Discount Type & Value --}}
            <div class="grid grid-cols-2 gap-4">
                {{-- Custom Dropdown for Discount Type --}}
                <div x-data="{ openTypeDropdown: false }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Discount Type <span class="text-red-500">*</span>
                    </label>
                    <button type="button" 
                            @click="openTypeDropdown = !openTypeDropdown"
                            @click.outside="openTypeDropdown = false"
                            class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-yellow-100 outline-none transition-all bg-white text-left flex items-center justify-between cursor-pointer"
                            :class="openTypeDropdown ? 'border-yellow-400 ring-2 ring-yellow-100' : ''">
                        <span x-text="editPromo.discountType === 'percentage' ? 'Percentage (%)' : 'Fixed Amount ($)'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div x-show="openTypeDropdown" 
                         x-transition
                         class="dropdown-menu top-full mt-2 w-full">
                        <button type="button" 
                                @click="editPromo.discountType = 'percentage'; openTypeDropdown = false"
                                class="dropdown-item"
                                :class="editPromo.discountType === 'percentage' ? 'dropdown-item-active' : ''">
                            Percentage (%)
                        </button>
                        <button type="button" 
                                @click="editPromo.discountType = 'fixed'; openTypeDropdown = false"
                                class="dropdown-item"
                                :class="editPromo.discountType === 'fixed' ? 'dropdown-item-active' : ''">
                            Fixed Amount ($)
                        </button>
                    </div>
                </div>

                <div>
                    <label for="editDiscountValue" class="block text-sm font-medium text-gray-700 mb-1">
                        Discount Value <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="editDiscountValue" 
                               x-model="editPromo.discountValue" 
                               @input="promoErrors.discountValue = ''"
                               placeholder="0"
                               min="0"
                               :max="editPromo.discountType === 'percentage' ? 100 : 9999"
                               step="1"
                               :class="promoErrors.discountValue ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                               class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                        <span class="absolute right-8 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium" x-text="editPromo.discountType === 'percentage' ? '%' : '$'"></span>
                    </div>
                    
                    <div x-show="promoErrors.discountValue" 
                         x-transition
                         class="form-error">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <span x-text="promoErrors.discountValue"></span>
                    </div>
                </div>
            </div>

            {{-- Apply To Section --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Apply To <span class="text-red-500">*</span>
                </label>
                
                <div x-data="{ openApplyToDropdown: false }" class="relative">
                    <button type="button" 
                            @click="openApplyToDropdown = !openApplyToDropdown"
                            @click.outside="openApplyToDropdown = false"
                            class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-100 outline-none transition-all bg-white text-left flex items-center justify-between cursor-pointer"
                            :class="openApplyToDropdown ? 'border-yellow-400 ring-2 ring-yellow-100' : ''">
                        <span class="capitalize" x-text="editPromo.applyTo === 'all' ? 'All Menu Items' : editPromo.applyTo === 'category' ? 'Specific Category' : 'Specific Dish'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div x-show="openApplyToDropdown" 
                         x-transition
                         class="dropdown-menu top-full mt-2 w-full">
                        <button type="button" 
                                @click="editPromo.applyTo = 'all'; editPromo.selectedCategory = null; editPromo.selectedDish = null; openApplyToDropdown = false; promoErrors.selectedCategory = ''; promoErrors.selectedDish = ''"
                                class="dropdown-item"
                                :class="editPromo.applyTo === 'all' ? 'dropdown-item-active' : ''">
                            All Menu Items
                        </button>
                        <button type="button" 
                                @click="editPromo.applyTo = 'category'; editPromo.selectedDish = null; openApplyToDropdown = false; promoErrors.selectedDish = ''"
                                class="dropdown-item"
                                :class="editPromo.applyTo === 'category' ? 'dropdown-item-active' : ''">
                            Specific Category
                        </button>
                        <button type="button" 
                                @click="editPromo.applyTo = 'dish'; editPromo.selectedCategory = null; openApplyToDropdown = false; promoErrors.selectedCategory = ''"
                                class="dropdown-item"
                                :class="editPromo.applyTo === 'dish' ? 'dropdown-item-active' : ''">
                            Specific Dish
                        </button>
                    </div>
                </div>
            </div>

            {{-- Category Selection (Conditional) --}}
            <div x-show="editPromo.applyTo === 'category'" x-transition>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Categories <span class="text-red-500">*</span>
                </label>
                
                <div class="space-y-3">
                    <template x-for="(selectedCat, index) in editPromo.selectedCategories" :key="index">
                        <div class="flex gap-2 items-start">
                            <div x-data="{ openCategoryDropdown: false }" class="relative flex-1">
                                <div class="relative">
                                    <input type="text" 
                                           :value="editPromo.selectedCategories[index] || editPromo.categorySearches[index]"
                                           @input="editPromo.categorySearches[index] = $event.target.value; editPromo.selectedCategories[index] = ''; openCategoryDropdown = true; if (promoErrors.selectedCategories) promoErrors.selectedCategories[index] = ''"
                                           @click="openCategoryDropdown = true"
                                           @click.outside="openCategoryDropdown = false"
                                           placeholder="Search category..."
                                           :class="promoErrors.selectedCategories && promoErrors.selectedCategories[index] ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                                           class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                
                                <div x-show="openCategoryDropdown && getFilteredCategories(index).length > 0" 
                                     x-transition
                                     class="dropdown-menu top-full mt-2 w-full max-h-60 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                    <template x-for="category in getFilteredCategories(index)" :key="category.name">
                                        <button type="button" 
                                                @click="editPromo.selectedCategories[index] = category.name; editPromo.categorySearches[index] = ''; openCategoryDropdown = false; if (promoErrors.selectedCategories) promoErrors.selectedCategories[index] = ''"
                                                class="dropdown-item"
                                                :class="editPromo.selectedCategories[index] === category.name ? 'dropdown-item-active' : ''">
                                            <span x-text="category.icon + ' ' + category.name"></span>
                                        </button>
                                    </template>
                                </div>
                                
                                <div x-show="openCategoryDropdown && getFilteredCategories(index).length === 0 && editPromo.categorySearches[index]" 
                                     x-transition
                                     class="absolute z-50 top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-gray-100 p-4 text-center text-sm text-gray-500">
                                    No category found matching "<span x-text="editPromo.categorySearches[index]"></span>"
                                </div>
                                
                                <div x-show="promoErrors.selectedCategories && promoErrors.selectedCategories[index]" 
                                     x-transition
                                     class="form-error mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                    </svg>
                                    <span x-text="promoErrors.selectedCategories[index]"></span>
                                </div>
                            </div>
                            
                            {{-- Remove button (shown for all except first) --}}
                            <button x-show="index > 0" 
                                    type="button" 
                                    @click="removeCategoryField(index, 'edit')"
                                    class="cursor-pointer p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    
                    {{-- Add Another Category Button --}}
                    <button type="button" 
                            @click="addCategoryField('edit')"
                            class="cursor-pointer w-full py-2 px-4 border-2 border-dashed border-gray-300 rounded-xl text-gray-600 hover:border-yellow-400 hover:text-yellow-600 transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                        <span>Add Another Category</span>
                    </button>
                </div>
            </div>

            {{-- Dish Selection (Conditional) --}}
            <div x-show="editPromo.applyTo === 'dish'" x-transition>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Dishes <span class="text-red-500">*</span>
                </label>
                
                <div class="space-y-3">
                    <template x-for="(selectedDsh, index) in editPromo.selectedDishes" :key="index">
                        <div class="flex gap-2 items-start">
                            <div x-data="{ openDishDropdown: false }" class="relative flex-1">
                                <div class="relative">
                                    <input type="text" 
                                           :value="editPromo.selectedDishes[index] || editPromo.dishSearches[index]"
                                           @input="editPromo.dishSearches[index] = $event.target.value; editPromo.selectedDishes[index] = ''; openDishDropdown = true; if (promoErrors.selectedDishes) promoErrors.selectedDishes[index] = ''"
                                           @click="openDishDropdown = true"
                                           @click.outside="openDishDropdown = false"
                                           placeholder="Search dish..."
                                           :class="promoErrors.selectedDishes && promoErrors.selectedDishes[index] ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                                           class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                
                                <div x-show="openDishDropdown && getFilteredDishes(index).length > 0" 
                                     x-transition
                                     class="dropdown-menu top-full mt-2 w-full max-h-60 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                    <template x-for="dish in getFilteredDishes(index)" :key="dish.name">
                                        <button type="button" 
                                                @click="editPromo.selectedDishes[index] = dish.name; editPromo.dishSearches[index] = ''; openDishDropdown = false; if (promoErrors.selectedDishes) promoErrors.selectedDishes[index] = ''"
                                                class="dropdown-item text-left flex flex-col items-start gap-0.5"
                                                :class="editPromo.selectedDishes[index] === dish.name ? 'dropdown-item-active' : ''">
                                            <span x-text="dish.name" class="font-medium"></span>
                                            <span x-text="dish.category" class="text-xs text-gray-400"></span>
                                        </button>
                                    </template>
                                </div>
                                
                                <div x-show="openDishDropdown && getFilteredDishes(index).length === 0 && editPromo.dishSearches[index]" 
                                     x-transition
                                     class="absolute z-50 top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-gray-100 p-4 text-center text-sm text-gray-500">
                                    No dish found matching "<span x-text="editPromo.dishSearches[index]"></span>"
                                </div>
                                
                                <div x-show="promoErrors.selectedDishes && promoErrors.selectedDishes[index]" 
                                     x-transition
                                     class="form-error mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                    </svg>
                                    <span x-text="promoErrors.selectedDishes[index]"></span>
                                </div>
                            </div>
                            
                            {{-- Remove button (shown for all except first) --}}
                            <button x-show="index > 0" 
                                    type="button" 
                                    @click="removeDishField(index, 'edit')"
                                    class="cursor-pointer p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    
                    {{-- Add Another Dish Button --}}
                    <button type="button" 
                            @click="addDishField('edit')"
                            class="cursor-pointer w-full py-2 px-4 border-2 border-dashed border-gray-300 rounded-xl text-gray-600 hover:border-yellow-400 hover:text-yellow-600 transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                        <span>Add Another Dish</span>
                    </button>
                </div>
            </div>

            {{-- Date Range --}}
            <div class="grid grid-cols-2 gap-4">
                {{-- Start Date Picker --}}
                <div x-data="datePicker(editPromo.startDate)" x-modelable="selectedDate" x-model="editPromo.startDate">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Start Date <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <button type="button" 
                                @click="showPicker = !showPicker"
                                @click.outside="showPicker = false"
                                class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-100 outline-none transition-all flex items-center justify-between cursor-pointer bg-white"
                                :class="{'border-yellow-400 ring-2 ring-yellow-100': showPicker}">
                            <span x-text="formattedDate || 'Select Date'" :class="{'text-gray-400': !formattedDate, 'text-gray-900': formattedDate}"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                                <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="showPicker"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute z-50 top-full mt-2 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 p-4"
                             style="display: none;">
                            
                            <div class="flex items-center justify-between mb-4">
                                <button @click="prevMonth" type="button" class="p-1 hover:bg-gray-100 rounded-full text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                        <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 0 1-.02 1.06L8.832 10l3.938 3.71a.75.75 0 1 1-1.04 1.08l-4.5-4.25a.75.75 0 0 1 0-1.08l4.5-4.25a.75.75 0 0 1 1.06.02Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div class="font-bold text-gray-900" x-text="monthName + ' ' + currentYear"></div>
                                <button @click="nextMonth" type="button" class="p-1 hover:bg-gray-100 rounded-full text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 .02-1.06L11.168 10 7.23 6.29a.75.75 0 1 1 1.04-1.08l4.5 4.25a.75.75 0 0 1 0 1.08l-4.5 4.25a.75.75 0 0 1-1.06-.02Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-7 gap-1 text-center text-xs font-bold text-gray-400 mb-2">
                                <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                            </div>
                            
                            <div class="grid grid-cols-7 gap-1">
                                <template x-for="(day, index) in days" :key="index">
                                    <div class="aspect-square flex items-center justify-center">
                                        <button x-show="day"
                                                type="button"
                                                @click="selectDate(day)"
                                                x-text="day"
                                                class="w-8 h-8 rounded-full text-sm flex items-center justify-center transition-colors"
                                                :class="{
                                                    'bg-yellow-400 text-gray-900 font-bold shadow-md': isSelected(day),
                                                    'text-yellow-600 font-bold bg-yellow-50': isToday(day) && !isSelected(day),
                                                    'text-gray-700 hover:bg-gray-100': !isSelected(day) && !isToday(day)
                                                }">
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                   
                   <div x-show="promoErrors.startDate" 
                         x-transition
                         class="form-error">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <span x-text="promoErrors.startDate"></span>
                    </div>
                </div>

                {{-- End Date Picker --}}
                <div x-data="datePicker(editPromo.endDate)" x-modelable="selectedDate" x-model="editPromo.endDate">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        End Date <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <button type="button" 
                                @click="showPicker = !showPicker"
                                @click.outside="showPicker = false"
                                class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-100 outline-none transition-all flex items-center justify-between cursor-pointer bg-white"
                                :class="{'border-yellow-400 ring-2 ring-yellow-100': showPicker}">
                            <span x-text="formattedDate || 'Select Date'" :class="{'text-gray-400': !formattedDate, 'text-gray-900': formattedDate}"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                                <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="showPicker"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute z-50 top-full mt-2 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 p-4"
                             style="display: none;">
                            
                            <div class="flex items-center justify-between mb-4">
                                <button @click="prevMonth" type="button" class="p-1 hover:bg-gray-100 rounded-full text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                        <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 0 1-.02 1.06L8.832 10l3.938 3.71a.75.75 0 1 1-1.04 1.08l-4.5-4.25a.75.75 0 0 1 0-1.08l4.5-4.25a.75.75 0 0 1 1.06.02Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div class="font-bold text-gray-900" x-text="monthName + ' ' + currentYear"></div>
                                <button @click="nextMonth" type="button" class="p-1 hover:bg-gray-100 rounded-full text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 .02-1.06L11.168 10 7.23 6.29a.75.75 0 1 1 1.04-1.08l4.5 4.25a.75.75 0 0 1 0 1.08l-4.5 4.25a.75.75 0 0 1-1.06-.02Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-7 gap-1 text-center text-xs font-bold text-gray-400 mb-2">
                                <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                            </div>
                            
                            <div class="grid grid-cols-7 gap-1">
                                <template x-for="(day, index) in days" :key="index">
                                    <div class="aspect-square flex items-center justify-center">
                                        <button x-show="day"
                                                type="button"
                                                @click="selectDate(day)"
                                                x-text="day"
                                                class="w-8 h-8 rounded-full text-sm flex items-center justify-center transition-colors"
                                                :class="{
                                                    'bg-yellow-400 text-gray-900 font-bold shadow-md': isSelected(day),
                                                    'text-yellow-600 font-bold bg-yellow-50': isToday(day) && !isSelected(day),
                                                    'text-gray-700 hover:bg-gray-100': !isSelected(day) && !isToday(day)
                                                }">
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="promoErrors.endDate" 
                         x-transition
                         class="form-error">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <span x-text="promoErrors.endDate"></span>
                    </div>
                </div>
            </div>

            {{-- Active Status --}}
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" 
                           x-model="editPromo.isActive"
                           class="w-5 h-5 rounded border-gray-300 text-yellow-400 focus:ring-yellow-200">
                    <span class="form-label mb-0">Promotion is active</span>
                </label>
                <p class="text-xs text-gray-400 mt-1 ml-7">The promotion will be active within the specified date range</p>
            </div>

            {{-- Usage Stats --}}
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <h4 class="text-sm font-bold text-gray-900 mb-2">Usage Statistics</h4>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-green-500">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                    <span>This promotion has been used <span class="font-bold text-gray-900" x-text="editPromo.usageCount"></span> times</span>
                </div>
            </div>

        </div>
        </div>

        {{-- Modal Footer --}}
        <div class="modal-footer">
            <button @click="deletePromo(selectedPromo.id)" 
                    type="button"
                    class="px-4 py-2.5 rounded-full font-bold text-red-600 hover:bg-red-50 transition-colors cursor-pointer flex items-center gap-2 border-2 border-red-200 hover:border-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                </svg>
                Delete
            </button>
            <button @click="closeEditPromoModal()" 
                    type="button"
                    class="modal-btn-cancel">
                Cancel
            </button>
            <button @click="updatePromo()" 
                    type="button"
                    class="modal-btn-submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path d="M10 2a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 2ZM10 15a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 15ZM10 7a3 3 0 1 0 0 6 3 3 0 0 0 0-6ZM15.657 5.404a.75.75 0 1 0-1.06-1.06l-1.061 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM6.464 14.596a.75.75 0 1 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM18 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 18 10ZM5 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 5 10ZM14.596 15.657a.75.75 0 0 0 1.06-1.06l-1.06-1.061a.75.75 0 1 0-1.06 1.06l1.06 1.06ZM5.404 6.464a.75.75 0 0 0 1.06-1.06l-1.06-1.06a.75.75 0 1 0-1.061 1.06l1.06 1.06Z" />
                </svg>
                Update Promotion
            </button>
        </div>
    </div>
</div>
