<div class="bg-white rounded-2xl shadow-sm border-l-4 transition-all duration-200 hover:shadow-md entrance-animation cursor-pointer"
     :class="[
         notification.read ? 'bg-gray-50 opacity-75' : 'bg-white',
         notification.priority === 'critical' ? 'border-l-red-500' : 
         notification.priority === 'high' ? 'border-l-orange-500' : 
         notification.priority === 'normal' ? 'border-l-blue-500' : 'border-l-gray-400'
     ]"
     @click="!notification.read && toggleRead(notification.id)">
    <div class="p-5">
        <div class="flex items-start gap-4">
            <!-- Priority Icon -->
            <div class="shrink-0 w-12 h-12 rounded-full flex items-center justify-center"
                 :class="[
                     notification.priority === 'critical' ? 'bg-red-50' : 
                     notification.priority === 'high' ? 'bg-orange-50' : 
                     notification.priority === 'normal' ? 'bg-blue-50' : 'bg-gray-50'
                 ]">
                <!-- Security Icon for Critical -->
                <svg x-show="notification.type === 'security'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                     :class="notification.priority === 'critical' ? 'text-red-600' : 'text-gray-600'"
                     class="w-6 h-6">
                    <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08Zm3.094 8.016a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                </svg>
                
                <!-- Order Icon -->
                <svg x-show="notification.type === 'order'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                     :class="notification.priority === 'high' ? 'text-orange-600' : 'text-gray-600'"
                     class="w-6 h-6">
                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
                
                <!-- Review/Star Icon -->
                <svg x-show="notification.type === 'review'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                     :class="notification.priority === 'normal' ? 'text-blue-600' : 'text-gray-600'"
                     class="w-6 h-6">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                </svg>
                
                <!-- Thank You/Heart Icon -->
                <svg x-show="notification.type === 'thank_you'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                     class="w-6 h-6 text-gray-600">
                    <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                </svg>

                <!-- Alert Icon -->
                <svg x-show="notification.type === 'alert'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                     :class="notification.priority === 'high' ? 'text-orange-600' : 'text-gray-600'"
                     class="w-6 h-6">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            
            <!-- Content -->
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-gray-900" x-text="notification.title"></h3>
                            <span x-show="!notification.read" class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1" x-text="notification.message"></p>
                    </div>
                    <span class="text-xs text-gray-400 whitespace-nowrap" x-text="notification.time"></span>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center gap-3 mt-3">
                    {{-- Publish Review Button (for reviews/thank_you only) --}}
                    <button x-show="(notification.type === 'review' || notification.type === 'thank_you') && !notification.published" 
                            @click.stop="publishReview(notification.id)"
                            class="text-xs text-green-600 hover:text-green-700 hover:bg-green-50 px-3 py-1.5 rounded-lg font-semibold flex items-center gap-1 transition-all cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                            <path d="M3.5 2.75a.75.75 0 00-1.5 0v14.5a.75.75 0 001.5 0v-4.392l1.657-.348a6.449 6.449 0 014.271.572 7.948 7.948 0 005.965.524l2.078-.64A.75.75 0 0018 12.25v-8.5a.75.75 0 00-.904-.734l-2.38.501a7.25 7.25 0 01-4.186-.363l-.502-.2a8.75 8.75 0 00-5.053-.439l-1.475.31V2.75z" />
                        </svg>
                        Publish to Menu
                    </button>
                    
                    {{-- Published Badge --}}
                    <span x-show="(notification.type === 'review' || notification.type === 'thank_you') && notification.published"
                          class="text-xs text-green-600 bg-green-50 px-3 py-1.5 rounded-lg font-semibold flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        Published
                    </span>
                    
                    <button x-show="!notification.read" 
                            @click.stop="markAsRead(notification.id)"
                            class="text-xs text-yellow-600 hover:text-yellow-700 font-semibold flex items-center gap-1 transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                        </svg>
                        Mark as Read
                    </button>
                    <button @click.stop="deleteNotification(notification.id)"
                            class="text-xs text-red-600 hover:text-red-700 font-semibold flex items-center gap-1 transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
