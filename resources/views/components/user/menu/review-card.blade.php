<div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
    {{-- Header with Avatar and Dish Name --}}
    <div class="flex items-start gap-4 mb-4">
        {{-- User Avatar --}}
        <div class="shrink-0">
            <img :src="review.userAvatar" 
                 :alt="review.userName" 
                 class="w-14 h-14 rounded-full object-cover border-2 border-yellow-100">
        </div>
        
        {{-- User Info and Dish --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between gap-2 mb-1">
                <h4 class="text-lg font-bold text-gray-900 truncate" x-text="review.userName"></h4>
                <div class="flex items-center gap-1 shrink-0">
                    <template x-for="i in 5" :key="i">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                             class="w-4 h-4"
                             :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-200'">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                        </svg>
                    </template>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500">reviewed</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                        <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                    </svg>
                    <span x-text="review.dishName"></span>
                </span>
            </div>
        </div>
    </div>
    
    {{-- Review Content --}}
    <p class="text-gray-600 leading-relaxed line-clamp-3" x-text="review.content"></p>
    
    {{-- Footer with Date --}}
    <div class="mt-4 pt-4 border-t border-gray-100">
        <span class="text-xs text-gray-400" x-text="review.date"></span>
    </div>
</div>
