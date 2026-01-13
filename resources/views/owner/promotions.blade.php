<x-owner.layout>
    <script src="{{ asset('assets/js/components/date-picker.js') }}"></script>
    <script src="{{ asset('assets/js/owner/promotions.js') }}"></script>

    <div class="space-y-6 pb-20" x-data="promotionsHandler()">
        {{-- Header with Heading and Search --}}
        <x-owner.heading>
            <x-slot:title>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-yellow-500">
                    <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" />
                </svg>
                Promotions
            </x-slot:title>
            <x-slot:subtitle>Manage discounts and special offers</x-slot:subtitle>
            
            <x-slot:searchplacehold>Search promotions...</x-slot:searchplacehold>
            <x-slot:filter>filter in searchFilters</x-slot:filter>

            {{-- Quick Stats --}}
            <div class="flex gap-3">
                <div class="stat-card">
                    <div class="stat-value text-yellow-600" x-text="activePromotions.length"></div>
                    <div class="stat-label">Active Promos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value text-green-600" x-text="promotions.reduce((sum, p) => sum + p.usageCount, 0)"></div>
                    <div class="stat-label">Total Usage</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value text-gray-900" x-text="scheduledPromotions.length"></div>
                    <div class="stat-label">Scheduled</div>
                </div>
            </div>
        </x-owner.heading>

        {{-- Status Filter --}}
        <x-owner.promotions.filter-status />

        {{-- Promotions Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-owner.promotions.promo-card />
        </div>

        {{-- Empty State --}}
        <div x-show="filteredPromotions.length === 0" class="text-center py-20" style="display: none;">
            <div class="text-6xl mb-4">🎁</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No promotions found</h3>
            <p class="text-gray-500 mb-6">Create your first promotion to boost sales</p>
            <div x-show="searchQuery.trim() === '' && statusFilter === 'All'" class="flex justify-center align-middle">
                <button @click="openAddPromoModal()" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    Add Promotion
                </button>
            </div>
        </div>

        {{-- Floating Add Button --}}
        <button @click="openAddPromoModal()" 
                class="btn-primary fixed bottom-8 left-8 p-4 shadow-2xl hover:scale-110 z-40 group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 group-hover:rotate-90 transition-transform duration-300">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
            </svg>
        </button>

        {{-- Add Promotion Modal --}}
        <x-owner.promotions.add-promo-modal />

        {{-- Edit Promotion Modal --}}
        <x-owner.promotions.edit-promo-modal />
    </div>
</x-owner.layout>