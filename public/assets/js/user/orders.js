document.addEventListener("alpine:init", () => {
    // Orders Handler for User Panel
    Alpine.data("ordersHandler", () => ({
        searchQuery: "",
        selectedPeriod: "All",
        showModal: false,
        selectedOrder: null,

        init() {
            this.$watch('searchQuery', () => this.triggerAnimation());
            this.$watch('selectedPeriod', () => this.triggerAnimation());
        },

        // Sample orders data
        orders: [
            {
                id: "ORD-1236",
                time: "10 minutes ago",
                status: "Pending",
                type: "Delivery",
                address: "456 Elm Street, Apartment 8C, Uptown",
                items: [
                    {
                        name: "Beef Burger Deluxe",
                        qty: 2,
                        price: 15.99,
                    },
                    {
                        name: "Spaghetti Carbonara",
                        qty: 1,
                        price: 17.99,
                        originalPrice: 21.99,
                    },
                    {
                        name: "Caesar Salad",
                        qty: 2,
                        price: 12.99,
                    },
                    {
                        name: "Chocolate Lava Cake",
                        qty: 1,
                        price: 8.99,
                    },
                    {
                        name: "Fresh Juice",
                        qty: 3,
                        price: 4.99,
                    },
                ],
                total: 86.92,
                date: new Date(Date.now() - 10 * 60 * 1000), // 10 minutes ago
            },
            {
                id: "ORD-1235",
                time: "30 minutes ago",
                status: "In Progress",
                type: "Delivery",
                address: "789 Maple Street, Apartment 12A",
                items: [
                    {
                        name: "Pepperoni Pizza",
                        qty: 2,
                        price: 17.99,
                    },
                    {
                        name: "Caesar Salad",
                        qty: 1,
                        price: 12.99,
                    },
                    {
                        name: "Fresh Juice",
                        qty: 2,
                        price: 4.99,
                    },
                ],
                total: 53.96,
                date: new Date(Date.now() - 30 * 60 * 1000), // 30 minutes ago
            },
            {
                id: "ORD-1234",
                time: "2 hours ago",
                status: "Delivered",
                type: "Delivery",
                address: "123 Main Street, Apartment 4B, Downtown",
                items: [
                    {
                        name: "Grilled Chicken Breast",
                        qty: 2,
                        price: 19.99,
                        originalPrice: 24.99,
                    },
                    {
                        name: "Caesar Salad",
                        qty: 1,
                        price: 12.99,
                    },
                    {
                        name: "Chocolate Lava Cake",
                        qty: 1,
                        price: 8.99,
                    },
                ],
                total: 52.96,
                date: new Date(Date.now() - 2 * 60 * 60 * 1000), // 2 hours ago
            },
            {
                id: "ORD-1233",
                time: "Yesterday, 7:30 PM",
                status: "Delivered",
                type: "Pickup",
                items: [
                    {
                        name: "Margherita Pizza",
                        qty: 1,
                        price: 16.99,
                        originalPrice: 19.99,
                    },
                    {
                        name: "Spaghetti Carbonara",
                        qty: 1,
                        price: 17.99,
                    },
                ],
                total: 34.98,
                date: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000), // 1 day ago
            },
            {
                id: "ORD-1232",
                time: "3 days ago",
                status: "Delivered",
                type: "Delivery",
                address: "456 Oak Avenue, Suite 12",
                items: [
                    {
                        name: "Beef Burger Deluxe",
                        qty: 2,
                        price: 15.99,
                    },
                    {
                        name: "Salmon Fillet",
                        qty: 1,
                        price: 24.99,
                        originalPrice: 29.99,
                    },
                    {
                        name: "Fresh Juice",
                        qty: 2,
                        price: 4.99,
                    },
                ],
                total: 61.96,
                date: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000), // 3 days ago
            },
            {
                id: "ORD-1231",
                time: "5 days ago",
                status: "Delivered",
                type: "Pickup",
                items: [
                    {
                        name: "Greek Salad",
                        qty: 1,
                        price: 9.99,
                    },
                    {
                        name: "Tiramisu",
                        qty: 1,
                        price: 8.99,
                    },
                ],
                total: 18.98,
                date: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000), // 5 days ago
            },
            {
                id: "ORD-1230",
                time: "1 week ago",
                status: "Delivered",
                type: "Delivery",
                address: "789 Elm Street, Building C, Floor 3",
                items: [
                    {
                        name: "Pepperoni Pizza",
                        qty: 1,
                        price: 17.99,
                    },
                    {
                        name: "Chicken Wings",
                        qty: 1,
                        price: 13.99,
                        originalPrice: 16.99,
                    },
                    {
                        name: "Smoothie Bowl",
                        qty: 2,
                        price: 7.99,
                    },
                ],
                total: 47.96,
                date: new Date(Date.now() - 7 * 24 * 60 * 60 * 1000), // 1 week ago
            },
            {
                id: "ORD-1229",
                time: "2 weeks ago",
                status: "Cancelled",
                type: "Delivery",
                address: "321 Pine Road",
                items: [
                    {
                        name: "Veggie Burger",
                        qty: 1,
                        price: 12.99,
                    },
                ],
                total: 12.99,
                date: new Date(Date.now() - 14 * 24 * 60 * 60 * 1000), // 2 weeks ago
            },
            {
                id: "ORD-1228",
                time: "3 weeks ago",
                status: "Delivered",
                type: "Pickup",
                items: [
                    {
                        name: "Shrimp Stir-Fry",
                        qty: 1,
                        price: 18.99,
                    },
                    {
                        name: "Spring Rolls",
                        qty: 2,
                        price: 6.99,
                    },
                ],
                total: 32.97,
                date: new Date(Date.now() - 21 * 24 * 60 * 60 * 1000), // 3 weeks ago
            },
            {
                id: "ORD-1227",
                time: "1 month ago",
                status: "Delivered",
                type: "Delivery",
                address: "555 Sunset Boulevard, Apartment 7A",
                items: [
                    {
                        name: "Grilled Salmon",
                        qty: 1,
                        price: 24.99,
                    },
                    {
                        name: "Bruschetta",
                        qty: 1,
                        price: 7.99,
                        originalPrice: 9.99,
                    },
                    {
                        name: "Quinoa Salad",
                        qty: 1,
                        price: 10.99,
                    },
                ],
                total: 43.97,
                date: new Date(Date.now() - 30 * 24 * 60 * 60 * 1000), // 1 month ago
            },
        ],

        // Filter orders based on search query and time period
        get filteredOrders() {
            let filtered = this.orders;

            // Filter by search query (order ID)
            if (this.searchQuery.trim()) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter((order) =>
                    order.id.toLowerCase().includes(query),
                );
            }

            // Filter by time period
            if (this.selectedPeriod !== "All") {
                const now = new Date();
                filtered = filtered.filter((order) => {
                    const daysDiff = Math.floor(
                        (now - order.date) / (1000 * 60 * 60 * 24),
                    );

                    if (this.selectedPeriod === "Last Week") {
                        return daysDiff <= 7;
                    } else if (this.selectedPeriod === "Last Month") {
                        return daysDiff <= 30;
                    } else if (this.selectedPeriod === "Last Year") {
                        return daysDiff <= 365;
                    }
                    return true;
                });
            }

            return filtered;
        },

        // Reorder functionality
        reorderItems(order) {
            // TODO: Add items to cart
            alert(
                `Reordering ${order.items.length} items from order ${order.id}`,
            );
            console.log("Reorder items:", order.items);
            // You can implement actual cart functionality here
        },

        // Open order modal
        openOrderModal(order) {
            this.selectedOrder = order;
            this.showModal = true;
            document.body.style.overflow = "hidden";
        },

        // Close order modal
        closeOrderModal() {
            this.showModal = false;
            this.selectedOrder = null;
            document.body.style.overflow = "";
        },

        // Trigger animation for filtered cards
        triggerAnimation() {
            this.$nextTick(() => {
                const cards = document.querySelectorAll('.animate-entrance-card');
                cards.forEach((card) => {
                    card.classList.remove('animate-entrance-card');
                    void card.offsetWidth; // Force reflow
                    card.classList.add('animate-entrance-card');
                });
            });
        },
    }));
});
