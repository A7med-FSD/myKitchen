{{-- Hero Offer Card Component - Large, Eye-catching Design --}}
{{-- Used in x-for loop, 'offer' and 'index' available from Alpine scope --}}

<div class="relative overflow-hidden rounded-4xl shadow-2xl hover:shadow-3xl transition-all duration-500 group min-h-[400px]"
     :class="'animate-entrance-card animate-delay-' + (index * 100)"
     x-data="{ shown: false }" 
     x-intersect.threshold.20="shown = true"
     :class="shown ? 'opacity-100' : 'opacity-0'">
    
    {{-- Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br" 
         :class="offer.bgGradient">
    </div>
    
    {{-- Animated Pattern Overlay --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    {{-- Content --}}
    <div class="relative p-8 md:p-12 flex flex-col justify-between min-h-[400px]">
        <div>
            {{-- Discount Badge --}}
            <div class="inline-flex items-center mb-6 animate-pulse">
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 border-2 border-white/30 shadow-lg">
                    <span class="text-6xl md:text-7xl font-black text-white drop-shadow-lg" x-text="offer.discount + '%'"></span>
                    <span class="text-2xl font-bold text-white/90 ml-2">OFF</span>
                </div>
            </div>
            
            {{-- Title & Description --}}
            <div class="space-y-3 mb-6">
                <h2 class="text-4xl md:text-5xl font-black text-white drop-shadow-2xl leading-tight" x-text="offer.title"></h2>
                <p class="text-xl md:text-2xl text-white/90 font-medium max-w-xl" x-text="offer.description"></p>
            </div>
        </div>
        
        <div class="space-y-4">
            {{-- Countdown Timer --}}
            <div class="inline-flex items-center gap-2 bg-black/30 backdrop-blur-md rounded-2xl px-5 py-3 border border-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-white">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                </svg>
                <span class="text-white font-bold text-lg" :class="isExpiringSoon(offer.validUntil) ? 'text-red-300 animate-pulse' : ''" x-text="getCountdown(offer.validUntil)"></span>
                <span class="text-white/80 text-sm">remaining</span>
            </div>
            
            {{-- Promo Code & CTA --}}
            <div class="flex flex-wrap gap-3 items-center">
                {{-- Promo Code --}}
                {{-- Promo Code --}}
                <button x-data="{ copied: false }"
                        @click.stop="
                            copyCode(offer.code);
                            copied = true;
                            setTimeout(() => copied = false, 2000);
                        " 
                        class="group/code flex items-center gap-2 bg-white/95 hover:bg-white backdrop-blur-sm rounded-xl px-5 py-3 transition-all duration-300 hover:scale-105 shadow-lg cursor-pointer min-w-[200px] justify-center">
                    
                    {{-- Default State --}}
                    <div x-show="!copied" class="flex items-center gap-2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-700">
                            <path d="M7 3.5A1.5 1.5 0 018.5 2h3.879a1.5 1.5 0 011.06.44l3.122 3.12A1.5 1.5 0 0117 6.622V12.5a1.5 1.5 0 01-1.5 1.5h-1v-3.379a3 3 0 00-.879-2.121L10.5 5.379A3 3 0 008.379 4.5H7v-1z" />
                            <path d="M4.5 6A1.5 1.5 0 003 7.5v9A1.5 1.5 0 004.5 18h7a1.5 1.5 0 001.5-1.5v-5.879a1.5 1.5 0 00-.44-1.06L9.44 6.439A1.5 1.5 0 008.379 6H4.5z" />
                        </svg>
                        <span class="font-mono font-bold text-gray-900 text-lg" x-text="offer.code"></span>
                        <span class="text-xs text-gray-600 group-hover/code:text-gray-900">Click to copy</span>
                    </div>

                    {{-- Copied State --}}
                    <div x-show="copied" style="display: none;" class="flex items-center gap-2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-green-600">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-bold text-green-700 text-lg">Copied!</span>
                    </div>
                </button>
                
                {{-- Shop Now Button --}}
                <button class="btn-primary w-[200px] h-[50px]">
                    <span class="text-lg">Shop Now</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    {{-- Shine Effect on Hover --}}
    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 group-hover:animate-shine"></div>
    </div>
</div>
