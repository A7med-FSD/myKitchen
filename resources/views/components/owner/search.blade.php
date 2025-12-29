@props(['searchplacehold', 'filter'])

            <div class="w-full max-w-2xl md:w-96 relative group grow animate-entrance-search z-50">
                <input type="text" 
                    x-model="searchQuery"
                    placeholder="{{$searchplacehold}}" 
                    class="w-full bg-white border-none outline-none rounded-full py-3 pl-12 pr-20 shadow-sm focus:ring-2 focus:ring-gray-200 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-4 top-3.5 text-gray-400 size-5 group-focus-within:text-gray-600 transition-colors">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" />
                </svg>
                <svg x-show="searchQuery" 
                    @click="searchQuery = ''"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                    class="absolute right-12 top-3.5 z-50 text-gray-400 size-5 cursor-pointer hover:text-gray-600 transition-colors">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>

                {{-- Search Filter Dropdown --}}
                <div x-data="{ showFilter: false }" class="absolute z-50 right-4 top-3.5">
                    <svg @click="showFilter = !showFilter" @click.outside="showFilter = false" 
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                        class="text-gray-400 size-5 cursor-pointer hover:text-gray-600 transition-colors z-50"
                        :class="searchFilter !== 'All' ? 'text-yellow-500 hover:text-yellow-600' : ''">
                        <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                    </svg>
                    
                    {{-- Dropdown Menu --}}
                    <div x-show="showFilter" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 top-8 w-48 bg-white rounded-2xl overflow-hidden shadow-xl py-2 border z-50 border-gray-100 dark:border-gray-800"
                        style="display: none;">
                        
                        <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Search By</div>
                        
                        <template x-for="{{$filter}}">
                            <button @click="searchFilter = filter; showFilter = false"
                                    class="w-full text-left px-4 py-2.5 text-sm font-medium hover:bg-yellow-50 hover:text-yellow-700 transition-colors flex items-center justify-between"
                                    :class="searchFilter === filter ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600'">
                                <span x-text="filter"></span>
                                <svg x-show="searchFilter === filter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-yellow-500">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>
            </div>