function customersHandler() {
    return ({
        // Modal State
        showCustomerModal: false,
        selectedCustomer: null,

        // Search & Filtering State
        searchQuery: '',
        searchFilters: ['All', 'Name', 'Email', 'Phone'],
        searchFilter: 'All',
        sortField: 'name', // 'name' or 'orders'
        sortOrder: 'asc', // 'asc' or 'desc'
        customerFilter: 'All', // 'All', 'VIP', 'Regular', 'NEW'
        activityFilter: 'All', // 'All', 'Active' or 'Inactive'
        
        // Mock Customer Data (30+ customers)
        customers: [
            { id: 1, name: 'Ahmed Hassan', email: 'ahmed.hassan@example.com', phone: '+201001234567', image: 'https://randomuser.me/api/portraits/men/1.jpg', totalOrders: 45, totalSpent: 2250, lastOrderDate: '2026-01-05', joinedDate: '2025-06-15' },
            { id: 2, name: 'Fatima Ali', email: 'fatima.ali@example.com', phone: '+201012345678', image: 'https://randomuser.me/api/portraits/women/2.jpg', totalOrders: 12, totalSpent: 600, lastOrderDate: '2026-01-04', joinedDate: '2025-11-20' },
            { id: 3, name: 'Mohamed Salah', email: 'mohamed.salah@example.com', phone: '+201023456789', image: 'https://randomuser.me/api/portraits/men/3.jpg', totalOrders: 78, totalSpent: 3900, lastOrderDate: '2026-01-06', joinedDate: '2025-03-10' },
            { id: 4, name: 'Nour Ibrahim', email: 'nour.ibrahim@example.com', phone: '+201034567890', image: 'https://randomuser.me/api/portraits/women/4.jpg', totalOrders: 23, totalSpent: 1150, lastOrderDate: '2025-12-28', joinedDate: '2025-08-05' },
            { id: 5, name: 'Omar Khaled', email: 'omar.khaled@example.com', phone: '+201045678901', image: 'https://randomuser.me/api/portraits/men/5.jpg', totalOrders: 5, totalSpent: 250, lastOrderDate: '2026-01-03', joinedDate: '2025-12-28' },
            { id: 6, name: 'Sara Mahmoud', email: 'sara.mahmoud@example.com', phone: '+201056789012', image: 'https://randomuser.me/api/portraits/women/6.jpg', totalOrders: 67, totalSpent: 3350, lastOrderDate: '2026-01-05', joinedDate: '2025-04-22' },
            { id: 7, name: 'Youssef Ahmed', email: 'youssef.ahmed@example.com', phone: '+201067890123', image: 'https://randomuser.me/api/portraits/men/7.jpg', totalOrders: 34, totalSpent: 1700, lastOrderDate: '2025-12-15', joinedDate: '2025-07-18' },
            { id: 8, name: 'Hana Mostafa', email: 'hana.mostafa@example.com', phone: '+201078901234', image: 'https://randomuser.me/api/portraits/women/8.jpg', totalOrders: 89, totalSpent: 4500, lastOrderDate: '2026-01-06', joinedDate: '2025-02-14' },
            { id: 9, name: 'Karim Essam', email: 'karim.essam@example.com', phone: '+201089012345', image: 'https://randomuser.me/api/portraits/men/9.jpg', totalOrders: 15, totalSpent: 750, lastOrderDate: '2026-01-02', joinedDate: '2025-10-30' },
            { id: 10, name: 'Layla Farouk', email: 'layla.farouk@example.com', phone: '+201090123456', image: 'https://randomuser.me/api/portraits/women/10.jpg', totalOrders: 3, totalSpent: 150, lastOrderDate: '2026-01-05', joinedDate: '2026-01-01' },
        ],

        // Computed Properties
        get customerTag() {
            return (customer) => {
                const daysSinceJoined = this.getDaysSince(customer.joinedDate);
                if (daysSinceJoined <= 30) return 'NEW';
                if (customer.totalSpent >= 3000) return 'VIP';
                return 'Regular';
            };
        },

        get activityStatus() {
            return (customer) => {
                const daysSinceLastOrder = this.getDaysSince(customer.lastOrderDate);
                if (daysSinceLastOrder <= 7) return 'last-week';
                if (daysSinceLastOrder <= 30) return 'last-month';
                return 'inactive';
            };
        },

        get filteredCustomers() {
            let filtered = this.customers;

            // Apply search filter
            if (this.searchQuery.trim() !== '') {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(c => {
                    if (this.searchFilter === 'All') {
                        return c.name.toLowerCase().includes(query) ||
                            c.email.toLowerCase().includes(query) ||
                            c.phone.toLowerCase().includes(query);
                    } else if (this.searchFilter === 'Name') {
                        return c.name.toLowerCase().includes(query);
                    } else if (this.searchFilter === 'Email') {
                        return c.email.toLowerCase().includes(query);
                    } else if (this.searchFilter === 'Phone') {
                        return c.phone.toLowerCase().includes(query);
                    }
                    return true;
                });
            }

            // Filter by customer type
            if (this.customerFilter !== 'All') {
                filtered = filtered.filter(c => this.customerTag(c) === this.customerFilter);
            }

            // Filter by activity status
            if (this.activityFilter === 'Active') {
                filtered = filtered.filter(c => {
                    const status = this.activityStatus(c);
                    return status === 'last-week' || status === 'last-month';
                });
            } else if (this.activityFilter === 'Inactive') {
                filtered = filtered.filter(c => this.activityStatus(c) === 'inactive');
            }

            return filtered;
        },

        get sortedCustomers() {
            const sorted = [...this.filteredCustomers];
            
            sorted.sort((a, b) => {
                // Check Direction First
                if (this.sortOrder === 'asc') {
                    if (this.sortField === 'name') return a.name.localeCompare(b.name);
                    if (this.sortField === 'orders') return a.totalOrders - b.totalOrders;
                    if (this.sortField === 'totalSpent') return a.totalSpent - b.totalSpent;
                } else {
                    // Descending
                    if (this.sortField === 'name') return b.name.localeCompare(a.name);
                    if (this.sortField === 'orders') return b.totalOrders - a.totalOrders;
                    if (this.sortField === 'totalSpent') return b.totalSpent - a.totalSpent;
                }
                return 0; // Fallback
            });
            
            return sorted;
        },

        // Helper Functions
        getDaysSince(dateString) {
            const date = new Date(dateString);
            const today = new Date('2026-01-06'); // Mock current date
            const diffTime = Math.abs(today - date);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        },

        formatPhone(phone) {
            // Format phone number as: +20 123 456 7890
            // Assuming format +20XXXXXXXXXX
            if (!phone) return '';
            const clean = phone.replace(/\s+/g, '');
            if (clean.length < 4) return clean;
            
            // +20 1XX XXX XXXX
            return clean.replace(/(\+\d{2})(\d{3})(\d{3})(\d{4})/, '$1 $2 $3 $4');
        },

        // Actions
        setSortField(field) {
            if (this.sortField === field) return;

            this.sortField = field;
        },

        toggleSortOrder() {
            this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
        },

        showCustomerDetails(customer) {
            this.selectedCustomer = customer;
            this.showCustomerModal = true;
        },

        setCustomerFilter(filter) {
            this.customerFilter = filter;
        },

        setActivityFilter(filter) {
            this.activityFilter = filter;
        }
    });
}
