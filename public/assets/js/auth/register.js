document.addEventListener("alpine:init", () => {
    Alpine.data("registerHandler", () => ({
        // User data
        userData: {
            name: "",
            email: "",
            password: "",
            confirmPassword: "",
            phone: "",
            address: "",
            mapLink: "",
            profileImage: null
        },

        // UI States
        showPassword: false,
        showConfirmPassword: false,
        imagePreview: null,
        loading: false,
        errors: {},

        // Handle image upload
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert("File size must be less than 2MB");
                return;
            }

            // Validate file type
            const validTypes = ["image/jpeg", "image/png", "image/webp"];
            if (!validTypes.includes(file.type)) {
                alert("Please upload a JPG, PNG, or WebP image");
                return;
            }

            // Create preview
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
                this.userData.profileImage = file;
            };
            reader.readAsDataURL(file);
        },

        // Remove uploaded image
        removeImage() {
            this.imagePreview = null;
            this.userData.profileImage = null;
            // Clear the file input
            this.$refs.imageInput.value = '';
        },

        // Validate form
        validateForm() {
            this.errors = {};

            // Name validation
            if (!this.userData.name) {
                this.errors.name = "Name is required";
            } else if (this.userData.name.length < 3) {
                this.errors.name = "Name must be at least 3 characters";
            }

            // Email validation
            if (!this.userData.email) {
                this.errors.email = "Email is required";
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.userData.email)) {
                this.errors.email = "Please enter a valid email address";
            }

            // Password validation
            if (!this.userData.password) {
                this.errors.password = "Password is required";
            } else if (this.userData.password.length < 6) {
                this.errors.password = "Password must be at least 6 characters";
            }

            // Confirm password validation
            if (!this.userData.confirmPassword) {
                this.errors.confirmPassword = "Please confirm your password";
            } else if (this.userData.password !== this.userData.confirmPassword) {
                this.errors.confirmPassword = "Passwords do not match";
            }

            // Optional: Google Map link validation
            if (this.userData.mapLink && !this.userData.mapLink.startsWith("http")) {
                this.errors.mapLink = "Please enter a valid URL";
            }

            return Object.keys(this.errors).length === 0;
        },

        // Submit registration form
        submitRegister() {
            // Validate form
            if (!this.validateForm()) {
                return;
            }

            // Start loading
            this.loading = true;

            // Simulate API call (replace with actual endpoint)
            setTimeout(() => {
                console.log("Registration data:", this.userData);
                
                // In production, send to backend:
                // const formData = new FormData();
                // for (const key in this.userData) {
                //     formData.append(key, this.userData[key]);
                // }
                // fetch('/register', {
                //     method: 'POST',
                //     body: formData
                // }).then(response => {
                //     if (response.ok) {
                //         window.location.href = '/menu';
                //     }
                // });

                // For demo, redirect to menu
                window.location.href = "/login";
            }, 1000);
        },
    }));
});
