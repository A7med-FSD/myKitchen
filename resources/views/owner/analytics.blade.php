<x-owner.layout>
    <script src="{{ asset('assets/js/owner/analytics.js') }}"></script>

    <div class="space-y-6 pb-20" x-data="analyticsHandler()">
        <!-- Header with Heading -->
        <x-owner.heading>
            <x-slot:title>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-yellow-500">
                    <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3z" clip-rule="evenodd" />
                </svg>
                Analytics Dashboard
            </x-slot:title>
            <x-slot:subtitle>Business insights and performance metrics</x-slot:subtitle>
            
            {{-- <x-slot:searchplacehold></x-slot:searchplacehold>
            <x-slot:filter></x-slot:filter> --}}
            

            
            <div class="flex flex-col gap-4">
                
                <!-- Quick Stats -->
                <div class="flex flex-wrap gap-3">
                    <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                        <div class="text-2xl font-bold text-gray-900">$<span x-text="formatCurrency(revenue.total)"></span></div>
                        <div class="text-xs text-gray-500">Total Revenue</div>
                    </div>
                    <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                        <div class="text-2xl font-bold text-gray-900" x-text="orders.total"></div>
                        <div class="text-xs text-gray-500">Orders</div>
                    </div>
                    <div class="bg-white px-4 py-3 rounded-2xl shadow-sm">
                        <div class="text-2xl font-bold text-gray-900" x-text="customers.total"></div>
                        <div class="text-xs text-gray-500">Customers</div>
                    </div>
                </div>
            </div>
        </x-owner.heading>
        <!-- Date Range Filter -->
        <x-owner.search-filter.analytics-date-filter />
        <div class="grid grid-cols-12 gap-6">
            <!-- Orders by Status (Donut Chart) -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 entrance-animation
            col-span-12 lg:col-span-8 xl:col-span-5">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                    </svg>
                    Orders by Status
                </h2>
                
                <div class="flex flex-col md:flex-row items-center gap-8 h-full">
                    <!-- Interactive Donut Chart -->
                    <div class="relative w-64 h-64 shrink-0" @mousemove="updateTooltip($event)">
                        <svg width="100%" height="100%" viewBox="0 0 100 100" class="transform -rotate-90">
                            <!-- Background Circle -->
                            <circle cx="50" cy="50" r="35" fill="none" stroke="#f3f4f6" stroke-width="25"></circle>
                            
                            <!-- Segment 0: Pending -->
                            <circle cx="50" cy="50" r="35" fill="none" 
                                :stroke="segments[0].color" 
                                stroke-width="25"
                                :stroke-dasharray="showAnimations ? segments[0].strokeDasharray : `0 ${donutCircumference}`"
                                :stroke-dashoffset="segments[0].strokeDashoffset"
                                class="transition-all duration-1000 ease-out cursor-pointer hover:scale-105 origin-center"
                                :style="{ opacity: hoveredSegment === null || hoveredSegment === 0 ? 1 : 0.2 }"
                                @mouseenter="hoveredSegment = 0; tooltipVisible = true"
                                @mouseleave="hoveredSegment = null; tooltipVisible = false">
                            </circle>

                            <!-- Segment 1: In Progress -->
                            <circle cx="50" cy="50" r="35" fill="none" 
                                :stroke="segments[1].color" 
                                stroke-width="25"
                                :stroke-dasharray="showAnimations ? segments[1].strokeDasharray : `0 ${donutCircumference}`"
                                :stroke-dashoffset="segments[1].strokeDashoffset"
                                class="transition-all duration-1000 ease-out cursor-pointer hover:scale-105 origin-center"
                                :style="{ opacity: hoveredSegment === null || hoveredSegment === 1 ? 1 : 0.2 }"
                                @mouseenter="hoveredSegment = 1; tooltipVisible = true"
                                @mouseleave="hoveredSegment = null; tooltipVisible = false">
                            </circle>

                            <!-- Segment 2: Ready -->
                            <circle cx="50" cy="50" r="35" fill="none" 
                                :stroke="segments[2].color" 
                                stroke-width="25"
                                :stroke-dasharray="showAnimations ? segments[2].strokeDasharray : `0 ${donutCircumference}`"
                                :stroke-dashoffset="segments[2].strokeDashoffset"
                                class="transition-all duration-1000 ease-out cursor-pointer hover:scale-105 origin-center"
                                :style="{ opacity: hoveredSegment === null || hoveredSegment === 2 ? 1 : 0.2 }"
                                @mouseenter="hoveredSegment = 2; tooltipVisible = true"
                                @mouseleave="hoveredSegment = null; tooltipVisible = false">
                            </circle>

                            <!-- Segment 3: Completed -->
                            <circle cx="50" cy="50" r="35" fill="none" 
                                :stroke="segments[3].color" 
                                stroke-width="25"
                                :stroke-dasharray="showAnimations ? segments[3].strokeDasharray : `0 ${donutCircumference}`"
                                :stroke-dashoffset="segments[3].strokeDashoffset"
                                class="transition-all duration-1000 ease-out cursor-pointer hover:scale-105 origin-center"
                                :style="{ opacity: hoveredSegment === null || hoveredSegment === 3 ? 1 : 0.2 }"
                                @mouseenter="hoveredSegment = 3; tooltipVisible = true"
                                @mouseleave="hoveredSegment = null; tooltipVisible = false">
                            </circle>

                            <!-- Segment 4: Cancelled -->
                            <circle cx="50" cy="50" r="35" fill="none" 
                                :stroke="segments[4].color" 
                                stroke-width="25"
                                :stroke-dasharray="showAnimations ? segments[4].strokeDasharray : `0 ${donutCircumference}`"
                                :stroke-dashoffset="segments[4].strokeDashoffset"
                                class="transition-all duration-1000 ease-out cursor-pointer hover:scale-105 origin-center"
                                :style="{ opacity: hoveredSegment === null || hoveredSegment === 4 ? 1 : 0.2 }"
                                @mouseenter="hoveredSegment = 4; tooltipVisible = true"
                                @mouseleave="hoveredSegment = null; tooltipVisible = false">
                            </circle>
                        </svg>

                        <!-- Center Text (Total Only) -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <div class="text-center transition-opacity duration-300" :class="hoveredSegment !== null ? 'opacity-50' : 'opacity-100'">
                                <div class="text-xs text-gray-500 font-medium">Total Orders</div>
                                <div class="text-3xl font-bold text-gray-900" x-text="totalOrders"></div>
                            </div>
                        </div>

                        <!-- Floating Tooltip -->
                        <div x-show="tooltipVisible && hoveredSegment !== null" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute z-10 pointer-events-none bg-gray-900/90 backdrop-blur-sm text-white px-3 py-2 rounded-lg shadow-xl text-center min-w-[80px]"
                                :style="`left: ${tooltipX}px; top: ${tooltipY - 50}px; transform: translateX(-50%);`">
                            <template x-if="hoveredSegment !== null">
                                <div>
                                    <div class="text-[10px] uppercase tracking-wider font-semibold text-gray-300" x-text="segments[hoveredSegment].label"></div>
                                    <div class="text-lg font-bold" x-text="segments[hoveredSegment].percentage + '%'"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Legend / Interactive List -->
                    <div class="flex-1 w-full shrink-0">
                        <template x-for="(segment, index) in segments" :key="index">
                            <button @mouseenter="hoveredSegment = index"
                                    @mouseleave="hoveredSegment = null"
                                    class="w-full flex items-center justify-between p-3 rounded-xl transition-all duration-200 border group active:scale-95 bg-white border-gray-100 hover:border-gray-300 hover:bg-gray-50"
                                    :style="{ opacity: hoveredSegment === null || hoveredSegment === index ? 1 : 0.4 }">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full shadow-sm" :style="`background-color: ${segment.color}`"></div>
                                    <span class="text-sm font-bold text-gray-700" x-text="segment.label"></span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-bold text-gray-900" x-text="segment.value"></span>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Completion Rate</span>
                        <span class="font-bold text-green-600" x-text="completedOrdersPercentage + '%'"></span>
                    </div>
                </div>
            </div>

            <!-- Revenue Section -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 entrance-animation
            col-span-12 xl:col-span-7">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                                <path fill-rule="evenodd" d="M12.577 4.878a.75.75 0 0 1 .919-.53l4.78 1.281a.75.75 0 0 1 .531.919l-1.281 4.78a.75.75 0 0 1-1.449-.387l.81-3.022a19.407 19.407 0 0 0-5.594 5.203.75.75 0 0 1-1.139.093L7 10.06l-4.72 4.72a.75.75 0 0 1-1.06-1.061l5.25-5.25a.75.75 0 0 1 1.06 0l3.074 3.073a20.923 20.923 0 0 1 5.545-4.931l-3.042-.815a.75.75 0 0 1-.53-.919Z" clip-rule="evenodd" />
                            </svg>
                            Revenue Trends
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Peak day: <span class="font-semibold" x-text="maxRevenueDay"></span></p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">$<span x-text="formatCurrency(revenue.total)"></span></div>
                        <div class="text-sm font-semibold flex items-center gap-1 justify-end mt-1"
                                :class="revenueChangePositive ? 'text-green-600' : 'text-red-600'">
                            <svg x-show="revenueChangePositive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.25-5.5a.75.75 0 0 1 1.08 0l5.25 5.5a.75.75 0 1 1-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0 1 10 17Z" clip-rule="evenodd" />
                            </svg>
                            <svg x-show="!revenueChangePositive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .75.75v10.638l3.96-4.158a.75.75 0 1 1 1.08 1.04l-5.25 5.5a.75.75 0 0 1-1.08 0l-5.25-5.5a.75.75 0 1 1 1.08-1.04l3.96 4.158V3.75A.75.75 0 0 1 10 3Z" clip-rule="evenodd" />
                            </svg>
                            <span x-text="Math.abs(revenueChange) + '%'"></span> vs last period
                        </div>
                    </div>
                </div>
                
                <!-- Line Chart -->
                <div class="relative h-64 flex items-end gap-2">
                    <template x-for="(value, index) in revenue.chartData.values" :key="index">
                        <div class="flex-1 flex flex-col items-center justify-end h-full gap-2 group">
                            <div class="w-full bg-gradient-to-t from-yellow-400 to-yellow-200 rounded-t-lg transition-all duration-1000 ease-out hover:from-yellow-500 hover:to-yellow-300 relative"
                                    :style="`height: ${showAnimations ? getBarHeight(value, Math.max(...revenue.chartData.values)) : 0}%`">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                    $<span x-text="value"></span>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 font-medium" x-text="revenue.chartData.labels[index]"></span>
                        </div>
                    </template>
                </div>
            </div>

            
            <!-- Orders Timeline -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 entrance-animation
            col-span-12 lg:col-span-9 xl:col-span-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                        <path d="M10.75 6.75a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z" />
                    </svg>
                    Orders Distribution
                </h2>
                
                <!-- Bar Chart -->
                <div class="relative h-48 flex items-end gap-2">
                    <template x-for="(value, index) in orders.timeline.values" :key="index">
                        <div class="flex-1 flex flex-col items-center justify-end h-full gap-2 group">
                            <div class="w-full bg-gradient-to-t from-blue-400 to-blue-200 rounded-t-lg transition-all duration-1000 ease-out hover:from-blue-500 hover:to-blue-300 relative"
                                    :style="`height: ${showAnimations ? getBarHeight(value, Math.max(...orders.timeline.values)) : 0}%`">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span x-text="value"></span> orders
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 font-medium" x-text="orders.timeline.labels[index]"></span>
                        </div>
                    </template>
                </div>
                
                <div class="mt-6 grid grid-cols-2 gap-4 pt-6 border-t border-gray-100">
                    <div>
                        <div class="text-xs text-gray-500">Avg Order Value</div>
                        <div class="text-lg font-bold text-gray-900">$<span x-text="orders.avgValue.toFixed(2)"></span></div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Peak Hour</div>
                        <div class="text-lg font-bold text-gray-900" x-text="orders.peakHour"></div>
                    </div>
                </div>
            </div>
            <!-- Top Selling Items -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 entrance-animation
            col-span-12 lg:col-span-6 xl:col-span-4">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                    </svg>
                    Top Selling Items
                </h2>
                
                <div class="space-y-4">
                    <template x-for="(item, index) in topItems" :key="index">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm"
                                 :class="index === 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500'">
                                <span x-text="index + 1"></span>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 text-sm" x-text="item.name"></div>
                                <div class="text-xs text-gray-500">
                                    <span x-text="item.orders"></span> orders · $<span x-text="item.revenue.toFixed(2)"></span>
                                </div>
                            </div>
                            <div class="text-sm font-semibold"
                                 :class="item.trend.startsWith('+') ? 'text-green-600' : 'text-red-600'"
                                 x-text="item.trend"></div>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Category Distribution -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 entrance-animation
            col-span-12 lg:col-span-6 xl:col-span-4">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                        <path d="M3 3a1 1 0 0 0 0 2h11a1 1 0 1 0 0-2H3ZM3 7a1 1 0 0 0 0 2h7a1 1 0 1 0 0-2H3ZM3 11a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2H3ZM15 8a1 1 0 1 0-2 0v5.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l3 3a1 1 0 0 0 1.414 0l3-3a1 1 0 0 0-1.414-1.414L15 13.586V8Z" />
                    </svg>
                    Category Performance
                </h2>
                
                <div class="space-y-3">
                    <template x-for="(percentage, category) in categoryDistribution" :key="category">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700" x-text="category"></span>
                                <span class="font-bold text-gray-900" x-text="percentage + '%'"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-purple-400 to-purple-600 rounded-full transition-all duration-500"
                                     :style="`width: ${percentage}%`"></div>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Top Category</span>
                        <span class="font-bold text-purple-600" x-text="topCategory"></span>
                    </div>
                </div>
            </div>

            <!-- Inventory Value -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 entrance-animation
            col-span-12 md:col-span-6 xl:col-span-4">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                        <path fill-rule="evenodd" d="M6 5v1H4.667a1.75 1.75 0 0 0-1.743 1.598l-.826 9.5A1.75 1.75 0 0 0 3.84 19H16.16a1.75 1.75 0 0 0 1.743-1.902l-.826-9.5A1.75 1.75 0 0 0 15.333 6H14V5a4 4 0 0 0-8 0Zm4-2.5A2.5 2.5 0 0 0 7.5 5v1h5V5A2.5 2.5 0 0 0 10 2.5ZM7.5 10a2.5 2.5 0 0 0 5 0V8.75a.75.75 0 0 1 1.5 0V10a4 4 0 0 1-8 0V8.75a.75.75 0 0 1 1.5 0V10Z" clip-rule="evenodd" />
                    </svg>
                    Inventory
                </h3>
                <div class="text-3xl font-bold text-gray-900 mb-2">$<span x-text="formatCurrency(inventory.totalValue)"></span></div>
                <div class="text-sm text-gray-500 mb-4">Total Stock Value</div>
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Items to Restock</span>
                        <span class="font-bold text-orange-600" x-text="inventory.restockNeeded"></span>
                    </div>
                    <a href="{{ route('owner.inventory') }}" class="mt-3 text-xs font-semibold text-yellow-600 hover:text-yellow-700 flex items-center gap-1">
                        View Inventory
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="col-span-12 xl:col-span-4 grid grid-cols-2 gap-4">
                <!-- Average Rating -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 entrance-animation
                col-span-1 xl:col-span-2 max-h-76">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                        </svg>
                        Average Rating
                    </h3>
                    <div class="text-3xl font-bold text-gray-900 mb-2" x-text="customers.avgRating.toFixed(1)"></div>
                    <div class="flex text-yellow-400 gap-0.5 mb-4">
                        <template x-for="i in 5" :key="i">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5"
                                 :class="i <= Math.round(customers.avgRating) ? 'text-yellow-400' : 'text-gray-200'">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                            </svg>
                        </template>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 h-full rounded-full transition-all duration-500"
                             :style="`width: ${(customers.avgRating / 5) * 100}%`"></div>
                    </div>
                </div>

                <!-- Customer Stats -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 entrance-animation
                col-span-1 xl:col-span-2">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                            <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM6 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM1.49 15.326a.78.78 0 0 1-.358-.442 3 3 0 0 1 4.308-3.516 6.484 6.484 0 0 0-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 0 1-2.07-.655ZM16.44 15.98a4.97 4.97 0 0 0 2.07-.654.78.78 0 0 0 .357-.442 3 3 0 0 0-4.308-3.517 6.484 6.484 0 0 1 1.907 3.96 2.32 2.32 0 0 1-.026.654ZM18 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM5.304 16.19a.844.844 0 0 1-.277-.71 5 5 0 0 1 9.947 0 .843.843 0 0 1-.277.71A6.975 6.975 0 0 1 10 18a6.974 6.974 0 0 1-4.696-1.81Z" />
                        </svg>
                        Customers
                    </h3>
                    <div class="text-3xl font-bold text-gray-900 mb-2" x-text="customers.total"></div>
                    <div class="text-sm text-gray-500 mb-4">
                        <span class="text-green-600 font-semibold" x-text="customers.new"></span> new this period
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Returning Rate</span>
                            <span class="font-bold text-green-600" x-text="customers.returningRate + '%'"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Performance Heatmap -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 entrance-animation
            col-span-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                            <path fill-rule="evenodd" d="M4.25 2A2.25 2.25 0 0 0 2 4.25v11.5A2.25 2.25 0 0 0 4.25 18h11.5A2.25 2.25 0 0 0 18 15.75V4.25A2.25 2.25 0 0 0 15.75 2H4.25ZM15 7.5h-4.75V3h4.75A1.25 1.25 0 0 0 15 4.25V7.5Zm-6.25-4.5v4.5H3.5V4.25A1.25 1.25 0 0 1 4.75 3h4ZM3.5 9h11v6.75c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25V9Z" clip-rule="evenodd" />
                        </svg>
                        Performance Heatmap
                    </h2>
                    <div class="flex items-center gap-3">
                        <!-- Pagination Controls (only for Month mode) -->
                        <div x-show="maxHeatmapPages > 1" class="flex items-center gap-2">
                            <button @click="prevHeatmapPage()" 
                                    :disabled="!canPagePrev()"
                                    :class="canPagePrev() ? 'text-gray-700 hover:bg-gray-100 cursor-pointer' : 'text-gray-300 cursor-not-allowed'"
                                    class="p-1.5 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full" x-text="heatmapPageInfo"></span>
                            <button @click="nextHeatmapPage()" 
                                    :disabled="!canPageNext()"
                                    :class="canPageNext() ? 'text-gray-700 hover:bg-gray-100 cursor-pointer' : 'text-gray-300 cursor-not-allowed'"
                                    class="p-1.5 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        
                    </div>
                </div>
                <p class="text-sm text-gray-500 mb-6">
                    <span x-show="dateRange === 'Week'">Order volume by day and hour</span>
                    <span x-show="dateRange === 'Month'">Order volume by week and day</span>
                    <span x-show="dateRange === 'Year'">Order volume by week across months</span>
                </p>
                
                <!-- Heatmap Grid -->
                <div class="overflow-x-auto px-4 py-10">
                    <div class="inline-flex flex-col gap-1 min-w-0">
                        <!-- Column Labels (Hours/Days/Months) -->
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-16"></span> <!-- Spacer for row labels -->
                            <div class="flex gap-1">
                                <template x-for="(label, index) in heatmapLabels.columns" :key="index">
                                    <div class="text-center text-[10px] text-gray-400 font-medium"
                                         :class="dateRange === 'Week' ? 'w-8' : (dateRange === 'Month' ? 'w-12' : 'w-16')"
                                         x-text="label"></div>
                                </template>
                            </div>
                        </div>

                        <!-- Heatmap Rows -->
                        <template x-for="(rowData, rowIndex) in heatmap" :key="rowIndex">
                            <div class="flex items-center gap-3">
                                <span class="w-16 text-xs font-bold text-gray-400 text-right" x-text="heatmapLabels.rows[rowIndex]"></span>
                                <div class="flex gap-1">
                                    <template x-for="(intensity, colIndex) in rowData" :key="colIndex">
                                        <div class="group relative">
                                            <div class="rounded transition-all duration-200 hover:scale-110 hover:shadow-md cursor-pointer"
                                                 :class="[getHeatmapColor(intensity), dateRange === 'Week' ? 'w-8 h-8' : (dateRange === 'Month' ? 'w-12 h-12' : 'w-16 h-10')]"></div>
                                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-10">
                                                <span x-text="heatmapLabels.rows[rowIndex]"></span>
                                                <span x-text="' - ' + heatmapLabels.columns[colIndex]"></span>:
                                                <span x-text="intensity"></span> orders
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            
            <div class="flex items-center gap-4 mt-6 text-xs text-gray-500">
                <span>Low Activity</span>
                <div class="flex gap-1">
                    <div class="w-4 h-4 bg-gray-50 rounded"></div>
                    <div class="w-4 h-4 bg-green-100 rounded"></div>
                    <div class="w-4 h-4 bg-yellow-200 rounded"></div>
                    <div class="w-4 h-4 bg-orange-300 rounded"></div>
                    <div class="w-4 h-4 bg-red-400 rounded"></div>
                </div>
                <span>High Activity</span>
            </div>
        </div>
    </div>
</div>
</x-owner.layout>
