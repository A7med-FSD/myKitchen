function notificationsHandler() {
    return {
        priorityFilter: 'All',
        searchQuery: '',
        searchFilter: 'All',
        notifications: [
            {
                id: 1,
                priority: 'critical',
                type: 'security',
                title: 'Phone Number Change Request',
                message: 'Customer #1234 requested to change phone number from +1234567890 to +0987654321. Please review and approve.',
                time: '2 hours ago',
                read: false,
                timestamp: '2026-01-09T09:29:00'
            },
            {
                id: 2,
                priority: 'critical',
                type: 'security',
                title: 'Address Modification Request',
                message: 'Customer Ahmed requested to change delivery address. Security verification required.',
                time: '3 hours ago',
                read: false,
                timestamp: '2026-01-09T08:29:00'
            },
            {
                id: 3,
                priority: 'high',
                type: 'order',
                title: 'New Order Received',
                message: 'Order #4321 from Ahmed - $45.50 (2x Grilled Salmon, 1x Chicken Alfredo)',
                time: '3 hours ago',
                read: false,
                timestamp: '2026-01-09T08:29:00'
            },
            {
                id: 4,
                priority: 'high',
                type: 'alert',
                title: 'Low Stock Alert',
                message: 'Salmon inventory is running low (only 5 portions remaining). Consider restocking soon.',
                time: '5 hours ago',
                read: false,
                timestamp: '2026-01-09T06:29:00'
            },
            {
                id: 5,
                priority: 'high',
                type: 'order',
                title: 'Order Cancelled',
                message: 'Order #4320 was cancelled by customer. Refund processed automatically.',
                time: '6 hours ago',
                read: true,
                timestamp: '2026-01-09T05:29:00'
            },
            {
                id: 6,
                priority: 'normal',
                type: 'review',
                title: 'Order Completed',
                message: 'Order #4319 has been completed and delivered successfully.',
                time: '8 hours ago',
                read: true,
                timestamp: '2026-01-09T03:29:00'
            },
            {
                id: 7,
                priority: 'normal',
                type: 'review',
                title: 'New Customer Review',
                message: 'Ahmed left a 5-star review: "Amazing Grilled Salmon! Best I\'ve ever had!"',
                time: '10 hours ago',
                read: true,
                timestamp: '2026-01-09T01:29:00'
            },
            {
                id: 8,
                priority: 'normal',
                type: 'order',
                title: 'Order Ready for Pickup',
                message: 'Order #4318 is ready for pickup. Customer has been notified.',
                time: '12 hours ago',
                read: true,
                timestamp: '2026-01-08T23:29:00'
            },
            {
                id: 9,
                priority: 'low',
                type: 'thank_you',
                title: 'Customer Feedback',
                message: 'Sarah loved the Grilled Salmon! ⭐⭐⭐⭐⭐ Thank you for the amazing food!',
                time: '1 day ago',
                read: true,
                timestamp: '2026-01-08T11:29:00'
            },
            {
                id: 10,
                priority: 'low',
                type: 'thank_you',
                title: 'Positive Feedback',
                message: 'Customer Mohammed: "Best dining experience! Will definitely order again."',
                time: '1 day ago',
                read: true,
                timestamp: '2026-01-08T10:29:00'
            },
            {
                id: 11,
                priority: 'low',
                type: 'thank_you',
                title: 'Weekly Summary',
                message: 'Great week! You served 245 customers with an average rating of 4.8 stars.',
                time: '2 days ago',
                read: true,
                timestamp: '2026-01-07T11:29:00'
            }
        ],
        
        get filteredNotifications() {
            let filtered = this.notifications;
            
            // Filter by priority first
            if (this.priorityFilter !== 'All') {
                filtered = filtered.filter(n => n.priority === this.priorityFilter.toLowerCase());
            }
            
            // Then filter by search query
            if (this.searchQuery.trim() !== '') {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(n => {
                    if (this.searchFilter === 'Message') {
                        // Search only in title
                        return n.title.toLowerCase().includes(query);
                    } else if (this.searchFilter === 'Content') {
                        // Search only in message
                        return n.message.toLowerCase().includes(query);
                    } else {
                        // Search in both title and message
                        return n.title.toLowerCase().includes(query) || 
                               n.message.toLowerCase().includes(query);
                    }
                });
            }
            
            return filtered;
        },
        
        get unreadCount() {
            return this.notifications.filter(n => !n.read).length;
        },
        
        get criticalCount() {
            return this.notifications.filter(n => n.priority === 'critical' && !n.read).length;
        },
        
        getPriorityCount(priority) {
            if (priority === 'All') return this.notifications.length;
            return this.notifications.filter(n => n.priority === priority.toLowerCase()).length;
        },
        
        markAsRead(id) {
            const notification = this.notifications.find(n => n.id === id);
            if (notification) {
                notification.read = true;
            }
        },
        
        toggleRead(id) {
            const notification = this.notifications.find(n => n.id === id);
            if (notification) {
                notification.read = !notification.read;
            }
        },
        
        markAllAsRead() {
            this.notifications.forEach(n => n.read = true);
        },
        
        deleteNotification(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        },
        
        init() {
            console.log('Notifications Handler Initialized');
            console.log(`Total notifications: ${this.notifications.length}`);
            console.log(`Unread: ${this.unreadCount}, Critical: ${this.criticalCount}`);
        }
    };
}
