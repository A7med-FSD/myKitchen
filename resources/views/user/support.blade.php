<x-user.layout>
    <div class="max-w-4xl mx-auto mt-10" x-data="supportHandler()">
        
        {{-- Page Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-gray-900 mb-2">
                How can we help you?
            </h1>
            <p class="text-gray-600">
                We're here to assist you with any questions or concerns
            </p>
        </div>

        {{-- Issue Type Selection --}}
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Select Issue Type</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Order Problem --}}
                <div class="cursor-pointer p-6 border-2 rounded-2xl transition-all hover:shadow-lg"
                     :class="selectedType === 'order' 
                       ? 'border-blue-500 bg-blue-50' 
                       : 'border-gray-200 hover:border-blue-300'"
                     @click="selectedType = 'order'; showContactForm = false">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-blue-500">
                                <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Order Problem</h3>
                        <p class="text-xs text-gray-500 mt-1">Issues with your order</p>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="cursor-pointer p-6 border-2 rounded-2xl transition-all hover:shadow-lg"
                     :class="selectedType === 'payment' 
                       ? 'border-green-500 bg-green-50' 
                       : 'border-gray-200 hover:border-green-300'"
                     @click="selectedType = 'payment'; showContactForm = false">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-green-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-green-500">
                                <path d="M4.5 3.75a3 3 0 00-3 3v.75h21v-.75a3 3 0 00-3-3h-15z" />
                                <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 003 3h15a3 3 0 003-3v-7.5zm-18 3.75a.75.75 0 01.75-.75h6a.75.75 0 010 1.5h-6a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Payment</h3>
                        <p class="text-xs text-gray-500 mt-1">Payment or billing issues</p>
                    </div>
                </div>

                {{-- Delivery --}}
                <div class="cursor-pointer p-6 border-2 rounded-2xl transition-all hover:shadow-lg"
                     :class="selectedType === 'delivery' 
                       ? 'border-orange-500 bg-orange-50' 
                       : 'border-gray-200 hover:border-orange-300'"
                     @click="selectedType = 'delivery'; showContactForm = false">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-orange-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-orange-500">
                                <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 116 0h3a.75.75 0 00.75-.75V15z" />
                                <path d="M8.25 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0zM15.75 6.75a.75.75 0 00-.75.75v11.25c0 .087.015.17.042.248a3 3 0 015.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 00-3.732-10.104 1.837 1.837 0 00-1.47-.725H15.75z" />
                                <path d="M19.5 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Delivery</h3>
                        <p class="text-xs text-gray-500 mt-1">Delivery status or location</p>
                    </div>
                </div>

                {{-- General Question --}}
                <div class="cursor-pointer p-6 border-2 rounded-2xl transition-all hover:shadow-lg"
                     :class="selectedType === 'general' 
                       ? 'border-purple-500 bg-purple-50' 
                       : 'border-gray-200 hover:border-purple-300'"
                     @click="selectedType = 'general'; showContactForm = false">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-purple-500">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">General Question</h3>
                        <p class="text-xs text-gray-500 mt-1">Other questions</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Conditional Content --}}
        <div x-show="selectedType" x-transition class="space-y-6">
            
            {{-- Order Code Input (for non-general) --}}
            <div x-show="selectedType !== 'general'" x-transition>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Order Code <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       x-model="orderCode"
                       @input="errors.orderCode = ''"
                       placeholder="#ORD-12345"
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none"
                       :class="errors.orderCode ? 'border-red-400' : ''">
                <p class="text-xs text-gray-500 mt-1">
                    📋 Find your order code in My Orders section
                </p>
                <div x-show="errors.orderCode" x-transition class="form-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="errors.orderCode"></span>
                </div>
            </div>

            {{-- FAQ Section (General only) --}}
            <div x-show="selectedType === 'general' && !showContactForm" x-transition>
                <h3 class="text-lg font-bold mb-4">Frequently Asked Questions</h3>
                
                <div class="space-y-3">
                    {{-- FAQ 1 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 1 ? null : 1"
                                type="button"
                                class="w-full p-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900 pr-4">How do I place an order?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" 
                                 class="w-5 h-5 shrink-0 transition-transform duration-200"
                                 :class="openFaq === 1 ? 'rotate-180' : ''">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 1" 
                             x-collapse
                             class="px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                            Browse our menu, add items to your cart, then proceed to checkout. You can pay with credit card, Vodafone Cash, InstaPay, or Fawry. Your order will be confirmed within minutes!
                        </div>
                    </div>

                    {{-- FAQ 2 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 2 ? null : 2"
                                type="button"
                                class="w-full p-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900 pr-4">What are your delivery hours?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" 
                                 class="w-5 h-5 shrink-0 transition-transform duration-200"
                                 :class="openFaq === 2 ? 'rotate-180' : ''">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 2" 
                             x-collapse
                             class="px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                            We deliver daily from 10:00 AM to 10:00 PM. Orders are typically delivered within 30-45 minutes during normal hours. Peak times may take slightly longer.
                        </div>
                    </div>

                    {{-- FAQ 3 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 3 ? null : 3"
                                type="button"
                                class="w-full p-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900 pr-4">Can I modify my order after placing it?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" 
                                 class="w-5 h-5 shrink-0 transition-transform duration-200"
                                 :class="openFaq === 3 ? 'rotate-180' : ''">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 3" 
                             x-collapse
                             class="px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                            You can modify your order within 5 minutes of placing it. After that, contact our support team with your order code and we'll do our best to help!
                        </div>
                    </div>

                    {{-- FAQ 4 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 4 ? null : 4"
                                type="button"
                                class="w-full p-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900 pr-4">Do you offer vegetarian options?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" 
                                 class="w-5 h-5 shrink-0 transition-transform duration-200"
                                 :class="openFaq === 4 ? 'rotate-180' : ''">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 4" 
                             x-collapse
                             class="px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                            Yes! Check our menu and look for the 🥬 icon to see all vegetarian options. We also have vegan and gluten-free dishes available.
                        </div>
                    </div>

                    {{-- FAQ 5 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 5 ? null : 5"
                                type="button"
                                class="w-full p-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900 pr-4">What is your refund policy?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" 
                                 class="w-5 h-5 shrink-0 transition-transform duration-200"
                                 :class="openFaq === 5 ? 'rotate-180' : ''">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 5" 
                             x-collapse
                             class="px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                            We offer full refunds for cancelled orders within 5 minutes of placement. For quality issues, contact support within 24 hours with photos and we'll make it right!
                        </div>
                    </div>

                    {{-- FAQ 6 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 6 ? null : 6"
                                type="button"
                                class="w-full p-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900 pr-4">How can I track my order?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" 
                                 class="w-5 h-5 shrink-0 transition-transform duration-200"
                                 :class="openFaq === 6 ? 'rotate-180' : ''">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 6" 
                             x-collapse
                             class="px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                            Go to "My Orders" page to see real-time delivery status. You'll also receive SMS updates on your registered phone number!
                        </div>
                    </div>
                </div>

                {{-- Still need help? --}}
                <div class="mt-6 p-4 bg-yellow-50 border-2 border-yellow-200 rounded-xl">
                    <p class="font-bold text-yellow-800 mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                        Still need help?
                    </p>
                    <button type="button"
                            @click="showContactForm = true"
                            class="text-sm text-yellow-600 hover:text-yellow-700 font-bold transition-colors flex items-center gap-1">
                        → Send us a message
                    </button>
                </div>
            </div>

            {{-- Message TextArea --}}
            <div x-show="selectedType !== 'general' || showContactForm" x-transition>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Describe your issue <span class="text-red-500">*</span>
                </label>
                <textarea x-model="message"
                          @input="errors.message = ''"
                          rows="6"
                          maxlength="500"
                          class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-4 focus:ring-yellow-100 transition-all outline-none resize-none"
                          :class="errors.message ? 'border-red-400' : ''"
                          placeholder="Please describe your issue in detail..."></textarea>
                
                {{-- Character Counter --}}
                <div class="flex justify-between items-center mt-1">
                    <p class="text-xs text-gray-500">Be as specific as possible</p>
                    <p class="text-xs font-medium" 
                       :class="message.length > 450 ? 'text-red-500' : 'text-gray-500'">
                        <span x-text="message.length"></span>/500
                    </p>
                </div>
                <div x-show="errors.message" x-transition class="form-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="errors.message"></span>
                </div>
            </div>

            {{-- Submit Button --}}
            <div x-show="selectedType !== 'general' || showContactForm" x-transition>
                <button @click="submitSupport()"
                        :disabled="!isFormValid || loading"
                        class="btn-primary w-full h-14 transition-all"
                        :class="{
                            'opacity-50 cursor-not-allowed pointer-events-none': loading,
                            'opacity-60 cursor-not-allowed pointer-events-none': !isFormValid && !loading
                        }">
                    <template x-if="loading">
                        <svg class="animate-spin h-5 w-5 text-gray-900 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <template x-if="!loading">
                        <div class="flex items-center justify-center gap-2">
                            <span class="font-bold text-lg">Submit Request</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </template>
                </button>
            </div>
        </div>

    </div>

    {{-- Include support.js --}}
    <script src="{{ asset('assets/js/user/support.js') }}"></script>
</x-user.layout>