        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 animate-entrance-header relative z-30">
            {{-- title --}}
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                {{$title}}
                </h1>
                <p class="text-gray-500 mt-2 font-medium">{{$subtitle}}</p>
            </div>

            {{-- Search Bar --}}
        @isset($searchplacehold)
             <x-search :searchplacehold="$searchplacehold" :filter="$filter" />
        @endisset


            {{-- Quick Stats --}}
            {{$slot}}
        </div>