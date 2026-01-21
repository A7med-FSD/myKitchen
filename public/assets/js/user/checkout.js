document.addEventListener("alpine:init", () => {
    Alpine.data("checkoutHandler", () => ({
        // User data
        userData: {
            name: "",
            phone: "",
            address: "",
            locationLink: "",
            deliveryNotes: "",
            paymentMethod: ""
        },

        // UI States
        errors: {},
        loading: false,
        showPromo: false,
        promoCode: "",
        promoApplied: false,
        promoError: "",
        discountAmount: 0,

        // Mock cart data (replace with actual cart store)
        subtotal: 41.97,
        deliveryFee: 5.00,

        // Computed properties
        get tax() {
            // Apply tax on subtotal (usually pre-discount, but can be post depending on rules)
            // Here we assume tax is on the final amount before total? 
            // Or tax on subtotal, then discount? Let's keep it simple: Tax on subtotal
            return this.subtotal * 0.14;
        },

        get grandTotal() {
            return Math.max(0, this.subtotal + this.deliveryFee + this.tax - this.discountAmount);
        },

        // Stage 1: Basic validation - just check if required fields are filled
        // This controls the button disabled state
        get isFormValid() {
            return (
                this.userData.name.trim().length > 0 &&
                this.userData.phone.trim().length > 0 &&
                this.userData.address.trim().length > 0 &&
                this.userData.paymentMethod !== ""
            );
        },

        // Stage 2: Detailed validation - check format and rules
        // This runs when user clicks "Place Order"
        validateForm() {
            this.errors = {};

            // Validate name - detailed check
            if (!this.userData.name) {
                this.errors.name = "Name is required";
            } else if (this.userData.name.trim().length < 3) {
                this.errors.name = "Name must be at least 3 characters";
            }

            // Validate phone - detailed check (Egyptian format)
            if (!this.userData.phone) {
                this.errors.phone = "Phone number is required";
            } else if (this.userData.phone.length < 11) {
                this.errors.phone = "Phone number must be 11 digits";
            } else if (!/^01[0-2,5]{1}[0-9]{8}$/.test(this.userData.phone)) {
                this.errors.phone = "Please enter a valid Egyptian phone number (01xxxxxxxxx)";
            }

            // Validate address - detailed check
            if (!this.userData.address) {
                this.errors.address = "Delivery address is required";
            } else if (this.userData.address.trim().length < 10) {
                this.errors.address = "Please provide a detailed address";
            }

            // Validate payment method
            if (!this.userData.paymentMethod) {
                this.errors.payment = "Please select a payment method";
            }

            // Validate location link if provided
            if (this.userData.locationLink && !this.userData.locationLink.startsWith("http")) {
                this.errors.locationLink = "Please enter a valid URL";
            }

            return Object.keys(this.errors).length === 0;
        },

        applyPromo() {
            // Reset states
            this.promoError = "";
            this.promoApplied = false;
            this.discountAmount = 0;

            if (!this.promoCode) {
                this.promoError = "Please enter a code";
                return;
            }

            // Simulate promo check
            // For demo: code 'DISCOUNT10' gives $10 off
            if (this.promoCode.toUpperCase() === 'DISCOUNT10') {
                this.discountAmount = 10.00;
                this.promoApplied = true;
                this.showPromo = false; // Close input on success? Or keep open to show success
            } else {
                this.promoError = "Invalid promo code";
            }
        },

        placeOrder() {
            // Validate form
            if (!this.validateForm()) {
                // Scroll to first error
                const firstError = document.querySelector(".form-error");
                if (firstError) {
                    firstError.scrollIntoView({ behavior: "smooth", block: "center" });
                }
                return;
            }

            // Start loading
            this.loading = true;

            // Simulate order placement
            setTimeout(() => {
                console.log("Order placed successfully!", {
                    ...this.userData,
                    total: this.grandTotal.toFixed(2)
                });

                // Show success message (replace with actual toast/modal)
                alert(`Order placed successfully! Total: $${this.grandTotal.toFixed(2)}`);

                // Redirect to orders page
                window.location.href = "/orders";
            }, 2000);
        },
    }));
});
