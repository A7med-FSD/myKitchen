document.addEventListener("alpine:init", () => {
    Alpine.data("offersHandler", () => ({
        selectedFilter: "active", // active, expired, upcoming

        // Hero offers (all menu)
        heroOffers: [
            {
                id: 1,
                type: "all_menu",
                title: "Weekend Mega Sale",
                description: "Get 30% off on your entire order this weekend!",
                discount: 30,
                validUntil: new Date(Date.now() + 2 * 24 * 60 * 60 * 1000).toISOString(), // 2 days from now
                code: "WEEKEND30",
                bgGradient: "from-orange-500 via-red-500 to-pink-500",
            },
            {
                id: 2,
                type: "all_menu",
                title: "New Customer Special",
                description: "First order? Enjoy 25% off everything!",
                discount: 25,
                validUntil: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString(), // 7 days from now
                code: "WELCOME25",
                bgGradient: "from-purple-500 via-indigo-500 to-blue-500",
            },
        ],

        // Category offers
        categoryOffers: [
            {
                id: 3,
                type: "category",
                category: "Pizza",
                categoryIcon: "🍕",
                discount: 20,
                validUntil: new Date(Date.now() + 3 * 24 * 60 * 60 * 1000).toISOString(),
                code: "PIZZA20",
                bgColor: "bg-red-500",
            },
            {
                id: 4,
                type: "category",
                category: "Burgers",
                categoryIcon: "🍔",
                discount: 15,
                validUntil: new Date(Date.now() + 5 * 24 * 60 * 60 * 1000).toISOString(),
                code: "BURGER15",
                bgColor: "bg-yellow-500",
            },
            {
                id: 5,
                type: "category",
                category: "Salads",
                categoryIcon: "🥗",
                discount: 10,
                validUntil: new Date(Date.now() + 4 * 24 * 60 * 60 * 1000).toISOString(),
                code: "HEALTHY10",
                bgColor: "bg-green-500",
            },
            {
                id: 6,
                type: "category",
                category: "Desserts",
                categoryIcon: "🍰",
                discount: 25,
                validUntil: new Date(Date.now() + 1 * 24 * 60 * 60 * 1000).toISOString(),
                code: "SWEET25",
                bgColor: "bg-pink-500",
            },
        ],

        // Dish-specific offers
        dishOffers: [
            {
                id: 7,
                type: "dish",
                dishName: "Grilled Chicken Breast",
                originalPrice: 24.99,
                discountedPrice: 19.99,
                discount: 20,
                validUntil: new Date(Date.now() + 12 * 60 * 60 * 1000).toISOString(), // 12 hours
                image: "https://images.unsplash.com/photo-1532550907401-a500c9a57435?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
            },
            {
                id: 8,
                type: "dish",
                dishName: "Margherita Pizza",
                originalPrice: 19.99,
                discountedPrice: 14.99,
                discount: 25,
                validUntil: new Date(Date.now() + 6 * 60 * 60 * 1000).toISOString(),
                image: "https://images.unsplash.com/photo-1574071318508-1cdbab80d002?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
            },
            {
                id: 9,
                type: "dish",
                dishName: "Beef Burger Deluxe",
                originalPrice: 16.99,
                discountedPrice: 13.59,
                discount: 20,
                validUntil: new Date(Date.now() + 8 * 60 * 60 * 1000).toISOString(),
                image: "https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
            },
            {
                id: 10,
                type: "dish",
                dishName: "Caesar Salad",
                originalPrice: 12.99,
                discountedPrice: 9.74,
                discount: 25,
                validUntil: new Date(Date.now() + 10 * 60 * 60 * 1000).toISOString(),
                image: "https://images.unsplash.com/photo-1550304943-4f24f54ddde9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
            },
            {
                id: 11,
                type: "dish",
                dishName: "Salmon Fillet",
                originalPrice: 29.99,
                discountedPrice: 23.99,
                discount: 20,
                validUntil: new Date(Date.now() + 4 * 60 * 60 * 1000).toISOString(),
                image: "https://images.unsplash.com/photo-1467003909585-2f8a7270028d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
            },
            {
                id: 12,
                type: "dish",
                dishName: "Chocolate Lava Cake",
                originalPrice: 8.99,
                discountedPrice: 6.74,
                discount: 25,
                validUntil: new Date(Date.now() + 15 * 60 * 60 * 1000).toISOString(),
                image: "https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
            },
        ],

        init() {
            // Start countdown timers
            setInterval(() => {
                this.$nextTick();
            }, 1000);
        },

        // Calculate countdown
        getCountdown(validUntil) {
            const now = new Date();
            const end = new Date(validUntil);
            const diff = end - now;

            if (diff <= 0) return "Expired";

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            if (days > 0) return `${days}d ${hours}h ${minutes}m`;
            if (hours > 0) return `${hours}h ${minutes}m ${seconds}s`;
            return `${minutes}m ${seconds}s`;
        },

        // Check if offer is expiring soon (< 24 hours)
        isExpiringSoon(validUntil) {
            const now = new Date();
            const end = new Date(validUntil);
            const diff = end - now;
            return diff > 0 && diff < 24 * 60 * 60 * 1000;
        },

        // Check if offer is expired
        isExpired(validUntil) {
            return new Date(validUntil) < new Date();
        },

        // Copy promo code
        copyCode(code) {
            navigator.clipboard.writeText(code);
            // Alert removed to use inline feedback
        },

        // Get filtered offers based on active/expired/upcoming
        get filteredHeroOffers() {
            if (this.selectedFilter === "active") {
                return this.heroOffers.filter((o) => !this.isExpired(o.validUntil));
            } else if (this.selectedFilter === "expired") {
                return this.heroOffers.filter((o) => this.isExpired(o.validUntil));
            }
            return this.heroOffers;
        },

        get filteredCategoryOffers() {
            if (this.selectedFilter === "active") {
                return this.categoryOffers.filter((o) => !this.isExpired(o.validUntil));
            } else if (this.selectedFilter === "expired") {
                return this.categoryOffers.filter((o) => this.isExpired(o.validUntil));
            }
            return this.categoryOffers;
        },

        get filteredDishOffers() {
            if (this.selectedFilter === "active") {
                return this.dishOffers.filter((o) => !this.isExpired(o.validUntil));
            } else if (this.selectedFilter === "expired") {
                return this.dishOffers.filter((o) => this.isExpired(o.validUntil));
            }
            return this.dishOffers;
        },
    }));
});
