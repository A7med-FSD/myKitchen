document.addEventListener("alpine:init", () => {
    Alpine.data("supportHandler", () => ({
        // Data
        selectedType: '',  // 'order', 'payment', 'delivery', 'general'
        orderCode: '',
        message: '',
        openFaq: null,     // Track which FAQ is open (1-6)
        showContactForm: false,  // Show message form in General
        loading: false,
        errors: {},

        // Stage 1: Basic validation - check if required fields are filled
        // This controls the button disabled state
        get isFormValid() {
            // For general without contact form, FAQ is enough
            if (this.selectedType === 'general' && !this.showContactForm) {
                return false; // No submit button shown
            }

            // For others, need basic fields filled
            if (this.selectedType !== 'general') {
                return (
                    this.orderCode.trim().length > 0 &&
                    this.message.trim().length > 0
                );
            }

            // For general with contact form
            return this.message.trim().length > 0;
        },

        // Stage 2: Detailed validation - check format and rules
        // This runs when user clicks "Submit Request"
        validateForm() {
            this.errors = {};

            if (!this.selectedType) {
                this.errors.type = "Please select an issue type";
                return false;
            }

            // Validate order code for non-general
            if (this.selectedType !== 'general') {
                if (!this.orderCode.trim()) {
                    this.errors.orderCode = "Order code is required";
                } else if (this.orderCode.trim().length < 5) {
                    this.errors.orderCode = "Please enter a valid order code";
                }
            }

            // Validate message
            if ((this.selectedType !== 'general' || this.showContactForm)) {
                if (!this.message.trim()) {
                    this.errors.message = "Please describe your issue";
                } else if (this.message.trim().length < 10) {
                    this.errors.message = "Please provide at least 10 characters";
                } else if (this.message.length > 500) {
                    this.errors.message = "Message must be 500 characters or less";
                }
            }

            return Object.keys(this.errors).length === 0;
        },

        submitSupport() {
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

            // Simulate support request submission
            setTimeout(() => {
                console.log('Support request submitted:', {
                    type: this.selectedType,
                    orderCode: this.orderCode || 'N/A',
                    message: this.message
                });

                // Show success message (replace with actual toast/modal)
                alert('Your support request has been submitted! We\'ll get back to you soon.');

                // Reset form
                this.selectedType = '';
                this.orderCode = '';
                this.message = '';
                this.showContactForm = false;
                this.openFaq = null;
                this.loading = false;

                // Redirect to home or orders
                // window.location.href = "/";
            }, 1500);
        },
    }));
});
