<div class="flex gap-2 overflow-x-auto pb-2 entrance-animation flex-wrap">
    <template x-for="priority in ['All', 'Critical', 'High', 'Normal', 'Low']" :key="priority">
        <button @click="priorityFilter = priority"
                :class="[
                    priorityFilter === priority ? (priority === 'All' ? 'bg-yellow-400 text-gray-900' : priority === 'Critical' ? 'bg-red-500 text-white' : priority === 'High' ? 'bg-orange-500 text-white' : priority === 'Normal' ? 'bg-blue-500 text-white' : 'bg-gray-500 text-white') : 'bg-white text-gray-600 hover:bg-gray-50',
                    'px-4 py-2 rounded-full font-medium transition-all duration-200 whitespace-nowrap cursor-pointer flex items-center gap-2 shadow-sm'
                ]">
            <span x-show="priority === 'Critical'" class="w-2 h-2 bg-red-500 rounded-full" :class="priorityFilter !== 'Critical' ? 'animate-pulse' : 'bg-white'"></span>
            <span x-show="priority === 'High'" class="w-2 h-2 rounded-full" :class="priorityFilter === 'High' ? 'bg-white' : 'bg-orange-500'"></span>
            <span x-show="priority === 'Normal'" class="w-2 h-2 rounded-full" :class="priorityFilter === 'Normal' ? 'bg-white' : 'bg-blue-500'"></span>
            <span x-show="priority === 'Low'" class="w-2 h-2 rounded-full" :class="priorityFilter === 'Low' ? 'bg-white' : 'bg-gray-400'"></span>
            <span x-text="priority"></span>
            <span x-show="priority !== 'All' && getPriorityCount(priority) > 0" 
                  :class="priorityFilter === priority ? 'bg-white/20 text-white' : (priority === 'Critical' ? 'bg-red-100 text-red-700' : priority === 'High' ? 'bg-orange-100 text-orange-700' : priority === 'Normal' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600')"
                  class="px-2 py-0.5 rounded-full text-xs font-bold"
                  x-text="getPriorityCount(priority)"></span>
        </button>
    </template>
</div>
