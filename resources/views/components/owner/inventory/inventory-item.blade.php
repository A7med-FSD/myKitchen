<tr class="hover:bg-gray-50 transition-colors">
    <!-- Item Name -->
    <td class="px-6 py-4">
        <div class="font-semibold text-gray-900" x-text="item.name"></div>
        <div class="text-xs text-gray-400 flex items-center gap-1 mt-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-3">
                <path fill-rule="evenodd" d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0ZM9 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM6.75 8a.75.75 0 0 0 0 1.5h.75v1.75a.75.75 0 0 0 1.5 0v-2.5A.75.75 0 0 0 8.25 8h-1.5Z" clip-rule="evenodd" />
            </svg>
            Alert at <span x-text="item.lowStockThreshold"></span> <span x-text="item.unit"></span>
        </div>
    </td>
    
    <!-- Category -->
    <td class="px-6 py-4">
        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700" x-text="item.category"></span>
    </td>
    
    <!-- Status (Quick Editable) -->
    <td class="px-6 py-4 text-center relative" x-data="{ open: false }">
        <button @click="statusFilter === 'All' ? open = !open : null" 
                @click.away="open = false"
                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold gap-2 transition-all duration-200 border"
                :class="{
                    'cursor-default opacity-90': statusFilter !== 'All',
                    'cursor-pointer hover:shadow-md': statusFilter === 'All',
                    
                    'bg-red-50 text-red-700 border-red-200': getStockStatus(item) === 'out',
                    'hover:bg-red-100': getStockStatus(item) === 'out' && statusFilter === 'All',
                    
                    'bg-orange-50 text-orange-700 border-orange-200': getStockStatus(item) === 'low',
                    'hover:bg-orange-100': getStockStatus(item) === 'low' && statusFilter === 'All',
                    
                    'bg-green-50 text-green-700 border-green-200': getStockStatus(item) === 'in',
                    'hover:bg-green-100': getStockStatus(item) === 'in' && statusFilter === 'All'
                }">
            <span class="w-2 h-2 rounded-full"
                  :class="{
                      'bg-red-500': getStockStatus(item) === 'out',
                      'bg-orange-500': getStockStatus(item) === 'low',
                      'bg-green-500': getStockStatus(item) === 'in'
                  }"></span>
            <span x-text="getStockStatus(item) === 'out' ? 'Out of Stock' : (getStockStatus(item) === 'low' ? 'Low Stock' : 'In Stock')"></span>
            
            <!-- Chevron (Only show if editable) -->
            <svg x-show="statusFilter === 'All'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 opacity-60 transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open && statusFilter === 'All'" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             class="absolute left-1/2 -translate-x-1/2 top-[70%] mt-2 w-40 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden py-1">
            
            <button @click="updateItemStatus(item, 'in'); open = false" 
                    class="w-full text-left px-4 py-2 text-sm hover:bg-green-50 hover:text-green-700 flex items-center gap-2 transition-colors cursor-pointer group">
                <span class="w-2 h-2 rounded-full bg-green-500 group-hover:scale-110 transition-transform"></span>
                In Stock
            </button>
            
            <button @click="updateItemStatus(item, 'low'); open = false" 
                    class="w-full text-left px-4 py-2 text-sm hover:bg-orange-50 hover:text-orange-700 flex items-center gap-2 transition-colors cursor-pointer group">
                <span class="w-2 h-2 rounded-full bg-orange-500 group-hover:scale-110 transition-transform"></span>
                Low Stock
            </button>
            
            <button @click="updateItemStatus(item, 'out'); open = false" 
                    class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 hover:text-red-700 flex items-center gap-2 transition-colors cursor-pointer group">
                <span class="w-2 h-2 rounded-full bg-red-500 group-hover:scale-110 transition-transform"></span>
                Out of Stock
            </button>
        </div>
    </td>
    
    <!-- Stock Quantity -->
    <td class="px-6 py-4 text-center">
        <div class="text-2xl font-bold text-gray-900">
            <span x-text="parseFloat(Number(item.quantity).toFixed(2))"></span>
        </div>
        <div class="text-xs text-gray-500" x-text="item.unit"></div>
    </td>
    
    <!-- Quick Adjust -->
    <td x-show="statusFilter === 'All'" class="px-6 py-4">
        <div class="flex items-center justify-center gap-2">
            <button @click="quickAdjustStock(item, -1)" 
                    :disabled="item.quantity === 0"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-lg transition-colors cursor-pointer disabled:opacity-30 disabled:cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z" clip-rule="evenodd" />
                </svg>
            </button>
            <button @click="quickAdjustStock(item, 1)" 
                    class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 p-2 rounded-lg transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                    <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                </svg>
            </button>
        </div>
    </td>
    
    <!-- Price -->
    <td class="px-6 py-4 text-right">
        <div class="text-lg font-bold text-gray-900">
            $<span x-text="item.pricePerUnit.toFixed(2)"></span>
        </div>
        <div class="text-xs text-gray-500">per <span x-text="item.unit"></span></div>
    </td>
    
    <!-- Actions -->
    <td class="px-6 py-4">
        <div class="flex items-center justify-center gap-2">
            <button x-show="statusFilter === 'All'" @click="openEditItemModal(item)" 
                    class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-3 py-1.5 rounded-lg font-semibold text-sm transition-colors cursor-pointer">
                Edit
            </button>
            <button @click="deleteItem(item)" 
                    class="bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 p-2 rounded-lg transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </td>

</tr>
