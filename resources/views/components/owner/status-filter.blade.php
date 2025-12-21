{{-- Status Filter Component --}}
{{-- This component works within Alpine.js x-data scope, so it accesses statuses and selectedStatus directly --}}

<div class="flex flex-wrap gap-3 animate-entrance-search">
    <template x-for="status in statuses" :key="status.name">
        <button @click="selectedStatus = status.name"
                class="px-4 py-2 rounded-full font-semibold transition-all duration-300 flex items-center gap-2 cursor-pointer shadow-sm border border-transparent"
                :class="selectedStatus === status.name ? status.activeClass + ' shadow-lg scale-105' : status.inactiveClass">
            <span x-html="status.icon" class="w-5 h-5 flex items-center justify-center"></span>
            <span x-text="status.name"></span>
            <span class="text-xs px-2 py-0.5 rounded-full bg-black/10" x-text="status.count"></span>
        </button>
    </template>
</div>
