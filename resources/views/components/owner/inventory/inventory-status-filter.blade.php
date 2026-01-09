<div class="flex gap-2 overflow-x-auto pb-2 entrance-animation flex-wrap">
    <template x-for="status in ['All', 'In Stock', 'Low Stock', 'Out of Stock']" :key="status">
        <button @click="statusFilter = status"
                :class="statusFilter === status ? 'bg-yellow-400 text-gray-900 shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50'"
                class="px-4 py-2 rounded-full font-medium transition-all duration-200 whitespace-nowrap cursor-pointer flex items-center gap-2">
            <span x-show="status === 'In Stock'" class="text-green-500">●</span>
            <span x-show="status === 'Low Stock'" class="text-orange-500">●</span>
            <span x-show="status === 'Out of Stock'" class="text-red-500">●</span>
            <span x-text="status"></span>
            <span x-show="status === 'Low Stock'" 
                  class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full text-xs font-bold"
                  x-text="lowStockCount"></span>
            <span x-show="status === 'Out of Stock'" 
                  class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-bold"
                  x-text="outOfStockCount"></span>
        </button>
    </template>
</div>
