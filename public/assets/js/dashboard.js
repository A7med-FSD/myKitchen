/**
 * Dashboard Alpine.js Components
 */

/**
 * Schedule Handler Component
 * Manages the daily schedule view and event filtering
 */
function scheduleHandler() {
    return {
        selectedDay: 'Mon',
        editMode: false, // Global edit mode toggle
        selectedStatus: 'completed', // Currently selected status in toolbar
        days: [
            { date: '21', dayName: 'Sun' },
            { date: '22', dayName: 'Mon' },
            { date: '23', dayName: 'Tue' },
            { date: '27', dayName: 'Wed' },
            { date: '28', dayName: 'Thu' }
        ],
        // Status options for editing
        statusOptions: [
            { 
                key: 'completed', 
                label: 'Completed',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>`,
                colorClass: 'text-green-500',
                bgClass: 'bg-green-500',
                borderClass: 'border-green-500'
            },
            { 
                key: 'out-for-delivery', 
                label: 'Out for Delivery',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 116 0h3a.75.75 0 00.75-.75V15z" /><path d="M8.25 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0zM15.75 6.75a.75.75 0 00-.75.75v11.25c0 .087.015.17.042.248a3 3 0 015.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 00-3.732-10.104 1.837 1.837 0 00-1.47-.725H15.75z" /><path d="M19.5 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" /></svg>`,
                colorClass: 'text-blue-500',
                bgClass: 'bg-blue-500',
                borderClass: 'border-blue-500'
            },
            { 
                key: 'pending', 
                label: 'Pending',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" /></svg>`,
                colorClass: 'text-yellow-500',
                bgClass: 'bg-yellow-500',
                borderClass: 'border-yellow-500'
            },
            { 
                key: 'delayed', 
                label: 'Delayed',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" /></svg>`,
                colorClass: 'text-orange-500',
                bgClass: 'bg-orange-500',
                borderClass: 'border-orange-500'
            },
            { 
                key: 'cancelled', 
                label: 'Cancelled',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>`,
                colorClass: 'text-red-500',
                bgClass: 'bg-red-500',
                borderClass: 'border-red-500'
            }
        ],
        // Database of events
        eventsDb: {
            'Sun': [
                { time: '09:00 AM', title: 'Order #1001 - Breakfast', status: 'completed', tags: [{label:'Delivery', colorClass:'bg-blue-100 text-blue-500'}, {label:'Pd: $25', colorClass:'bg-green-100 text-green-600'}] },
                { time: '10:30 AM', title: 'Order #1002 - Catering', status: 'completed', tags: [{label:'Pickup', colorClass:'bg-orange-100 text-orange-600'}] }
            ],
            'Mon': [
                { time: '08:15 AM', title: 'Order #1024 - Morning Coffee', status: 'completed', tags: [
                    { label: 'Pickup', colorClass: 'bg-orange-100 text-orange-600' }, 
                    { label: '☕ 2 Items', colorClass: 'bg-gray-100 text-gray-500' }
                ]},
                { time: '12:30 PM', title: 'Order #1025 - Family Feast', status: 'out-for-delivery', tags: [
                    { label: 'Delivery', colorClass: 'bg-blue-100 text-blue-600' },
                    { label: '🍔 5 Items', colorClass: 'bg-gray-100 text-gray-500' },
                    { label: 'Cash', colorClass: 'bg-green-100 text-green-600' }
                ]},
                { time: '01:45 PM', title: 'Order #1026 - Quick Lunch', status: 'pending', tags: [
                    { label: 'Dine-in', colorClass: 'bg-purple-100 text-purple-600' },
                    { label: '🥗 Salad', colorClass: 'bg-gray-100 text-gray-500' }
                ]},
                { time: '07:00 PM', title: 'Order #1027 - Dinner Party', status: 'delayed', tags: [
                    { label: 'Pre-order', colorClass: 'bg-yellow-100 text-yellow-600' },
                    { label: 'Large', colorClass: 'bg-red-100 text-red-500' }
                ]}
            ],
            'Tue': [
                { time: '11:00 AM', title: 'Order #1030', status: 'pending', tags: [{label:'Pending', colorClass:'bg-gray-200 text-gray-600'}] }
            ]
        },
        get currentEvents() {
            return this.eventsDb[this.selectedDay] || [];
        },
        toggleEditMode() {
            this.editMode = !this.editMode;
            if (!this.editMode) {
                this.selectedStatus = 'completed'; // Reset to default when exiting
            }
        },
        selectStatus(statusKey) {
            this.selectedStatus = statusKey;
        },
        applyStatusToOrder(eventIndex) {
            if (!this.editMode) return; // Only allow changes in edit mode
            
            const events = this.eventsDb[this.selectedDay];
            if (events && events[eventIndex]) {
                events[eventIndex].status = this.selectedStatus;
            }
        },
        getStatusInfo(statusKey) {
            return this.statusOptions.find(s => s.key === statusKey) || this.statusOptions[2]; // Default to pending
        },
        nextDay() {
            const idx = this.days.findIndex(d => d.dayName === this.selectedDay);
            if (idx < this.days.length - 1) this.selectedDay = this.days[idx + 1].dayName;
        },
        prevDay() {
            const idx = this.days.findIndex(d => d.dayName === this.selectedDay);
            if (idx > 0) this.selectedDay = this.days[idx - 1].dayName;
        }
    }
}

/**
 * Performance Stats Component
 * Handles animated statistics for revenue, orders, and rating
 */
function performanceStats() {
    return {
        revenue: 0,
        activeOrders: 0,
        rating: 0,
        init() {
            setTimeout(() => {
                this.animateValue('revenue', 0, 2500, 2000); // 2 seconds to reach 2.5k
                this.animateValue('activeOrders', 0, 85, 1500);
                this.animateValue('rating', 0, 4.8, 1500);
            }, 500);
        },
        animateValue(key, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                
                // Calculate value
                let val = progress * (end - start) + start;
                
                // Specific formatting for different keys if needed, 
                // or just general rounding to avoid long decimals
                if (key === 'activeOrders') val = Math.round(val);
                
                this[key] = val;
                
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        },
        formatNumber(num) {
            if (num >= 1000) {
                return (num / 1000).toFixed(1) + 'K';
            }
            return Math.round(num);
        }
    }
}

/**
 * Top Items Stats Component
 * Manages top selling items display and selection
 */
function topItemsStats() {
    return {
        items: [
            { name: 'Burger', icon: '🍔', color: 'green', count: 850, goal: 1000 },
            { name: 'Pizza', icon: '🍕', color: 'orange', count: 620, goal: 1000 },
            { name: 'Pasta', icon: '🍝', color: 'blue', count: 450, goal: 1000 }
        ],
        activeItem: 0, // Index of selected item to show bar for
        get currentItem() {
            return this.items[this.activeItem];
        }
    }
}

/**
 * Restock List Component
 * Manages inventory items and stock status
 */
function restockList() {
    return {
        items: [
            { name: 'Tomatoes', q: '5 kg', icon: '🍅', stock: true },
            { name: 'Flour', q: '10 kg', icon: '🌾', stock: true },
            { name: 'Milk', q: '20 L', icon: '🥛', stock: false, tag: 'Low' },
            { name: 'Eggs', q: '50 pcs', icon: '🥚', stock: false },
            { name: 'Onion', q: '3 kg', icon: '🧅', stock: false },
        ],
        toggleStock(index) {
            this.items[index].stock = !this.items[index].stock;
        }
    }
}

