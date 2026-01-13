function promotionsHandler() {
    return {
        // Modal States
        showAddPromoModal: false,
        showEditPromoModal: false,
        selectedPromo: null,

        // Search & Filtering
        searchQuery: '',
        searchFilters: ['All', 'Title', 'Code'],
        searchFilter: 'All',
        statusFilter: 'All', // All, Active, Expired, Scheduled
        
        // Menu data for targeted promotions
        categories: [
            { name: 'Main Dishes', icon: '🍖' },
            { name: 'Appetizers', icon: '🥗' },
            { name: 'Desserts', icon: '🍰' },
            { name: 'Drinks', icon: '🥤' },
            { name: 'Soups', icon: '🥣' },
            { name: 'Salads', icon: '🥗' }
        ],
        
        dishes: [
            { name: 'Shrimp Stir-Fry with Brown Rice', category: 'Main Dishes' },
            { name: 'Grilled Salmon', category: 'Main Dishes' },
            { name: 'Chicken Alfredo Pasta', category: 'Main Dishes' },
            { name: 'Veggie Burger', category: 'Main Dishes' },
            { name: 'Beef Steak', category: 'Main Dishes' },
            { name: 'Caesar Salad', category: 'Appetizers' },
            { name: 'Bruschetta', category: 'Appetizers' },
            { name: 'Spring Rolls', category: 'Appetizers' },
            { name: 'Chocolate Lava Cake', category: 'Desserts' },
            { name: 'Tiramisu', category: 'Desserts' },
            { name: 'Fresh Juice', category: 'Drinks' },
            { name: 'Smoothie Bowl', category: 'Drinks' },
            { name: 'Tomato Basil Soup', category: 'Soups' },
            { name: 'Chicken Noodle Soup', category: 'Soups' },
            { name: 'Mushroom Soup', category: 'Soups' },
            { name: 'Greek Salad', category: 'Salads' },
            { name: 'Quinoa Salad', category: 'Salads' },
            { name: 'Fruit Salad', category: 'Salads' }
        ],

        // Form Data
        newPromo: {
            title: '',
            code: '',
            discountType: 'percentage',
            discountValue: 0,
            startDate: '',
            endDate: '',
            appliedDishes: [],
            isActive: true,
            applyTo: 'all',
            selectedCategories: [],
            selectedDishes: [],
            categorySearches: [''],
            dishSearches: ['']
        },
        editPromo: {},
        promoErrors: {
            title: '',
            code: '',
            discountValue: '',
            startDate: '',
            endDate: '',
            selectedCategories: [],
            selectedDishes: []
        },

        // Mock Promotions Data
        promotions: [
            {
                id: 1,
                title: 'Weekend Special',
                code: 'WEEKEND25',
                discountType: 'percentage',
                discountValue: 25,
                startDate: '2026-01-10',
                endDate: '2026-01-15',
                isActive: true,
                usageCount: 23,
                applyTo: 'category',
                selectedCategories: ['Main Course', 'Appetizers'],
                selectedDishes: [],
                categorySearches: ['Main Course', 'Appetizers'],
                dishSearches: ['']
            },
            {
                id: 2,
                title: 'New Year Discount',
                code: 'NEWYEAR2026',
                discountType: 'fixed',
                discountValue: 10,
                startDate: '2026-01-01',
                endDate: '2026-01-07',
                isActive: false,
                usageCount: 156,
                applyTo: 'all',
                selectedCategories: [],
                selectedDishes: [],
                categorySearches: [''],
                dishSearches: ['']
            },
            {
                id: 3,
                title: 'Valentine\'s Day Special',
                code: 'LOVE50',
                discountType: 'percentage',
                discountValue: 50,
                startDate: '2026-02-14',
                endDate: '2026-02-14',
                isActive: false,
                usageCount: 0,
                applyTo: 'dish',
                selectedCategories: [],
                selectedDishes: ['Chocolate Cake', 'Red Velvet'],
                categorySearches: [''],
                dishSearches: ['Chocolate Cake', 'Red Velvet']
            },
            {
                id: 4,
                title: 'Lunch Hour Deal',
                code: 'LUNCH15',
                discountType: 'percentage',
                discountValue: 15,
                startDate: '2026-01-08',
                endDate: '2026-01-20',
                isActive: true,
                usageCount: 45,
                applyTo: 'category',
                selectedCategories: ['Sandwiches'],
                selectedDishes: [],
                categorySearches: ['Sandwiches'],
                dishSearches: ['']
            },
            {
                id: 5,
                title: 'First Order Bonus',
                code: 'FIRST20',
                discountType: 'fixed',
                discountValue: 20,
                startDate: '2026-01-01',
                endDate: '2026-12-31',
                isActive: true,
                usageCount: 89,
                applyTo: 'all',
                selectedCategories: [],
                selectedDishes: [],
                categorySearches: [''],
                dishSearches: ['']
            },
            {
                id: 6,
                title: 'Seafood Festival',
                code: 'SEA20',
                discountType: 'percentage',
                discountValue: 20,
                startDate: '2026-03-01',
                endDate: '2026-03-10',
                isActive: true,
                usageCount: 5,
                applyTo: 'dish',
                selectedCategories: [],
                selectedDishes: ['Grilled Salmon', 'Shrimp Pasta', 'Fish Tacos'],
                categorySearches: [''],
                dishSearches: ['Grilled Salmon', 'Shrimp Pasta', 'Fish Tacos']
            }
        ],


        // Computed Properties
        get filteredPromotions() {
            let filtered = this.promotions;

            // Apply status filter
            if (this.statusFilter !== 'All') {
                const now = new Date();
                filtered = filtered.filter(promo => {
                    const start = new Date(promo.startDate);
                    const end = new Date(promo.endDate);
                    
                    if (this.statusFilter === 'Active') {
                        return promo.isActive && start <= now && end >= now;
                    } else if (this.statusFilter === 'Expired') {
                        return end < now;
                    } else if (this.statusFilter === 'Scheduled') {
                        return start > now;
                    }
                    return true;
                });
            }

            // Apply search filter
            if (this.searchQuery.trim() !== '') {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(promo => {
                    if (this.searchFilter === 'All') {
                        return promo.title.toLowerCase().includes(query) ||
                               promo.code.toLowerCase().includes(query);
                    } else if (this.searchFilter === 'Title') {
                        return promo.title.toLowerCase().includes(query);
                    } else if (this.searchFilter === 'Code') {
                        return promo.code.toLowerCase().includes(query);
                    }
                    return true;
                });
            }

            return filtered;
        },

        get activePromotions() {
            const now = new Date();
            return this.promotions.filter(promo => {
                const start = new Date(promo.startDate);
                const end = new Date(promo.endDate);
                return promo.isActive && start <= now && end >= now;
            });
        },

        get expiredPromotions() {
            const now = new Date();
            return this.promotions.filter(promo => {
                const end = new Date(promo.endDate);
                return end < now;
            });
        },

        get scheduledPromotions() {
            const now = new Date();
            return this.promotions.filter(promo => {
                const start = new Date(promo.startDate);
                return start > now;
            });
        },

        // Modal Methods
        openAddPromoModal() {
            this.newPromo = {
                title: "",
                code: "",
                discountType: "percentage",
                discountValue: 0,
                startDate: "",
                endDate: "",
                appliedDishes: [],
                isActive: true,
                applyTo: "all",
                selectedCategories: [''],
                selectedDishes: [''],
                categorySearches: [""],
                dishSearches: [""]
            };
            this.promoErrors = {
                selectedCategories: [],
                selectedDishes: []
            };
            this.showAddPromoModal = true;
        },

        closeAddPromoModal() {
            this.showAddPromoModal = false;
            this.newPromo = {
                title: '',
                code: '',
                discountType: 'percentage',
                discountValue: 0,
                startDate: '',
                endDate: '',
                appliedDishes: [],
                isActive: true
            };
            this.promoErrors = {};
        },

        openEditPromoModal(promo) {
            this.selectedPromo = promo;
            this.editPromo = { ...promo };
            this.promoErrors = {};
            this.showEditPromoModal = true;
        },

        closeEditPromoModal() {
            this.showEditPromoModal = false;
            this.selectedPromo = null;
            this.editPromo = {};
            this.promoErrors = {};
        },

        // CRUD Operations
        savePromo() {
            if (!this.validatePromo(this.newPromo)) {
                return;
            }

            const newId = Math.max(...this.promotions.map(p => p.id)) + 1;
            this.promotions.push({
                id: newId,
                ...this.newPromo,
                usageCount: 0
            });

            this.closeAddPromoModal();
        },

        updatePromo() {
            if (!this.validatePromo(this.editPromo)) {
                return;
            }

            const index = this.promotions.findIndex(p => p.id === this.selectedPromo.id);
            if (index !== -1) {
                this.promotions[index] = { ...this.editPromo };
            }

            this.closeEditPromoModal();
        },

        deletePromo(id) {
            if (confirm('Are you sure you want to delete this promotion?')) {
                this.promotions = this.promotions.filter(p => p.id !== id);
                this.closeEditPromoModal();
            }
        },

        // Validation
        validatePromo(promo) {
            // Reset errors with full object structure matching menu.js pattern
            this.promoErrors = {
                title: '',
                code: '',
                discountValue: '',
                startDate: '',
                endDate: ''
            };
            
            let isValid = true;

            if (!promo.title || promo.title.trim() === '') {
                this.promoErrors.title = 'Title is required';
                isValid = false;
            }

            if (!promo.code || promo.code.trim() === '') {
                this.promoErrors.code = 'Promo code is required';
                isValid = false;
            }

            if (!promo.discountValue || promo.discountValue <= 0) {
                this.promoErrors.discountValue = 'Valid discount value is required';
                isValid = false;
            }

            if (promo.discountType === 'percentage' && promo.discountValue > 100) {
                this.promoErrors.discountValue = 'Percentage cannot exceed 100%';
                isValid = false;
            }

            if (!promo.startDate) {
                this.promoErrors.startDate = "Start date is required";
                isValid = false;
            }

            if (!promo.endDate) {
                this.promoErrors.endDate = 'End date is required';
                isValid = false;
            }

            if (promo.startDate && promo.endDate && new Date(promo.startDate) > new Date(promo.endDate)) {
                this.promoErrors.endDate = 'End date must be after start date';
                isValid = false;
            }
            
            // Validate targeted promotion fields
            if (promo.applyTo === 'category') {
                // Reset category errors
                this.promoErrors.selectedCategories = [];
                
                if (!promo.selectedCategories || promo.selectedCategories.length === 0) {
                    this.promoErrors.selectedCategories[0] = 'Please select at least one category';
                    isValid = false;
                } else {
                    // Validate each category
                    promo.selectedCategories.forEach((cat, index) => {
                        if (!cat || cat.trim() === '') {
                            this.promoErrors.selectedCategories[index] = 'Please select a category';
                            isValid = false;
                        }
                    });
                }
            }
            
            if (promo.applyTo === 'dish') {
                // Reset dish errors
                this.promoErrors.selectedDishes = [];
                
                if (!promo.selectedDishes || promo.selectedDishes.length === 0) {
                    this.promoErrors.selectedDishes[0] = 'Please select at least one dish';
                    isValid = false;
                } else {
                    // Validate each dish
                    promo.selectedDishes.forEach((dish, index) => {
                        if (!dish || dish.trim() === '') {
                            this.promoErrors.selectedDishes[index] = 'Please select a dish';
                            isValid = false;
                        }
                    });
                }
            }

            return isValid;
        },
        
        // Searchable dropdown helpers
        getFilteredCategories(index) {
            const promo = this.showAddPromoModal ? this.newPromo : this.editPromo;
            const search = promo.categorySearches[index] || '';
            if (!search) return this.categories;
            return this.categories.filter(cat => 
                cat.name.toLowerCase().includes(search.toLowerCase())
            );
        },
        
        getFilteredDishes(index) {
            const promo = this.showAddPromoModal ? this.newPromo : this.editPromo;
            const search = promo.dishSearches[index] || '';
            if (!search) return this.dishes;
            return this.dishes.filter(dish => 
                dish.name.toLowerCase().includes(search.toLowerCase())
            );
        },
        
        addCategoryField(promoType = 'new') {
            const promo = promoType === 'new' ? this.newPromo : this.editPromo;
            promo.selectedCategories.push('');
            promo.categorySearches.push('');
        },
        
        removeCategoryField(index, promoType = 'new') {
            const promo = promoType === 'new' ? this.newPromo : this.editPromo;
            promo.selectedCategories.splice(index, 1);
            promo.categorySearches.splice(index, 1);
            if (this.promoErrors.selectedCategories) {
                this.promoErrors.selectedCategories.splice(index, 1);
            }
        },
        
        addDishField(promoType = 'new') {
            const promo = promoType === 'new' ? this.newPromo : this.editPromo;
            promo.selectedDishes.push('');
            promo.dishSearches.push('');
        },
        
        removeDishField(index, promoType = 'new') {
            const promo = promoType === 'new' ? this.newPromo : this.editPromo;
            promo.selectedDishes.splice(index, 1);
            promo.dishSearches.splice(index, 1);
            if (this.promoErrors.selectedDishes) {
                this.promoErrors.selectedDishes.splice(index, 1);
            }
        },

        // Helper Methods
        getPromoStatus(promo) {
            const now = new Date();
            const start = new Date(promo.startDate);
            const end = new Date(promo.endDate);

            if (start > now) {
                return 'Scheduled';
            } else if (end < now) {
                return 'Expired';
            } else if (promo.isActive && start <= now && end >= now) {
                return 'Active';
            }
            return 'Inactive';
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }
    };
}
