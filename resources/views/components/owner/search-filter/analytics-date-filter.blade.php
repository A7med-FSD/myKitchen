<div class="flex gap-2 overflow-x-auto pb-2 entrance-animation flex-wrap">
    <template x-for="range in dateRanges" :key="range">
        <button @click="changeDateRange(range)"
                :class="dateRange === range ? 'bg-yellow-400 text-gray-900 shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50'"
                class="px-4 py-2 rounded-full font-medium transition-all duration-200 whitespace-nowrap cursor-pointer flex items-center gap-2">
            <span x-text="range"></span>
        </button>
    </template>
</div>
