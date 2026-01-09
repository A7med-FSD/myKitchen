<x-owner.layout>
    <div class="space-y-6 pb-20" x-data="inventoryHandler()">
        <!-- Header with Heading and Search -->
        <x-owner.heading>
            <x-slot:title>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-yellow-500">
                    <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                    <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
                Inventory Management
            </x-slot:title>
            <x-slot:subtitle>Track and manage your stock items</x-slot:subtitle>
            
            <x-slot:searchplacehold>Search items...</x-slot:searchplacehold>
            <x-slot:filter>filter in searchFilters</x-slot:filter>
            <div class="flex gap-3">
                <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                    <div class="text-2xl font-bold text-gray-900" x-text="totalItems"></div>
                    <div class="text-xs text-gray-500">Total Items</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                    <div class="text-2xl font-bold text-orange-600" x-text="lowStockCount"></div>
                    <div class="text-xs text-gray-500">Low Stock</div>
                </div>
            </div>
        </x-owner.heading>

        <!-- Status/Category Filters -->
        <x-owner.inventory.inventory-status-filter />

        <!-- Inventory Table -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 entrance-animation" x-ref="inventoryTable">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Item Name
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Stock
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider" x-show="statusFilter === 'All'">
                                Quick Adjust
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Price/Unit
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(item, index) in filteredItems" :key="item.id">
                            <x-owner.inventory.inventory-item />
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State -->
        <div x-show="filteredItems.length === 0" class="text-center py-20" style="display: none;">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No items found</h3>
            <p class="text-gray-500 mb-6">Try selecting a different filter or search term</p>
            
            <!-- Add Items Button (When search is empty and no items) -->
            <div x-show="searchQuery.trim() === '' && filteredItems.length === 0 && statusFilter === 'All'" class="mb-4">
                <button @click="openAddItemModal()" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-400 text-gray-900 rounded-full font-semibold hover:bg-yellow-500 transition-all shadow-lg shadow-yellow-200 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Add First Item
                </button>
            </div>
        </div>

        <!-- Floating Add Item Button -->
        <button x-show="statusFilter === 'All'" @click="openAddItemModal()" 
                class="fixed bottom-8 left-8 cursor-pointer bg-yellow-400 hover:bg-yellow-500 text-gray-900 p-4 rounded-full shadow-2xl hover:shadow-yellow-200 transition-all duration-300 hover:scale-110 z-40 group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 group-hover:rotate-90 transition-transform duration-300">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
            </svg>
        </button>
        
        <!-- Add Item Modal -->
        <x-owner.inventory.add-inventory-modal />
        
        <!-- Edit Item Modal -->
        <x-owner.inventory.edit-inventory-modal />
    </div>

    <script src="{{ asset('assets/js/owner/inventory.js') }}"></script>
</x-owner.layout>
