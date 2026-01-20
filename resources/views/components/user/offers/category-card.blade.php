{{-- Category Offer Card Component --}}
{{-- Used in x-for loop, 'offer' and 'index' available from Alpine scope --}}

<div class="relative overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 group h-64"
     :class="'animate-entrance-card animate-delay-' + (index * 100)"
     x-data="{ shown: false }" 
     x-intersect.threshold.20="shown = true"
     :class="shown ? 'opacity-100' : 'opacity-0'">
    
    {{-- Background Color with Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br" 
         :class="offer.bgColor + ' from-opacity-100 to-opacity-80'">
    </div>
    
    {{-- Pattern Overlay --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;80&quot; height=&quot;80&quot; viewBox=&quot;0 0 80 80&quot;%3E%3Cg fill=&quot;%23000000&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M0 0h40v40H0V0zm40 40h40v40H40V40zm0-40h2l-2 2V0zm0 4l4-4h2l-6 6V4zm0 4l8-8h2L40 10V8zm0 4L52 0h2L40 14v-2zm0 4L56 0h2L40 18v-2zm0 4L60 0h2L40 22v-2zm0 4L64 0h2L40 26v-2zm0 4L68 0h2L40 30v-2zm0 4L72 0h2L40 34v-2zm0 4L76 0h2L40 38v-2zm0 4L80 0v2L42 40h-2zm4 0L80 4v2L46 40h-2zm4 0L80 8v2L50 40h-2zm4 0l28-28v2L54 40h-2zm4 0l24-24v2L58 40h-2zm4 0l20-20v2L62 40h-2zm4 0l16-16v2L66 40h-2zm4 0l12-12v2L70 40h-2zm4 0l8-8v2l-6 6h-2zm4 0l4-4v2l-2 2h-2z&quot;/%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    {{-- Content --}}
    <div class="relative h-full p-6 flex flex-col justify-between">
        <div>
            {{-- Discount Badge --}}
            <div class="absolute top-4 right-4">
                <div class="bg-white rounded-full px-4 py-2 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl font-black text-gray-900" x-text="offer.discount + '%'"></span>
                    <span class="text-xs font-bold text-gray-600 ml-1">OFF</span>
                </div>
            </div>
            
            {{-- Category Icon & Name --}}
            <div class="space-y-3">
                <div class="text-7xl transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300" x-text="offer.categoryIcon"></div>
                <h3 class="text-3xl font-black text-white drop-shadow-lg" x-text="offer.category"></h3>
            </div>
        </div>
        
        <div class="space-y-3">
            {{-- Countdown --}}
            <div class="inline-flex items-center gap-2 bg-black/20 backdrop-blur-sm rounded-lg px-3 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                </svg>
                <span class="text-white font-bold text-sm" x-text="getCountdown(offer.validUntil)"></span>
            </div>
            
            {{-- View Category Button --}}
            <button class="w-full bg-white/95 text-gray-900 font-bold py-3 rounded-xl transition-all duration-300 hover:bg-yellow-400 hover:text-gray-900 shadow-lg flex items-center justify-center gap-2 group-hover:scale-105 cursor-pointer">
                <span>View Category</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</div>
