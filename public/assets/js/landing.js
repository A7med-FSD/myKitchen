// Initialize Alpine Stores
document.addEventListener('alpine:init', () => {
    console.log('Cart store initialized'); // بيطبع 
    Alpine.store('cart', {
        items: [],
        isOpen: false,
        
        add(dish) {
            if (!this.items.some(d => d.id === dish.id)) {
                this.items.push({...dish, quantity: 1});
                return true;
            }
            return false;
        },

        has(id) {
            return this.items.some(d => d.id === id);
        },

        updateQuantity(id, quantity) {
            const item = this.items.find(d => d.id === id);
            if (item && quantity >= 1) {
                item.quantity = quantity;
            }
        },

        remove(id) {
            this.items = this.items.filter(d => d.id !== id);
        },

        clear() {
            this.items = [];
        },

        toggleModal() {
            this.isOpen = !this.isOpen;
            console.log('Cart modal toggled'); // بيطبع عند الضغط على زر السلة
        },

        getItemPrice(item) {
            if (item.discount) {
                return (item.price * (1 - item.discount / 100)).toFixed(2);
            }
            return item.price.toFixed(2);
        },

        getTotal() {
            return this.items.reduce((total, item) => {
                const price = item.discount 
                    ? item.price * (1 - item.discount / 100) 
                    : item.price;
                return total + (price * item.quantity);
            }, 0).toFixed(2);
        },

        canPlaceOrder() {
            return this.items.length > 0;
        },

        get count() {
            return this.items.length;
        }
    });
});

// User Home Page Handler
function homeHandler() {
    return {
        // State
        visibleCount: 6,
        totalDishes: 9,

        // Featured Dishes Data
        featuredDishes: [
            {
                id: 1,
                name: "Grilled Chicken Breast",
                description: "Tender grilled chicken with herbs and spices, served with seasonal vegetables",
                price: 12.99,
                discount: 10,
                image: "https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=800&h=600&fit=crop",
                badge: "featured",
                rating: 5,
                reviews: 124,
                prepTime: 25,
            },
            {
                id: 2,
                name: "Mediterranean Pasta",
                description: "Fresh pasta tossed with cherry tomatoes, olives, and feta cheese",
                price: 14.99,
                image: "https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=800&h=600&fit=crop",
                badge: "recommended",
                rating: 4,
                reviews: 89,
                prepTime: 20,
            },
            {
                id: 3,
                name: "Salmon Teriyaki",
                description: "Pan-seared salmon glazed with homemade teriyaki sauce",
                price: 18.99,
                discount: 15,
                image: "https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=800&h=600&fit=crop",
                badge: "new",
                rating: 5,
                reviews: 67,
                prepTime: 30,
            },
            {
                id: 4,
                name: "Vegetarian Buddha Bowl",
                description: "Colorful mix of quinoa, roasted vegetables, and tahini dressing",
                price: 11.99,
                image: "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800&h=600&fit=crop",
                badge: "special",
                rating: 4,
                reviews: 102,
                prepTime: 15,
            },
            {
                id: 5,
                name: "BBQ Baby Back Ribs",
                description: "Fall-off-the-bone ribs with our signature BBQ sauce",
                price: 22.99,
                discount: 20,
                image: "https://images.unsplash.com/photo-1544025162-d76694265947?w=800&h=600&fit=crop",
                badge: "featured",
                rating: 5,
                reviews: 156,
                prepTime: 45,
            },
            {
                id: 6,
                name: "Classic Margherita Pizza",
                description: "Wood-fired pizza with fresh mozzarella, basil, and tomato sauce",
                price: 13.99,
                image: "https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=800&h=600&fit=crop",
                badge: null,
                rating: 5,
                reviews: 203,
                prepTime: 20,
            },
            {
                id: 7,
                name: "Spicy Beef Tacos",
                description: "Soft corn tortillas filled with seasoned beef, pico de gallo, and avocado",
                price: 9.99,
                image: "https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=800&h=600&fit=crop",
                badge: "recommended",
                rating: 4.5,
                reviews: 95,
                prepTime: 15,
            },
            {
                id: 8,
                name: "Mushroom Risotto",
                description: "Creamy arborio rice with wild mushrooms, parmesan, and truffle oil",
                price: 16.50,
                image: "https://images.unsplash.com/photo-1476124369491-e7addf5db371?w=800&h=600&fit=crop",
                badge: null,
                rating: 4.8,
                reviews: 110,
                prepTime: 35,
            },
            {
                id: 9,
                name: "Berry Cheese Cake",
                description: "Classic New York cheesecake topped with fresh mixed berries compote",
                price: 8.50,
                discount: 5,
                image: "https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=800&h=600&fit=crop",
                badge: "special",
                rating: 5,
                reviews: 215,
                prepTime: 10,
            },
        ],

        // Methods
        loadMore() {
            if (this.visibleCount < this.totalDishes) {
                this.visibleCount += 3;
            } else {
                window.location.href = '/menu'; // Redirect to user panel menu
            }
        },

        get buttonText() {
            return this.visibleCount < this.totalDishes ? 'View More' : 'View Full Menu';
        },

        init() {
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
                anchor.addEventListener("click", function (e) {
                    e.preventDefault();
                    const target = document.querySelector(
                        this.getAttribute("href")
                    );
                    if (target) {
                        target.scrollIntoView({
                            behavior: "smooth",
                            block: "start",
                        });
                    }
                });
            });
        },
    };
}
