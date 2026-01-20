document.addEventListener("alpine:init", () => {
    Alpine.data("adminLoginHandler", () => ({
        // Credentials
        credentials: {
            email: "",
            password: ""
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
            if (!this.credentials.email) {
                this.errors.email = "Email is required";
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.credentials.email)) {
                this.errors.email = "Please enter a valid email address";
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
                console.log("Admin login credentials:", this.credentials);
                
                // In production, send to backend:
                // fetch('/admin/login', {
                //     method: 'POST',
                //     headers: { 'Content-Type': 'application/json' },
                //     body: JSON.stringify(this.credentials)
                // }).then(response => {
                //     if (response.ok) {
                //         window.location.href = '/owner';
                //     } else {
                //         this.errors.email = 'Invalid credentials';
                //     }
                // });

                // For demo, redirect to owner dashboard
                window.location.href = "/owner";
            }, 1000);
        },
    }));
});
