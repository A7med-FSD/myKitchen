<div class="flex gap-2 entrance-animation relative z-50">
    <button @click="setCustomerFilter('All')"
            class="px-4 py-2 rounded-full font-semibold text-sm transition-all cursor-pointer"
            :class="customerFilter === 'All' ? 'bg-yellow-500 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50'">
        All
    </button>
    <button @click="setCustomerFilter('VIP')"
            class="px-4 py-2 rounded-full font-semibold text-sm transition-all cursor-pointer"
            :class="customerFilter === 'VIP' ? 'bg-yellow-500 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50'">
        VIP
    </button>
    <button @click="setCustomerFilter('Regular')"
            class="px-4 py-2 rounded-full font-semibold text-sm transition-all cursor-pointer"
            :class="customerFilter === 'Regular' ? 'bg-yellow-500 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50'">
        Regular
    </button>
    <button @click="setCustomerFilter('NEW')"
            class="px-4 py-2 rounded-full font-semibold text-sm transition-all cursor-pointer"
            :class="customerFilter === 'NEW' ? 'bg-yellow-500 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50'">
        NEW
    </button>
</div>
