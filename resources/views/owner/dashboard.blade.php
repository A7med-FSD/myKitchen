<x-owner.layout>
    <!-- Dashboard Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/entrance.css') }}">
    
    <!-- Dashboard Scripts - Must load BEFORE Alpine.js -->
    <script src="{{ asset('assets/js/owner/dashboard.js') }}"></script>

    <div class="space-y-6" x-data="{ selectedDay: 'Mon' }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center gap-14">
            <!-- Header Greeting -->
            <div class="flex items-center flex-wrap gap-4 animate-entrance-header">
                <div class="relative">
                    <div class="w-16 h-16 bg-yellow-400 rounded-2xl flex items-center justify-center transform -rotate-6 shadow-lg">
                        <span class="text-3xl">👨‍🍳</span>
                    </div>
                    <div class="absolute -top-2 -right-2 w-4 h-4 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Hello, Chef <span class="text-yellow-500 underline decoration-wavy decoration-2 underline-offset-4">Ahmed</span>
                        <span class="inline-block animate-bounce origin-bottom-right">👋</span>
                    </h1>
                    <div class="flex items-center gap-2 mt-1 text-gray-500 font-medium whitespace-nowrap text-sm md:text-sm">
                        You have
                        <span class="bg-white border border-yellow-200 hover:border-yellow-400 text-yellow-400 font-bold cursor-pointer hover:bg-yellow-400 hover:text-white transition-colors duration-200 text-xs px-2 py-0.5 rounded-full shadow-sm">8 new orders</span>
                        waiting for you today!
                    </div>
                </div>
            </div>
            <div class="w-full max-w-2xl md:w-96 relative group grow animate-entrance-search">
                <input type="text" placeholder="Search orders, menu, etc..." class="w-full bg-white border-none outline-none rounded-full py-3 px-5 pl-12 shadow-sm focus:ring-2 focus:ring-gray-200 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-4 top-3.5 text-gray-400 size-5 group-focus-within:text-gray-600 transition-colors">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute right-4 top-3.5 text-gray-400 size-5 cursor-pointer hover:text-gray-600 transition-colors">
                    <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                </svg>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <!-- 1. Schedule Column (Column 1) - UPDATED -->
            <div class="md:col-span-5 lg:col-span-4 xl:col-span-3 bg-white rounded-3xl p-6 shadow-sm min-h-[600px] flex flex-col animate-entrance-col1" x-data="scheduleHandler()">
                
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-bold text-lg flex items-center gap-2">
                        <!-- Clock Icon with check -->
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <div class="absolute -bottom-1 -right-1 bg-white rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3 text-green-500">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        View Today's Orders
                    </h2>
                    <button 
                        class="text-gray-400 hover:text-gray-600 transition cursor-pointer relative"
                        @click="toggleEditMode()"
                        :class="editMode ? 'text-yellow-500 hover:text-yellow-600' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        <!-- Edit Mode Indicator -->
                        <div x-show="editMode" class="absolute -top-1 -right-1 w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                    </button>
                </div>

                <!-- Date Strip (Circular) -->
                <div class="flex justify-between items-center mb-4 px-2">
                    <button class="text-gray-400 hover:text-gray-600 transition" @click="prevDay()">&lt;</button>
                    <div class="flex-1 flex justify-around gap-2 px-2 overflow-x-auto noscroll">
                        <template x-for="(day, index) in days" :key="index">
                            <div class="flex flex-col items-center justify-center w-10 h-14 rounded-4xl cursor-pointer transition-all duration-300"
                                :class="selectedDay === day.dayName ? 'bg-yellow-400 shadow-lg shadow-yellow-100' : 'hover:bg-gray-200'"
                                @click="selectedDay = day.dayName">
                                <div class="text-sm font-bold" :class="selectedDay === day.dayName ? 'text-gray-900' : 'text-gray-500'" x-text="day.date"></div>
                                <div class="text-[10px]" :class="selectedDay === day.dayName ? 'text-gray-800' : 'text-gray-400'" x-text="day.dayName"></div>
                            </div>
                        </template>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 transition" @click="nextDay()">&gt;</button>
                </div>

                <!-- Status Selection Toolbar (shown when edit mode is active) -->
                <div 
                    x-show="editMode"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="mb-6 p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl border-2 border-yellow-200">
                    <div class="text-xs font-bold text-gray-600 mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-yellow-500">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                        Select status, then click on an order
                    </div>
                    <div class="grid grid-cols-[repeat(auto-fit,minmax(50px,1fr))] gap-2">
                        <template x-for="statusOption in statusOptions" :key="statusOption.key">
                            <button
                                @click="selectStatus(statusOption.key)"
                                class="flex cursor-pointer flex-col items-center gap-1 p-2 rounded-xl transition-all duration-300 transform border-2"
                                :class="selectedStatus === statusOption.key 
                                    ? statusOption.bgClass + ' text-white shadow-xl' 
                                    : 'bg-white ' + statusOption.borderClass + ' ' + statusOption.colorClass + ' hover:shadow-lg'">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                    :class="selectedStatus === statusOption.key ? 'bg-white/30' : 'bg-gray-50'"
                                    x-html="statusOption.icon">
                                </div>
                                <span class="text-[8px] font-bold leading-tight text-center" x-text="statusOption.label"></span>
                                <!-- Selected indicator -->
                                <div x-show="selectedStatus === statusOption.key" 
                                    class="absolute -top-1 -right-1 w-3 h-3 bg-white rounded-full flex items-center justify-center">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="space-y-0 relative pl-4 flex-1 overflow-y-auto noscroll pr-2">
                    <!-- Dynamic Event List -->
                    <template x-for="(event, index) in currentEvents" :key="index">
                        <div class="relative pl-8 pb-8 group"
                            :class="editMode ? 'cursor-pointer' : ''"
                            @click="applyStatusToOrder(index)">
                            <!-- Connecting Line -->
                            <div class="absolute left-[11px] top-6 bottom-[-10px] w-[2px] border-l-2 transition-all duration-500"
                                :class="{
                                    'border-green-500 border-dashed': event.status === 'ready',
                                    'border-purple-500 border-dashed': event.status === 'delivered',
                                    'border-yellow-500 border-dashed': event.status === 'pending',
                                    'border-blue-500 border-dashed': event.status === 'in-progress',
                                    'border-red-500 border-dashed': event.status === 'cancelled',
                                    'border-gray-200 border-dashed': !event.status
                                }"
                                x-show="index !== currentEvents.length - 1"></div>

                            <!-- Status Icon -->
                            <div class="absolute left-0 top-1 z-10 bg-white">
                                <!-- Ready -->
                                <template x-if="event.status === 'ready'">
                                    <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-white shadow-sm ring-4 ring-white transition-all duration-300"
                                        :class="editMode ? 'ring-green-200 shadow-lg shadow-green-200 group-hover:scale-110' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </template>
                                <!-- Delivered -->
                                <template x-if="event.status === 'delivered'">
                                    <div class="w-6 h-6 rounded-full bg-purple-500 flex items-center justify-center text-white shadow-sm ring-4 ring-white transition-all duration-300"
                                        :class="editMode ? 'ring-purple-200 shadow-lg shadow-purple-200 group-hover:scale-110' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                        <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 116 0h3a.75.75 0 00.75-.75V15z" />
                                        </svg>
                                    </div>
                                </template>
                                <!-- Pending -->
                                <template x-if="event.status === 'pending'">
                                    <div class="w-6 h-6 rounded-full bg-yellow-500 flex items-center justify-center text-white shadow-sm ring-4 ring-white transition-all duration-300"
                                        :class="editMode ? 'ring-yellow-200 shadow-lg shadow-yellow-200 group-hover:scale-110' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </template>
                                <!-- In Progress -->
                                <template x-if="event.status === 'in-progress'">
                                    <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-sm ring-4 ring-white transition-all duration-300"
                                        :class="editMode ? 'ring-blue-200 shadow-lg shadow-blue-200 group-hover:scale-110' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                        <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0015.059-4.035.75.75 0 00-.53-.918z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </template>
                                <!-- Cancelled -->
                                <template x-if="event.status === 'cancelled'">
                                    <div class="w-6 h-6 rounded-full bg-red-500 flex items-center justify-center text-white shadow-sm ring-4 ring-white transition-all duration-300"
                                        :class="editMode ? 'ring-red-200 shadow-lg shadow-red-200 group-hover:scale-110' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </template>
                            </div>

                            <!-- Content -->
                            <div class="transition-all duration-200" :class="editMode ? 'group-hover:translate-x-1' : ''">
                                <span class="text-xs text-gray-400 block mb-1 font-medium" x-text="event.time"></span>
                                <h3 class="font-bold text-gray-800 text-sm mb-2" x-text="event.title"></h3>
                                
                                <div class="flex flex-wrap gap-2 text-[10px] font-semibold" x-show="event.tags && event.tags.length">
                                    <template x-for="tag in event.tags">
                                        <span class="px-2 py-1 rounded flex items-center gap-1"
                                            :class="tag.colorClass || 'bg-gray-100 text-gray-500'">
                                            <span x-text="tag.label"></span>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <!-- Empty State -->
                    <div x-show="currentEvents.length === 0" class="text-center py-10 text-gray-400 text-sm">
                        No orders for this day.
                    </div>
                </div>
            </div>



            <!-- 2. Center Column (Column 2) -->
            <div class="md:col-span-7 lg:col-span-5 xl:col-span-6 space-y-6 grid grid-cols-12 animate-entrance-col2">
                <!-- Report Card - ADAPTED: Business Metrics (Interactive) -->
                <div class="bg-white rounded-3xl p-6 shadow-sm col-span-12 xl:col-span-12" x-data="performanceStats()">
                    <div class="flex items-end gap-2 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-gray-400">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm4.5 7.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5a.75.75 0 0 1 .75-.75Zm3.75-3a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-1.5 0v-7.5a.75.75 0 0 1 .75-.75Zm3.75 2.25a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0v-5.25a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                        </svg>
                        <h2 class="font-bold text-lg">Performance <span class="text-gray-400 text-sm font-normal">This week</span></h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Revenue Card - Clean Design -->
                        <div class="bg-white border-2 border-yellow-400/30 rounded-2xl p-2 md:p-4 text-gray-800 relative h-36 flex flex-col justify-between overflow-hidden group hover:border-yellow-400/60 hover:shadow-xl hover:shadow-yellow-50 transition-all duration-300">
                            
                            <!-- Floating Dollar Icon -->
                            <div class="absolute top-3 right-3 z-10 hidden sm:block md:hidden xl:block">
                                <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center shadow-sm border border-yellow-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-yellow-500">
                                        <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-bold text-gray-600 text-xs uppercase tracking-wider">Total Revenue</h3>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-green-700 bg-green-50 px-2 py-0.5 rounded-full font-semibold flex items-center gap-1 border border-green-200">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                                        </svg>
                                        +24%
                                    </span>
                                </div>
                            </div>

                            <div class="relative z-10">
                                <!-- Revenue Amount -->
                                <div class="flex items-baseline gap-1 mb-2">
                                    <span class="text-2xl md:text-3xl font-black tracking-tight text-gray-900">$</span>
                                    <span class="text-3xl md:text-4xl font-black tracking-tight text-gray-900" x-text="formatNumber(revenue)">0</span>
                                    <span class="text-sm text-gray-500 font-medium ml-1">USD</span>
                                </div>
                                
                                <!-- Mini Bar Chart -->
                                <div class="flex items-end gap-0.5 h-6">
                                    <div class="w-full bg-yellow-200 rounded-sm" style="height: 40%"></div>
                                    <div class="w-full bg-yellow-300 rounded-sm" style="height: 55%"></div>
                                    <div class="w-full bg-yellow-200 rounded-sm" style="height: 35%"></div>
                                    <div class="w-full bg-yellow-300 rounded-sm" style="height: 70%"></div>
                                    <div class="w-full bg-yellow-300 rounded-sm" style="height: 50%"></div>
                                    <div class="w-full bg-yellow-400 rounded-sm animate-pulse" style="height: 85%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Orders (Orange) - Circular Progress -->
                        <div class="bg-white border border-gray-100 rounded-2xl p-2 md:p-4 text-gray-800 h-36 flex flex-col justify-between group hover:border-orange-200 hover:shadow-md transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-orange-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-150 duration-500"></div>
                            
                            <h3 class="font-bold text-gray-700 z-10">Active Orders</h3>
                            
                            <div class="flex items-center justify-between mt-2 z-10">
                                <!-- Circular Progress -->
                                <div class="relative w-16 h-16">
                                    <svg class="w-full h-full transform -rotate-90">
                                        <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="6" fill="transparent" class="text-gray-100" />
                                        <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="6" fill="transparent" 
                                                class="text-orange-500 transition-all duration-1000 ease-out"
                                                :stroke-dasharray="2 * Math.PI * 28"
                                                :stroke-dashoffset="2 * Math.PI * 28 * (1 - activeOrders / 100)"
                                                stroke-linecap="round" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center font-bold text-sm text-gray-800">
                                        <span x-text="activeOrders">0</span>%
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900">12</div>
                                    <div class="text-xs text-gray-400">Current</div>
                                </div>
                            </div>
                        </div>

                        <!-- Avg Prep Time (Green) - Pulse Graph -->
                        <div class="bg-white border border-gray-100 rounded-2xl p-2 md:p-4 text-gray-800 h-36 flex flex-col justify-between group hover:border-green-200 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-gray-700">Prep Time</h3>
                                <span class="bg-green-100 text-green-600 text-[10px] font-bold px-1.5 py-0.5 rounded flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" /></svg>
                                    12%
                                </span>
                            </div>

                            <div class="h-12 w-full mt-1 relative overflow-hidden">
                                <!-- Live Pulse Line -->
                                <svg viewBox="0 0 100 40" class="w-full h-full stroke-green-500 fill-none stroke-2 drop-shadow-sm">
                                <path d="M0,20 L10,20 L20,10 L30,30 L40,20 L60,20 L70,5 L80,35 L90,20 L100,20" 
                                        class="animate-[dash_2s_linear_infinite]" 
                                        stroke-dasharray="100" stroke-dashoffset="100"/>
                                </svg>
                            </div>
                            
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl font-bold text-gray-900">15</span>
                                <span class="text-sm text-gray-500 font-medium">min</span>
                                <span class="text-[10px] text-gray-400 ml-auto font-medium">Avg: 17m</span>
                            </div>
                        </div>

                        <!-- Rating (Pink) - Star Fill -->
                        <div class="bg-white border border-gray-100 rounded-2xl p-2 md:p-4 text-gray-800 h-36 flex flex-col justify-between group hover:border-pink-200 hover:shadow-md transition-all duration-300">
                            <h3 class="font-bold text-xs md:text-base text-gray-700">Average Rating</h3>
                            
                            <div class="flex items-center flex-wrap justify-between">
                                <div class="text-4xl font-black text-gray-900 tracking-tighter" x-text="rating.toFixed(1)">0.0</div>
                                <div class="flex flex-col items-end">
                                    <div class="flex text-yellow-400 gap-0.5">
                                        <!-- Animated Stars -->
                                        <template x-for="i in 5">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 transition-transform hover:scale-125"
                                                :class="i <= Math.round(rating) ? 'text-yellow-400' : 'text-gray-200'">
                                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006Z" clip-rule="evenodd" />
                                            </svg>
                                        </template>
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-1 font-medium">152 Reviews</div>
                                </div>
                            </div>
                            
                            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-2 overflow-hidden">
                                <div class="bg-pink-500 h-full rounded-full transition-all duration-1000 ease-out" 
                                     :style="`width: ${(rating / 5) * 100}%`"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-12 gap-6 col-span-12">
                    <!-- ADAPTED: Top Selling Items -->
                    <div class="col-span-12 sm:col-span-6 bg-white rounded-3xl p-5 shadow-sm" x-data="topItemsStats()">
                        <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-gray-400">
                            <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.177 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                        </svg>
                            Top Items
                        </h2>
                        <div class="flex justify-around text-center">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="group cursor-pointer" @click="activeItem = index">
                                    <div class="w-11 h-11 rounded-full border-4 flex items-center justify-center font-bold text-2xl transition-all duration-300 transform group-hover:scale-110"
                                        :class="{'border-green-400': item.color === 'green', 'border-orange-400': item.color === 'orange', 'border-blue-400': item.color === 'blue', 'ring-4 ring-gray-200': activeItem === index}">
                                        <span x-text="item.icon"></span>
                                    </div>
                                    <span class="text-xs mt-1 block font-medium transition-colors" 
                                        :class="activeItem === index ? 'text-gray-900 font-bold' : 'text-gray-400 group-hover:text-gray-600'" 
                                        x-text="item.name"></span>
                                </div>
                            </template>
                        </div>
                        
                        <div class="mt-6">
                            <div class="flex justify-between text-xs text-gray-500 mb-2 font-medium">
                                <span>Monthly Goal (<span x-text="currentItem.name"></span>)</span>
                                <span><span x-text="currentItem.count"></span> / <span x-text="currentItem.goal"></span> Orders</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000 ease-out relative"
                                    :class="{'bg-green-500': currentItem.color === 'green', 'bg-orange-500': currentItem.color === 'orange', 'bg-blue-500': currentItem.color === 'blue'}"
                                    :style="`width: ${(currentItem.count / currentItem.goal) * 100}%`">
                                    <div class="absolute inset-0 bg-white/20 animate-[shimmer_2s_infinite]"></div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- ADAPTED: Sales Chart -->
                    <div class="col-span-12 sm:col-span-6 bg-white rounded-3xl p-6 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="font-bold text-lg flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-gray-400">
                                    <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
                                </svg>
                                Sales
                            </h2>
                            <span class="text-xs text-green-500 bg-green-50 px-2 py-1 rounded">+15%</span>
                        </div>
                    
                        <div class="grid grid-cols-7 gap-2 items-end h-32">
                            @foreach([40, 60, 30, 80, 50, 90, 70] as $h)
                            <div class="w-full bg-purple-100 rounded-t-md hover:bg-purple-300 transition-colors relative group" style="height: {{$h}}%">
                                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-black text-white text-[10px] px-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">{{$h}}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-7 gap-2 text-xs text-gray-400 mt-2">
                            <span class="text-center">Sun</span>
                            <span class="text-center">Mon</span>
                            <span class="text-center">Tue</span>
                            <span class="text-center">Wed</span>
                            <span class="text-center">Thu</span>
                            <span class="text-center">Fri</span>
                            <span class="text-center">Sat</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Shopping List (Column 3) - ADAPTED: Inventory/Restock -->
            <div class="md:col-span-10 lg:col-span-3 flex flex-wrap gap-6 animate-entrance-col3 relative">
                <div class="bg-white rounded-3xl p-5 grow shadow-sm" x-data="{ 
                    ...restockList(), 
                    showModal: false,
                    newItem: { name: '', icon: '', q: '', tag: '' }
                }">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-bold text-lg flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-gray-400">
                                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                            </svg>
                            Restock List
                        </h2>
                        <a href="{{ route('owner.inventory') }}" class="text-gray-400 hover:text-yellow-500 transition-colors flex items-center gap-1 text-xs font-semibold group">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 group-hover:rotate-12 transition-transform">
                                <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.122 2.122 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                            </svg>
                            Edit List
                        </a>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex items-center gap-3 group">
                                    <div class="rounded-md w-5 h-5 flex items-center justify-center transition-all cursor-pointer border-2"
                                        :class="item.stock ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-gray-400'"
                                        @click="toggleStock(index)">
                                    <template x-if="item.stock">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3 text-white"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
                                    </template>
                                    </div>
                                    <div class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center text-lg shadow-sm" x-text="item.icon"></div>
                                <div class="flex-1 text-sm font-semibold flex items-center gap-2">
                                    <span x-text="item.name"></span>
                                    <template x-if="item.tag">
                                        <span class="bg-blue-100 text-blue-500 text-[10px] px-1 rounded" x-text="item.tag"></span>
                                    </template>
                                </div>
                                <div class="text-sm font-bold text-gray-500" x-text="item.q"></div>
                            </div>
                        </template>
                    </div>

                    <button @click="showModal = true" class="w-full mt-8 bg-violet-500 hover:bg-violet-600 cursor-pointer text-white font-bold py-3 rounded-2xl flex items-center justify-center gap-2 transition duration-300 transform hover:scale-105">
                        Add New Item
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Add Item Modal -->
                    <div x-show="showModal" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 z-50 flex items-center justify-center p-4 min-w-70"
                        @click.self="showModal = false">
                        
                        <div x-show="showModal"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
                            class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden" 
                            @click.stop>
                            
                            <!-- Modal Header -->
                            <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-6 relative overflow-hidden">
                                <div class="relative flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-white">Add New Item</h3>
                                            <p class="text-violet-100 text-sm">Add to your restock list</p>
                                        </div>
                                    </div>
                                    <button @click="showModal = false" class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Modal Body -->
                            <div class="p-6 space-y-4">
                                <!-- Item Name -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Item Name</label>
                                    <input type="text" 
                                        x-model="newItem.name"
                                        placeholder="e.g., Tomatoes"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-violet-500 focus:ring-0 transition-colors">
                                </div>

                                <!-- Icon Emoji -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Icon (Emoji)</label>
                                    <input type="text" 
                                        x-model="newItem.icon"
                                        placeholder="🍅"
                                        maxlength="2"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-violet-500 focus:ring-0 transition-colors text-2xl">
                                </div>

                                <!-- Quantity -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Quantity</label>
                                    <input type="text" 
                                        x-model="newItem.q"
                                        placeholder="e.g., 5 kg"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-violet-500 focus:ring-0 transition-colors">
                                </div>

                                <!-- Tag (Optional) -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Tag (Optional)</label>
                                    <input type="text" 
                                        x-model="newItem.tag"
                                        placeholder="e.g., Low"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-violet-500 focus:ring-0 transition-colors">
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="p-6 bg-gray-50 flex gap-3">
                                <button @click="showModal = false" 
                                        class="flex-1 px-6 py-3 cursor-pointer bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors">
                                    Cancel
                                </button>
                                <button @click="
                                    if (newItem.name && newItem.icon && newItem.q) {
                                        items.push({ 
                                            name: newItem.name, 
                                            icon: newItem.icon, 
                                            q: newItem.q, 
                                            tag: newItem.tag || null,
                                            stock: false 
                                        });
                                        newItem = { name: '', icon: '', q: '', tag: '' };
                                        showModal = false;
                                    }
                                " 
                                        class="flex-1 px-6 py-3 cursor-pointer bg-gradient-to-r from-violet-500 to-purple-600 text-white font-bold rounded-xl hover:from-violet-600 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg">
                                    Add Item
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                
                {{-- main dish design --}}
                {{-- <div class="relative group cursor-pointer">
                    <div class="bg-white rounded-[32px] p-4 shadow-lg overflow-hidden border border-gray-100 transition-transform hover:-translate-y-1">
                        <div class="relative h-48 rounded-[24px] overflow-hidden mb-4">
                            <img src="https://images.unsplash.com/photo-1555126634-323283e090fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Shrimp Stir-Fry" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-2 right-2 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full text-[10px] font-bold">🔥 Signature</div>
                        </div>
                        
                        <h2 class="text-2xl font-black text-gray-900 leading-tight mb-2 font-serif group-hover:text-yellow-600 transition-colors">Shrimp Stir-Fry with Brown Rice</h2>
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed">A quick and healthy stir-fry with succulent shrimp, colorful vegetables, and a side of brown rice.</p>
                        
                        <div class="flex flex-wrap gap-2 text-[10px] font-bold text-gray-600 mb-6">
                            <div class="bg-green-100 text-green-700 px-2 py-1 rounded">Main dish</div>
                            <div class="bg-gray-100 px-2 py-1 rounded flex items-center gap-1">⚫ 350kcal</div>
                            <div class="bg-gray-100 px-2 py-1 rounded flex items-center gap-1">🕒 45min</div>
                        </div>

                        <h3 class="font-bold text-gray-900 mb-4">Ingredients</h3>
                        <div class="flex justify-between items-center text-center text-xs text-gray-500 mb-8">
                            <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-xl">🍤</div>
                                <span>60g</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-xl">🍚</div>
                                <span>100g</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-xl">🧅</div>
                                <span>1/2</span>
                            </div>
                             <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-xl">🥬</div>
                                <span>20g</span>
                            </div>
                             <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-xl">🧴</div>
                                <span>10ml</span>
                            </div>
                        </div>

                         <div class="flex items-center justify-between gap-4 text-xs font-bold text-gray-500 mb-6">
                            <div class="flex items-center gap-1"><span class="text-orange-500">🔥</span> Medium</div>
                            <div class="flex items-center gap-1">21.8K <span class="text-gray-300">👁</span> 156.1K</div>
                         </div>

                        <button class="w-full bg-white border border-gray-900 text-gray-900 font-bold py-3 rounded-full flex items-center justify-center gap-2 hover:bg-gray-900 hover:text-white transition-colors duration-300">
                            Explore Recipe <span>↗</span>
                        </button>
                    </div>
                </div> --}}
                
                <!-- Promo / Banner -> ADAPTED: Create Promotion -->
                <div class="bg-gradient-to-r max-w-[250px] shrink from-violet-600 flex to-indigo-600 rounded-3xl p-6 text-white text-center relative overflow-hidden group hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300">
                    <!-- Dynamic Background Shapes -->
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 bg-pink-500 opacity-20 rounded-full blur-xl group-hover:scale-125 transition-transform duration-700"></div>
                    
                    <!-- Floating Icons Decoration -->
                    <div class="absolute top-4 left-6 text-indigo-200 opacity-60 text-xl animate-bounce" style="animation-duration: 3s;">✦</div>
                    <div class="absolute bottom-6 right-6 text-pink-200 opacity-40 text-xl animate-pulse">★</div>
    
                    <div class="relative z-10 flex justify-evenly flex-col items-center">
                        <div class="w-14 h-14 mx-auto bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-4 shadow-sm group-hover:rotate-12 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-white"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006Z" clip-rule="evenodd" /></svg>
                        </div>
                        
                        <div>
                            <h3 class="font-bold text-xl mb-1 tracking-tight">Boost Your Sales!</h3>
                            <p class="text-indigo-100 text-xs mb-5 font-medium px-4 leading-relaxed">launch a special offer for this weekend to attract more customers.</p>
                        </div>
                        
                        <button class="bg-white cursor-pointer text-indigo-600 px-6 py-2.5 rounded-full text-sm font-bold shadow-md hover:bg-indigo-50 hover:scale-105 transition-all duration-300 w-full flex items-center justify-center gap-2">
                            <span>+</span> Create Promotion
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-owner.layout>
