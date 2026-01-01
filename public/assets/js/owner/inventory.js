function inventoryHandler() {
    return ({
        // Sample Data
        items: [
            { id: 1, name: 'Tomatoes', category: 'Vegetables', quantity: 50, unit: 'kg', pricePerUnit: 2.5, lowStockThreshold: 10 },
            { id: 2, name: 'Chicken Breast', category: 'Meat', quantity: 5, unit: 'kg', pricePerUnit: 8.5, lowStockThreshold: 10 },
            { id: 3, name: 'Olive Oil', category: 'Oils', quantity: 2, unit: 'L', pricePerUnit: 12, lowStockThreshold: 5 },
            { id: 4, name: 'Rice', category: 'Grains', quantity: 25, unit: 'kg', pricePerUnit: 3, lowStockThreshold: 15 },
            { id: 5, name: 'Salt', category: 'Spices', quantity: 0, unit: 'kg', pricePerUnit: 1, lowStockThreshold: 2 },
            { id: 6, name: 'Sugar', category: 'Sweeteners', quantity: 15, unit: 'kg', pricePerUnit: 2.2, lowStockThreshold: 10 },
        ],

        categories: ['All', 'Vegetables', 'Meat', 'Oils', 'Grains', 'Spices', 'Sweeteners'],
        units: ['kg', 'g', 'L', 'ml', 'pcs'],

        // Search and Filter
        searchQuery: '',
        searchFilters: ['All', 'Name', 'Category'],
        searchFilter: 'All',
        statusFilter: 'All', // All, In Stock, Low Stock, Out of Stock

        // Add Item Modal State
        showAddItemModal: false,
        newItem: {
            name: '',
            category: '',
            quantity: '',
            unit: 'kg',
            pricePerUnit: '',
            lowStockThreshold: 10
        },
        itemErrors: {
            name: '',
            category: '',
            quantity: '',
            pricePerUnit: ''
        },

        // Edit Item Modal State
        showEditItemModal: false,
        editItem: {
            index: null,
            id: null,
            name: '',
            category: '',
            quantity: '',
            unit: 'kg',
            pricePerUnit: '',
            lowStockThreshold: 10
        },

        // Computed Properties
        get filteredItems() {
            let filtered = this.items;

            // Status filter
            if (this.statusFilter === 'In Stock') {
                filtered = filtered.filter(item => item.quantity > item.lowStockThreshold);
            } else if (this.statusFilter === 'Low Stock') {
                filtered = filtered.filter(item => item.quantity > 0 && item.quantity <= item.lowStockThreshold);
            } else if (this.statusFilter === 'Out of Stock') {
                filtered = filtered.filter(item => item.quantity === 0);
            }

            // Search filter
            if (this.searchQuery.trim()) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(item => {
                    if (this.searchFilter === 'Name') {
                        return item.name.toLowerCase().includes(query);
                    } else if (this.searchFilter === 'Category') {
                        return item.category.toLowerCase().includes(query);
                    } else {
                        return item.name.toLowerCase().includes(query) ||
                               item.category.toLowerCase().includes(query);
                    }
                });
            }

            return filtered;
        },

        get totalItems() {
            return this.items.length;
        },

        get lowStockCount() {
            return this.items.filter(item => item.quantity > 0 && item.quantity <= item.lowStockThreshold).length;
        },

        get outOfStockCount() {
            return this.items.filter(item => item.quantity === 0).length;
        },

        getStockStatus(item) {
            if (item.quantity === 0) return 'out';
            if (item.quantity <= item.lowStockThreshold) return 'low';
            return 'in';
        },

        // Add Item Modal Functions
        openAddItemModal() {
            this.newItem = {
                name: '',
                category: '',
                quantity: '',
                unit: 'kg',
                pricePerUnit: '',
                lowStockThreshold: 10
            };
            this.itemErrors = {
                name: '',
                category: '',
                quantity: '',
                pricePerUnit: ''
            };
            this.showAddItemModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeAddItemModal() {
            this.showAddItemModal = false;
            document.body.style.overflow = '';
        },

        validateAddItemForm() {
            let isValid = true;

            this.itemErrors = {
                name: '',
                category: '',
                quantity: '',
                pricePerUnit: ''
            };

            if (!this.newItem.name || !this.newItem.name.trim()) {
                this.itemErrors.name = 'Item name is required';
                isValid = false;
            }

            if (!this.newItem.category) {
                this.itemErrors.category = 'Please select a category';
                isValid = false;
            }

            if (this.newItem.quantity === '' || parseFloat(this.newItem.quantity) < 0) {
                this.itemErrors.quantity = 'Valid quantity is required';
                isValid = false;
            }

            if (!this.newItem.pricePerUnit || parseFloat(this.newItem.pricePerUnit) <= 0) {
                this.itemErrors.pricePerUnit = 'Valid price is required';
                isValid = false;
            }

            return isValid;
        },

        saveItem() {
            if (!this.validateAddItemForm()) {
                return;
            }

            const newId = Math.max(...this.items.map(i => i.id), 0) + 1;

            const item = {
                id: newId,
                name: this.newItem.name.trim(),
                category: this.newItem.category,
                quantity: parseFloat(this.newItem.quantity),
                unit: this.newItem.unit,
                pricePerUnit: parseFloat(this.newItem.pricePerUnit),
                lowStockThreshold: parseInt(this.newItem.lowStockThreshold) || 10
            };

            this.items.push(item);
            this.closeAddItemModal();
        },

        // Edit Item Modal Functions
        openEditItemModal(item) {
            const itemIndex = this.items.findIndex(i => i.id === item.id);

            this.editItem = {
                index: itemIndex,
                id: item.id,
                name: item.name,
                category: item.category,
                quantity: item.quantity,
                unit: item.unit,
                pricePerUnit: item.pricePerUnit,
                lowStockThreshold: item.lowStockThreshold
            };

            this.itemErrors = {
                name: '',
                category: '',
                quantity: '',
                pricePerUnit: ''
            };

            this.showEditItemModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeEditItemModal() {
            this.showEditItemModal = false;
            document.body.style.overflow = '';
        },

        validateEditItemForm() {
            let isValid = true;

            this.itemErrors = {
                name: '',
                category: '',
                quantity: '',
                pricePerUnit: ''
            };

            if (!this.editItem.name || !this.editItem.name.trim()) {
                this.itemErrors.name = 'Item name is required';
                isValid = false;
            }

            if (!this.editItem.category) {
                this.itemErrors.category = 'Please select a category';
                isValid = false;
            }

            if (this.editItem.quantity === '' || parseFloat(this.editItem.quantity) < 0) {
                this.itemErrors.quantity = 'Valid quantity is required';
                isValid = false;
            }

            if (!this.editItem.pricePerUnit || parseFloat(this.editItem.pricePerUnit) <= 0) {
                this.itemErrors.pricePerUnit = 'Valid price is required';
                isValid = false;
            }

            return isValid;
        },

        updateItem() {
            if (!this.validateEditItemForm()) {
                return;
            }

            if (this.editItem.index === null || this.editItem.index < 0) {
                return;
            }

            this.items[this.editItem.index] = {
                id: this.editItem.id,
                name: this.editItem.name.trim(),
                category: this.editItem.category,
                quantity: parseFloat(this.editItem.quantity),
                unit: this.editItem.unit,
                pricePerUnit: parseFloat(this.editItem.pricePerUnit),
                lowStockThreshold: parseInt(this.editItem.lowStockThreshold) || 10
            };

            this.closeEditItemModal();
        },

        deleteItem(itemToDelete = null) {
            let index = -1;

            if (itemToDelete) {
                index = this.items.findIndex(i => i.id === itemToDelete.id);
            } else {
                index = this.editItem.index;
            }

            if (index === -1) return;

            if (!confirm('Are you sure you want to delete this item?')) {
                return;
            }

            this.items.splice(index, 1);
            this.closeEditItemModal();
        },

        quickAdjustStock(item, amount) {
            const itemIndex = this.items.findIndex(i => i.id === item.id);
            if (itemIndex !== -1) {
                const newQuantity = this.items[itemIndex].quantity + amount;
                if (newQuantity >= 0) {
                    this.items[itemIndex].quantity = newQuantity;
                }
            }
        },
        updateItemStatus(item, status) {
            const index = this.items.findIndex(i => i.id === item.id);
            if (index === -1) return;

            if (status === 'out') {
                this.items[index].quantity = 0;
            } else if (status === 'low') {
                this.items[index].quantity = this.items[index].lowStockThreshold;
            } else if (status === 'in') {
                if (this.items[index].quantity <= this.items[index].lowStockThreshold) {
                    this.items[index].quantity = this.items[index].lowStockThreshold + 5; // Default to safe amount
                }
            }
        }
    })
}
