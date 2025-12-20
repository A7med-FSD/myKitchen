{{-- Status Filter Component --}}
{{-- This component works within Alpine.js x-data scope, so it accesses statuses and selectedStatus directly --}}

<div class="flex flex-wrap gap-3 animate-entrance-search">
    <template x-for="status in statuses" :key="status.name">
        <button @click="selectedStatus = status.name"
                class="px-4 py-2 rounded-full font-semibold transition-all duration-300 flex items-center gap-2 cursor-pointer"
                :class="selectedStatus === status.name ? 'bg-yellow-400 text-gray-900 shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-100'">
            <span x-text="status.icon"></span>
            <span x-text="status.name"></span>
            <span class="text-xs px-2 py-0.5 rounded-full bg-black/10" x-text="status.count"></span>
        </button>
    </template>
</div>
