<template x-for="promo in filteredPromotions" :key="promo.id">
    <div class="card p-6 transition-all duration-300 entrance-animation group cursor-pointer relative overflow-hidden hover:-translate-y-2 hover:shadow-xl border border-transparent hover:border-yellow-200"
         @click="openEditPromoModal(promo)">
        
        {{-- Discount Ticket Badge --}}
        <div class="flex items-start justify-between mb-6">
            <div class="relative bg-yellow-50 border-2 border-dashed border-yellow-400 rounded-2xl p-4 min-w-[100px] flex flex-col items-center justify-center text-center group-hover:bg-yellow-400 group-hover:border-yellow-500 group-hover:text-white transition-all duration-300">
                <span class="text-3xl font-black text-gray-900 group-hover:text-gray-900 transition-colors" x-text="promo.discountType === 'percentage' ? promo.discountValue + '%' : '$' + promo.discountValue"></span>
                <span class="text-xs font-bold text-yellow-700 uppercase tracking-wider group-hover:text-yellow-900 transition-colors">OFF</span>
                
                {{-- Ticket Cutouts --}}
                <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-3 h-3 bg-white rounded-full"></div>
                <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 bg-white rounded-full"></div>
            </div>
            
            {{-- Status Badge --}}
            <span class="badge px-3 py-1.5 shadow-sm" :class="{
                'bg-emerald-100 text-emerald-700 border border-emerald-200': getPromoStatus(promo) === 'Active',
                'bg-red-50 text-red-600 border border-red-100': getPromoStatus(promo) === 'Expired',
                'bg-blue-50 text-blue-600 border border-blue-100': getPromoStatus(promo) === 'Scheduled'
            }">
                <div class="flex items-center gap-1.5">
                    <div class="w-1.5 h-1.5 rounded-full" :class="{
                        'bg-emerald-500': getPromoStatus(promo) === 'Active',
                        'bg-red-500': getPromoStatus(promo) === 'Expired',
                        'bg-blue-500': getPromoStatus(promo) === 'Scheduled'
                    }"></div>
                    <span class="font-bold text-xs" x-text="getPromoStatus(promo)"></span>
                </div>
            </span>
        </div>

        {{-- Title & Code --}}
        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-yellow-600 transition-colors line-clamp-1" x-text="promo.title"></h3>
            <div class="inline-flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100 group-hover:border-yellow-100 group-hover:bg-yellow-50/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400 group-hover:text-yellow-500 transition-colors">
                    <path fill-rule="evenodd" d="M5 3.25A2.75 2.75 0 0 1 7.75.5h7A2.75 2.75 0 0 1 17.5 3.25v11.5A2.75 2.75 0 0 1 14.75 17h-7A2.75 2.75 0 0 1 5 14.75V3.25Zm2.75-1.25c-.69 0-1.25.56-1.25 1.25v11.5c0 .69.56 1.25 1.25 1.25h7c.69 0 1.25-.56 1.25-1.25V3.25c0-.69-.56-1.25-1.25-1.25h-7ZM9.5 6A1.5 1.5 0 0 1 11 4.5h2A1.5 1.5 0 0 1 14.5 6v2A1.5 1.5 0 0 1 13 9.5h-2A1.5 1.5 0 0 1 9.5 8V6Z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-mono font-bold text-gray-600 tracking-wide" x-text="promo.code"></span>
            </div>
        </div>

        {{-- Apply To Details --}}
        <div class="mb-4">
            <div class="flex flex-wrap gap-2">
                {{-- All Menu Items --}}
                <template x-if="promo.applyTo === 'all'">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
                            <path fill-rule="evenodd" d="M3.75 3A1.75 1.75 0 0 0 2 4.75v10.5c0 .966.784 1.75 1.75 1.75h12.5A1.75 1.75 0 0 0 18 15.25V4.75A1.75 1.75 0 0 0 16.25 3H3.75ZM3.5 4.75a.25.25 0 0 1 .25-.25h12.5a.25.25 0 0 1 .25.25v10.5a.25.25 0 0 1-.25.25H3.75a.25.25 0 0 1-.25-.25V4.75Z" clip-rule="evenodd" />
                        </svg>
                        All Menu
                    </span>
                </template>

                {{-- Categories --}}
                <template x-if="promo.applyTo === 'category'">
                    <div class="flex flex-wrap gap-1.5">
                        <template x-for="(cat, index) in promo.selectedCategories.slice(0, 2)" :key="index">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-orange-50 text-orange-600 border border-orange-100">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
                                    <path fill-rule="evenodd" d="M10 2c-1.716 0-3.408.106-5.07.31C3.806 2.45 3 3.414 3 4.517V17.25a.75.75 0 0 0 1.075.676L10 15.082l5.925 2.844A.75.75 0 0 0 17 17.25V4.517c0-1.103-.806-2.068-1.93-2.207A41.403 41.403 0 0 0 10 2Z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="cat"></span>
                            </span>
                        </template>
                        <template x-if="promo.selectedCategories.length > 2">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-500 border border-gray-100" x-text="'+' + (promo.selectedCategories.length - 2)"></span>
                        </template>
                    </div>
                </template>

                {{-- Dishes --}}
                <template x-if="promo.applyTo === 'dish'">
                    <div class="flex flex-wrap gap-1.5">
                        <template x-for="(dish, index) in promo.selectedDishes.slice(0, 2)" :key="index">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
                                    <path fill-rule="evenodd" d="M10 3a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3ZM10 8c-3.12 0-5.789 1.636-7.148 4.09l-.499.9a.75.75 0 0 0 .656 1.114h13.982a.75.75 0 0 0 .656-1.114l-.499-.9C15.789 9.636 13.12 8 10 8Z" clip-rule="evenodd" />
                                </svg>
                                <span x-text="dish"></span>
                            </span>
                        </template>
                        <template x-if="promo.selectedDishes.length > 2">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-500 border border-gray-100" x-text="'+' + (promo.selectedDishes.length - 2)"></span>
                        </template>
                    </div>
                </template>
            </div>
        </div>


        {{-- Footer Info --}}
        <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
            <div class="flex flex-col gap-1">
                <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Valid Until</span>
                <span class="text-sm font-bold text-gray-700" x-text="formatDate(promo.endDate)"></span>
            </div>
            
            <div class="flex flex-col gap-1 items-end">
                <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Used</span>
                <div class="flex items-center gap-1 text-sm font-bold text-gray-700">
                    <span x-text="promo.usageCount"></span>
                    <span class="text-xs text-gray-400 font-normal">times</span>
                </div>
            </div>
        </div>
        
        {{-- Hover Action Indicator --}}
        <div class="absolute bottom-0 left-0 w-full h-1 bg-yellow-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
    </div>
</template>
