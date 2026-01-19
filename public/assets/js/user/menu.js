// Menu Page - Most Ordered Carousel
document.addEventListener("alpine:init", () => {
    Alpine.data("mostOrderedCarousel", () => ({
        currentIndex: 0,
        isTransitioning: false,
        
        // Sample data - replace with backend data later
        dishes: [
            {
                id: 1,
                name: "Grilled Chicken Breast",
                description: "Tender grilled chicken with herbs and spices",
                price: 18.99,
                discount: 15,
                image: "https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=800&h=600&fit=crop",
                badge: "featured",
                rating: 5,
                reviews: 342,
                prepTime: 25
            },
            {
                id: 2,
                name: "Beef Burger Deluxe",
                description: "Juicy beef patty with cheese, lettuce, and special sauce",
                price: 15.99,
                image: "https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800&h=600&fit=crop",
                badge: "special",
                rating: 5,
                reviews: 289,
                prepTime: 20
            },
            {
                id: 3,
                name: "Margherita Pizza",
                description: "Fresh mozzarella, tomatoes, and basil on thin crust",
                price: 16.99,
                discount: 10,
                image: "https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=800&h=600&fit=crop",
                badge: "recommended",
                rating: 4,
                reviews: 215,
                prepTime: 30
            },
            {
                id: 4,
                name: "Caesar Salad",
                description: "Crispy romaine lettuce with parmesan and croutons",
                price: 12.99,
                image: "https://images.unsplash.com/photo-1546793665-c74683f339c1?w=800&h=600&fit=crop",
                badge: "new",
                rating: 4,
                reviews: 178,
                prepTime: 15
            },
            {
                id: 5,
                name: "Spaghetti Carbonara",
                description: "Classic Italian pasta with bacon and creamy sauce",
                price: 17.99,
                image: "https://images.unsplash.com/photo-1555126634-323283e090fa?auto=format&fit=crop&w=800&q=80",
                rating: 5,
                reviews: 256,
                prepTime: 25
            },
            {
                id: 6,
                name: "Salmon Fillet",
                description: "Pan-seared salmon with lemon butter sauce",
                price: 24.99,
                discount: 20,
                image: "https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=800&h=600&fit=crop",
                badge: "featured",
                rating: 5,
                reviews: 301,
                prepTime: 20
            }
        ],

        // Calculate maximum scroll position (last set of 3 cards)
        get maxIndex() {
            return Math.max(0, this.dishes.length - 3);
        },

        // Check if we can go to previous
        get canGoPrev() {
            return this.currentIndex > 0;
        },

        // Check if we can go to next
        get canGoNext() {
            return this.currentIndex < this.maxIndex;
        },

        // Calculate translate value (each card is 320px + 16px gap)
        get translateX() {
            const cardWidth = 336; // 320px card + 16px gap
            return `-${this.currentIndex * cardWidth}px`;
        },

        slideNext() {
            if (!this.canGoNext || this.isTransitioning) return;
            
            this.isTransitioning = true;
            this.currentIndex++;
            
            setTimeout(() => {
                this.isTransitioning = false;
            }, 500); // Match CSS transition duration
        },

        slidePrev() {
            if (!this.canGoPrev || this.isTransitioning) return;
            
            this.isTransitioning = true;
            this.currentIndex--;
            
            setTimeout(() => {
                this.isTransitioning = false;
            }, 500); // Match CSS transition duration
        },

        handleManualNext() {
            this.slideNext();
        },

        handleManualPrev() {
            this.slidePrev();
        }
    }));

    // Main Menu Handler
    Alpine.data("mainMenuHandler", () => ({
        searchQuery: "",
        searchFilter: "All",
        selectedCategory: "All",
        selectedBadge: null,

        // All menu dishes with categories
        allDishes: [
            {
                id: 1,
                name: "Grilled Chicken Breast",
                description: "Tender grilled chicken with herbs and spices",
                price: 18.99,
                discount: 15,
                image: "https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=800&h=600&fit=crop",
                badge: "featured",
                rating: 5,
                reviews: 342,
                prepTime: 25,
                category: "Main Course",
            },
            {
                id: 2,
                name: "Beef Burger Deluxe",
                description:
                    "Juicy beef patty with cheese, lettuce, and special sauce",
                price: 15.99,
                image: "https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800&h=600&fit=crop",
                badge: "special",
                rating: 5,
                reviews: 289,
                prepTime: 20,
                category: "Fast Food",
            },
            {
                id: 3,
                name: "Margherita Pizza",
                description:
                    "Fresh mozzarella, tomatoes, and basil on thin crust",
                price: 16.99,
                discount: 10,
                image: "https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=800&h=600&fit=crop",
                badge: "recommended",
                rating: 4,
                reviews: 215,
                prepTime: 30,
                category: "Pizza",
            },
            {
                id: 4,
                name: "Caesar Salad",
                description:
                    "Crispy romaine lettuce with parmesan and croutons",
                price: 12.99,
                image: "https://images.unsplash.com/photo-1546793665-c74683f339c1?w=800&h=600&fit=crop",
                badge: "new",
                rating: 4,
                reviews: 178,
                prepTime: 15,
                category: "Salads",
            },
            {
                id: 5,
                name: "Spaghetti Carbonara",
                description:
                    "Classic Italian pasta with bacon and creamy sauce",
                price: 17.99,
                image: "https://images.unsplash.com/photo-1555126634-323283e090fa?auto=format&fit=crop&w=800&q=80",
                rating: 5,
                reviews: 256,
                prepTime: 25,
                category: "Pasta",
            },
            {
                id: 6,
                name: "Salmon Fillet",
                description: "Pan-seared salmon with lemon butter sauce",
                price: 24.99,
                discount: 20,
                image: "https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=800&h=600&fit=crop",
                badge: "featured",
                rating: 5,
                reviews: 301,
                prepTime: 20,
                category: "Seafood",
            },
            {
                id: 7,
                name: "Chocolate Lava Cake",
                description:
                    "Warm chocolate cake with molten center and vanilla ice cream",
                price: 8.99,
                image: "https://images.unsplash.com/photo-1624353365286-3f8d62daad51?w=800&h=600&fit=crop",
                badge: "special",
                rating: 5,
                reviews: 412,
                prepTime: 15,
                category: "Desserts",
            },
            {
                id: 8,
                name: "Pepperoni Pizza",
                description:
                    "Classic pepperoni with extra cheese and Italian herbs",
                price: 17.99,
                image: "https://images.unsplash.com/photo-1628840042765-356cda07504e?w=800&h=600&fit=crop",
                badge: "recommended",
                rating: 5,
                reviews: 387,
                prepTime: 25,
                category: "Pizza",
            },
            {
                id: 9,
                name: "Greek Salad",
                description: "Fresh vegetables with feta cheese and olives",
                price: 11.99,
                image: "https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=800&h=600&fit=crop",
                rating: 4,
                reviews: 156,
                prepTime: 10,
                category: "Salads",
            },
            {
                id: 10,
                name: "Chicken Wings",
                description: "Crispy buffalo wings with ranch dipping sauce",
                price: 13.99,
                discount: 15,
                image: "https://images.unsplash.com/photo-1608039829572-78524f79c4c7?w=800&h=600&fit=crop",
                badge: "new",
                rating: 5,
                reviews: 234,
                prepTime: 20,
                category: "Fast Food",
            },
            {
                id: 11,
                name: "Shrimp Scampi Pasta",
                description: "Garlic butter shrimp with linguine pasta",
                price: 22.99,
                image: "https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=800&h=600&fit=crop",
                badge: "featured",
                rating: 5,
                reviews: 289,
                prepTime: 30,
                category: "Seafood",
            },
            {
                id: 12,
                name: "New York Cheesecake",
                description:
                    "Classic creamy cheesecake with graham cracker crust",
                price: 7.99,
                image: "https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=800&h=600&fit=crop",
                rating: 4,
                reviews: 198,
                prepTime: 10,
                category: "Desserts",
            },
        ],

        // Categories with icons
        categories: [
            { name: "All", icon: "🍽️", count: 0 },
            { name: "Main Course", icon: "🍗", count: 0 },
            { name: "Fast Food", icon: "🍔", count: 0 },
            { name: "Pizza", icon: "🍕", count: 0 },
            { name: "Pasta", icon: "🍝", count: 0 },
            { name: "Salads", icon: "🥗", count: 0 },
            { name: "Seafood", icon: "🦐", count: 0 },
            { name: "Desserts", icon: "🍰", count: 0 },
        ],

        init() {
            this.updateCategoryCounts();
        },

        // Update category counts
        updateCategoryCounts() {
            this.categories.forEach((cat) => {
                if (cat.name === "All") {
                    cat.count = this.allDishes.length;
                } else {
                    cat.count = this.allDishes.filter(
                        (dish) => dish.category === cat.name,
                    ).length;
                }
            });
        },

        // Get filtered dishes based on all filters
        get filteredDishes() {
            let items = this.allDishes;

            // Filter by category first
            if (this.selectedCategory !== "All") {
                items = items.filter((dish) => dish.category === this.selectedCategory);
            }

            // Filter by badge
            if (this.selectedBadge) {
                items = items.filter((dish) => dish.badge === this.selectedBadge);
            }

            // Filter by search
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                items = items.filter((dish) => {
                    if (this.searchFilter === "All") {
                        return (
                            dish.name.toLowerCase().includes(query) ||
                            dish.description.toLowerCase().includes(query)
                        );
                    } else if (this.searchFilter === "Name") {
                        return dish.name.toLowerCase().includes(query);
                    } else if (this.searchFilter === "Description") {
                        return dish.description.toLowerCase().includes(query);
                    }
                    return false;
                });
            }

            // Update count for the selected category based on the filtered results
            const selectedCatIndex = this.categories.findIndex(
                (c) => c.name === this.selectedCategory,
            );
            if (selectedCatIndex !== -1) {
                this.categories[selectedCatIndex].count = items.length;
            }

            return items;
        },

        // Reset category count to its original value
        resetCategoryCount(categoryName) {
            const category = this.categories.find((c) => c.name === categoryName);
            if (!category) return;

            if (categoryName === "All") {
                category.count = this.allDishes.length;
            } else {
                category.count = this.allDishes.filter(
                    (dish) => dish.category === categoryName,
                ).length;
            }
        },

        // Set category
        setCategory(categoryName) {
            if (this.selectedCategory === categoryName) return;

            // Reset the count of the previously selected category to its total
            this.resetCategoryCount(this.selectedCategory);

            this.selectedCategory = categoryName;
        },

        // Get category button classes
        getCategoryClasses(categoryName) {
            return this.selectedCategory === categoryName
                ? "bg-yellow-400 text-gray-900 shadow-lg shadow-yellow-100 scale-105"
                : "bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-200";
        },

        // Get count badge classes
        getCountClasses(categoryName) {
            return this.selectedCategory === categoryName
                ? 'bg-white/20 text-white'
                : 'bg-black/5 text-black/50';
        },
    }));

    // Customer Reviews Handler
    Alpine.data("customerReviews", () => ({
        reviews: [
            {
                id: 1,
                userName: "Sarah Johnson",
                userAvatar: "https://i.pravatar.cc/150?img=1",
                dishName: "Grilled Chicken Breast",
                rating: 5,
                content: "Absolutely delicious! The chicken was perfectly seasoned and cooked to perfection. The herbs add such a wonderful flavor. Will definitely order again!",
                date: "2 days ago",
            },
            {
                id: 2,
                userName: "Michael Chen",
                userAvatar: "https://i.pravatar.cc/150?img=13",
                dishName: "Margherita Pizza",
                rating: 5,
                content: "Best pizza I've had in a long time! The crust was crispy, the mozzarella was fresh, and the basil was aromatic. Exactly what a Margherita should be.",
                date: "3 days ago",
            },
            {
                id: 3,
                userName: "Emma Davis",
                userAvatar: "https://i.pravatar.cc/150?img=5",
                dishName: "Salmon Fillet",
                rating: 4,
                content: "Really enjoyed this dish! The salmon was fresh and the lemon butter sauce complemented it perfectly. Only wish the portion was a bit larger.",
                date: "5 days ago",
            },
            {
                id: 4,
                userName: "James Wilson",
                userAvatar: "https://i.pravatar.cc/150?img=12",
                dishName: "Chocolate Lava Cake",
                rating: 5,
                content: "Heaven in a dessert! The molten center was perfectly gooey, and paired with vanilla ice cream it was simply divine. A must-try for chocolate lovers!",
                date: "1 week ago",
            },
            {
                id: 5,
                userName: "Olivia Martinez",
                userAvatar: "https://i.pravatar.cc/150?img=9",
                dishName: "Caesar Salad",
                rating: 4,
                content: "Fresh and crispy! The dressing was creamy and flavorful, and the croutons added a nice crunch. Perfect for a light lunch.",
                date: "1 week ago",
            },
            {
                id: 6,
                userName: "David Brown",
                userAvatar: "https://i.pravatar.cc/150?img=15",
                dishName: "Beef Burger Deluxe",
                rating: 5,
                content: "Hands down the best burger in town! The patty was juicy, the cheese perfectly melted, and that special sauce is amazing. Highly recommended!",
                date: "2 weeks ago",
            },
        ],
    }));
});
