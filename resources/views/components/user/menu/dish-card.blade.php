<div x-data="{ touched: false }" 
     @click="touched = !touched" 
     @mouseleave="touched = false"
     :class="touched ? 'hover-active' : ''"
     class="bg-white rounded-4xl p-4 shadow-lg border border-gray-100 transition-all duration-300 group hover:-translate-y-2 hover:shadow-2xl hover:border-yellow-200 animate-entrance-card"
     :class="'animate-delay-' + ((index % 6) * 100)">
    
    {{-- Image Container --}}
    <div class="relative h-60 rounded-[24px] overflow-hidden mb-4">
        <img :src="dish.image" 
             :alt="dish.name" 
             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
        
        {{-- Offer Badge (Top Left - Above Price) --}}
        <template x-if="dish.discount">
            <div class="absolute top-3 left-3 z-20">
                <div class="bg-orange-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                        <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v4.75a1.5 1.5 0 0 0 .44 1.06l7.25 7.25a1.5 1.5 0 0 0 2.12 0l4.75-4.75a1.5 1.5 0 0 0 0-2.12L10.31 2.44A1.5 1.5 0 0 0 9.25 2H4.5Zm3.75 3.25a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="dish.discount + '% OFF'"></span>
                </div>
            </div>
        </template>

        {{-- Price Badge --}}
        <div class="absolute left-3 bg-black/60 backdrop-blur-sm px-4 py-2 rounded-full text-white font-bold shadow-lg transition-all duration-300" 
             :class="dish.discount ? 'top-12' : 'top-3'">
             
            <template x-if="dish.discount">
                <div class="flex items-center gap-2">
                    <span class="text-orange-400 line-through text-xs" x-text="'$' + dish.price"></span>
                    <span class="text-white" x-text="'$' + (dish.price * (1 - dish.discount / 100)).toFixed(2)"></span>
                </div>
            </template>

            <template x-if="!dish.discount">
                <span x-text="'$' + dish.price"></span>
            </template>
        </div>
        
        {{-- Badge (Featured/New/etc) --}}
        <template x-if="dish.badge">
            <div class="absolute top-3 right-3 z-10">
                
                {{-- Featured (Purple) --}}
                <template x-if="dish.badge === 'featured'">
                    <div class="text-purple-600 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1 transition-all duration-300 group-hover:bg-purple-500 group-hover:text-white">
                        <span>Featured</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                            <path fill-rule="evenodd" d="M10 2c-1.716 0-3.408.106-5.07.31C3.806 2.45 3 3.414 3 4.517V17.25a.75.75 0 0 0 1.075.676L10 15.082l5.925 2.844A.75.75 0 0 0 17 17.25V4.517c0-1.103-.806-2.068-1.93-2.207A41.403 41.403 0 0 0 10 2Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </template>

                 {{-- New (Green) --}}
                <template x-if="dish.badge === 'new'">
                    <div class="text-green-600 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1 transition-all duration-300 group-hover:bg-green-500 group-hover:text-white">
                        <span>New</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                           <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                    </div>
                </template>

                {{-- Recommended (Blue) --}}
                <template x-if="dish.badge === 'recommended'">
                    <div class="text-blue-500 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1 transition-all duration-300 group-hover:bg-blue-500 group-hover:text-white">
                        <span>Recommended</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                            <path d="M1 8.25a1.25 1.25 0 1 1 2.5 0v7.5a1.25 1.25 0 1 1-2.5 0v-7.5ZM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0 1 14 3c0 .995-.182 1.948-.514 2.826-.204.54.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 0 1-1.341 5.974C17.153 16.323 16.072 17 14.9 17h-3.192a3 3 0 0 1-1.341-.317l-2.734-1.366A3 3 0 0 0 6.29 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 0 1 2.166-1.73c.432-.143.853-.386 1.011-.814.16-.432.448-.779.9-.918" />
                        </svg>
                    </div>
                </template>

                 {{-- Special (Yellow) --}}
                <template x-if="dish.badge === 'special'">
                    <div class="text-yellow-600 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1 transition-all duration-300 group-hover:bg-yellow-500 group-hover:text-white font-black">
                        <span>Special</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </template>
            </div>
        </template>
        
        {{-- Quick Add Button (Shows on Hover) --}}
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <button @click.stop="touched = true; $store.cart.add(dish)"
                    :class="$store.cart.has(dish.id) ? 'bg-green-500 text-white cursor-default' : 'bg-yellow-400 hover:bg-yellow-500 text-gray-900 cursor-pointer'"
                    class="font-bold px-6 py-3 rounded-full shadow-xl transform scale-90 group-hover:scale-100 transition-all duration-300 flex items-center gap-2"
                    :disabled="$store.cart.has(dish.id)">
                
                <span x-text="$store.cart.has(dish.id) ? 'Added' : 'Add to Cart'"></span>
                
                <template x-if="$store.cart.has(dish.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                </template>
            </button>
        </div>
    </div>
    
    {{-- Content --}}
    <div class="flex flex-col">
        <h3 class="text-xl font-black text-gray-900 mb-2 line-clamp-1 group-hover:text-yellow-600 transition-colors" 
            x-text="dish.name"></h3>
        
        <p class="text-sm text-gray-500 mb-4 line-clamp-2 leading-relaxed h-10" 
           x-text="dish.description"></p>
        
        <div class="flex items-center justify-between mt-auto">
            {{-- Rating --}}
            <div class="flex text-yellow-400 text-xs">
                <template x-for="i in 5" :key="i">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                            class="size-4"
                            :class="i <= (dish.rating || 0) ? 'text-yellow-400' : 'text-gray-200'">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                    </svg>
                </template>
                <span class="ml-1 text-gray-600 font-medium" x-text="'(' + (dish.reviews || 0) + ')'"></span>
            </div>
            
            {{-- Prep Time --}}
            <div class="flex items-center gap-1 text-xs text-gray-500 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                </svg>
                <span x-text="dish.prepTime + ' min'"></span>
            </div>
        </div>
    </div>
</div>
