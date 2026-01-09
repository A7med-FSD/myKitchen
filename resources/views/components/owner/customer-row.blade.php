@props(['customer'])

<tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors group">
    <!-- Customer Profile (Image + Name + Email) -->
    <td class="px-6 py-4">
        <div class="flex items-center gap-4">
            <img :src="customer.image" 
                :alt="customer.name"
                class="w-10 h-10 rounded-full object-cover border border-gray-100 shadow-sm group-hover:scale-105 transition-transform duration-300">
            
            <div>
                <div class="flex items-center gap-2">
                    <div class="text-sm font-bold text-gray-900" x-text="customer.name"></div>
                    
                    <!-- Activity Status Badge -->
                    <template x-if="activityStatus(customer) === 'last-week'">
                        <span class="px-1.5 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold rounded-md tracking-wide">
                            Last Week
                        </span>
                    </template>
                    <template x-if="activityStatus(customer) === 'last-month'">
                        <span class="px-1.5 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-md tracking-wide">
                            Last Month
                        </span>
                    </template>
                    <template x-if="activityStatus(customer) === 'inactive'">
                        <span class="px-1.5 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-md tracking-wide">
                            Inactive
                        </span>
                    </template>
                </div>
                <div class="text-xs text-gray-500 font-medium" x-text="customer.email"></div>
            </div>
        </div>
    </td>

    <!-- Phone -->
    <td class="px-6 py-4">
        <div class="text-sm font-semibold text-gray-600 font-mono tracking-wide" x-text="formatPhone(customer.phone)"></div>
    </td>

    <!-- Performance (Orders + Spent) -->
    <td class="px-6 py-4 text-center">
        <div class="flex flex-col items-center">
            <span class="text-sm font-bold text-gray-900" x-text="customer.totalOrders + ' Orders'"></span>
            <span class="text-[10px] font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full mt-1" x-text="'$' + customer.totalSpent.toLocaleString()"></span>
        </div>
    </td>

    <!-- Customer Tag -->
    <td class="px-6 py-4 text-center">
        <template x-if="customerTag(customer) === 'VIP'">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-700 text-xs font-bold rounded-full border border-yellow-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                </svg>
                VIP
            </span>
        </template>
        <template x-if="customerTag(customer) === 'Regular'">
            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full border border-gray-300">
                Regular
            </span>
        </template>
        <template x-if="customerTag(customer) === 'NEW'">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full border border-green-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                    <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                </svg>
                NEW
            </span>
        </template>
    </td>

    <!-- Last Order Date -->
    <td class="px-6 py-4 text-center">
        <div class="flex flex-col items-center">
            <span class="text-xs font-semibold text-gray-700" x-text="formatDate(customer.lastOrderDate)"></span>
            <span class="text-[10px] text-gray-400" x-text="getDaysSince(customer.lastOrderDate) + ' days ago'"></span>
        </div>
    </td>

    <!-- Action Button -->
    <td class="px-6 py-4 text-center">
        <button class="px-4 py-1.5 bg-white border cursor-pointer border-gray-200 text-gray-600 text-xs font-bold rounded-full hover:bg-yellow-50 hover:border-yellow-200 hover:text-yellow-700 transition-all shadow-sm" 
                title="View Details"
                @click="showCustomerDetails(customer)">
            Show
        </button>
    </td>
</tr>
