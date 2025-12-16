<x-layout>
    <!-- Custom CSS for specific dashboard elements -->
    <style>
        .noscroll::-webkit-scrollbar {
            display: none;
        }
        .noscroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <div class="space-y-6" x-data="{ selectedDay: 'Mon' }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Hello, Jessica</h1>
                <p class="text-gray-500 mt-1">You have <span class="font-bold text-gray-900">8 new orders</span> today</p>
            </div>
            <div class="w-full md:w-96 relative group">
                <input type="text" placeholder="Search orders, menu, etc..." class="w-full bg-white border-none rounded-full py-3 px-5 pl-12 shadow-sm focus:ring-2 focus:ring-gray-200 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-4 top-3.5 text-gray-400 size-5 group-focus-within:text-gray-600 transition-colors">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" />
                </svg>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
            
            <!-- 1. Schedule Column (Span 3) - ADAPTED: Order Schedule -->
            <div class="xl:col-span-3 bg-white rounded-3xl p-6 shadow-sm min-h-[600px]">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-bold text-lg flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-gray-400">
                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                        </svg>
                        Order Schedule
                    </h2>
                    <button class="text-gray-400 hover:text-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </button>
                </div>

                <!-- Date Strip -->
                <div class="flex justify-between items-center mb-8 text-center text-xs">
                     <button class="text-gray-400 hover:text-gray-600">&lt;</button>
                     <div class="flex-1 flex justify-around">
                        @foreach([['d'=>'21', 'n'=>'Sun'], ['d'=>'22', 'n'=>'Mon'], ['d'=>'23', 'n'=>'Tue'], ['d'=>'24', 'n'=>'Wed']] as $day)
                            <div class="cursor-pointer transition-all duration-200"
                                 :class="selectedDay === '{{$day['n']}}' ? 'bg-yellow-400 rounded-2xl py-2 px-3 shadow-md shadow-yellow-200 text-gray-900 font-bold scale-110' : 'text-gray-400 hover:text-gray-600'"
                                 @click="selectedDay = '{{$day['n']}}'">
                                <div class="mb-1">{{$day['d']}}</div><div>{{$day['n']}}</div>
                            </div>
                        @endforeach
                     </div>
                     <button class="text-gray-400 hover:text-gray-600">&gt;</button>
                </div>

                <!-- Timeline -->
                <div class="space-y-8 relative pl-2">
                    <!-- Dotted Line -->
                    <div class="absolute left-[19px] top-2 bottom-2 w-[2px] border-l-2 border-dashed border-gray-200"></div>

                    <!-- Item 1: Pending -->
                    <div class="relative pl-10 group cursor-pointer">
                        <div class="absolute left-0 top-0 bg-white border-2 border-gray-300 rounded-full w-4 h-4 z-10 group-hover:border-yellow-400 transition-colors"></div>
                        <span class="text-xs text-gray-400 block mb-1">08:00 AM</span>
                        <h3 class="font-bold text-gray-800">New Order #1024</h3>
                        <p class="text-xs text-gray-500 line-clamp-1">2x Pancakes, 1x Coffee</p>
                    </div>

                    <!-- Item 2: Preparing -->
                    <div class="relative pl-10 group cursor-pointer transition-transform hover:translate-x-1">
                         <div class="absolute left-0 top-0 bg-yellow-400 rounded-full p-1 border-4 border-white z-10 shadow-sm">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3 text-white">
                              <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs text-gray-400 block mb-1">08:15 AM</span>
                        <h3 class="font-bold text-gray-800 mb-2">Order #1025 - Delivery</h3>
                        <div class="flex flex-wrap gap-2 text-[10px] font-semibold">
                            <span class="bg-red-100 text-red-500 px-2 py-1 rounded">Urgent</span>
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded flex items-center gap-1">💵 Paid</span>
                        </div>
                    </div>

                    <!-- Item 3: Ready -->
                    <div class="relative pl-10 group cursor-pointer">
                         <div class="absolute left-0 top-0 bg-green-500 rounded-full p-1 border-4 border-white z-10 shadow-sm">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3 text-white">
                              <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs text-gray-400 block mb-1">08:45 AM</span>
                        <h3 class="font-bold text-gray-800 mb-2">Order #1022 - Pickup</h3>
                         <div class="flex flex-wrap gap-2 text-[10px] font-semibold">
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded">Ready</span>
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded flex items-center gap-1">⏱️ 15m left</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Center Column (Span 6) -->
            <div class="xl:col-span-6 space-y-6">
                <!-- Report Card - ADAPTED: Business Metrics -->
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="flex items-end gap-2 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-gray-400">
                          <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm4.5 7.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5a.75.75 0 0 1 .75-.75Zm3.75-3a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-1.5 0v-7.5a.75.75 0 0 1 .75-.75Zm3.75 2.25a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0v-5.25a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                        </svg>
                        <h2 class="font-bold text-lg">Performance <span class="text-gray-400 text-sm font-normal">This week</span></h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Revenue (Blue) -->
                        <div class="bg-blue-400 rounded-2xl p-4 text-white relative h-32 flex flex-col justify-between overflow-hidden group hover:shadow-lg transition-shadow">
                             <div class="absolute top-8 left-0 w-full h-full opacity-20">
                                 <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full"><path d="M0 50 Q 50 20 100 50 V 100 H 0 Z" fill="white" /></svg>
                             </div>
                            <h3 class="font-bold z-10 text-white">Revenue</h3>
                            <div class="z-10">
                                <div class="text-2xl font-bold">SAR 2.5K</div>
                                <div class="text-[10px] opacity-90">Goal 3.1K</div>
                            </div>
                        </div>

                         <!-- Active Orders (Orange) -->
                        <div class="bg-orange-50 rounded-2xl p-4 text-gray-800 h-32 flex flex-col justify-between group hover:bg-orange-100 transition-colors">
                            <h3 class="font-bold">Active Orders</h3>
                             <div class="relative h-12 w-24 mx-auto mt-2">
                                <div class="w-full h-full border-[6px] border-orange-200 rounded-t-full border-b-0"></div>
                                <div class="absolute top-0 left-0 w-full h-full border-[6px] border-orange-400 rounded-t-full border-b-0 border-r-transparent border-l-transparent transform -rotate-45"></div>
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 font-bold text-xl">12</div>
                             </div>
                            <div class="flex justify-between text-xs mt-1">
                                <span class="text-gray-400">Capacity</span>
                                <span class="text-gray-400 self-end">85%</span>
                            </div>
                        </div>

                         <!-- Avg Prep Time (Green) -->
                        <div class="bg-green-50 rounded-2xl p-4 text-gray-800 h-32 flex flex-col justify-between group hover:bg-green-100 transition-colors">
                            <h3 class="font-bold">Avg Prep Time</h3>
                            <div class="flex items-center justify-center h-full">
                                <svg viewBox="0 0 100 40" class="w-full h-8 stroke-green-500 fill-none stroke-2">
                                    <polyline points="0,20 20,20 30,10 40,30 50,20 60,20 70,5 80,35 90,20 100,20" />
                                </svg>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="font-bold text-lg">15m</span>
                                <span class="text-gray-400">-2m than avg</span>
                            </div>
                        </div>

                         <!-- Rating (Pink) -->
                        <div class="bg-pink-50 rounded-2xl p-4 text-gray-800 h-32 flex flex-col justify-between group hover:bg-pink-100 transition-colors">
                            <h3 class="font-bold">Rating</h3>
                             <div class="relative h-12 w-24 mx-auto mt-2">
                                <div class="w-full h-full border-[6px] border-pink-200 rounded-t-full border-b-0"></div>
                                <div class="absolute top-0 left-0 w-full h-full border-[6px] border-pink-400 rounded-t-full border-b-0 rotate-45"></div>
                                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 font-bold text-sm">4.8</div>
                             </div>
                            <div class="flex justify-between text-xs mt-1">
                                <span class="font-bold text-pink-500">Excellent</span>
                                <span class="text-gray-400 self-end">152 Reviews</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Daily Intake -> ADAPTED: Top Selling Items -->
                     <div class="bg-white rounded-3xl p-6 shadow-sm">
                          <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-gray-400">
                              <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.177 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                            </svg>
                            Top Items
                          </h2>
                          <div class="flex justify-around text-center">
                              <div class="group cursor-pointer">
                                  <div class="w-12 h-12 rounded-full border-4 border-green-400 flex items-center justify-center font-bold text-2xl group-hover:bg-green-50 transition-colors">🍔</div>
                                  <span class="text-xs text-gray-400 mt-1 block group-hover:text-gray-800">Burger</span>
                              </div>
                               <div class="group cursor-pointer">
                                  <div class="w-12 h-12 rounded-full border-4 border-orange-400 flex items-center justify-center font-bold text-2xl group-hover:bg-orange-50 transition-colors">🍕</div>
                                  <span class="text-xs text-gray-400 mt-1 block group-hover:text-gray-800">Pizza</span>
                              </div>
                               <div class="group cursor-pointer">
                                  <div class="w-12 h-12 rounded-full border-4 border-blue-400 flex items-center justify-center font-bold text-2xl group-hover:bg-blue-50 transition-colors">🍝</div>
                                  <span class="text-xs text-gray-400 mt-1 block group-hover:text-gray-800">Pasta</span>
                              </div>
                          </div>
                          
                          <div class="mt-4">
                             <div class="flex justify-between text-xs text-gray-500 mb-1">
                                 <span>Monthly Goal</span>
                                 <span>850 / 1000 Orders</span>
                             </div>
                             <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="bg-blue-500 h-2.5 rounded-full" style="width: 85%"></div>
                             </div>
                          </div>
                     </div>

                     <!-- Activity -> ADAPTED: Sales Chart -->
                     <div class="bg-white rounded-3xl p-6 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="font-bold text-lg flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-gray-400">
                                  <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                                  <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
                                </svg>
                                Sales
                            </h2>
                            <span class="text-xs text-green-500 bg-green-50 px-2 py-1 rounded">+15%</span>
                        </div>
                        
                        <div class="flex items-end justify-between h-32 gap-2">
                            @foreach([40, 60, 30, 80, 50, 90, 70] as $h)
                            <div class="w-full bg-purple-100 rounded-t-md hover:bg-purple-300 transition-colors relative group" style="height: {{$h}}%">
                                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-black text-white text-[10px] px-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">{{$h}}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between text-xs text-gray-400 mt-2">
                            <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                        </div>
                     </div>
                </div>
            </div>

            <!-- 3. Shopping List (Span 3) - ADAPTED: Inventory/Restock -->
            <div class="xl:col-span-3">
                 <div class="bg-white rounded-3xl p-6 shadow-sm mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-bold text-lg flex items-center gap-2">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-gray-400">
                              <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                            </svg>
                            Restock List
                        </h2>
                         <button class="bg-black text-white rounded-full p-1 hover:bg-gray-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" /></svg>
                        </button>
                    </div>

                    <div class="space-y-6">
                        @foreach([
                            ['name'=>'Tomatoes', 'q'=>'5 kg', 'icon'=>'🍅', 'stock'=>true],
                            ['name'=>'Flour', 'q'=>'10 kg', 'icon'=>'🌾', 'stock'=>true],
                            ['name'=>'Milk', 'q'=>'20 L', 'icon'=>'🥛', 'stock'=>false, 'tag'=>'Low'],
                            ['name'=>'Eggs', 'q'=>'50 pcs', 'icon'=>'🥚', 'stock'=>false],
                            ['name'=>'Onion', 'q'=>'3 kg', 'icon'=>'🧅', 'stock'=>false],
                        ] as $item)
                        <div class="flex items-center gap-3">
                             <div class="{{$item['stock'] ? 'bg-green-500' : 'border-2 border-gray-300'}} rounded-md w-5 h-5 flex items-center justify-center transition-colors cursor-pointer">
                                @if($item['stock'])
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3 text-white"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
                                @endif
                             </div>
                             <div class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center text-lg">{{$item['icon']}}</div>
                            <div class="flex-1 text-sm font-semibold flex items-center gap-2">
                                {{$item['name']}} 
                                @if(isset($item['tag'])) <span class="bg-blue-100 text-blue-500 text-[10px] px-1 rounded">{{$item['tag']}}</span> @endif
                            </div>
                            <div class="text-sm font-bold text-gray-500">{{$item['q']}}</div>
                        </div>
                        @endforeach
                    </div>

                    <button class="w-full mt-8 bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-3 rounded-2xl flex items-center justify-center gap-2 transition transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                           <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                        </svg>
                        Order Supplies
                    </button>
                </div>

                <!-- 4. Recipe Card (Overlay - Same as design) -->
                 <div class="relative group cursor-pointer">
                    <div class="bg-white rounded-[32px] p-4 shadow-lg overflow-hidden border border-gray-100 transition-transform hover:-translate-y-1">
                        <div class="relative h-48 rounded-[24px] overflow-hidden mb-4">
                            <img src="https://images.unsplash.com/photo-1555126634-323283e090fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Shrimp Stir-Fry" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                             <div class="absolute top-2 right-2 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full text-[10px] font-bold">🔥 Signature</div>
                        </div>
                        
                        <h2 class="text-2xl font-black text-gray-900 leading-tight mb-2 font-serif group-hover:text-yellow-600 transition-colors">Shrimp Stir-Fry with Brown Rice</h2>
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed">A quick and healthy stir-fry with succulent shrimp, colorful vegetables, and a side of brown rice.</p>
                        
                        <div class="flex flex-wrap gap-2 text-[10px] font-bold text-gray-600 mb-6">
                            <div class="bg-green-100 text-green-700 px-2 py-1 rounded">Main dish</div>
                            <div class="bg-gray-100 px-2 py-1 rounded flex items-center gap-1">⚫ 350kcal</div>
                            <div class="bg-gray-100 px-2 py-1 rounded flex items-center gap-1">🕒 45min</div>
                        </div>

                        <h3 class="font-bold text-gray-900 mb-4">Ingredients</h3>
                        <div class="flex justify-between items-center text-center text-xs text-gray-500 mb-8">
                            <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-xl">🍤</div>
                                <span>60g</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-xl">🍚</div>
                                <span>100g</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-xl">🧅</div>
                                <span>1/2</span>
                            </div>
                             <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-xl">🥬</div>
                                <span>20g</span>
                            </div>
                             <div class="flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-xl">🧴</div>
                                <span>10ml</span>
                            </div>
                        </div>

                         <div class="flex items-center justify-between gap-4 text-xs font-bold text-gray-500 mb-6">
                            <div class="flex items-center gap-1"><span class="text-orange-500">🔥</span> Medium</div>
                            <div class="flex items-center gap-1">21.8K <span class="text-gray-300">👁</span> 156.1K</div>
                         </div>

                        <button class="w-full bg-white border border-gray-900 text-gray-900 font-bold py-3 rounded-full flex items-center justify-center gap-2 hover:bg-gray-900 hover:text-white transition-colors duration-300">
                            Explore Recipe <span>↗</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    
    <!-- Inline Scripts for simple interactions -->
    <script>
        // Simple JS to handle date selection visuals if not using Alpine
        // (Alpine logic is already in the x-data attribute above, which requires Alpine.js installed.
        // If the user doesn't have Alpine, this script serves as fallback or additional logic)
        
        document.addEventListener('DOMContentLoaded', () => {
             // Hover effects on cards are handled by Tailwind classes (group-hover)
             console.log('Dashboard Loaded');
        });
    </script>
</x-layout>
