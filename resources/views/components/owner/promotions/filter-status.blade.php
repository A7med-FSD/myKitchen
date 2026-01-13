<div class="flex gap-2 flex-wrap entrance-animation relative z-20">
    <template x-for="status in ['All', 'Active', 'Expired', 'Scheduled']" :key="status">
        <button @click="statusFilter = status"
                class="filter-pill"
                :class="statusFilter === status ? 'filter-pill-active' : 'filter-pill-inactive'">
            <span x-text="status"></span>
        </button>
    </template>
</div>
