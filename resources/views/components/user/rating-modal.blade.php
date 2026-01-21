{{-- Rating Modal Component --}}
<div x-data="ratingModalHandler()" 
     x-show="$store.ratingModal.isOpen"
     x-transition.opacity.duration.300ms
     class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
     @click.self.prevent
     style="display: none;">
    
    {{-- Modal Content --}}
    <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-2xl"
         @click.stop
         x-transition.scale.origin.center>
        
        {{-- Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-2xl font-black text-gray-900">
                How was your order?
            </h2>
            <button @click="$store.ratingModal.close()"
                    class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-gray-600">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
            </button>
        </div>

        {{-- Reward Banner --}}
        <div class="bg-linear-to-r from-yellow-400 to-orange-400 p-4">
            <div class="flex items-center justify-center gap-3 text-white">
                <div class="text-4xl">🎁</div>
                <div>
                    <p class="font-black text-lg">Exclusive Offer for You!</p>
                    <p class="text-sm">We reward customers who share their feedback with special discounts</p>
                </div>
            </div>
        </div>

        {{-- Scrollable Items List --}}
        <div class="flex-1 overflow-y-auto">
            <template x-if="$store.ratingModal.orderData">
                <div>
                    <template x-for="item in $store.ratingModal.orderData.items" :key="item.id">
                        <div class="p-6 border-b border-gray-100 last:border-0">
                            <div class="flex gap-4">
                                {{-- Dish Image --}}
                                <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 bg-gray-100">
                                    <img :src="item.image" 
                                         :alt="item.name"
                                         class="w-full h-full object-cover">
                                </div>
                                
                                {{-- Rating Content --}}
                                <div class="flex-1">
                                    {{-- Dish Name --}}
                                    <h3 class="font-bold text-gray-900 mb-2" x-text="item.name"></h3>
                                    
                                    {{-- Star Rating --}}
                                    <div class="flex gap-1 mb-3">
                                        <template x-for="star in 5" :key="star">
                                            <button @click="setRating(item.id, star)"
                                                    type="button"
                                                    class="transition-transform hover:scale-110 focus:outline-none cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                                                     class="w-8 h-8 transition-colors duration-200"
                                                     :class="star <= (ratings[item.id] || 0) ? 'text-yellow-400' : 'text-gray-200'">
                                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </template>
                                    </div>
                                    
                                    {{-- Optional Comment --}}
                                    <textarea x-model="comments[item.id]"
                                              rows="2"
                                              maxlength="200"
                                              placeholder="Add a comment (optional)"
                                              class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-100 outline-none resize-none transition-all"></textarea>
                                    <p class="text-xs text-gray-400 mt-1 text-right">
                                        <span x-text="(comments[item.id] || '').length"></span>/200
                                    </p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        {{-- Action Buttons --}}
        <div class="p-6 border-t border-gray-200 bg-gray-50 space-y-3">
            {{-- Submit Button --}}
            <button @click="submitRatings()"
                    :disabled="!canSubmit || loading"
                    type="button"
                    class="btn-primary w-full h-14 transition-all cursor-pointer"
                    :class="(!canSubmit || loading) ? 'opacity-50 cursor-not-allowed pointer-events-none' : ''">
                <template x-if="loading">
                    <svg class="animate-spin h-5 w-5 text-gray-900 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <template x-if="!loading">
                    <span class="font-bold text-lg">Submit Ratings & Claim Offer</span>
                </template>
            </button>
            
            {{-- Maybe Later --}}
            <button @click="$store.ratingModal.close()"
                    type="button"
                    class="w-full py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-200/50 font-medium transition-all rounded-lg cursor-pointer">
                Maybe Later
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    // Global Store for Modal State
    Alpine.store('ratingModal', {
        isOpen: false,
        orderData: null,  // { orderId, items: [{id, name, image}] }
        
        open(orderData) {
            this.orderData = orderData;
            this.isOpen = true;
            document.body.style.overflow = 'hidden'; // Lock scroll
        },
        
        close() {
            this.isOpen = false;
            document.body.style.overflow = ''; // Restore scroll
        }
    });
    
    // Component Logic
    Alpine.data('ratingModalHandler', () => ({
        ratings: {},  // { dishId: rating (1-5) }
        comments: {}, // { dishId: comment }
        loading: false,
        
        init() {
            // Watch for modal open and initialize ratings
            this.$watch('$store.ratingModal.orderData', (orderData) => {
                if (orderData?.items) {
                    this.ratings = {};
                    this.comments = {};
                    orderData.items.forEach(item => {
                        this.ratings[item.id] = 0;
                        this.comments[item.id] = '';
                    });
                }
            });
        },
        
        setRating(dishId, star) {
            this.ratings[dishId] = star;
        },
        
        get canSubmit() {
            // At least one rating must be > 0
            return Object.values(this.ratings).some(r => r > 0);
        },
        
        submitRatings() {
            if (!this.canSubmit) return;
            
            this.loading = true;
            
            // Prepare data
            const ratingsData = Object.keys(this.ratings)
                .filter(id => this.ratings[id] > 0)
                .map(id => ({
                    dishId: id,
                    rating: this.ratings[id],
                    comment: this.comments[id] || null
                }));
            
            // Simulate API call
            setTimeout(() => {
                console.log('Ratings submitted:', ratingsData);
                
                // Show success & apply discount code
                alert('🎉 Thank you for rating!\n\nYour 10% discount code: THANKYOU10\n\nUse it on your next order!');
                
                // Close modal
                this.$store.ratingModal.close();
                this.loading = false;
                
                // Reset
                this.ratings = {};
                this.comments = {};
            }, 1000);
        }
    }));
});
</script>
