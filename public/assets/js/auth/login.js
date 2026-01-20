document.addEventListener("alpine:init", () => {
    Alpine.data("loginHandler", () => ({
        // Credentials
        credentials: {
            identifier: "", // Email or phone
            password: "",
            remember: false
        },

        // UI States
        showPassword: false,
        loading: false,
        errors: {},

        // Submit login form
        submitLogin() {
            // Reset errors
            this.errors = {};

            // Simple validation
            if (!this.credentials.identifier) {
                this.errors.identifier = "Email or phone is required";
            }

            if (!this.credentials.password) {
                this.errors.password = "Password is required";
            } else if (this.credentials.password.length < 6) {
                this.errors.password = "Password must be at least 6 characters";
            }

            // If errors exist, don't submit
            if (Object.keys(this.errors).length > 0) {
                return;
            }

            // Start loading
            this.loading = true;

            // Simulate API call (replace with actual endpoint)
            setTimeout(() => {
                // For now, just show success and redirect
                console.log("Login credentials:", this.credentials);
                
                // In production, send to backend:
                // fetch('/login', {
                //     method: 'POST',
                //     headers: { 'Content-Type': 'application/json' },
                //     body: JSON.stringify(this.credentials)
                // }).then(response => {
                //     if (response.ok) {
                //         window.location.href = '/dashboard';
                //     } else {
                //         this.errors.general = 'Invalid credentials';
                //     }
                // });

                // For demo, redirect to menu
                window.location.href = "/menu";
            }, 1000);
        },
    }));
});
