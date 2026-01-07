<x-owner.layout>
    <script src="{{ asset('assets/js/owner/customers.js') }}"></script>

    <div class="space-y-6 pb-20" x-data="customersHandler()">
        <!-- Header with Heading and Search -->
        <x-owner.heading>
            <x-slot:title>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-yellow-500">
                    <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                </svg>
                Customers
            </x-slot:title>
            <x-slot:subtitle>Manage your customer base and relationships</x-slot:subtitle>
            
            <x-slot:searchplacehold>Search customers...</x-slot:searchplacehold>
            <x-slot:filter>filter in searchFilters</x-slot:filter>

            <!-- Quick Stats -->
            <div class="flex gap-3">
                <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                    <div class="text-2xl font-bold text-gray-900" x-text="customers.length"></div>
                    <div class="text-xs text-gray-500">Total Customers</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                    <div class="text-2xl font-bold text-yellow-600" x-text="customers.filter(c => customerTag(c) === 'VIP').length"></div>
                    <div class="text-xs text-gray-500">VIP Customers</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                    <div class="text-2xl font-bold text-green-600" x-text="customers.filter(c => customerTag(c) === 'NEW').length"></div>
                    <div class="text-xs text-gray-500">New This Month</div>
                </div>
            </div>
        </x-owner.heading>

        <!-- Filters and Controls -->
        <div class="flex flex-wrap gap-4 items-center justify-between relative z-20">
            <!-- Customer Type Filters -->
            <x-owner.search-filter.customer-filter />

            <!-- Sorting and Activity Controls -->
            <div class="flex gap-3 entrance-animation relative z-50">
                <!-- Activity Status Dropdown -->
                <div x-data="{ showActivityMenu: false }" class="relative">
                    <button @click="showActivityMenu = !showActivityMenu"
                            @click.away="showActivityMenu = false"
                            class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-gray-200 hover:border-yellow-400 transition-colors font-semibold text-sm shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400">
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd" />
                        </svg>
                        <span>Status: <span x-text="activityFilter" class="font-bold"></span></span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400 transition-transform" :class="showActivityMenu ? 'rotate-180' : ''">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="showActivityMenu"
                        x-transition
                        class="absolute top-full right-0 mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 min-w-[160px]">
                        <button @click="setActivityFilter('All'); showActivityMenu = false"
                                class="w-full px-4 py-2 text-left text-sm hover:bg-yellow-50 transition-colors"
                                :class="activityFilter === 'All' ? 'bg-yellow-50 text-yellow-700 font-bold' : 'text-gray-700'">
                            All
                        </button>
                        <button @click="setActivityFilter('Active'); showActivityMenu = false"
                                class="w-full px-4 py-2 text-left text-sm hover:bg-yellow-50 transition-colors"
                                :class="activityFilter === 'Active' ? 'bg-yellow-50 text-yellow-700 font-bold' : 'text-gray-700'">
                            Active
                        </button>
                        <button @click="setActivityFilter('Inactive'); showActivityMenu = false"
                                class="w-full px-4 py-2 text-left text-sm hover:bg-yellow-50 transition-colors"
                                :class="activityFilter === 'Inactive' ? 'bg-yellow-50 text-yellow-700 font-bold' : 'text-gray-700'">
                            Inactive
                        </button>
                    </div>
                </div>

                <!-- Sort By Dropdown -->
                <div x-data="{ showSortMenu: false }" class="relative">
                    <button @click="showSortMenu = !showSortMenu"
                            @click.away="showSortMenu = false"
                            class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-gray-200 hover:border-yellow-400 transition-colors font-semibold text-sm shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400">
                            <path fill-rule="evenodd" d="M2.24 6.8a.75.75 0 0 0 1.06-.04l1.95-2.1v8.59a.75.75 0 0 0 1.5 0V4.66l1.95 2.1a.75.75 0 1 0 1.1-1.02l-3.25-3.5a.75.75 0 0 0-1.1 0L2.2 5.74a.75.75 0 0 0 .04 1.06Zm8 6.4a.75.75 0 0 0-.04 1.06l3.25 3.5a.75.75 0 0 0 1.1 0l3.25-3.5a.75.75 0 1 0-1.1-1.02l-1.95 2.1V6.75a.75.75 0 0 0-1.5 0v8.59l-1.95-2.1a.75.75 0 0 0-1.06-.04Z" clip-rule="evenodd" />
                        </svg>
                        <span>Sort: <span x-text="sortField === 'name' ? 'Name' : (sortField === 'orders' ? 'Orders' : 'Total Spent')" class="font-bold"></span></span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400 transition-transform" :class="showSortMenu ? 'rotate-180' : ''">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="showSortMenu"
                        x-transition
                        class="absolute top-full right-0 mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 min-w-[160px]">
                        <button @click="setSortField('name'); showSortMenu = false"
                                class="w-full px-4 py-2 text-left text-sm hover:bg-yellow-50 transition-colors"
                                :class="sortField === 'name' ? 'bg-yellow-50 text-yellow-700 font-bold' : 'text-gray-700'">
                            Name
                        </button>
                        <button @click="setSortField('orders'); showSortMenu = false"
                                class="w-full px-4 py-2 text-left text-sm hover:bg-yellow-50 transition-colors"
                                :class="sortField === 'orders' ? 'bg-yellow-50 text-yellow-700 font-bold' : 'text-gray-700'">
                            Number of Orders
                        </button>
                        <button @click="setSortField('totalSpent'); showSortMenu = false"
                                class="w-full px-4 py-2 text-left text-sm hover:bg-yellow-50 transition-colors"
                                :class="sortField === 'totalSpent' ? 'bg-yellow-50 text-yellow-700 font-bold' : 'text-gray-700'">
                            Total Spent
                        </button>
                    </div>
                </div>

                <!-- Sort Order Toggle -->
                <button @click="toggleSortOrder()"
                        class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-gray-200 hover:border-yellow-400 transition-colors font-semibold text-sm shadow-sm"
                        title="Toggle sort order">
                    <svg x-show="sortOrder === 'asc'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-600">
                        <path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.25-5.5a.75.75 0 0 1 1.08 0l5.25 5.5a.75.75 0 1 1-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0 1 10 17Z" clip-rule="evenodd" />
                    </svg>
                    <svg x-show="sortOrder === 'desc'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-600">
                        <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .75.75v10.638l3.96-4.158a.75.75 0 1 1 1.08 1.04l-5.25 5.5a.75.75 0 0 1-1.08 0l-5.25-5.5a.75.75 0 1 1 1.08-1.04l3.96 4.158V3.75A.75.75 0 0 1 10 3Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="sortOrder === 'asc' ? 'Ascending' : 'Descending'"></span>
                </button>
            </div>
        </div>

        <!-- Customers Table -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 entrance-animation relative z-10">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Phone
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Performance
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Last Active
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="customer in sortedCustomers" :key="customer.id">
                            <x-owner.customer-row />
                        </template>

                        <!-- Empty State -->
                        <tr x-show="sortedCustomers.length === 0">
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    <div class="text-gray-500 font-semibold">No customers found</div>
                                    <div class="text-gray-400 text-sm">Try adjusting your filters</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Results Count -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    Showing <span class="font-bold text-gray-900" x-text="sortedCustomers.length"></span> 
                    of <span class="font-bold text-gray-900" x-text="customers.length"></span> customers
                </div>
            </div>
        </div>

        <!-- Customer Details Modal -->
        <x-owner.modals.customer-details-modal />
    </div>
</x-owner.layout>
