<div x-show="showAddCategoryModal" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="modal-backdrop"
    @click="closeAddCategoryModal()"
    style="display: none;">
    
    <div x-show="showAddCategoryModal"
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
            <h3 class="modal-header-title">Add Category</h3>
            <p class="modal-header-subtitle">Create a new section for your menu.</p>
            <button @click="closeAddCategoryModal()" class="modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="modal-body">
        
        {{-- Warning Alert --}}
        <div class="mx-6 mt-4 p-3 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-amber-600 shrink-0 mt-0.5">
                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            <div class="flex-1">
                <p class="text-xs font-semibold text-amber-800">Important Note</p>
                <p class="text-xs text-amber-700 mt-0.5">You cannot delete a category that contains items. Make sure the category is necessary and appropriately named before adding any items.</p>
            </div>
        </div>

        {{-- Modal Body --}}
        <div class="modal-body-content">
            {{-- Category Name Input --}}
            <div>
                <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-1">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="categoryName" x-model="newCategoryName" 
                    @input="categoryNameError = ''"
                    placeholder="e.g., Breakfast, Drinks..." required
                    :class="categoryNameError ? 'border-red-400 focus:border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-yellow-400 focus:ring-yellow-100'"
                    class="w-full px-4 py-2 rounded-xl border focus:ring-2 outline-none transition-all placeholder:text-gray-300">
                
                {{-- Error Message --}}
                <div x-show="categoryNameError" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="categoryNameError"></span>
                </div>
            </div>

            {{-- Icon Selector --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Icon (Optional)</label>
                
                {{-- Preview Box --}}
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-20 h-20 rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center text-4xl bg-gray-50 transition-all"
                        :class="newCategoryIcon ? 'border-yellow-400 bg-yellow-50' : ''">
                        <span x-text="newCategoryIcon || '?'" class="transition-all"></span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-700" x-show="newCategoryIcon">Selected Icon</p>
                        <p class="text-xs text-gray-400" x-show="!newCategoryIcon">No icon selected</p>
                        <button type="button" 
                                x-show="newCategoryIcon"
                                @click="newCategoryIcon = ''"
                                class="mt-2 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 hover:border-red-300 transition-colors cursor-pointer">
                            Clear selection
                        </button>
                    </div>
                </div>

                {{-- Icon Grid --}}
                <div class="grid grid-cols-6 gap-2 p-2 bg-gray-50 rounded-xl max-h-[230px] overflow-y-auto">
                    <template x-for="(icon, index) in availableIcons" :key="index">
                        <div class="relative group">
                            {{-- Empty Icon Input --}}
                            <div x-show="icon === ''"
                                 contenteditable="true"
                                 @blur="updateIcon(index, $event)"
                                 @keydown.enter.prevent="$el.blur()"
                                 class="icon-input w-full text-2xl p-2 rounded-lg border-2 border-yellow-400 bg-yellow-50 ring-2 ring-yellow-200 cursor-text flex justify-center items-center outline-none min-h-[44px]"
                                 placeholder="">
                            </div>
                            
                            {{-- Regular Icon Button --}}
                            <button x-show="icon !== ''"
                                    type="button" 
                                    @click="newCategoryIcon = icon"
                                    class="w-full text-2xl p-2 rounded-lg border-2 transition-all duration-200 hover:scale-110 cursor-pointer bg-white flex justify-center items-center"
                                    :class="newCategoryIcon === icon ? 'border-yellow-400 bg-yellow-50 scale-110 ring-2 ring-yellow-200' : 'border-gray-200 hover:border-gray-300'"
                                    x-text="icon">
                            </button>
                            
                            {{-- Delete Button (only for non-empty icons) --}}
                            <button x-show="icon !== ''"
                                    type="button"
                                    @click.stop="removeIcon(icon)"
                                    class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 text-white">
                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    
                    {{-- Add New Icon Button --}}
                    <button type="button"
                            @click="addCustomIcon()"
                            class="text-2xl p-2 rounded-lg border-2 border-dashed border-gray-300 transition-all duration-200 hover:scale-110 cursor-pointer bg-white hover:bg-yellow-50 hover:border-yellow-400 flex justify-center items-center group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-400 group-hover:text-yellow-600 transition-colors">
                            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-2">Click any icon to select it, hover to remove, or click + to add custom emoji</p>
            </div>
        </div>
        </div>

        {{-- Modal Footer --}}
        <div class="modal-footer">
            <button @click="closeAddCategoryModal()" 
                    class="modal-btn-cancel">
                Cancel
            </button>
            <button @click="saveCategory()" 
                    :disabled="!newCategoryName"
                    class="modal-btn-submit disabled:opacity-50 disabled:cursor-not-allowed">
                Save Category
            </button>
        </div>
    </div>
</div>
