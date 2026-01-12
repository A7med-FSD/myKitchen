<x-owner.layout>
    <script src="{{ asset('assets/js/owner/notifications.js') }}"></script>
    
    <div class="space-y-6 pb-20" x-data="notificationsHandler()">
        <!-- Header -->
        <x-owner.heading>
            <x-slot:title>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-yellow-500">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                </svg>
                Notifications
            </x-slot:title>
            <x-slot:subtitle>Stay updated with your kitchen's activities</x-slot:subtitle>
            
            <x-slot:searchplacehold>Search notifications...</x-slot:searchplacehold>
            <x-slot:filter>filter in ['All', 'Message', 'Content']</x-slot:filter>
            
            <!-- Quick Stats -->
            <div class="flex flex-wrap gap-3">
                <div class="stat-card">
                    <div class="stat-value text-gray-900" x-text="unreadCount"></div>
                    <div class="stat-label">Unread</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value text-red-600" x-text="criticalCount"></div>
                    <div class="stat-label">Critical</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value text-gray-900" x-text="notifications.length"></div>
                    <div class="stat-label">Total</div>
                </div>
            </div>
        </x-owner.heading>
        
        <!-- Priority Filter & Actions -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <x-owner.notifications.notification-priority-filter />
            
            <!-- Mark All as Read Button -->
            <button x-show="unreadCount > 0"
                    @click="markAllAsRead()"
                    class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                </svg>
                Mark All as Read
            </button>
        </div>
        
        <!-- Notifications List -->
        <div class="space-y-4">
            <template x-for="notification in filteredNotifications" :key="notification.id">
                <x-owner.notifications.notification-card />
            </template>
            
            <!-- Empty State -->
            <div x-show="filteredNotifications.length === 0" 
                 class="bg-white rounded-2xl p-12 text-center entrance-animation">
                <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-gray-400">
                        <path d="M5.85 3.5a.75.75 0 0 0-1.117-1 9.719 9.719 0 0 0-2.348 4.876.75.75 0 0 0 1.479.248A8.219 8.219 0 0 1 5.85 3.5ZM19.267 2.5a.75.75 0 1 0-1.118 1 8.22 8.22 0 0 1 1.987 4.124.75.75 0 0 0 1.48-.248A9.72 9.72 0 0 0 19.266 2.5Z" />
                        <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 0 0 5.25 9v.75a8.217 8.217 0 0 1-2.119 5.52.75.75 0 0 0 .298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 1 0 7.48 0 24.583 24.583 0 0 0 4.83-1.244.75.75 0 0 0 .298-1.205 8.217 8.217 0 0 1-2.118-5.52V9A6.75 6.75 0 0 0 12 2.25ZM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 0 0 4.496 0l.002.1a2.25 2.25 0 1 1-4.5 0Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Notifications</h3>
                <p class="text-gray-500 text-sm">
                    <span x-show="priorityFilter === 'All'">You're all caught up! No notifications to display.</span>
                    <span x-show="priorityFilter !== 'All'">No <span x-text="priorityFilter.toLowerCase()"></span> priority notifications.</span>
                </p>
            </div>
        </div>
    </div>
</x-owner.layout>
