// Initialize Alpine Stores
document.addEventListener("alpine:init", () => {
    Alpine.store("cart", {
        items: [],
        isOpen: false,

        add(dish) {
            if (!this.items.some((d) => d.id === dish.id)) {
                this.items.push({ ...dish, quantity: 1 });
                return true;
            }
            return false;
        },

        has(id) {
            return this.items.some((d) => d.id === id);
        },

        updateQuantity(id, quantity) {
            const item = this.items.find((d) => d.id === id);
            if (item && quantity >= 1) {
                item.quantity = quantity;
            }
        },

        remove(id) {
            this.items = this.items.filter((d) => d.id !== id);
        },

        clear() {
            this.items = [];
        },

        toggleModal() {
            this.isOpen = !this.isOpen;
        },

        getItemPrice(item) {
            if (item.discount) {
                return (item.price * (1 - item.discount / 100)).toFixed(2);
            }
            return item.price.toFixed(2);
        },

        getTotal() {
            return this.items
                .reduce((total, item) => {
                    const price = item.discount
                        ? item.price * (1 - item.discount / 100)
                        : item.price;
                    return total + price * item.quantity;
                }, 0)
                .toFixed(2);
        },

        canPlaceOrder() {
            return this.items.length > 0;
        },

        get count() {
            return this.items.length;
        },
    });
});
