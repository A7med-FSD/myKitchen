document.addEventListener("alpine:init", () => {
    Alpine.data("profileHandler", () => ({
        // Original data (from server/API in future)
        originalData: {
            name: "Ahmed Hassan",
            phone: "01234567890",
            email: "ahmed@email.com",
            address: "15 Tahrir Street, Dokki, Giza",
            vip: true,
            orders: 12,
            favorite: "Burgers",
            lastOrder: "3 days ago",
            profileImage: null // Will hold the uploaded image
        },

        // Current form data (editable)
        formData: {
            name: "Ahmed Hassan",
            phone: "01234567890",
            email: "ahmed@email.com",
            address: "15 Tahrir Street, Dokki, Giza"
        },

        // UI states
        showMap: false,
        saving: false,
        profileImagePreview: null, // For image preview

        init() {
            // Initialize profile image preview from Vite asset
            this.profileImagePreview = this.originalData.profileImage;
        },

        // Computed: Check if form has changes
        get hasChanges() {
            return (
                this.originalData.name !== this.formData.name ||
                this.originalData.phone !== this.formData.phone ||
                this.originalData.email !== this.formData.email ||
                this.originalData.address !== this.formData.address ||
                this.profileImagePreview !== this.originalData.profileImage
            );
        },

        // Open file picker for profile photo
        changeProfilePhoto() {
            // Create a hidden file input
            const input = document.createElement("input");
            input.type = "file";
            input.accept = "image/*";
            input.onchange = (e) => {
                const file = e.target.files[0];
                if (file) {
                    // Create preview URL
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.profileImagePreview = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            };
            input.click();
        },

        // Save profile changes
        saveProfile() {
            this.saving = true;
            // Simulate API call
            setTimeout(() => {
                // Update original data
                this.originalData.name = this.formData.name;
                this.originalData.phone = this.formData.phone;
                this.originalData.email = this.formData.email;
                this.originalData.address = this.formData.address;
                this.originalData.profileImage = this.profileImagePreview;
                this.saving = false;

                // Show success message (you can use toast/notification)
                alert("Profile updated successfully!");
            }, 500);
        },

        // Cancel changes
        cancelChanges() {
            this.formData = { ...this.originalData };
            this.profileImagePreview = this.originalData.profileImage;
        },
    }));
});
