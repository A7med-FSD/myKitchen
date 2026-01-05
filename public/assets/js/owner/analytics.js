function analyticsHandler() {
    console.log('Analytics Handler'); //بيطبع 
    return ({
        // Date Range
        dateRange: 'Week',
        dateRanges: ['Week', 'Month', 'Year'],
        
        // 12 Weeks of Test Data (chronologically ordered)
        weeksData: [
            // Week 1
            {
                revenue: { total: 8500, values: [1100, 1200, 1150, 1300, 1250, 1400, 1100] },
                orders: { total: 180, byStatus: { pending: 8, inProgress: 5, ready: 10, completed: 145, cancelled: 12 }, values: [22, 25, 24, 28, 26, 30, 25] },
                customers: { total: 140, new: 30, returning: 110, avgRating: 4.4 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 65, revenue: 1625, trend: '+10%' },
                    { name: 'Chicken Alfredo', orders: 55, revenue: 935, trend: '+5%' },
                    { name: 'Beef Steak', orders: 50, revenue: 1450, trend: '+8%' }
                ]
            },
            // Week 2
            {
                revenue: { total: 9200, values: [1250, 1300, 1200, 1400, 1350, 1500, 1200] },
                orders: { total: 195, byStatus: { pending: 10, inProgress: 6, ready: 12, completed: 155, cancelled: 12 }, values: [25, 28, 26, 30, 28, 32, 26] },
                customers: { total: 155, new: 35, returning: 120, avgRating: 4.5 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 70, revenue: 1750, trend: '+12%' },
                    { name: 'Chicken Alfredo', orders: 60, revenue: 1020, trend: '+7%' },
                    { name: 'Beef Steak', orders: 55, revenue: 1595, trend: '+10%' }
                ]
            },
            // Week 3
            {
                revenue: { total: 10500, values: [1400, 1500, 1450, 1600, 1550, 1700, 1300] },
                orders: { total: 210, byStatus: { pending: 11, inProgress: 7, ready: 13, completed: 165, cancelled: 14 }, values: [28, 30, 29, 32, 30, 34, 27] },
                customers: { total: 165, new: 38, returning: 127, avgRating: 4.5 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 75, revenue: 1875, trend: '+14%' },
                    { name: 'Chicken Alfredo', orders: 65, revenue: 1105, trend: '+9%' },
                    { name: 'Beef Steak', orders: 60, revenue: 1740, trend: '+12%' }
                ]
            },
            // Week 4
            {
                revenue: { total: 11200, values: [1500, 1600, 1550, 1700, 1650, 1800, 1400] },
                orders: { total: 225, byStatus: { pending: 12, inProgress: 8, ready: 14, completed: 178, cancelled: 13 }, values: [30, 32, 31, 34, 32, 36, 30] },
                customers: { total: 170, new: 40, returning: 130, avgRating: 4.6 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 80, revenue: 2000, trend: '+15%' },
                    { name: 'Chicken Alfredo', orders: 68, revenue: 1156, trend: '+10%' },
                    { name: 'Beef Steak', orders: 63, revenue: 1827, trend: '+13%' }
                ]
            },
            // Week 5
            {
                revenue: { total: 10800, values: [1450, 1550, 1500, 1650, 1600, 1700, 1350] },
                orders: { total: 218, byStatus: { pending: 11, inProgress: 7, ready: 13, completed: 0, cancelled: 14 }, values: [29, 31, 30, 33, 31, 35, 29] },
                customers: { total: 168, new: 39, returning: 129, avgRating: 4.5 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 78, revenue: 1950, trend: '+13%' },
                    { name: 'Chicken Alfredo', orders: 67, revenue: 1139, trend: '+9%' },
                    { name: 'Beef Steak', orders: 62, revenue: 1798, trend: '+12%' }
                ]
            },
            // Week 6
            {
                revenue: { total: 11800, values: [1600, 1700, 1650, 1800, 1750, 1900, 1400] },
                orders: { total: 235, byStatus: { pending: 13, inProgress: 8, ready: 15, completed: 7, cancelled: 14 }, values: [31, 34, 33, 36, 34, 38, 29] },
                customers: { total: 178, new: 42, returning: 136, avgRating: 4.6 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 82, revenue: 2050, trend: '+16%' },
                    { name: 'Chicken Alfredo', orders: 70, revenue: 1190, trend: '+11%' },
                    { name: 'Beef Steak', orders: 65, revenue: 1885, trend: '+14%' }
                ]
            },
            // Week 7
            {
                revenue: { total: 12100, values: [1650, 1750, 1700, 1850, 1800, 1950, 1400] },
                orders: { total: 238, byStatus: { pending: 13, inProgress: 9, ready: 15, completed: 7, cancelled: 14 }, values: [32, 34, 33, 37, 35, 39, 28] },
                customers: { total: 180, new: 43, returning: 137, avgRating: 4.6 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 83, revenue: 2075, trend: '+17%' },
                    { name: 'Chicken Alfredo', orders: 71, revenue: 1207, trend: '+11%' },
                    { name: 'Beef Steak', orders: 66, revenue: 1914, trend: '+14%' }
                ]
            },
            // Week 8
            {
                revenue: { total: 12500, values: [1700, 1800, 1750, 1900, 1850, 2000, 1500] },
                orders: { total: 242, byStatus: { pending: 14, inProgress: 9, ready: 16, completed: 6, cancelled: 14 }, values: [33, 35, 34, 38, 36, 40, 26] },
                customers: { total: 182, new: 44, returning: 138, avgRating: 4.7 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 84, revenue: 2100, trend: '+17%' },
                    { name: 'Chicken Alfredo', orders: 72, revenue: 1224, trend: '+12%' },
                    { name: 'Beef Steak', orders: 67, revenue: 1943, trend: '+15%' }
                ]
            },
            // Week 9
            {
                revenue: { total: 12850, values: [1750, 1850, 1800, 1950, 1900, 2100, 1500] },
                orders: { total: 245, byStatus: { pending: 12, inProgress: 8, ready: 15, completed: 5, cancelled: 10 }, values: [34, 36, 35, 39, 37, 42, 22] },
                customers: { total: 185, new: 45, returning: 140, avgRating: 4.7 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 85, revenue: 2125, trend: '+18%' },
                    { name: 'Chicken Alfredo', orders: 73, revenue: 1241, trend: '+12%' },
                    { name: 'Beef Steak', orders: 68, revenue: 1972, trend: '+15%' }
                ]
            },
            // Week 10
            {
                revenue: { total: 13200, values: [1800, 1900, 1850, 2000, 1950, 2150, 1550] },
                orders: { total: 248, byStatus: { pending: 13, inProgress: 9, ready: 16, completed: 195, cancelled: 15 }, values: [35, 37, 36, 40, 38, 43, 19] },
                customers: { total: 188, new: 46, returning: 142, avgRating: 4.7 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 86, revenue: 2150, trend: '+18%' },
                    { name: 'Chicken Alfredo', orders: 74, revenue: 1258, trend: '+13%' },
                    { name: 'Beef Steak', orders: 69, revenue: 2001, trend: '+16%' }
                ]
            },
            // Week 11
            {
                revenue: { total: 12900, values: [1750, 1850, 1800, 1950, 1900, 2050, 1600] },
                orders: { total: 250, byStatus: { pending: 14, inProgress: 9, ready: 17, completed: 195, cancelled: 15 }, values: [35, 37, 36, 40, 38, 44, 20] },
                customers: { total: 190, new: 47, returning: 143, avgRating: 4.6 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 87, revenue: 2175, trend: '+19%' },
                    { name: 'Chicken Alfredo', orders: 75, revenue: 1275, trend: '+13%' },
                    { name: 'Beef Steak', orders: 70, revenue: 2030, trend: '+16%' }
                ]
            },
            // Week 12 (Current Week)
            {
                revenue: { total: 13500, values: [1850, 1950, 1900, 2050, 2000, 2150, 1600] },
                orders: { total: 5, byStatus: { pending: 15, inProgress: 10, ready: 18, completed: 197, cancelled: 15 }, values: [36, 38, 37, 41, 39, 45, 19] },
                customers: { total: 195, new: 48, returning: 147, avgRating: 4.7 },
                topItems: [
                    { name: 'Grilled Salmon', orders: 88, revenue: 2200, trend: '+20%' },
                    { name: 'Chicken Alfredo', orders: 76, revenue: 1292, trend: '+14%' },
                    { name: 'Beef Steak', orders: 71, revenue: 2059, trend: '+17%' }
                ]
            }
        ],
        
        categoryDistribution: {
            'Main Dishes': 45,
            'Appetizers': 25,
            'Desserts': 15,
            'Drinks': 10,
            'Soups': 5
        },
        
        // Inventory
        inventory: {
            totalValue: 5420.30,
            restockNeeded: 12,
            categoryValues: [
                { name: 'Meat', value: 1850.50, percentage: 34 },
                { name: 'Vegetables', value: 1200.80, percentage: 22 },
                { name: 'Grains', value: 980.40, percentage: 18 },
                { name: 'Oils', value: 750.20, percentage: 14 },
                { name: 'Spices', value: 638.40, percentage: 12 }
            ]
        },
        
        // Heatmap Data (7 days × 24 hours) - Always shows current week
        heatmap: [
            // Monday
            [0,0,0,0,0,0,0,1,2,3,4,5,8,7,6,5,4,6,9,10,8,5,2,1],
            // Tuesday
            [0,0,0,0,0,0,0,1,3,4,5,6,9,8,7,6,5,7,10,9,7,4,2,1],
            // Wednesday
            [0,0,0,0,0,0,0,2,3,4,5,6,8,7,6,5,4,6,8,9,7,5,2,1],
            // Thursday
            [0,0,0,0,0,0,0,1,2,4,5,7,9,8,7,6,5,7,10,10,8,6,3,1],
            // Friday
            [0,0,0,0,0,0,0,2,4,5,6,8,10,9,8,7,6,8,10,10,9,7,4,2],
            // Saturday
            [0,0,0,0,0,0,0,3,5,6,7,9,10,10,9,8,7,9,10,10,9,6,3,1],
            // Sunday
            [0,0,0,0,0,0,0,2,3,5,6,7,9,8,7,6,5,7,9,8,7,5,2,1]
        ],
        
        
        // Computed Properties - Dynamic based on dateRange
        get revenue() {
            if (this.dateRange === 'Week') {
                // Return current week (Week 12)
                const currentWeek = this.weeksData[11];
                return {
                    total: currentWeek.revenue.total,
                    previousPeriod: this.weeksData[10].revenue.total,
                    chartData: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        values: currentWeek.revenue.values
                    }
                };
            } else if (this.dateRange === 'Month') {
                // Sum last 4 weeks (Weeks 9-12)
                const last4Weeks = this.weeksData.slice(8, 12);
                const weekTotals = last4Weeks.map(w => w.revenue.total);
                const total = weekTotals.reduce((a, b) => a + b, 0);
                const previousMonth = this.weeksData.slice(4, 8).map(w => w.revenue.total).reduce((a, b) => a + b, 0);
                return {
                    total: total,
                    previousPeriod: previousMonth,
                    chartData: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        values: weekTotals
                    }
                };
            } else { // Year
                // Sum all 12 weeks grouped into months (3 weeks per month = 4 months)
                const monthTotals = [];
                for (let i = 0; i < 12; i += 3) {
                    const monthRevenue = this.weeksData.slice(i, i + 3).reduce((sum, w) => sum + w.revenue.total, 0);
                    monthTotals.push(monthRevenue);
                }
                const total = monthTotals.reduce((a, b) => a + b, 0);
                return {
                    total: total,
                    previousPeriod: total * 0.85, // Mock previous year
                    chartData: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        values: [...monthTotals, ...monthTotals, ...monthTotals] // Repeat pattern
                    }
                };
            }
        },

        get orders() {
            if (this.dateRange === 'Week') {
                const currentWeek = this.weeksData[11];
                return {
                    total: currentWeek.orders.total,
                    byStatus: currentWeek.orders.byStatus,
                    timeline: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        values: currentWeek.orders.values
                    },
                    avgValue: (currentWeek.revenue.total / currentWeek.orders.total).toFixed(2),
                    peakHour: '7:00 PM'
                };
            } else if (this.dateRange === 'Month') {
                const last4Weeks = this.weeksData.slice(8, 12);
                const weekTotals = last4Weeks.map(w => w.orders.total);
                const weekValues = last4Weeks.map(w => w.orders.values.reduce((a, b) => a + b, 0));
                const totalOrders = weekTotals.reduce((a, b) => a + b, 0);
                const totalRevenue = last4Weeks.reduce((sum, w) => sum + w.revenue.total, 0);
                const aggregatedStatus = {
                    pending: last4Weeks.reduce((sum, w) => sum + w.orders.byStatus.pending, 0),
                    inProgress: last4Weeks.reduce((sum, w) => sum + w.orders.byStatus.inProgress, 0),
                    ready: last4Weeks.reduce((sum, w) => sum + w.orders.byStatus.ready, 0),
                    completed: last4Weeks.reduce((sum, w) => sum + w.orders.byStatus.completed, 0),
                    cancelled: last4Weeks.reduce((sum, w) => sum + w.orders.byStatus.cancelled, 0)
                };
                return {
                    total: totalOrders,
                    byStatus: aggregatedStatus,
                    timeline: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        values: weekValues
                    },
                    avgValue: (totalRevenue / totalOrders).toFixed(2),
                    peakHour: '7:00 PM'
                };
            } else { // Year
                const monthValues = [];
                let totalOrders = 0;
                let totalRevenue = 0;
                const aggregatedStatus = { pending: 0, inProgress: 0, ready: 0, completed: 0, cancelled: 0 };
                
                for (let i = 0; i < 12; i += 3) {
                    const monthWeeks = this.weeksData.slice(i, i + 3);
                    const monthOrders = monthWeeks.reduce((sum, w) => sum + w.orders.total, 0);
                    monthValues.push(monthOrders);
                    totalOrders += monthOrders;
                    totalRevenue += monthWeeks.reduce((sum, w) => sum + w.revenue.total, 0);
                    
                    monthWeeks.forEach(w => {
                        aggregatedStatus.pending += w.orders.byStatus.pending;
                        aggregatedStatus.inProgress += w.orders.byStatus.inProgress;
                        aggregatedStatus.ready += w.orders.byStatus.ready;
                        aggregatedStatus.completed += w.orders.byStatus.completed;
                        aggregatedStatus.cancelled += w.orders.byStatus.cancelled;
                    });
                }
                
                return {
                    total: totalOrders,
                    byStatus: aggregatedStatus,
                    timeline: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        values: [...monthValues, ...monthValues, ...monthValues]
                    },
                    avgValue: (totalRevenue / totalOrders).toFixed(2),
                    peakHour: '7:00 PM'
                };
            }
        },

        get customers() {
            if (this.dateRange === 'Week') {
                const currentWeek = this.weeksData[11];
                return {
                    total: currentWeek.customers.total,
                    new: currentWeek.customers.new,
                    returning: currentWeek.customers.returning,
                    avgRating: currentWeek.customers.avgRating,
                    returningRate: Math.round((currentWeek.customers.returning / currentWeek.customers.total) * 100)
                };
            } else if (this.dateRange === 'Month') {
                const last4Weeks = this.weeksData.slice(8, 12);
                const total = last4Weeks.reduce((sum, w) => sum + w.customers.total, 0);
                const newCustomers = last4Weeks.reduce((sum, w) => sum + w.customers.new, 0);
                const returning = last4Weeks.reduce((sum, w) => sum + w.customers.returning, 0);
                const avgRating = (last4Weeks.reduce((sum, w) => sum + w.customers.avgRating, 0) / 4).toFixed(1);
                return {
                    total: total,
                    new: newCustomers,
                    returning: returning,
                    avgRating: parseFloat(avgRating),
                    returningRate: Math.round((returning / total) * 100)
                };
            } else { // Year
                const total = this.weeksData.reduce((sum, w) => sum + w.customers.total, 0);
                const newCustomers = this.weeksData.reduce((sum, w) => sum + w.customers.new, 0);
                const returning = this.weeksData.reduce((sum, w) => sum + w.customers.returning, 0);
                const avgRating = (this.weeksData.reduce((sum, w) => sum + w.customers.avgRating, 0) / 12).toFixed(1);
                return {
                    total: total,
                    new: newCustomers,
                    returning: returning,
                    avgRating: parseFloat(avgRating),
                    returningRate: Math.round((returning / total) * 100)
                };
            }
        },

        get topItems() {
            if (this.dateRange === 'Week') {
                return this.weeksData[11].topItems;
            } else if (this.dateRange === 'Month') {
                // Aggregate top items from last 4 weeks
                const last4Weeks = this.weeksData.slice(8, 12);
                const itemsMap = {};
                last4Weeks.forEach(week => {
                    week.topItems.forEach(item => {
                        if (!itemsMap[item.name]) {
                            itemsMap[item.name] = { name: item.name, orders: 0, revenue: 0 };
                        }
                        itemsMap[item.name].orders += item.orders;
                        itemsMap[item.name].revenue += item.revenue;
                    });
                });
                return Object.values(itemsMap)
                    .sort((a, b) => b.orders - a.orders)
                    .slice(0, 5)
                    .map(item => ({ ...item, trend: '+12%' }));
            } else { // Year
                const itemsMap = {};
                this.weeksData.forEach(week => {
                    week.topItems.forEach(item => {
                        if (!itemsMap[item.name]) {
                            itemsMap[item.name] = { name: item.name, orders: 0, revenue: 0 };
                        }
                        itemsMap[item.name].orders += item.orders;
                        itemsMap[item.name].revenue += item.revenue;
                    });
                });
                return Object.values(itemsMap)
                    .sort((a, b) => b.orders - a.orders)
                    .slice(0, 5)
                    .map(item => ({ ...item, trend: '+15%' }));
            }
        },
        
        get revenueChange() {
            const change = ((this.revenue.total - this.revenue.previousPeriod) / this.revenue.previousPeriod) * 100;
            return change.toFixed(1);
        },
        
        get revenueChangePositive() {
            return this.revenueChange > 0;
        },
        
        get completedOrdersPercentage() {
            if (this.totalOrders === 0) return 0;
            return Math.round((this.orders.byStatus.completed / this.totalOrders) * 100);
        },
        
        get maxRevenueDay() {
            const maxIndex = this.revenue.chartData.values.indexOf(Math.max(...this.revenue.chartData.values));
            return this.revenue.chartData.labels[maxIndex];
        },
        
        get topCategory() {
            return Object.keys(this.categoryDistribution).reduce((a, b) => 
                this.categoryDistribution[a] > this.categoryDistribution[b] ? a : b
            );
        },
        
        // Donut Chart State
        hoveredSegment: null,
        tooltipVisible: false,
        tooltipX: 0,
        tooltipY: 0,
        donutRadius: 35,
        donutCircumference: 2 * Math.PI * 35,

        updateTooltip(event) {
            // Get the bounding rectangle of the SVG container
            const rect = event.currentTarget.getBoundingClientRect();
            // Calculate absolute position relative to the container
            this.tooltipX = event.clientX - rect.left;
            this.tooltipY = event.clientY - rect.top;
        },

        get totalOrders() {
            return Object.values(this.orders.byStatus).reduce((a, b) => a + b, 0);
        },

        get segments() {
            const statusColors = {
                pending: '#FBBF24',      // yellow-400
                inProgress: '#3B82F6',   // blue-500
                ready: '#22C55E',        // green-500
                completed: '#A855F7',    // purple-500
                cancelled: '#EF4444'     // red-500
            };

            const labels = {
                pending: 'Pending',
                inProgress: 'In Progress',
                ready: 'Ready',
                completed: 'Completed',
                cancelled: 'Cancelled'
            };
            
            let accumulatedValue = 0;
            const total = this.totalOrders || 1; // Prevent division by zero, if 0 it uses 1 but values are 0 so segments are 0

            return Object.entries(this.orders.byStatus).map(([key, value], index) => {
                const segmentValue = (value / total) * this.donutCircumference;
                const offset = accumulatedValue;
                accumulatedValue += segmentValue;

                return {
                    key: key,
                    label: labels[key],
                    value: value,
                    color: statusColors[key],
                    percentage: Math.round((value / total) * 100),
                    strokeDasharray: `${segmentValue} ${this.donutCircumference}`,
                    strokeDashoffset: -offset // Negative because charts usually go clockwise with negative offset or calculated differently. SVG default is counter-clockwise for positive offset if not careful, but rotation -90 fixes start. Let's verify standard dashoffset logic. 
                    // Standard logic: dasharray = "length section_gap", dashoffset = -start_point.
                };
            });
        },

        // Helper Functions
        formatCurrency(value) {
            console.log("format"); 
            return value.toFixed(2);
        },
        
        getOrderStatusColor(status) {
            const colors = {
                pending: 'bg-yellow-100 text-yellow-700',
                inProgress: 'bg-blue-100 text-blue-700',
                ready: 'bg-green-100 text-green-700',
                completed: 'bg-purple-100 text-purple-700',
                cancelled: 'bg-red-100 text-red-700'
            };
            return colors[status] || 'bg-gray-100 text-gray-700';
        },
        
        getHeatmapColor(intensity) {
            if (intensity === 0) return 'bg-gray-50';
            if (intensity <= 2) return 'bg-green-100';
            if (intensity <= 4) return 'bg-green-200';
            if (intensity <= 6) return 'bg-yellow-200';
            if (intensity <= 8) return 'bg-orange-300';
            return 'bg-red-400';
        },
        
        getBarHeight(value, max) {
            return (value / max) * 100;
        },
        
        // Animation State
        showAnimations: false,

        init() {
            setTimeout(() => {
                this.showAnimations = true;
            }, 300);
        },

        changeDateRange(range) {
            this.dateRange = range;
            // Reset animations
            this.showAnimations = false;
            
            // In a real implementation, this would fetch new data from the API
            // For now, we simulate a reload with animations
            setTimeout(() => {
                this.showAnimations = true;
            }, 300);

            console.log('Date range changed to:', range);
        }
    })
}
