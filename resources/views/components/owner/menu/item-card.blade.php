<template x-for="(dish, index) in filteredDishes" :key="dish.name + index">
    <div class="relative group animate-entrance-card min-h-120"
         :class="'animate-delay-' + ((index % 6) * 100)"
         @click="openEditModal(dish)">
        <div class="bg-white rounded-4xl p-4 shadow-lg overflow-hidden border border-gray-100 transition-transform h-full flex flex-col">
            <!-- Image Container -->
            <div class="relative h-60 rounded-[24px] overflow-hidden mb-4 shrink-0">
                <img :src="dish.image" :alt="dish.name" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                
                <!-- Badges -->
                <div class="absolute top-2 right-2 flex flex-col gap-1 items-end">
                    <template x-if="dish.badge === 'special'">
                        <div class="bg-amber-100 text-amber-600 px-2.5 py-1 rounded-full text-[10px] font-bold shadow-sm transition-all duration-300 group-hover:bg-amber-500 group-hover:text-white group-hover:scale-105 flex items-center gap-1">
                            <span>Special</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </template>
                    
                    <template x-if="dish.badge === 'featured'">
                        <div class="bg-violet-100 text-violet-600 px-2.5 py-1 rounded-full text-[10px] font-bold shadow-sm transition-all duration-300 group-hover:bg-violet-500 group-hover:text-white group-hover:scale-105 flex items-center gap-1">
                            <span>Featured</span>
                        </div>
                    </template>
                
                    <template x-if="dish.badge === 'recommended'">
                        <div class="bg-sky-100 text-sky-600 px-2.5 py-1 rounded-full text-[10px] font-bold shadow-sm transition-all duration-300 group-hover:bg-sky-500 group-hover:text-white group-hover:scale-105 flex items-center gap-1">
                            <span>Recommended</span>
                        </div>
                    </template>

                    <template x-if="dish.badge === 'new'">
                        <div class="bg-emerald-100 text-emerald-600 px-2.5 py-1 rounded-full text-[10px] font-bold shadow-sm transition-all duration-300 group-hover:bg-emerald-500 group-hover:text-white group-hover:scale-105 flex items-center gap-1">
                            <span>New</span>
                        </div>
                    </template>
                </div>

                <div class="absolute top-2 left-2 bg-black/60 backdrop-blur-sm px-3 py-1.5 rounded-full text-white text-xs font-bold" x-text="'$' + dish.price"></div>
            </div>
            
            <!-- Content -->
            <div class="flex flex-col flex-1">
                <div class="flex justify-between items-start mb-2 gap-2">
                    <h2 class="text-xl font-black text-gray-900 leading-tight group-hover:text-yellow-500 transition-colors line-clamp-1" :title="dish.name" x-text="dish.name"></h2>
                    <!-- Star Rating -->
                    <div class="flex text-yellow-400 text-xs shrink-0 pt-1">
                        <template x-for="i in 5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3"
                                :class="i <= (dish.rating || 0) ? 'text-yellow-400' : 'text-gray-200'">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                        </template>
                    </div>
                </div>

                <p class="text-xs text-gray-500 mb-4 leading-relaxed line-clamp-2 h-10" :title="dish.description" x-text="dish.description"></p>
                
                <div class="mt-auto">
                    <div class="flex flex-wrap gap-2 text-[10px] font-bold text-gray-500 mb-4">
                        <div class="bg-green-100 text-green-700 px-2 py-1 rounded truncate max-w-[100px]" x-text="dish.category"></div>
                        <div class="bg-gray-100 px-2 py-1 rounded flex items-center gap-1">
                            🕒 <span x-text="dish.prepTime + 'min'"></span>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button class="flex-1 bg-yellow-400 cursor-pointer hover:bg-yellow-500 text-gray-900 font-bold py-2.5 rounded-full transition-colors duration-300 text-sm shadow-sm hover:shadow-md">
                            Edit
                        </button>
                        <button @click.stop="openDeleteConfirmModal(dish)" 
                                class="px-3 bg-gray-100 cursor-pointer hover:bg-red-100 text-gray-500 hover:text-red-500 font-bold py-2.5 rounded-full transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
