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
            { id: 11, name: 'Tarek Nabil', email: 'tarek.nabil@example.com', phone: '+201101234567', image: 'https://randomuser.me/api/portraits/men/11.jpg', totalOrders: 52, totalSpent: 2600, lastOrderDate: '2026-01-04', joinedDate: '2025-05-08' },
            { id: 12, name: 'Mona Samy', email: 'mona.samy@example.com', phone: '+201112345678', image: 'https://randomuser.me/api/portraits/women/12.jpg', totalOrders: 28, totalSpent: 1400, lastOrderDate: '2025-11-20', joinedDate: '2025-06-25' },
            { id: 13, name: 'Adel Ramy', email: 'adel.ramy@example.com', phone: '+201123456789', image: 'https://randomuser.me/api/portraits/men/13.jpg', totalOrders: 41, totalSpent: 2050, lastOrderDate: '2026-01-01', joinedDate: '2025-04-17' },
            { id: 14, name: 'Dina Sherif', email: 'dina.sherif@example.com', phone: '+201134567890', image: 'https://randomuser.me/api/portraits/women/14.jpg', totalOrders: 19, totalSpent: 950, lastOrderDate: '2025-12-30', joinedDate: '2025-09-12' },
            { id: 15, name: 'Hassan Gamal', email: 'hassan.gamal@example.com', phone: '+201145678901', image: 'https://randomuser.me/api/portraits/men/15.jpg', totalOrders: 72, totalSpent: 3600, lastOrderDate: '2026-01-05', joinedDate: '2025-03-29' },
            { id: 16, name: 'Rana Tamer', email: 'rana.tamer@example.com', phone: '+201156789012', image: 'https://randomuser.me/api/portraits/women/16.jpg', totalOrders: 8, totalSpent: 400, lastOrderDate: '2026-01-04', joinedDate: '2025-12-15' },
            { id: 17, name: 'Amr Waleed', email: 'amr.waleed@example.com', phone: '+201167890123', image: 'https://randomuser.me/api/portraits/men/17.jpg', totalOrders: 95, totalSpent: 4300, lastOrderDate: '2026-01-06', joinedDate: '2025-01-20' },
            { id: 18, name: 'Yasmin Hossam', email: 'yasmin.hossam@example.com', phone: '+201178901234', image: 'https://randomuser.me/api/portraits/women/18.jpg', totalOrders: 36, totalSpent: 1800, lastOrderDate: '2025-12-22', joinedDate: '2025-07-03' },
            { id: 19, name: 'Khaled Magdy', email: 'khaled.magdy@example.com', phone: '+201189012345', image: 'https://randomuser.me/api/portraits/men/19.jpg', totalOrders: 14, totalSpent: 700, lastOrderDate: '2026-01-03', joinedDate: '2025-11-08' },
            { id: 20, name: 'Salma Fady', email: 'salma.fady@example.com', phone: '+201190123456', image: 'https://randomuser.me/api/portraits/women/20.jpg', totalOrders: 2, totalSpent: 100, lastOrderDate: '2026-01-02', joinedDate: '2026-01-01' },
            { id: 21, name: 'Mahmoud Ashraf', email: 'mahmoud.ashraf@example.com', phone: '+201201234567', image: 'https://randomuser.me/api/portraits/men/21.jpg', totalOrders: 58, totalSpent: 2900, lastOrderDate: '2026-01-05', joinedDate: '2025-05-14' },
            { id: 22, name: 'Noha Reda', email: 'noha.reda@example.com', phone: '+201212345678', image: 'https://randomuser.me/api/portraits/women/22.jpg', totalOrders: 26, totalSpent: 1300, lastOrderDate: '2025-12-18', joinedDate: '2025-08-19' },
            { id: 23, name: 'Sherif Medhat', email: 'sherif.medhat@example.com', phone: '+201223456789', image: 'https://randomuser.me/api/portraits/men/23.jpg', totalOrders: 43, totalSpent: 2150, lastOrderDate: '2026-01-04', joinedDate: '2025-06-07' },
            { id: 24, name: 'Mariam Samir', email: 'mariam.samir@example.com', phone: '+201234567890', image: 'https://randomuser.me/api/portraits/women/24.jpg', totalOrders: 11, totalSpent: 550, lastOrderDate: '2025-12-29', joinedDate: '2025-11-25' },
            { id: 25, name: 'Eslam Wael', email: 'eslam.wael@example.com', phone: '+201245678901', image: 'https://randomuser.me/api/portraits/men/25.jpg', totalOrders: 81, totalSpent: 4050, lastOrderDate: '2026-01-06', joinedDate: '2025-02-28' },
            { id: 26, name: 'Aya Hussam', email: 'aya.hussam@example.com', phone: '+201256789012', image: 'https://randomuser.me/api/portraits/women/26.jpg', totalOrders: 6, totalSpent: 300, lastOrderDate: '2026-01-01', joinedDate: '2025-12-20' },
            { id: 27, name: 'Bassem Zaki', email: 'bassem.zaki@example.com', phone: '+201267890123', image: 'https://randomuser.me/api/portraits/men/27.jpg', totalOrders: 48, totalSpent: 2400, lastOrderDate: '2025-11-28', joinedDate: '2025-04-11' },
            { id: 28, name: 'Reem Adel', email: 'reem.adel@example.com', phone: '+201278901234', image: 'https://randomuser.me/api/portraits/women/28.jpg', totalOrders: 32, totalSpent: 1600, lastOrderDate: '2026-01-05', joinedDate: '2025-07-22' },
            { id: 29, name: 'Ibrahim Tawfik', email: 'ibrahim.tawfik@example.com', phone: '+201289012345', image: 'https://randomuser.me/api/portraits/men/29.jpg', totalOrders: 17, totalSpent: 850, lastOrderDate: '2025-12-31', joinedDate: '2025-10-05' },
            { id: 30, name: 'Habiba Kamal', email: 'habiba.kamal@example.com', phone: '+201290123456', image: 'https://randomuser.me/api/portraits/women/30.jpg', totalOrders: 4, totalSpent: 200, lastOrderDate: '2026-01-06', joinedDate: '2025-12-30' },
            { id: 31, name: 'Mazen Hany', email: 'mazen.hany@example.com', phone: '+201301234567', image: 'https://randomuser.me/api/portraits/men/31.jpg', totalOrders: 63, totalSpent: 3150, lastOrderDate: '2026-01-04', joinedDate: '2025-04-05' },
            { id: 32, name: 'Nadine Fouad', email: 'nadine.fouad@example.com', phone: '+201312345678', image: 'https://randomuser.me/api/portraits/women/32.jpg', totalOrders: 21, totalSpent: 1050, lastOrderDate: '2025-12-25', joinedDate: '2025-09-01' }
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
