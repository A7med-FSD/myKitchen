<x-layout>
    <!-- Menu Page Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    <div class="space-y-6" x-data="menuHandler()">
        <!-- Header with Search and Filters -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="animate-entrance-header">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-yellow-500">
                        <path d="M11.25 4.53286C9.73455 3.56279 7.93246 3 6 3C4.86178 3 3.76756 3.19535 2.75007 3.55499C2.45037 3.66091 2.25 3.94425 2.25 4.26212V18.5121C2.25 18.7556 2.36818 18.9839 2.56696 19.1245C2.76574 19.265 3.02039 19.3004 3.24993 19.2192C4.10911 18.9156 5.03441 18.75 6 18.75C7.99502 18.75 9.82325 19.4573 11.25 20.6357V4.53286Z" />
                        <path d="M12.75 20.6357C14.1768 19.4573 16.005 18.75 18 18.75C18.9656 18.75 19.8909 18.9156 20.7501 19.2192C20.9796 19.3004 21.2343 19.265 21.433 19.1245C21.6318 18.9839 21.75 18.7556 21.75 18.5121V4.26212C21.75 3.94425 21.5496 3.66091 21.2499 3.55499C20.2324 3.19535 19.1382 3 18 3C16.0675 3 14.2655 3.56279 12.75 4.53286V20.6357Z" />
                    </svg>
                    Menu Management
                </h1>
                <p class="text-gray-500 mt-2 font-medium">Manage your restaurant menu items</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-96 relative group animate-entrance-search">
                <input type="text" 
                       x-model="searchQuery"
                       placeholder="Search dishes..." 
                       class="w-full bg-white border-none outline-none rounded-full py-3 px-5 pl-12 shadow-sm focus:ring-2 focus:ring-gray-200 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-4 top-3.5 text-gray-400 size-5 group-focus-within:text-gray-600 transition-colors">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" />
                </svg>
            </div>
        </div>

        <!-- Category Filters -->
        <div class="flex flex-wrap gap-3 animate-entrance-header">
            <template x-for="cat in categories" :key="cat.name">
                <button @click="selectedCategory = cat.name"
                        class="px-4 py-2 rounded-full font-semibold transition-all duration-300 flex items-center gap-2"
                        :class="selectedCategory === cat.name ? 'bg-yellow-400 text-gray-900 shadow-lg shadow-yellow-100' : 'bg-white text-gray-600 hover:bg-gray-100'">
                    <span x-text="cat.icon"></span>
                    <span x-text="cat.name"></span>
                    <span class="text-xs opacity-75" x-text="'(' + cat.count + ')'"></span>
                </button>
            </template>
        </div>

        <!-- Menu Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <template x-for="(dish, index) in filteredDishes" :key="index">
                <div class="relative group cursor-pointer animate-entrance-card"
                     :class="'animate-delay-' + ((index % 6) * 100)">
                    <div class="bg-white rounded-[32px] p-4 shadow-lg overflow-hidden border border-gray-100 transition-transform hover:-translate-y-1">
                        <div class="relative h-48 rounded-[24px] overflow-hidden mb-4">
                            <img :src="dish.image" :alt="dish.name" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div x-show="dish.signature" class="absolute top-2 right-2 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full text-[10px] font-bold">🔥 Signature</div>
                            <div class="absolute top-2 left-2 bg-black/60 backdrop-blur-sm px-2 py-1 rounded-full text-white text-[10px] font-bold" x-text="'$' + dish.price"></div>
                        </div>
                        
                        <h2 class="text-xl font-black text-gray-900 leading-tight mb-2 group-hover:text-yellow-600 transition-colors" x-text="dish.name"></h2>
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed line-clamp-2" x-text="dish.description"></p>
                        
                        <div class="flex flex-wrap gap-2 text-[10px] font-bold text-gray-600 mb-6">
                            <div class="bg-green-100 text-green-700 px-2 py-1 rounded" x-text="dish.category"></div>
                            <div class="bg-gray-100 px-2 py-1 rounded flex items-center gap-1">
                                ⚫ <span x-text="dish.calories + 'kcal'"></span>
                            </div>
                            <div class="bg-gray-100 px-2 py-1 rounded flex items-center gap-1">
                                🕒 <span x-text="dish.prepTime + 'min'"></span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-2.5 rounded-full transition-colors duration-300">
                                Edit
                            </button>
                            <button class="px-4 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 font-bold py-2.5 rounded-full transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State -->
        <div x-show="filteredDishes.length === 0" class="text-center py-20">
            <div class="text-6xl mb-4">🍽️</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No dishes found</h3>
            <p class="text-gray-500">Try selecting a different category or search term</p>
        </div>

        <!-- Floating Add Button -->
        <button @click="openAddDishModal()" 
                class="fixed bottom-8 right-8 bg-yellow-400 hover:bg-yellow-500 text-gray-900 p-4 rounded-full shadow-2xl hover:shadow-yellow-200 transition-all duration-300 hover:scale-110 z-50 group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 group-hover:rotate-90 transition-transform duration-300">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <script>
        function menuHandler() {
            return {
                searchQuery: '',
                selectedCategory: 'All',
                categories: [
                    { name: 'All', icon: '🍽️', count: 12 },
                    { name: 'Main Dishes', icon: '🍖', count: 5 },
                    { name: 'Appetizers', icon: '🥗', count: 3 },
                    { name: 'Desserts', icon: '🍰', count: 2 },
                    { name: 'Drinks', icon: '🥤', count: 2 }
                ],
                dishes: [
                    { name: 'Shrimp Stir-Fry with Brown Rice', description: 'A quick and healthy stir-fry with succulent shrimp, colorful vegetables, and a side of brown rice.', category: 'Main Dishes', price: 18.99, calories: 350, prepTime: 45, signature: true, image: 'https://images.unsplash.com/photo-1555126634-323283e090fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Grilled Salmon', description: 'Fresh Atlantic salmon grilled to perfection with lemon butter sauce.', category: 'Main Dishes', price: 24.99, calories: 420, prepTime: 30, signature: true, image: 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Chicken Alfredo Pasta', description: 'Creamy alfredo sauce with tender chicken breast over fettuccine pasta.', category: 'Main Dishes', price: 16.99, calories: 580, prepTime: 35, signature: false, image: 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Veggie Burger', description: 'Plant-based patty with fresh vegetables and special sauce.', category: 'Main Dishes', price: 12.99, calories: 380, prepTime: 25, signature: false, image: 'https://images.unsplash.com/photo-1520072959219-c595dc870360?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Beef Steak', description: 'Premium beef steak cooked to your preference with seasonal vegetables.', category: 'Main Dishes', price: 28.99, calories: 650, prepTime: 40, signature: true, image: 'https://images.unsplash.com/photo-1546833999-b9f581a1996d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Caesar Salad', description: 'Classic Caesar salad with crispy romaine lettuce, croutons, and parmesan.', category: 'Appetizers', price: 8.99, calories: 180, prepTime: 15, signature: false, image: 'https://images.unsplash.com/photo-1546793665-c74683f339c1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Bruschetta', description: 'Toasted bread topped with fresh tomatoes, basil, and mozzarella.', category: 'Appetizers', price: 7.99, calories: 150, prepTime: 10, signature: false, image: 'https://images.unsplash.com/photo-1572695157366-5e585ab2b69f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Spring Rolls', description: 'Crispy vegetable spring rolls served with sweet chili sauce.', category: 'Appetizers', price: 6.99, calories: 220, prepTime: 20, signature: false, image: 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Chocolate Lava Cake', description: 'Warm chocolate cake with a gooey molten center, served with vanilla ice cream.', category: 'Desserts', price: 9.99, calories: 480, prepTime: 25, signature: true, image: 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Tiramisu', description: 'Classic Italian dessert with layers of coffee-soaked ladyfingers and mascarpone.', category: 'Desserts', price: 8.99, calories: 390, prepTime: 15, signature: false, image: 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Fresh Juice', description: 'Freshly squeezed orange, apple, or carrot juice.', category: 'Drinks', price: 4.99, calories: 120, prepTime: 5, signature: false, image: 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' },
                    { name: 'Smoothie Bowl', description: 'Acai or mango smoothie bowl topped with fresh fruits and granola.', category: 'Drinks', price: 7.99, calories: 280, prepTime: 10, signature: false, image: 'https://images.unsplash.com/photo-1590301157890-4810ed352733?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }
                ],
                get filteredDishes() {
                    let items = this.dishes;
                    
                    // Filter by category
                    if (this.selectedCategory !== 'All') {
                        items = items.filter(dish => dish.category === this.selectedCategory);
                    }
                    
                    // Filter by search query
                    if (this.searchQuery.trim() !== '') {
                        const query = this.searchQuery.toLowerCase();
                        items = items.filter(dish => 
                            dish.name.toLowerCase().includes(query) || 
                            dish.description.toLowerCase().includes(query)
                        );
                    }
                    
                    return items;
                },
                openAddDishModal() {
                    alert('Add Dish Modal - To be implemented');
                }
            }
        }
    </script>
</x-layout>
