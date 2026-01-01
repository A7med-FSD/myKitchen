<div class="flex flex-wrap gap-3 animate-entrance-header">
    <template x-for="cat in categories" :key="cat.name">
        <button @click="setCategory(cat.name)"
                class="px-4 py-2 rounded-full cursor-pointer font-semibold transition-all duration-300 flex items-center gap-2 border border-transparent"
                :class="getCategoryClasses(cat.name)">
            <span x-text="cat.icon" class="text-lg"></span>
            <span x-text="cat.name"></span>
            <span class="text-xs px-1.5 py-0.5 rounded-full transition-colors duration-300" 
                :class="getCountClasses(cat.name)" 
                x-text="cat.count"></span>
        </button>
    </template>
    
    <!-- Add Category Button -->
    <button @click="openAddCategoryModal()" 
            class="group px-4 py-2 rounded-full cursor-pointer font-semibold transition-all duration-300 flex items-center gap-2 border-2 border-dashed border-gray-200 text-gray-400 hover:border-yellow-400 hover:text-yellow-600 hover:bg-yellow-50">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 group-hover:rotate-90 transition-transform duration-300">
            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
        </svg>
        <span>Add Category</span>
    </button>
</div>
