<x-wo-layout>
    <div class="space-y-6" x-data="calendarApp()">
        <!-- Header / Back button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('wo.venues.index') }}" class="p-2.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-sm text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                        {{ $venue->name }} — Kalender Ketersediaan
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Lihat dan kelola tanggal pemesanan (booking) untuk venue ini.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Calendar Section (Left, spans 2 cols) -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-6">
                <!-- Month & Year Selector / Navigation -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-50 dark:border-gray-700/50">
                    <div class="flex items-center gap-2">
                        <button @click="prevMonth()" class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-gray-600 dark:text-gray-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <h3 class="font-extrabold text-gray-900 dark:text-white text-lg min-w-[150px] text-center" x-text="monthNames[currentMonth] + ' ' + currentYear"></h3>
                        <button @click="nextMonth()" class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-gray-600 dark:text-gray-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                    <button @click="goToday()" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-white text-xs font-bold py-1.5 px-3 rounded-lg transition-all">Hari Ini</button>
                </div>

                <!-- Days of Week Headers -->
                <div class="grid grid-cols-7 gap-1 text-center font-bold text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                    <div>Min</div>
                    <div>Sen</div>
                    <div>Sel</div>
                    <div>Rab</div>
                    <div>Kam</div>
                    <div>Jum</div>
                    <div>Sab</div>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-2">
                    <template x-for="day in calendarDays">
                        <div class="min-h-[90px] p-2 border rounded-xl flex flex-col justify-between transition-all"
                             :class="{
                                 'bg-gray-50/50 dark:bg-gray-900/20 border-gray-50 dark:border-gray-800 text-gray-300 dark:text-gray-600': !day.currentMonth,
                                 'bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700 text-gray-900 dark:text-white': day.currentMonth && !day.isToday,
                                 'bg-pink-50/30 dark:bg-pink-950/10 border-pink-200 dark:border-pink-900/50 text-pink-600 dark:text-pink-400 font-semibold ring-1 ring-pink-400/20': day.isToday,
                                 'hover:shadow-md cursor-pointer': day.currentMonth
                             }"
                             @click="day.currentMonth && selectDay(day)">
                            <div class="flex items-center justify-between">
                                <span class="text-xs" :class="{ 'font-bold': day.isToday }" x-text="day.day"></span>
                                <!-- Booked Indicator Badge -->
                                <template x-if="day.isBooked">
                                    <span class="w-2.5 h-2.5 rounded-full"
                                          :class="{
                                              'bg-amber-500': day.bookingStatus === 'planning',
                                              'bg-sky-500': day.bookingStatus === 'ongoing',
                                              'bg-emerald-500': day.bookingStatus === 'completed'
                                          }"></span>
                                </template>
                            </div>
                            
                            <!-- Display brief project info inside calendar cell on desktop -->
                            <div class="hidden sm:block mt-1 space-y-1">
                                <template x-if="day.isBooked">
                                    <div class="text-[9px] px-1.5 py-0.5 rounded font-medium truncate"
                                         :class="{
                                             'bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30': day.bookingStatus === 'planning',
                                             'bg-sky-50 dark:bg-sky-950/20 text-sky-600 dark:text-sky-400 border border-sky-100 dark:border-sky-900/30': day.bookingStatus === 'ongoing',
                                             'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30': day.bookingStatus === 'completed'
                                         }"
                                         :title="day.bookingProjectName">
                                        <span x-text="day.bookingProjectName"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Booking Details / Info Section (Right) -->
            <div class="space-y-6">
                <!-- Selected Day Detail Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                    <h3 class="font-bold text-gray-900 dark:text-white text-base">Detail Ketersediaan</h3>
                    
                    <div x-show="selectedDay" class="space-y-4">
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Tanggal terpilih: <span class="font-bold text-gray-900 dark:text-white text-sm" x-text="formattedSelectedDate"></span>
                        </div>

                        <template x-if="selectedDay && selectedDay.isBooked">
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] uppercase tracking-wider font-bold"
                                          :class="{
                                              'text-amber-500': selectedDay.bookingStatus === 'planning',
                                              'text-sky-500': selectedDay.bookingStatus === 'ongoing',
                                              'text-emerald-500': selectedDay.bookingStatus === 'completed'
                                          }" x-text="selectedDay.bookingStatus"></span>
                                    
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold"
                                          :class="{
                                              'bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400': selectedDay.bookingStatus === 'planning',
                                              'bg-sky-50 dark:bg-sky-950/30 text-sky-600 dark:text-sky-400': selectedDay.bookingStatus === 'ongoing',
                                              'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400': selectedDay.bookingStatus === 'completed'
                                          }">BOOKED</span>
                                </div>

                                <div class="space-y-1">
                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm" x-text="selectedDay.bookingProjectName"></h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400" x-text="'Mempelai: ' + selectedDay.bookingClientName"></p>
                                </div>

                                <div class="pt-2 border-t border-gray-100 dark:border-gray-700/50">
                                    <a :href="'/wo/projects/' + selectedDay.bookingProjectId" class="text-pink-500 hover:text-pink-600 text-xs font-bold inline-flex items-center gap-1">
                                        <span>Buka Project</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        </template>

                        <template x-if="selectedDay && !selectedDay.isBooked">
                            <div class="p-8 text-center bg-emerald-50/20 dark:bg-emerald-950/10 border border-emerald-100/50 dark:border-emerald-900/30 rounded-xl space-y-2">
                                <div class="text-emerald-500 flex justify-center">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h4 class="font-bold text-emerald-600 dark:text-emerald-400 text-xs">Tersedia (Available)</h4>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500">Belum ada booking terdaftar untuk tanggal ini.</p>
                            </div>
                        </template>
                    </div>

                    <div x-show="!selectedDay" class="p-8 text-center text-gray-400 dark:text-gray-500 text-xs border border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                        Pilih tanggal pada kalender untuk melihat detail ketersediaan.
                    </div>
                </div>

                <!-- Upcoming Bookings List -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                    <h3 class="font-bold text-gray-900 dark:text-white text-base">Booking Terdekat</h3>
                    <div class="space-y-3 max-h-[300px] overflow-y-auto">
                        @forelse($bookings as $booking)
                            <div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700 flex flex-col gap-1 hover:border-gray-200 dark:hover:border-gray-600 transition-colors">
                                <div class="flex items-center justify-between text-[10px] text-gray-400 dark:text-gray-500 font-mono">
                                    <span>{{ \Carbon\Carbon::parse($booking->wedding_date)->translatedFormat('d F Y') }}</span>
                                    <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider"
                                          :class="{
                                              'bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400': '{{ $booking->status }}' === 'planning',
                                              'bg-sky-50 dark:bg-sky-950/30 text-sky-600 dark:text-sky-400': '{{ $booking->status }}' === 'ongoing',
                                              'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400': '{{ $booking->status }}' === 'completed'
                                          }">{{ $booking->status }}</span>
                                </div>
                                <h4 class="font-bold text-gray-800 dark:text-gray-200 text-xs">{{ $booking->name }}</h4>
                                <span class="text-[10px] text-gray-500 dark:text-gray-400">Mempelai: {{ ($booking->client->groom_name ?? '') }} & {{ ($booking->client->bride_name ?? '') }}</span>
                                <a href="{{ route('wo.projects.show', $booking) }}" class="text-[10px] text-pink-500 hover:text-pink-600 font-bold mt-1 inline-flex items-center gap-0.5">
                                    <span>Detail Project</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        @empty
                            <div class="text-center p-6 text-gray-400 dark:text-gray-500 text-xs">
                                Belum ada booking terdekat.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Javascript -->
    <script>
        function calendarApp() {
            const events = @json($events);
            
            return {
                currentMonth: new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                monthNames: [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ],
                calendarDays: [],
                selectedDay: null,
                formattedSelectedDate: '',

                init() {
                    this.generateCalendar();
                },

                generateCalendar() {
                    const firstDayOfMonth = new Date(this.currentYear, this.currentMonth, 1).getDay();
                    const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                    const daysInPrevMonth = new Date(this.currentYear, this.currentMonth, 0).getDate();

                    const days = [];

                    // Prev month padding days
                    for (let i = firstDayOfMonth - 1; i >= 0; i--) {
                        const dayVal = daysInPrevMonth - i;
                        const dateStr = this.formatDateString(this.currentYear, this.currentMonth - 1, dayVal);
                        const event = this.getEventForDate(dateStr);
                        days.push({
                            day: dayVal,
                            currentMonth: false,
                            dateStr: dateStr,
                            isToday: false,
                            isBooked: !!event,
                            bookingStatus: event ? event.status : null,
                            bookingProjectName: event ? event.bookingProjectName || event.project_name : null,
                            bookingClientName: event ? event.client_name : null,
                            bookingProjectId: event ? event.project_id : null
                        });
                    }

                    // Current month days
                    const today = new Date();
                    for (let i = 1; i <= daysInMonth; i++) {
                        const dateStr = this.formatDateString(this.currentYear, this.currentMonth, i);
                        const event = this.getEventForDate(dateStr);
                        const isToday = today.getDate() === i && 
                                        today.getMonth() === this.currentMonth && 
                                        today.getFullYear() === this.currentYear;
                        days.push({
                            day: i,
                            currentMonth: true,
                            dateStr: dateStr,
                            isToday: isToday,
                            isBooked: !!event,
                            bookingStatus: event ? event.status : null,
                            bookingProjectName: event ? event.bookingProjectName || event.project_name : null,
                            bookingClientName: event ? event.client_name : null,
                            bookingProjectId: event ? event.project_id : null
                        });
                    }

                    // Next month padding days
                    const totalDaysAdded = days.length;
                    const remainingDays = totalDaysAdded % 7 === 0 ? 0 : 7 - (totalDaysAdded % 7);
                    for (let i = 1; i <= remainingDays; i++) {
                        const dateStr = this.formatDateString(this.currentYear, this.currentMonth + 1, i);
                        const event = this.getEventForDate(dateStr);
                        days.push({
                            day: i,
                            currentMonth: false,
                            dateStr: dateStr,
                            isToday: false,
                            isBooked: !!event,
                            bookingStatus: event ? event.status : null,
                            bookingProjectName: event ? event.bookingProjectName || event.project_name : null,
                            bookingClientName: event ? event.client_name : null,
                            bookingProjectId: event ? event.project_id : null
                        });
                    }

                    this.calendarDays = days;
                },

                formatDateString(year, month, day) {
                    let d = new Date(year, month, day);
                    let y = d.getFullYear();
                    let m = String(d.getMonth() + 1).padStart(2, '0');
                    let dayStr = String(d.getDate()).padStart(2, '0');
                    return `${y}-${m}-${dayStr}`;
                },

                getEventForDate(dateStr) {
                    return events.find(e => e.date === dateStr);
                },

                prevMonth() {
                    if (this.currentMonth === 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                    this.generateCalendar();
                },

                nextMonth() {
                    if (this.currentMonth === 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                    this.generateCalendar();
                },

                goToday() {
                    const today = new Date();
                    this.currentMonth = today.getMonth();
                    this.currentYear = today.getFullYear();
                    this.generateCalendar();
                    
                    const todayStr = this.formatDateString(this.currentYear, this.currentMonth, today.getDate());
                    const todayObj = this.calendarDays.find(d => d.dateStr === todayStr && d.currentMonth);
                    if (todayObj) {
                        this.selectDay(todayObj);
                    }
                },

                selectDay(day) {
                    this.selectedDay = day;
                    const d = new Date(day.dateStr);
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    this.formattedSelectedDate = d.toLocaleDateString('id-ID', options);
                }
            }
        }
    </script>
</x-wo-layout>
