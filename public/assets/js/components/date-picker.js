// Date Picker Alpine.js Component
document.addEventListener('alpine:init', () => {
    Alpine.data('datePicker', (initialValue = '') => ({
        showPicker: false,
        selectedDate: initialValue,
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        
        init() {
            // Set calendar to selected date if exists
            if (this.selectedDate) {
                const date = new Date(this.selectedDate);
                if (!isNaN(date.getTime())) {
                    this.currentMonth = date.getMonth();
                    this.currentYear = date.getFullYear();
                }
            }
        },

        get formattedDate() {
            if (!this.selectedDate) return '';
            const date = new Date(this.selectedDate);
            return date.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric', 
                year: 'numeric' 
            });
        },

        get daysInMonth() {
            return new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
        },

        get firstDayOfMonth() {
            return new Date(this.currentYear, this.currentMonth, 1).getDay();
        },

        get monthName() {
            return new Date(this.currentYear, this.currentMonth).toLocaleString('default', { 
                month: 'long' 
            });
        },
        
        get days() {
            const days = [];
            // Add empty slots for days before month starts
            for (let i = 0; i < this.firstDayOfMonth; i++) {
                days.push(null);
            }
            // Add actual days
            for (let i = 1; i <= this.daysInMonth; i++) {
                days.push(i);
            }
            return days;
        },

        prevMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
        },

        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
        },

        selectDate(day) {
            const date = new Date(this.currentYear, this.currentMonth, day);
            const offset = date.getTimezoneOffset();
            const adjustedDate = new Date(date.getTime() - (offset * 60 * 1000));
            
            this.selectedDate = adjustedDate.toISOString().split('T')[0];
            this.showPicker = false;
        },
        
        isSelected(day) {
            if (!this.selectedDate) return false;
            const selected = new Date(this.selectedDate);
            return selected.getDate() === day && 
                   selected.getMonth() === this.currentMonth && 
                   selected.getFullYear() === this.currentYear;
        },
        
        isToday(day) {
            const today = new Date();
            return today.getDate() === day && 
                   today.getMonth() === this.currentMonth && 
                   today.getFullYear() === this.currentYear;
        }
    }));
});
