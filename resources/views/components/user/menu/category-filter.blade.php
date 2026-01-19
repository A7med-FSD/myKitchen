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
</div>
