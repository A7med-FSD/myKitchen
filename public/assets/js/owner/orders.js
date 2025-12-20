function ordersHandler() {
    return {
        selectedStatus: 'All',
        searchQuery: '',
        searchFilter: 'All', // 'All', 'Order ID', 'Customer Name', 'Customer Number'
        showModal: false,
        selectedOrder: null,
        todayOrders: 24,
        todayRevenue: 456.80,
        statuses: [
            { name: 'All', icon: '📋', count: 24 },
            { name: 'Pending', icon: '⏰', count: 8 },
            { name: 'In Progress', icon: '🔄', count: 6 },
            { name: 'Ready', icon: '✅', count: 5 },
            { name: 'Delivered', icon: '🚗', count: 4 },
            { name: 'Cancelled', icon: '❌', count: 1 }
        ],
        orders: [
            { id: '1024', time: '10:30 AM', customer: 'Ahmed Hassan', phone: '0123456789', type: 'Delivery', status: 'Pending', items: [{name: 'Burger', qty: 2, price: 12.99}, {name: 'Fries', qty: 1, price: 4.99}], total: 30.97, showAll: false },
            { id: '1025', time: '10:45 AM', customer: 'Sara Mohamed', phone: '0987654321', type: 'Pickup', status: 'In Progress', items: [{name: 'Pizza', qty: 1, price: 18.99}], total: 18.99, showAll: false },
            { id: '1026', time: '11:00 AM', customer: 'Khaled Ali', phone: '0111222333', type: 'Delivery', status: 'Pending', items: [{name: 'Pasta', qty: 3, price: 16.99}], total: 50.97, showAll: false },
            { id: '1027', time: '11:15 AM', customer: 'Nour Ibrahim', phone: '0444555666', type: 'Dine-in', status: 'Ready', items: [{name: 'Steak', qty: 2, price: 28.99}, {name: 'Salad', qty: 1, price: 8.99}, {name: 'Dessert', qty: 2, price:6.99}, {name: 'Coffee', qty: 2, price: 3.99}], total: 57.98, showAll: false },
            { id: '1028', time: '11:30 AM', customer: 'Omar Youssef', phone: '0777888999', type: 'Delivery', status: 'In Progress', items: [{name: 'Salad', qty: 1, price: 8.99}, {name: 'Juice', qty: 2, price: 4.99}], total: 18.97, showAll: false },
            { id: '1029', time: '11:45 AM', customer: 'Layla Mahmoud', phone: '0555444333', type: 'Pickup', status: 'Delivered', items: [{name: 'Smoothie Bowl', qty: 1, price: 7.99}], total: 7.99, showAll: false },
            { id: '1030', time: '12:00 PM', customer: 'Youssef Kamal', phone: '0666777888', type: 'Delivery', status: 'Pending', items: [{name: 'Shrimp Stir-Fry', qty: 2, price: 18.99}, {name: 'Rice', qty: 2, price: 3.99}, {name: 'Sauce', qty: 1, price: 2.99}, {name: 'Spring Rolls', qty: 4, price: 5.99}], total: 37.98, showAll: false },
            { id: '1031', time: '12:15 PM', customer: 'Mariam Adel', phone: '0888999000', type: 'Dine-in', status: 'Ready', items: [{name: 'Alfredo Pasta', qty: 1, price: 16.99}], total: 16.99, showAll: false },
            { id: '1032', time: '12:30 PM', customer: 'Hassan Tarek', phone: '0123987654', type: 'Delivery', status: 'In Progress', items: [{name: 'Veggie Burger', qty: 3, price: 12.99}], total: 38.97, showAll: false },
            { id: '1033', time: '12:45 PM', customer: 'Dina Sameh', phone: '0456789123', type: 'Pickup', status: 'Cancelled', items: [{name: 'Caesar Salad', qty: 2, price: 8.99}], total: 17.98, showAll: false }
        ],
        
        get filteredOrders() {
            let filtered = this.orders;
            
            // Filter by status
            if (this.selectedStatus !== 'All') {
                filtered = filtered.filter(order => order.status === this.selectedStatus);
            }
            
            // Filter by search query
            if (this.searchQuery.trim() !== '') {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(order => {
                    const matchesId = order.id.toLowerCase().includes(query);
                    const matchesName = order.customer.toLowerCase().includes(query);
                    const matchesPhone = order.phone.includes(query);
                    
                    if (this.searchFilter === 'All') {
                         // Search in everything
                        if (matchesId || matchesName || matchesPhone) return true;
                         // Search in item names
                         const hasMatchingItem = order.items.some(item => 
                            item.name.toLowerCase().includes(query)
                        );
                        if (hasMatchingItem) return true;
                    } else if (this.searchFilter === 'Order ID') {
                        return matchesId;
                    } else if (this.searchFilter === 'Customer Name') {
                        return matchesName;
                    } else if (this.searchFilter === 'Customer Number') {
                        return matchesPhone;
                    }
                    
                    return false;
                });
            }
            
            // Trigger animation re-render
            this.$nextTick(() => {
                this.triggerAnimations();
            });
            
            return filtered;
        },
        
        triggerAnimations() {
            // Force re-animation by removing and re-adding animation classes
            const cards = document.querySelectorAll('.animate-entrance-card');
            cards.forEach((card, index) => {
                card.style.animation = 'none';
                setTimeout(() => {
                    card.style.animation = '';
                }, 10);
            });
        },
        
        openOrderModal(order) {
            this.selectedOrder = order;
            this.showModal = true;
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        },
        
        closeOrderModal() {
            this.showModal = false;
            this.selectedOrder = null;
            document.body.style.overflow = ''; // Restore scrolling
        },
        
        acceptOrder(id) {
            const order = this.orders.find(o => o.id === id);
            if (order) {
                order.status = 'In Progress';
                // Update status counts
                this.updateStatusCounts();
            }
        },
        
        markReady(id) {
            const order = this.orders.find(o => o.id === id);
            if (order) {
                order.status = 'Ready';
                this.updateStatusCounts();
            }
        },
        
        cancelOrder(id) {
            const order = this.orders.find(o => o.id === id);
            if (order) {
                order.status = 'Cancelled';
                this.updateStatusCounts();
            }
        },
        
        updateStatusCounts() {
            // Recalculate status counts
            this.statuses.forEach(status => {
                if (status.name === 'All') {
                    status.count = this.orders.length;
                } else {
                    status.count = this.orders.filter(o => o.status === status.name).length;
                }
            });
        }
    }
}
