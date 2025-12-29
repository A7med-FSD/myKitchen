document.addEventListener('alpine:init', () => {
    Alpine.data('menuHandler', () => ({
        searchQuery: '',
        searchFilter: 'All', 
        searchFilters: ['All', 'Name', 'Description', 'Badge'], // Replaced Category with Badge
        selectedCategory: 'All',
        categories: [
            { name: 'All', icon: '🍽️', count: 18 },
            { name: 'Main Dishes', icon: '🍖', count: 5 },
            { name: 'Appetizers', icon: '🥗', count: 3 },
            { name: 'Desserts', icon: '🍰', count: 2 },
            { name: 'Drinks', icon: '🥤', count: 2 },
            { name: 'Soups', icon: '🥣', count: 3 },
            { name: 'Salads', icon: '🥗', count: 3 }
        ],
        dishes: [
            // Main Dishes
            { name: 'Shrimp Stir-Fry with Brown Rice', description: 'A quick and healthy stir-fry with succulent shrimp, colorful vegetables, and a side of brown rice.', category: 'Main Dishes', price: 18.99, prepTime: 45, image: 'https://images.unsplash.com/photo-1555126634-323283e090fa?auto=format&fit=crop&w=800&q=80', rating: 4, badge: 'new' },
            { name: 'Grilled Salmon', description: 'Fresh Atlantic salmon grilled to perfection with lemon butter sauce.', category: 'Main Dishes', price: 24.99, prepTime: 30, image: 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=800&q=80', rating: 5, badge: 'featured' },
            { name: 'Chicken Alfredo Pasta', description: 'Creamy alfredo sauce with tender chicken breast over fettuccine pasta.', category: 'Main Dishes', price: 16.99, prepTime: 35, image: 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?auto=format&fit=crop&w=800&q=80', rating: 4, badge: null },
            { name: 'Veggie Burger', description: 'Plant-based patty with fresh vegetables and special sauce.', category: 'Main Dishes', price: 12.99, prepTime: 25, image: 'https://images.unsplash.com/photo-1520072959219-c595dc870360?auto=format&fit=crop&w=800&q=80', rating: 3, badge: 'recommended' },
            { name: 'Beef Steak', description: 'Premium beef steak cooked to your preference with seasonal vegetables.', category: 'Main Dishes', price: 28.99, prepTime: 40, image: 'https://images.unsplash.com/photo-1546833999-b9f581a1996d?auto=format&fit=crop&w=800&q=80', rating: 5, badge: 'special' },
            
            // Appetizers
            { name: 'Caesar Salad', description: 'Classic Caesar salad with crispy romaine lettuce, croutons, and parmesan.', category: 'Appetizers', price: 8.99, prepTime: 15, image: 'https://images.unsplash.com/photo-1546793665-c74683f339c1?auto=format&fit=crop&w=800&q=80', rating: 4, badge: null },
            { name: 'Bruschetta', description: 'Toasted bread topped with fresh tomatoes, basil, and mozzarella.', category: 'Appetizers', price: 7.99, prepTime: 10, image: 'https://images.unsplash.com/photo-1572695157366-5e585ab2b69f?auto=format&fit=crop&w=800&q=80', rating: 4, badge: 'recommended' },
            { name: 'Spring Rolls', description: 'Crispy vegetable spring rolls served with sweet chili sauce.', category: 'Appetizers', price: 6.99, prepTime: 20, image: 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=800&q=80', rating: 3, badge: null },
            
            // Desserts
            { name: 'Chocolate Lava Cake', description: 'Warm chocolate cake with a gooey molten center, served with vanilla ice cream.', category: 'Desserts', price: 9.99, prepTime: 25, image: 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?auto=format&fit=crop&w=800&q=80', rating: 5, badge: 'featured' },
            { name: 'Tiramisu', description: 'Classic Italian dessert with layers of coffee-soaked ladyfingers and mascarpone.', category: 'Desserts', price: 8.99, prepTime: 15, image: 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?auto=format&fit=crop&w=800&q=80', rating: 4, badge: 'special' },
            
            // Drinks
            { name: 'Fresh Juice', description: 'Freshly squeezed orange, apple, or carrot juice.', category: 'Drinks', price: 4.99, prepTime: 5, image: 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?auto=format&fit=crop&w=800&q=80', rating: 5, badge: 'recommended' },
            { name: 'Smoothie Bowl', description: 'Acai or mango smoothie bowl topped with fresh fruits and granola.', category: 'Drinks', price: 7.99, prepTime: 10, image: 'https://images.unsplash.com/photo-1590301157890-4810ed352733?auto=format&fit=crop&w=800&q=80', rating: 4, badge: null },

            // Soups (New examples)
            { name: 'Tomato Basil Soup', description: 'Rich and creamy tomato soup with fresh basil.', category: 'Soups', price: 6.99, prepTime: 15, image: 'https://images.unsplash.com/photo-1547592166-23acbe32263b?auto=format&fit=crop&w=800&q=80', rating: 4, badge: 'new' },
            { name: 'Chicken Noodle Soup', description: 'Comforting chicken noodle soup with fresh vegetables.', category: 'Soups', price: 7.99, prepTime: 20, image: 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=800&q=80', rating: 4, badge: null },
            { name: 'Mushroom Soup', description: 'Creamy mushroom soup with truffle oil.', category: 'Soups', price: 8.99, prepTime: 25, image: 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=800&q=80', rating: 5, badge: 'special' },

            // More Salads
            { name: 'Greek Salad', description: 'Fresh cucumbers, tomatoes, olives, and feta cheese.', category: 'Salads', price: 9.99, prepTime: 15, image: 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80', rating: 4, badge: 'recommended' },
            { name: 'Quinoa Salad', description: 'Healthy quinoa salad with avocado and lime dressing.', category: 'Salads', price: 10.99, prepTime: 20, image: 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80', rating: 5, badge: 'featured' },
            { name: 'Fruit Salad', description: 'Seasonal fresh fruit salad with honey dressing.', category: 'Salads', price: 6.99, prepTime: 10, image: 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80', rating: 4, badge: null }
        ],

        // Category Modal State
        showAddCategoryModal: false,
        newCategoryName: '',
        newCategoryIcon: '',
        categoryNameError: '',
        availableIcons: ['🍽️', '🍖', '🥗', '🍰', '🥤', '🥣', '🍕', '🍔', '🌮', '🍜', '🍱', '🥘', '🍲', '🥙', '🧆', '🍛', '🥟'],
        //  '🍝', '🥞', '🧇', '🥓', '🍳','🥐', '🍞', '🥖', '🥨', '🧀', '🍗', '🍤', '🦀', '🍣', '🍙', '🍚', '🍢', '🍡', '🥮'

        // Add Dish Modal State
        showAddDishModal: false,
        newDish: {
            name: '',
            price: '',
            image: null,
            imagePreview: null,
            description: '',
            category: '',
            prepTime: 30,
            badge: null,
            rating: 0
        },
        dishErrors: {
            name: '',
            price: '',
            image: '',
            description: '',
            category: ''
        },

        // Edit Dish Modal State
        showEditDishModal: false,
        editDish: {
            index: null,
            name: '',
            price: '',
            image: null,
            imagePreview: null,
            description: '',
            category: '',
            prepTime: 30,
            badge: null,
            rating: 0
        },

        init() {
            this.$watch('searchQuery', () => this.triggerAnimation());
            this.$watch('searchFilter', () => this.triggerAnimation());
        },

        setCategory(category) {
            if (this.selectedCategory === category) return;
            
            // Reset the count of the previously selected category to its total
            this.resetCategoryCount(this.selectedCategory);
            
            this.selectedCategory = category;
            this.triggerAnimation();
        },

        resetCategoryCount(categoryName) {
            const category = this.categories.find(c => c.name === categoryName);
            if (!category) return;

            if (categoryName === 'All') {
                category.count = this.dishes.length;
            } else {
                category.count = this.dishes.filter(d => d.category === categoryName).length;
            }
        },

        getCategoryClasses(categoryName) {
            return this.selectedCategory === categoryName 
                ? 'bg-yellow-400 text-gray-900 shadow-lg shadow-yellow-100 scale-105' 
                : 'bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-200';
        },

        getCountClasses(categoryName) {
            return this.selectedCategory === categoryName
                ? 'bg-white/20 text-white'
                : 'bg-black/5 text-black/50';
        },

        get filteredDishes() {
            let items = this.dishes;
            
            // Filter by category (Tab)
            if (this.selectedCategory !== 'All') {
                items = items.filter(dish => dish.category === this.selectedCategory);
            }
            
            // Filter by search query with specific fields
            if (this.searchQuery.trim() !== '') {
                const query = this.searchQuery.toLowerCase();
                
                items = items.filter(dish => {
                    const nameMatch = dish.name.toLowerCase().includes(query);
                    const descMatch = dish.description.toLowerCase().includes(query);
                    const badgeMatch = dish.badge ? dish.badge.toLowerCase().includes(query) : false;

                    if (this.searchFilter === 'Name') {
                        return nameMatch;
                    } else if (this.searchFilter === 'Description') {
                        return descMatch;
                    } else if (this.searchFilter === 'Badge') {
                        return badgeMatch;
                    } else {
                        return nameMatch || descMatch || badgeMatch;
                    }
                });
            }

            // Update count for the selected category based on the filtered results
            const selectedCatIndex = this.categories.findIndex(c => c.name === this.selectedCategory);
            if (selectedCatIndex !== -1) {
                this.categories[selectedCatIndex].count = items.length;
            }
            
            return items;
        },

        triggerAnimation() {
            this.$nextTick(() => {
                const cards = document.querySelectorAll('.animate-entrance-card');
                cards.forEach(card => {
                    card.classList.remove('animate-entrance-card');
                    void card.offsetWidth;
                    card.classList.add('animate-entrance-card');
                });
            });
        },

        openAddDishModal() {
            // Reset form
            this.newDish = {
                name: '',
                price: '',
                image: null,
                imagePreview: null,
                description: '',
                category: this.selectedCategory !== 'All' ? this.selectedCategory : '',
                prepTime: 30,
                badge: null,
                rating: 0
            };
            this.dishErrors = {
                name: '',
                price: '',
                image: '',
                description: '',
                category: ''
            };
            this.showAddDishModal = true;
            document.body.style.overflow = 'hidden';
            
            // Reset file input on next tick
            this.$nextTick(() => {
                const fileInput = document.querySelector('input[type="file"]');
                if (fileInput) fileInput.value = '';
            });
        },

        closeAddDishModal() {
            this.showAddDishModal = false;
            document.body.style.overflow = '';
        },

        handleImageUpload(event) {
            let file;
            
            // Check if drag & drop or file input
            if (event.dataTransfer) {
                file = event.dataTransfer.files[0];
            } else {
                file = event.target.files[0];
            }

            if (!file) return;

            // Validate type
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                this.dishErrors.image = 'Please upload JPG, PNG, or WebP image';
                return;
            }

            // Validate size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                this.dishErrors.image = 'Image must be less than 5MB';
                return;
            }

            // Create preview
            const reader = new FileReader();
            reader.onload = (e) => {
                this.newDish.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);

            this.newDish.image = file;
            this.dishErrors.image = '';
        },

        removeImage() {
            this.newDish.image = null;
            this.newDish.imagePreview = null;
            // Reset file input
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput) fileInput.value = '';
        },

        validateAddDishForm() {
            let isValid = true;

            // Reset errors
            this.dishErrors = {
                name: '',
                price: '',
                image: '',
                description: '',
                category: ''
            };

            // Validate name
            if (!this.newDish.name || !this.newDish.name.trim()) {
                this.dishErrors.name = 'Dish name is required';
                isValid = false;
            }

            // Validate price
            if (!this.newDish.price || parseFloat(this.newDish.price) <= 0) {
                this.dishErrors.price = 'Valid price is required';
                isValid = false;
            }

            // Validate image - must have new image
            if (!this.newDish.image) {
                this.dishErrors.image = 'Dish image is required';
                isValid = false;
            }

            // Validate description
            if (!this.newDish.description || !this.newDish.description.trim()) {
                this.dishErrors.description = 'Description is required';
                isValid = false;
            }

            // Validate category
            if (!this.newDish.category) {
                this.dishErrors.category = 'Please select a category';
                isValid = false;
            }

            return isValid;
        },

        validateEditDishForm() {
            let isValid = true;

            // Reset errors
            this.dishErrors = {
                name: '',
                price: '',
                image: '',
                description: '',
                category: ''
            };

            // Validate name
            if (!this.editDish.name || !this.editDish.name.trim()) {
                this.dishErrors.name = 'Dish name is required';
                isValid = false;
            }

            // Validate price
            if (!this.editDish.price || parseFloat(this.editDish.price) <= 0) {
                this.dishErrors.price = 'Valid price is required';
                isValid = false;
            }

            // Validate image - must have preview (existing or new)
            if (!this.editDish.imagePreview) {
                this.dishErrors.image = 'Dish image is required';
                isValid = false;
            }

            // Validate description
            if (!this.editDish.description || !this.editDish.description.trim()) {
                this.dishErrors.description = 'Description is required';
                isValid = false;
            }

            // Validate category
            if (!this.editDish.category) {
                this.dishErrors.category = 'Please select a category';
                isValid = false;
            }

            return isValid;
        },

        saveDish() {
            // Validate form
            if (!this.validateAddDishForm()) {
                return;
            }

            // Create dish object
            const dish = {
                name: this.newDish.name.trim(),
                description: this.newDish.description.trim(),
                category: this.newDish.category,
                price: parseFloat(this.newDish.price),
                prepTime: parseInt(this.newDish.prepTime),
                image: this.newDish.imagePreview, // Use preview URL for now
                rating: 0,
                badge: this.newDish.badge
            };

            // Add to dishes array
            this.dishes.push(dish);

            // Update category count
            const categoryIndex = this.categories.findIndex(c => c.name === dish.category);
            if (categoryIndex !== -1) {
                this.categories[categoryIndex].count++;
            }
            
            // Update "All" count
            const allCategoryIndex = this.categories.findIndex(c => c.name === 'All');
            if (allCategoryIndex !== -1) {
                this.categories[allCategoryIndex].count = this.dishes.length;
            }

            // Close modal and trigger animation
            this.closeAddDishModal();
        },

        openEditModal(dish) {
            // Find dish index
            const dishIndex = this.dishes.findIndex(d => 
                d.name === dish.name && 
                d.category === dish.category && 
                d.price === dish.price
            );

            // Populate edit form with dish data
            this.editDish = {
                index: dishIndex,
                name: dish.name,
                price: dish.price,
                image: null,
                imagePreview: dish.image,
                description: dish.description,
                category: dish.category,
                prepTime: dish.prepTime,
                badge: dish.badge,
                rating: dish.rating
            };

            // Clear errors
            this.dishErrors = {
                name: '',
                price: '',
                image: '',
                description: '',
                category: ''
            };

            this.showEditDishModal = true;
            document.body.style.overflow = 'hidden';

            // Reset file input
            this.$nextTick(() => {
                const fileInput = document.querySelector('input[x-ref="editFileInput"]');
                if (fileInput) fileInput.value = '';
            });
        },

        closeEditDishModal() {
            this.showEditDishModal = false;
            document.body.style.overflow = '';
        },

        handleEditImageUpload(event) {
            let file;
            
            if (event.dataTransfer) {
                file = event.dataTransfer.files[0];
            } else {
                file = event.target.files[0];
            }

            if (!file) return;

            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                this.dishErrors.image = 'Please upload JPG, PNG, or WebP image';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                this.dishErrors.image = 'Image must be less than 5MB';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                this.editDish.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);

            this.editDish.image = file;
            this.dishErrors.image = '';
        },

        removeEditImage() {
            this.editDish.image = null;
            this.editDish.imagePreview = null;
            const fileInput = document.querySelector('input[x-ref="editFileInput"]');
            if (fileInput) fileInput.value = '';
        },

        updateDish() {
            // Validate form
            if (!this.validateEditDishForm()) {
                return;
            }

            if (this.editDish.index === null || this.editDish.index < 0) {
                return;
            }

            const oldCategory = this.dishes[this.editDish.index].category;
            const newCategory = this.editDish.category;

            // Update dish
            this.dishes[this.editDish.index] = {
                name: this.editDish.name.trim(),
                description: this.editDish.description.trim(),
                category: newCategory,
                price: parseFloat(this.editDish.price),
                prepTime: parseInt(this.editDish.prepTime),
                image: this.editDish.imagePreview,
                rating: this.editDish.rating,
                badge: this.editDish.badge
            };

            // Update category counts if category changed
            if (oldCategory !== newCategory) {
                // Decrease old category count
                const oldCatIndex = this.categories.findIndex(c => c.name === oldCategory);
                if (oldCatIndex !== -1 && this.categories[oldCatIndex].count > 0) {
                    this.categories[oldCatIndex].count--;
                }

                // Increase new category count
                const newCatIndex = this.categories.findIndex(c => c.name === newCategory);
                if (newCatIndex !== -1) {
                    this.categories[newCatIndex].count++;
                }
            }

            this.closeEditDishModal();
        },

        deleteDish(dishToDelete = null) {
            let index = -1;
            let dish = null;

            if (dishToDelete) {
                // Called from item card
                // Find index by matching properties
                index = this.dishes.findIndex(d => 
                    d.name === dishToDelete.name && 
                    d.category === dishToDelete.category && 
                    d.price === dishToDelete.price
                );
                dish = dishToDelete;
            } else {
                // Called from edit modal
                index = this.editDish.index;
                if (index !== null && index >= 0) {
                    dish = this.dishes[index];
                }
            }

            if (index === -1 || !dish) return;

            // Confirmation dialog
            if (!confirm('Are you sure you want to delete this dish?')) {
                return;
            }

            // Remove dish
            this.dishes.splice(index, 1);

            // Update category count
            const categoryIndex = this.categories.findIndex(c => c.name === dish.category);
            if (categoryIndex !== -1 && this.categories[categoryIndex].count > 0) {
                this.categories[categoryIndex].count--;
            }

            // Update "All" count
            const allCategoryIndex = this.categories.findIndex(c => c.name === 'All');
            if (allCategoryIndex !== -1) {
                this.categories[allCategoryIndex].count = this.dishes.length;
            }

            // Close modal if it was open (safe to call even if not open)
            this.closeEditDishModal();
        },

        openAddCategoryModal() {
            this.newCategoryName = '';
            this.newCategoryIcon = '';
            this.categoryNameError = '';
            this.showAddCategoryModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeAddCategoryModal() {
            this.showAddCategoryModal = false;
            document.body.style.overflow = '';
        },

        addCustomIcon() {
            // Add an empty placeholder that will be replaced with user input
            this.availableIcons.push('');
            // Focus on the new input after DOM update
            this.$nextTick(() => {
                const inputs = document.querySelectorAll('.icon-input');
                if (inputs.length > 0) {
                    inputs[inputs.length - 1].focus();
                }
            });
        },

        updateIcon(index, event) {
            const value = event.target.textContent.trim();
            if (value) {
                // Replace the empty string with the actual icon
                this.availableIcons[index] = value;
            } else {
                // Remove empty icon on blur if no value entered
                this.availableIcons.splice(index, 1);
            }
        },

        removeIcon(icon) {
            const index = this.availableIcons.indexOf(icon);
            if (index > -1) {
                this.availableIcons.splice(index, 1);
                // Clear selection if the removed icon was selected
                if (this.newCategoryIcon === icon) {
                    this.newCategoryIcon = '';
                }
            }       
        },

        saveCategory() {
            // Clear previous error
            this.categoryNameError = '';

            // Check if name is empty
            if (!this.newCategoryName.trim()) {
                return;
            }

            // Check for duplicate names (case-insensitive)
            const categoryNameLower = this.newCategoryName.trim().toLowerCase();
            const isDuplicate = this.categories.some(cat => cat.name.toLowerCase() === categoryNameLower);
            
            if (isDuplicate) {
                this.categoryNameError = 'This category name already exists';
                return;
            }

            const category = {
                name: this.newCategoryName.trim(),
                icon: this.newCategoryIcon || '🍽️', // Default icon if none selected
                count: 0
            };

            this.categories.push(category);

            // Select the new category
            this.selectedCategory = category.name;
            
            this.closeAddCategoryModal();
        },

        removeCategory() {
            // Prevent removing 'All' category
            if (this.selectedCategory === 'All') {
                alert('Cannot delete the "All" category');
                return;
            }

            // Check if category has items
            const itemCount = this.dishes.filter(d => d.category === this.selectedCategory).length;
            if (itemCount > 0) {
                alert(`Cannot delete "${this.selectedCategory}" category because it contains ${itemCount} item(s). Please move or delete all items first.`);
                return;
            }

            // Find and remove the category
            const categoryIndex = this.categories.findIndex(c => c.name === this.selectedCategory);
            if (categoryIndex !== -1) {
                this.categories.splice(categoryIndex, 1);
                
                // Switch to 'All' category after deletion
                this.selectedCategory = 'All';
            }
        }
    }))
});
