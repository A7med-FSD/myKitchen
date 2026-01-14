document.addEventListener('alpine:init', () => {
    Alpine.data('ordersHandler', () => ({
        selectedStatus: 'All',
        searchQuery: '',
        searchFilter: 'All', // 'All', 'Order ID', 'Customer Name', 'Customer Number'
        showModal: false,
        selectedOrder: null,
        showMap: false,
        todayOrders: 24,
        todayRevenue: 456.80,
        statuses: [
            { 
                name: 'All', 
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.127 7.939a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd" /></svg>`, 
                count: 10
            },
            { 
                name: 'Pending', 
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" /></svg>`, 
                count: 3
            },
            { 
                name: 'In Progress', 
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" /></svg>`, 
                count: 3
            },
            { 
                name: 'Ready', 
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" /></svg>`, 
                count: 2
            },
            { 
                name: 'Delivered', 
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15H13.5ZM8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75ZM19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" /></svg>`, 
                count: 1
            },
            { 
                name: 'Cancelled', 
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" /></svg>`, 
                count: 1
            }
        ],
        orders: [
            { id: '1024', time: '10:30 AM', customer: 'Ahmed Hassan', phone: '0123456789', type: 'Delivery', address: '15 Tahrir Street, Dokki, Giza', status: 'Pending', items: [{name: 'Burger', qty: 2, price: 12.99, originalPrice: 15.99, promoCode: 'BURGER20'}, {name: 'Fries', qty: 1, price: 4.99}], total: 30.97, showAll: false },
            { id: '1025', time: '10:45 AM', customer: 'Sara Mohamed', phone: '0987654321', type: 'Pickup', status: 'In Progress', items: [{name: 'Pizza', qty: 1, price: 18.99}], total: 18.99, showAll: false },
            { id: '1026', time: '11:00 AM', customer: 'Khaled Ali', phone: '0111222333', type: 'Delivery', address: '42 Ahmed Orabi Street, Mohandessin, Giza', status: 'Pending', items: [{name: 'Pasta', qty: 3, price: 16.99, originalPrice: 20.00, promoCode: 'ITALY15'}], total: 50.97, showAll: false },
            { id: '1027', time: '11:15 AM', customer: 'Nour Ibrahim', phone: '0444555666', type: 'Dine-in', status: 'Ready', items: [{name: 'Steak', qty: 2, price: 28.99}, {name: 'Salad', qty: 1, price: 8.99}, {name: 'Dessert', qty: 2, price:6.99}, {name: 'Coffee', qty: 2, price: 3.99}], total: 57.98, showAll: false },
            { id: '1028', time: '11:30 AM', customer: 'Omar Youssef', phone: '0777888999', type: 'Delivery', address: '8 El Thawra Street, Heliopolis, Cairo', status: 'In Progress', items: [{name: 'Salad', qty: 1, price: 8.99}, {name: 'Juice', qty: 2, price: 4.99}], total: 18.97, showAll: false },
            { id: '1029', time: '11:45 AM', customer: 'Layla Mahmoud', phone: '0555444333', type: 'Pickup', status: 'Delivered', items: [{name: 'Smoothie Bowl', qty: 1, price: 7.99}], total: 7.99, showAll: false },
            { id: '1030', time: '12:00 PM', customer: 'Youssef Kamal', phone: '0666777888', type: 'Delivery', address: '23 Nile Corniche, Zamalek, Cairo', status: 'Pending', items: [{name: 'Shrimp Stir-Fry', qty: 2, price: 18.99}, {name: 'Rice', qty: 2, price: 3.99}, {name: 'Sauce', qty: 1, price: 2.99}, {name: 'Spring Rolls', qty: 4, price: 5.99}], total: 37.98, showAll: false },
            { id: '1031', time: '12:15 PM', customer: 'Mariam Adel', phone: '0888999000', type: 'Dine-in', status: 'Ready', items: [{name: 'Alfredo Pasta', qty: 1, price: 16.99}], total: 16.99, showAll: false },
            { id: '1032', time: '12:30 PM', customer: 'Hassan Tarek', phone: '0123987654', type: 'Delivery', address: '56 Syria Street, Mohandessin, Giza', status: 'In Progress', items: [{name: 'Veggie Burger', qty: 3, price: 12.99}], total: 38.97, showAll: false },
            { id: '1033', time: '12:45 PM', customer: 'Dina Sameh', phone: '0456789123', type: 'Pickup', status: 'Cancelled', items: [{name: 'Caesar Salad', qty: 2, price: 8.99}], total: 17.98, showAll: false }
        ],

        init() {
            this.updateStatusCounts();
            this.$watch('searchQuery', () => this.triggerAnimation());
        },
        
        setStatus(status) {
            if (this.selectedStatus === status) return;
            
            // Reset the count of the previously selected status
            this.resetStatusCount(this.selectedStatus);

            this.selectedStatus = status;
            this.triggerAnimation();
        },

        resetStatusCount(statusName) {
            const status = this.statuses.find(s => s.name === statusName);
            if (!status) return;

            if (statusName === 'All') {
                status.count = this.orders.length;
            } else {
                status.count = this.orders.filter(o => o.status === statusName).length;
            }
        },

        getStatusClasses(statusName) {
            if (this.selectedStatus !== statusName) {
                switch (statusName) {
                    case 'Pending': return 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100';
                    case 'In Progress': return 'bg-blue-50 text-blue-700 hover:bg-blue-100';
                    case 'Ready': return 'bg-green-50 text-green-700 hover:bg-green-100';
                    case 'Delivered': return 'bg-purple-50 text-purple-700 hover:bg-purple-100';
                    case 'Cancelled': return 'bg-red-50 text-red-700 hover:bg-red-100';
                    default: return 'bg-gray-100 text-gray-600 hover:bg-gray-200';
                }
            }
            
            // Active states
            switch (statusName) {
                case 'Pending': return 'bg-yellow-400 text-white shadow-lg scale-105';
                case 'In Progress': return 'bg-blue-500 text-white shadow-lg scale-105';
                case 'Ready': return 'bg-green-500 text-white shadow-lg scale-105';
                case 'Delivered': return 'bg-purple-500 text-white shadow-lg scale-105';
                case 'Cancelled': return 'bg-red-500 text-white shadow-lg scale-105';
                default: return 'bg-gray-800 text-white shadow-lg scale-105';
            }
        },

        getCountClasses(statusName) {
            if (this.selectedStatus === statusName) {
                // For Pending (yellow bg), use distinct color, otherwise white
                return statusName === 'Pending' ? 'bg-black/10 text-white' : 'bg-white/20 text-white';
            }
            return 'bg-black/10 text-black/50';
        },
        
        get filteredOrders() {
            let filtered = this.orders;

            // Filter by status 
            if (this.selectedStatus !== "All") {
                filtered = filtered.filter(
                    (order) => order.status === this.selectedStatus
                );
            }

            // Filter by search query
            if (this.searchQuery.trim() !== "") {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter((order) => {
                    const matchesId = order.id.toLowerCase().includes(query);
                    const matchesName = order.customer.toLowerCase().includes(query);
                    const matchesPhone = order.phone.includes(query);

                    if (this.searchFilter === "All") {
                        if (matchesId || matchesName || matchesPhone) return true;
                        const hasMatchingItem = order.items.some((item) =>
                            item.name.toLowerCase().includes(query)
                        );
                        if (hasMatchingItem) return true;
                    } else if (this.searchFilter === "Order ID") {
                        return matchesId;
                    } else if (this.searchFilter === "Customer Name") {
                        return matchesName;
                    } else if (this.searchFilter === "Customer Number") {
                        return matchesPhone;
                    }

                    return false;
                });
            }

            // Update count for the selected status based on the filtered results
            const selectedStatusIndex = this.statuses.findIndex(s => s.name === this.selectedStatus);
            if (selectedStatusIndex !== -1) {
                this.statuses[selectedStatusIndex].count = filtered.length;
            }

            return filtered;
        },
        
        triggerAnimation() {
            this.$nextTick(() => {
                const cards = document.querySelectorAll('.animate-entrance-card');
                cards.forEach((card) => {
                    card.classList.remove('animate-entrance-card');
                    void card.offsetWidth;
                    card.classList.add('animate-entrance-card');
                });
            });
        },
        
        openOrderModal(order) {
            this.selectedOrder = order;
            this.showModal = true;
            document.body.style.overflow = 'hidden'; 
        },
        
        closeOrderModal() {
            this.showModal = false;
            this.selectedOrder = null;
            this.showMap = false;
            document.body.style.overflow = ''; 
        },
        
        acceptOrder(id) {
            const order = this.orders.find(o => o.id === id);
            if (order) {
                order.status = 'In Progress';
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
            this.statuses.forEach(status => {
                if (status.name === 'All') {
                    status.count = this.orders.length;
                } else {
                    status.count = this.orders.filter(o => o.status === status.name).length;
                }
            });
        }
    }))
});
