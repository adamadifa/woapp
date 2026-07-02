<x-wo-layout>
    @php
        $allocatedBudget = $budgetItems->sum('estimated_cost');
        $actualCost = $budgetItems->sum('actual_cost');
        $remainingTarget = $project->total_budget - $allocatedBudget;
        $allocatedPercent = $project->total_budget > 0 ? min(100, round(($allocatedBudget / $project->total_budget) * 100)) : 0;
    @endphp

    <div class="space-y-6" x-data="{ 
        activeTab: '{{ request()->query('tab', 'overview') }}',
        showCreateBudgetModal: false,
        showEditBudgetModal: false,
        budgetEditData: {
            id: '',
            category: '',
            vendor_id: '',
            description: '',
            estimated_cost: '',
            actual_cost: '',
            payment_status: 'unpaid',
            action: ''
        },
        openEditBudgetModal(item, actionUrl) {
            this.budgetEditData.id = item.id;
            this.budgetEditData.category = item.category;
            this.budgetEditData.vendor_id = item.vendor_id || '';
            this.budgetEditData.description = item.description || '';
            this.budgetEditData.estimated_cost = Math.round(item.estimated_cost);
            this.budgetEditData.actual_cost = Math.round(item.actual_cost);
            this.budgetEditData.payment_status = item.payment_status;
            this.budgetEditData.action = actionUrl;
            this.showEditBudgetModal = true;
        },

        // Milestone Modals
        showCreateMilestoneModal: false,
        showEditMilestoneModal: false,
        milestoneEditData: {
            id: '',
            title: '',
            description: '',
            due_date: '',
            status: 'pending',
            order: '0',
            action: ''
        },
        openEditMilestoneModal(milestone, actionUrl) {
            this.milestoneEditData.id = milestone.id;
            this.milestoneEditData.title = milestone.title;
            this.milestoneEditData.description = milestone.description || '';
            this.milestoneEditData.due_date = milestone.due_date;
            this.milestoneEditData.status = milestone.status;
            this.milestoneEditData.order = milestone.order;
            this.milestoneEditData.action = actionUrl;
            this.showEditMilestoneModal = true;
        },

        // Task Modals
        showCreateTaskModal: false,
        showEditTaskModal: false,
        taskEditData: {
            id: '',
            milestone_id: '',
            title: '',
            assigned_to: '',
            status: 'todo',
            due_date: '',
            action: ''
        },
        openEditTaskModal(task, actionUrl) {
            this.taskEditData.id = task.id;
            this.taskEditData.milestone_id = task.milestone_id;
            this.taskEditData.title = task.title;
            this.taskEditData.assigned_to = task.assigned_to || '';
            this.taskEditData.status = task.status;
            this.taskEditData.due_date = task.due_date || '';
            this.taskEditData.action = actionUrl;
            this.showEditTaskModal = true;
        },

        // Guest Modals
        showCreateGuestModal: false,
        showEditGuestModal: false,
        showImportGuestModal: false,
        guestEditData: {
            id: '',
            name: '',
            category: '',
            rsvp_status: 'pending',
            guest_count: 1,
            seat_number: '',
            notes: '',
            action: ''
        },
        openEditGuestModal(guest, actionUrl) {
            this.guestEditData.id = guest.id;
            this.guestEditData.name = guest.name;
            this.guestEditData.category = guest.category;
            this.guestEditData.rsvp_status = guest.rsvp_status;
            this.guestEditData.guest_count = guest.guest_count;
            this.guestEditData.seat_number = guest.seat_number || '';
            this.guestEditData.notes = guest.notes || '';
            this.guestEditData.action = actionUrl;
            this.showEditGuestModal = true;
        },
        searchGuest: '',
        filterCategory: '',
        filterRsvp: '',
        matchGuest(name, category, rsvp) {
            const matchesSearch = !this.searchGuest || name.toLowerCase().includes(this.searchGuest.toLowerCase());
            const matchesCategory = !this.filterCategory || category.toLowerCase() === this.filterCategory.toLowerCase();
            const matchesRsvp = !this.filterRsvp || rsvp === this.filterRsvp;
            return matchesSearch && matchesCategory && matchesRsvp;
        },

        // Rundown Modals & States
        rundownView: 'timeline',
        showCreateRundownModal: false,
        showEditRundownModal: false,
        rundownEditData: {
            id: '',
            time_start: '',
            time_end: '',
            activity: '',
            pic: '',
            notes: '',
            action: ''
        },
        openEditRundownModal(item, actionUrl) {
            this.rundownEditData.id = item.id;
            this.rundownEditData.time_start = item.time_start.substring(0, 5);
            this.rundownEditData.time_end = item.time_end.substring(0, 5);
            this.rundownEditData.activity = item.activity;
            this.rundownEditData.pic = item.pic || '';
            this.rundownEditData.notes = item.notes || '';
            this.rundownEditData.action = actionUrl;
            this.showEditRundownModal = true;
        },

        // Checklist Modals & States
        filterChecklistCategory: '',
        filterChecklistStatus: '',
        searchChecklist: '',
        showCreateChecklistModal: false,
        showEditChecklistModal: false,
        checklistEditData: {
            id: '',
            name: '',
            category: 'Persiapan',
            due_date: '',
            action: ''
        },
        openEditChecklistModal(item, actionUrl) {
            this.checklistEditData.id = item.id;
            this.checklistEditData.name = item.name;
            this.checklistEditData.category = item.category;
            this.checklistEditData.due_date = item.due_date || '';
            this.checklistEditData.action = actionUrl;
            this.showEditChecklistModal = true;
        },
        matchChecklist(name, category, status) {
            const matchesSearch = !this.searchChecklist || name.toLowerCase().includes(this.searchChecklist.toLowerCase());
            const matchesCategory = !this.filterChecklistCategory || category.toLowerCase() === this.filterChecklistCategory.toLowerCase();
            const matchesStatus = !this.filterChecklistStatus || status === this.filterChecklistStatus;
            return matchesSearch && matchesCategory && matchesStatus;
        }
    }">
        <!-- Back Link & Header -->
        <div class="space-y-2">
            <a href="{{ route('wo.projects.index') }}" class="text-xs text-pink-600 dark:text-pink-400 font-bold hover:underline">← Kembali ke Project List</a>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-950 dark:text-white tracking-tight flex items-center gap-3">
                        <span>{{ $project->name }}</span>
                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider 
                            @if($project->status === 'planning') bg-amber-500 text-white
                            @elseif($project->status === 'ongoing') bg-indigo-500 text-white
                            @elseif($project->status === 'completed') bg-emerald-500 text-white
                            @else bg-gray-500 text-white @endif">
                            {{ $project->status }}
                        </span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Wedding Date: {{ date('d M Y', strtotime($project->wedding_date)) }}</p>
                </div>
            </div>
        </div>

        <!-- Session Message Alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-rose-50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-850 text-rose-600 dark:text-rose-450 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Tab Controls Navigation -->
        <div class="border-b border-gray-100 dark:border-gray-700/50 flex flex-wrap gap-1">
            <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'border-pink-500 text-pink-600 dark:text-pink-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 font-bold text-xs border-b-2 -mb-[2px] transition-all">Overview</button>
            <button @click="activeTab = 'budget'" :class="activeTab === 'budget' ? 'border-pink-500 text-pink-600 dark:text-pink-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 font-bold text-xs border-b-2 -mb-[2px] transition-all">Budget Planning & Tracker</button>
            <button @click="activeTab = 'schedule'" :class="activeTab === 'schedule' ? 'border-pink-500 text-pink-600 dark:text-pink-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 font-bold text-xs border-b-2 -mb-[2px] transition-all">Schedule / Timeline</button>
            <button @click="activeTab = 'vendors'" :class="activeTab === 'vendors' ? 'border-pink-500 text-pink-600 dark:text-pink-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 font-bold text-xs border-b-2 -mb-[2px] transition-all">Vendor Hub</button>
            <button @click="activeTab = 'guests'" :class="activeTab === 'guests' ? 'border-pink-500 text-pink-600 dark:text-pink-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 font-bold text-xs border-b-2 -mb-[2px] transition-all">Guest List</button>
            <button @click="activeTab = 'rundown'" :class="activeTab === 'rundown' ? 'border-pink-500 text-pink-600 dark:text-pink-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 font-bold text-xs border-b-2 -mb-[2px] transition-all">Rundown Hari-H</button>
            <button @click="activeTab = 'checklist'" :class="activeTab === 'checklist' ? 'border-pink-500 text-pink-600 dark:text-pink-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 font-bold text-xs border-b-2 -mb-[2px] transition-all">Checklist</button>
            <button @click="activeTab = 'notes'" :class="activeTab === 'notes' ? 'border-pink-500 text-pink-600 dark:text-pink-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="px-4 py-2.5 font-bold text-xs border-b-2 -mb-[2px] transition-all">Notes & Chat</button>
        </div>

        <!-- Tab Contents -->
        <div>
            <!-- Overview Tab -->
            <div x-show="activeTab === 'overview'" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Details & Specs -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Countdown & Date -->
                    <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-6 rounded-2xl shadow-sm text-white flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="text-[9px] uppercase tracking-wider font-extrabold bg-white/20 px-2 py-0.5 rounded-full inline-block">Countdown Wedding</span>
                            @php
                                $daysLeft = (strtotime($project->wedding_date) - time()) / (60 * 60 * 24);
                                $daysLeft = ceil($daysLeft);
                            @endphp
                            <h3 class="text-2xl font-extrabold">
                                @if($daysLeft > 0)
                                    {{ $daysLeft }} Hari Lagi
                                @elseif($daysLeft == 0)
                                    Hari H Pernikahan! 🎉
                                @else
                                    Sudah Lewat ({{ abs($daysLeft) }} hari)
                                @endif
                            </h3>
                            <p class="text-xs opacity-90">Hari pernikahan direncanakan pada tanggal {{ date('d F Y', strtotime($project->wedding_date)) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>

                    <!-- Client Profile -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                        <h3 class="font-bold text-sm text-gray-950 dark:text-white border-b border-gray-50 dark:border-gray-700/50 pb-3">Profil Mempelai (Klien)</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-gray-400 block mb-1">Mempelai Pria</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $project->client->groom_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block mb-1">Mempelai Wanita</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $project->client->bride_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block mb-1">Kontak Telepon</span>
                                <span class="font-mono text-gray-900 dark:text-white">{{ $project->client->phone ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block mb-1">Email Klien</span>
                                <span class="font-mono text-gray-900 dark:text-white">{{ $project->client->user->email ?? '-' }}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-gray-400 block mb-1">Paket Wedding Pilihan</span>
                                <span class="font-bold text-pink-600 dark:text-pink-400 bg-pink-50 dark:bg-pink-950/20 px-2 py-0.5 rounded text-[10px] inline-block uppercase tracking-wider">
                                    {{ $project->client->package->name ?? 'Belum Memilih' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Venue Profile -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                        <h3 class="font-bold text-sm text-gray-950 dark:text-white border-b border-gray-50 dark:border-gray-700/50 pb-3">Lokasi / Venue Acara</h3>
                        @if($project->venue)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-gray-400 block mb-1">Nama Gedung/Venue</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $project->venue->name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 block mb-1">Kapasitas Tamu</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $project->venue->capacity ?? '-' }} Orang</span>
                                </div>
                                <div class="sm:col-span-2">
                                    <span class="text-gray-400 block mb-1">Alamat Venue</span>
                                    <span class="text-gray-900 dark:text-white block">{{ $project->venue->address ?? '-' }}</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6 text-xs text-gray-400">
                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Belum menentukan gedung / lokasi pernikahan.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Stats Summary -->
                <div class="space-y-6">
                    <!-- Budget Summary Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                        <h3 class="font-bold text-sm text-gray-950 dark:text-white border-b border-gray-50 dark:border-gray-700/50 pb-3">Ringkasan Budget</h3>
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-gray-400 block mb-1">Total Target Budget</span>
                                <span class="text-xl font-extrabold text-gray-900 dark:text-white">Rp{{ number_format($totalBudget, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $allocatedPercent >= 100 ? 'bg-red-500' : ($allocatedPercent >= 80 ? 'bg-amber-500' : 'bg-pink-500') }}" style="width: {{ $allocatedPercent }}%"></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] text-gray-400">
                                <span>{{ $allocatedPercent }}% Teralokasi (Rp{{ number_format($allocatedBudget, 0, ',', '.') }})</span>
                                <span>Sisa: Rp{{ number_format(max(0, $remainingTarget), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Milestones / Timeline progress -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                        <h3 class="font-bold text-sm text-gray-950 dark:text-white border-b border-gray-50 dark:border-gray-700/50 pb-3">Tahapan Persiapan</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-400">Total Milestone</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $milestonesCount }} Agenda</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-400">Rundown Hari-H</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $rundownCount }} Kegiatan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Budget Tab -->
            <div x-show="activeTab === 'budget'" class="space-y-6" style="display: none;">
                <!-- Budget Stats Widgets -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Target Budget</span>
                        <span class="text-lg font-extrabold text-gray-900 dark:text-white">Rp{{ number_format($project->total_budget, 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Teralokasi (Estimasi)</span>
                        <span class="text-lg font-extrabold text-pink-600 dark:text-pink-400">Rp{{ number_format($allocatedBudget, 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Realisasi Pengeluaran</span>
                        <span class="text-lg font-extrabold text-emerald-600 dark:text-emerald-400">Rp{{ number_format($actualCost, 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm {{ $remainingTarget < 0 ? 'border-red-200 bg-red-50/20 dark:border-red-950/20' : '' }}">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Sisa Target Budget</span>
                        <span class="text-lg font-extrabold {{ $remainingTarget < 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                            @if($remainingTarget < 0)
                                Over Budget (Rp{{ number_format(abs($remainingTarget), 0, ',', '.') }})
                            @else
                                Rp{{ number_format($remainingTarget, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Budget Items List -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-sm text-gray-950 dark:text-white">Alokasi Rincian Budget</h3>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Kelola alokasi dana per kategori vendor & status pembayaran klien.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('wo.projects.budget.export-pdf', $project) }}" target="_blank" class="flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold py-2 px-3 rounded-lg transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                <span>Export PDF</span>
                            </a>
                            <a href="{{ route('wo.projects.budget.export-excel', $project) }}" class="flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold py-2 px-3 rounded-lg transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Export Excel</span>
                            </a>
                            <button @click="showCreateBudgetModal = true" class="flex items-center gap-1.5 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2 px-3 rounded-lg shadow-sm transition-all">
                                <span>+ Tambah Item</span>
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 dark:bg-gray-700/20 text-gray-400 dark:text-gray-500 font-bold border-b border-gray-100 dark:border-gray-700">
                                    <th class="p-4">Kategori</th>
                                    <th class="p-4">Vendor</th>
                                    <th class="p-4">Deskripsi</th>
                                    <th class="p-4">Estimasi Cost</th>
                                    <th class="p-4">Realisasi Cost</th>
                                    <th class="p-4">Status Bayar</th>
                                    <th class="p-4">Bukti</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                                @forelse($budgetItems as $item)
                                    <tr class="hover:bg-gray-50/40 dark:hover:bg-gray-700/10 transition-colors">
                                        <td class="p-4">
                                            <span class="px-2 py-0.5 rounded bg-pink-50 text-pink-600 dark:bg-pink-950/20 dark:text-pink-400 font-bold text-[10px] uppercase tracking-wider">{{ $item->category }}</span>
                                        </td>
                                        <td class="p-4 text-gray-900 dark:text-white font-bold">{{ $item->vendor->name ?? '-' }}</td>
                                        <td class="p-4 text-gray-400 max-w-xs truncate" title="{{ $item->description }}">{{ $item->description ?? '-' }}</td>
                                        <td class="p-4">Rp{{ number_format($item->estimated_cost, 0, ',', '.') }}</td>
                                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-semibold">Rp{{ number_format($item->actual_cost, 0, ',', '.') }}</td>
                                        <td class="p-4">
                                            <span class="px-2.5 py-0.5 rounded-lg text-[9px] font-bold uppercase tracking-wider
                                                @if($item->payment_status === 'paid') bg-emerald-500 text-white
                                                @elseif($item->payment_status === 'dp') bg-indigo-500 text-white
                                                @else bg-gray-500 text-white @endif">
                                                {{ $item->payment_status }}
                                            </span>
                                        </td>
                                        <td class="p-4">
                                            @if($item->payment_proof)
                                                <a href="{{ asset('storage/' . $item->payment_proof) }}" target="_blank" class="text-pink-600 dark:text-pink-400 font-bold hover:underline text-[10px]">Lihat Bukti</a>
                                            @else
                                                <span class="text-gray-400 text-[10px]">-</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <button @click="openEditBudgetModal({{ json_encode($item) }}, '{{ route('wo.projects.budget-items.update', [$project, $item]) }}')" class="p-1 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-500 dark:text-gray-300 rounded-md transition-colors" title="Edit Budget Item">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <form method="POST" action="{{ route('wo.projects.budget-items.destroy', [$project, $item]) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 bg-red-50 dark:bg-red-950/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-md transition-colors" onclick="return confirm('Apakah anda yakin ingin menghapus budget item ini?')" title="Hapus Budget Item">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="p-8 text-center text-gray-400 dark:text-gray-500">Belum ada rincian item budget yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Schedule Tab (Phase 4.3) -->
            <div x-show="activeTab === 'schedule'" class="space-y-6" style="display: none;">
                <!-- Schedule Controls -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-sm text-gray-950 dark:text-white">Milestones & Jadwal Persiapan</h3>
                        <p class="text-[10px] text-gray-400 mt-0.5">Pantau tahapan pencapaian milestone dan tugas operasional tim.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('wo.projects.milestones.generate', $project) }}" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold py-2 px-3 rounded-lg transition-all" onclick="return confirm('Men-generate dari template akan menyalin seluruh milestones default ke project ini. Lanjutkan?')">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89H18v3.582"/></svg>
                                <span>Generate dari Template</span>
                            </button>
                        </form>
                        <button @click="showCreateMilestoneModal = true" class="flex items-center gap-1.5 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2 px-3 rounded-lg shadow-sm transition-all">
                            <span>+ Milestone Baru</span>
                        </button>
                        <button @click="showCreateTaskModal = true" class="flex items-center gap-1.5 bg-gray-900 hover:bg-gray-850 dark:bg-gray-700 text-white text-xs font-bold py-2 px-3 rounded-lg shadow-sm transition-all">
                            <span>+ Task Baru</span>
                        </button>
                    </div>
                </div>

                <!-- Milestone Stack Lists -->
                <div class="grid grid-cols-1 gap-6">
                    @forelse($milestones as $milestone)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                            <!-- Milestone Header -->
                            <div class="flex items-start justify-between gap-4 border-b border-gray-50 dark:border-gray-700/50 pb-3">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-mono text-[9px]">Order: {{ $milestone->order }}</span>
                                        <h4 class="font-bold text-gray-950 dark:text-white text-sm">{{ $milestone->title }}</h4>
                                    </div>
                                    <p class="text-xs text-gray-400">{{ $milestone->description ?? 'Tidak ada deskripsi.' }}</p>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-0.5 rounded-lg text-[9px] font-bold uppercase tracking-wider
                                        @if($milestone->status === 'done') bg-emerald-500 text-white
                                        @elseif($milestone->status === 'in_progress') bg-indigo-500 text-white
                                        @else bg-gray-500 text-white @endif">
                                        {{ $milestone->status }}
                                    </span>
                                    <span class="text-xs text-gray-400 font-bold">{{ date('d M Y', strtotime($milestone->due_date)) }}</span>
                                    <div class="flex items-center gap-1 shrink-0 border-l border-gray-100 dark:border-gray-700 pl-3">
                                        <button @click="openEditMilestoneModal({{ json_encode($milestone) }}, '{{ route('wo.projects.milestones.update', [$project, $milestone]) }}')" class="p-1 text-gray-400 hover:text-pink-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form method="POST" action="{{ route('wo.projects.milestones.destroy', [$project, $milestone]) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-gray-400 hover:text-red-600 transition-colors" onclick="return confirm('Menghapus milestone akan menghapus seluruh tasks di dalamnya. Lanjutkan?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Tasks List under Milestone -->
                            <div class="space-y-2">
                                <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Daftar Tasks Pekerjaan</span>
                                @forelse($milestone->tasks as $task)
                                    <div class="flex items-center justify-between p-3 bg-gray-50/50 dark:bg-gray-700/20 border border-gray-100 dark:border-gray-700 rounded-xl hover:border-pink-200 transition-all text-xs">
                                        <div class="flex items-center gap-3">
                                            <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider
                                                @if($task->status === 'done') bg-emerald-100 text-emerald-700
                                                @elseif($task->status === 'in_progress') bg-indigo-100 text-indigo-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                {{ $task->status }}
                                            </span>
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $task->title }}</span>
                                            @if($task->due_date)
                                                <span class="text-[10px] text-gray-400">Due: {{ date('d M Y', strtotime($task->due_date)) }}</span>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <span class="text-[10px] font-medium text-pink-600 dark:text-pink-400 bg-pink-50 dark:bg-pink-950/20 px-2 py-0.5 rounded">PIC: {{ $task->assignee->name ?? 'Belum Ditunjuk' }}</span>
                                            <div class="flex items-center gap-1.5">
                                                <button @click="openEditTaskModal({{ json_encode($task) }}, '{{ route('wo.projects.tasks.update', [$project, $task]) }}')" class="p-1 text-gray-400 hover:text-pink-600 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <form method="POST" action="{{ route('wo.projects.tasks.destroy', [$project, $task]) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 text-gray-400 hover:text-red-600 transition-colors" onclick="return confirm('Apakah anda yakin ingin menghapus task ini?')">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-[10px] text-gray-400">Belum ada task ditambahkan.</p>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 text-center space-y-4">
                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <h3 class="font-bold text-gray-900 dark:text-white">Timeline Milestone Masih Kosong</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 max-w-sm mx-auto">Generate timeline milestone secara otomatis menggunakan master template atau buat milestone secara manual.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Vendors Tab Placeholder -->
            <div x-show="activeTab === 'vendors'" class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 text-center space-y-4" style="display: none;">
                <div class="w-12 h-12 rounded-full bg-pink-50 dark:bg-pink-950/20 flex items-center justify-center text-pink-500 mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white">Vendor Hub</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 max-w-sm mx-auto">Daftar vendor yang ditunjuk dan terhubung khusus untuk event pernikahan ini (MUA, Catering, Band, dll.).</p>
                <span class="inline-block bg-pink-100 text-pink-600 dark:bg-pink-950/40 dark:text-pink-400 font-bold px-3 py-1 rounded text-[10px] uppercase tracking-wider">Segera Hadir di Tahap 4.4</span>
            </div>

            <!-- Guests Tab -->
            <div x-show="activeTab === 'guests'" class="space-y-6" style="display: none;">
                <!-- Statistics Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Total Tamu Undangan</span>
                            <span class="text-2xl font-extrabold text-gray-950 dark:text-white mt-1 block">{{ $totalGuestCount }} <span class="text-xs font-normal text-gray-400">Pax</span></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-pink-50 dark:bg-pink-955 flex items-center justify-center text-pink-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Konfirmasi Hadir</span>
                            <span class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1 block">{{ $confirmedGuestCount }} <span class="text-xs font-normal text-gray-400">Pax</span></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-955 flex items-center justify-center text-emerald-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Tidak Hadir</span>
                            <span class="text-2xl font-extrabold text-red-600 dark:text-red-400 mt-1 block">{{ $declinedGuestCount }} <span class="text-xs font-normal text-gray-400">Pax</span></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-red-955 flex items-center justify-center text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Belum Konfirmasi</span>
                            <span class="text-2xl font-extrabold text-amber-500 mt-1 block">{{ $pendingGuestCount }} <span class="text-xs font-normal text-gray-400">Pax</span></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-955 flex items-center justify-center text-amber-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Category Breakdown list -->
                @if($categoryBreakdown && count($categoryBreakdown) > 0)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                        <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-2">Rincian Per Kategori</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($categoryBreakdown as $catName => $catCount)
                                <span class="px-3 py-1 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 text-xs font-medium text-gray-700 dark:text-gray-300">
                                    {{ $catName }}: <strong class="text-pink-500 ml-1">{{ $catCount }} Pax</strong>
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Toolbar & Actions -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Filters Left -->
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative max-w-xs w-full">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" x-model="searchGuest" placeholder="Cari nama tamu..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <select x-model="filterCategory" class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-3 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            <option value="">Semua Kategori</option>
                            @foreach($guests->pluck('category')->unique() as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                            <option value="Keluarga Pria">Keluarga Pria</option>
                            <option value="Keluarga Wanita">Keluarga Wanita</option>
                            <option value="Teman">Teman</option>
                            <option value="Kolega">Kolega</option>
                            <option value="VVIP">VVIP</option>
                        </select>

                        <select x-model="filterRsvp" class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-3 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            <option value="">Semua RSVP</option>
                            <option value="pending">Belum Konfirmasi</option>
                            <option value="confirmed">Hadir</option>
                            <option value="declined">Tidak Hadir</option>
                        </select>
                    </div>

                    <!-- Actions Right -->
                    <div class="flex items-center gap-2">
                        <button @click="showImportGuestModal = true" class="flex items-center gap-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold py-2 px-3.5 rounded-xl transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span>Import CSV</span>
                        </button>
                        <a href="{{ route('wo.projects.guests.export', $project) }}" class="flex items-center gap-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold py-2 px-3.5 rounded-xl transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Export CSV</span>
                        </a>
                        <button @click="showCreateGuestModal = true" class="flex items-center gap-1.5 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2 px-4 rounded-xl shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Tamu</span>
                        </button>
                    </div>
                </div>

                <!-- Guests List Table -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 dark:bg-gray-900/40 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider border-b border-gray-50 dark:border-gray-750">
                                    <th class="py-4 px-6">Nama Tamu</th>
                                    <th class="py-4 px-6">Kategori</th>
                                    <th class="py-4 px-6 text-center">RSVP Status</th>
                                    <th class="py-4 px-6 text-center">Jumlah Tamu</th>
                                    <th class="py-4 px-6">No Kursi</th>
                                    <th class="py-4 px-6">Catatan</th>
                                    <th class="py-4 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-750 text-xs">
                                @forelse($guests as $guest)
                                    <tr x-show="matchGuest('{{ addslashes($guest->name) }}', '{{ addslashes($guest->category) }}', '{{ $guest->rsvp_status }}')" class="hover:bg-gray-50/30 dark:hover:bg-gray-900/10 transition-colors text-gray-700 dark:text-gray-300">
                                        <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">{{ $guest->name }}</td>
                                        <td class="py-4 px-6">
                                            <span class="px-2 py-0.5 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] font-medium border border-gray-100 dark:border-gray-600">
                                                {{ $guest->category }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($guest->rsvp_status === 'confirmed')
                                                <span class="px-2 py-0.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold border border-emerald-100 dark:border-emerald-900/30">Hadir</span>
                                            @elseif($guest->rsvp_status === 'declined')
                                                <span class="px-2 py-0.5 rounded-lg bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 text-[10px] font-bold border border-red-100 dark:border-red-900/30">Tidak Hadir</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-lg bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 text-[10px] font-bold border border-amber-100 dark:border-amber-900/30">Belum Konfirmasi</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center font-semibold">{{ $guest->guest_count }} Pax</td>
                                        <td class="py-4 px-6 font-mono text-[11px]">{{ $guest->seat_number ?? '-' }}</td>
                                        <td class="py-4 px-6 max-w-[200px] truncate text-gray-400 dark:text-gray-500" title="{{ $guest->notes }}">{{ $guest->notes ?? '-' }}</td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <button @click="openEditGuestModal({{ json_encode($guest) }}, '{{ route('wo.projects.guests.update', [$project, $guest]) }}')" class="p-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 rounded-lg transition-colors" title="Edit Tamu">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <form method="POST" action="{{ route('wo.projects.guests.destroy', [$project, $guest]) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus tamu ini?')" title="Hapus Tamu">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-gray-500 dark:text-gray-400">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-650 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Daftar Tamu Masih Kosong</p>
                                            <p class="text-xs text-gray-400 mt-1">Tambah tamu undangan secara manual atau lakukan import dari file CSV.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rundown Tab -->
            <div x-show="activeTab === 'rundown'" class="space-y-6" style="display: none;">
                <!-- Toolbar & Actions -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Toggle View Left -->
                    <div class="flex items-center gap-2">
                        <button @click="rundownView = 'timeline'" :class="rundownView === 'timeline' ? 'bg-pink-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm">
                            Visual Timeline
                        </button>
                        <button @click="rundownView = 'table'" :class="rundownView === 'table' ? 'bg-pink-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm">
                            Daftar Tabel
                        </button>
                    </div>

                    <!-- Actions Right -->
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('wo.projects.rundown.generate', $project) }}" class="inline" onsubmit="return confirm('Menerapkan template akan menghapus rundown saat ini. Apakah Anda yakin?')">
                            @csrf
                            <button type="submit" class="flex items-center gap-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold py-2 px-3.5 rounded-xl transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                <span>Terapkan Template</span>
                            </button>
                        </form>
                        <a href="{{ route('wo.projects.rundown.print', $project) }}" target="_blank" class="flex items-center gap-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold py-2 px-3.5 rounded-xl transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>Cetak Rundown</span>
                        </a>
                        <button @click="showCreateRundownModal = true" class="flex items-center gap-1.5 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2 px-4 rounded-xl shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Aktivitas</span>
                        </button>
                    </div>
                </div>

                <!-- Visual Timeline View -->
                <div x-show="rundownView === 'timeline'" class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="relative border-l-2 border-gray-150 dark:border-gray-700 ml-4 md:ml-32 space-y-8 py-4">
                        @forelse($rundownItems as $item)
                            <div class="relative">
                                <!-- Dot indicator -->
                                <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-pink-500 border-4 border-white dark:border-gray-800 shadow"></div>
                                
                                <!-- Time display on desktop (shifts left of timeline) -->
                                <div class="hidden md:block absolute -left-32 top-1 text-right w-24">
                                    <span class="font-bold text-gray-900 dark:text-white font-mono text-sm block">
                                        {{ date('H:i', strtotime($item->time_start)) }}
                                    </span>
                                    <span class="text-[10px] text-gray-400 font-mono block">
                                        s/d {{ date('H:i', strtotime($item->time_end)) }}
                                    </span>
                                </div>

                                <!-- Content Card -->
                                <div class="ml-6 bg-gray-50 dark:bg-gray-900/30 p-4 rounded-xl border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                                    <div class="space-y-1">
                                        <!-- Time display on mobile -->
                                        <div class="md:hidden flex items-center gap-1 text-[11px] font-bold text-gray-450 font-mono mb-1">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>{{ date('H:i', strtotime($item->time_start)) }} - {{ date('H:i', strtotime($item->time_end)) }}</span>
                                        </div>

                                        <h4 class="font-bold text-gray-900 dark:text-white text-sm">{{ $item->activity }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->notes ?? 'Tidak ada catatan tambahan.' }}</p>
                                    </div>

                                    <div class="flex items-center justify-between md:justify-end gap-3 shrink-0 pt-2 md:pt-0 border-t border-dashed border-gray-100 dark:border-gray-750 md:border-none">
                                        @if($item->pic)
                                            <span class="px-2 py-0.5 rounded-lg bg-pink-50 dark:bg-pink-950/20 text-pink-600 dark:text-pink-400 text-[10px] font-bold border border-pink-100 dark:border-pink-900/30">
                                                PIC: {{ $item->pic }}
                                            </span>
                                        @else
                                            <span class="text-[10px] text-gray-400">Tanpa PIC</span>
                                        @endif

                                        <div class="flex items-center gap-1">
                                            <button @click="openEditRundownModal({{ json_encode($item) }}, '{{ route('wo.projects.rundown.update', [$project, $item]) }}')" class="p-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded text-gray-500 dark:text-gray-400 transition-colors" title="Edit Aktivitas">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <form method="POST" action="{{ route('wo.projects.rundown.destroy', [$project, $item]) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 hover:bg-red-100 dark:hover:bg-red-950/30 rounded text-red-500 transition-colors" onclick="return confirm('Hapus aktivitas ini dari rundown?')" title="Hapus Aktivitas">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Belum Ada Rundown Acara</p>
                                <p class="text-xs text-gray-400 mt-1">Gunakan template standard atau tambahkan aktivitas manual untuk merancang susunan acara.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Table View -->
                <div x-show="rundownView === 'table'" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden" style="display: none;">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 dark:bg-gray-900/40 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider border-b border-gray-50 dark:border-gray-750">
                                    <th class="py-4 px-6" style="width: 150px;">Waktu</th>
                                    <th class="py-4 px-6">Aktivitas / Acara</th>
                                    <th class="py-4 px-6">PIC</th>
                                    <th class="py-4 px-6">Catatan / Perlengkapan</th>
                                    <th class="py-4 px-6 text-right" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-750 text-xs">
                                @forelse($rundownItems as $item)
                                    <tr class="hover:bg-gray-50/30 dark:hover:bg-gray-900/10 transition-colors text-gray-700 dark:text-gray-300">
                                        <td class="py-4 px-6 font-bold text-gray-900 dark:text-white font-mono text-[13px]">
                                            {{ date('H:i', strtotime($item->time_start)) }} - {{ date('H:i', strtotime($item->time_end)) }}
                                        </td>
                                        <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">{{ $item->activity }}</td>
                                        <td class="py-4 px-6">
                                            @if($item->pic)
                                                <span class="px-2 py-0.5 rounded-lg bg-pink-50 dark:bg-pink-955 text-pink-600 dark:text-pink-400 text-[10px] font-bold border border-pink-100 dark:border-pink-900/30">
                                                    {{ $item->pic }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 max-w-[300px] truncate text-gray-400 dark:text-gray-500" title="{{ $item->notes }}">{{ $item->notes ?? '-' }}</td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <button @click="openEditRundownModal({{ json_encode($item) }}, '{{ route('wo.projects.rundown.update', [$project, $item]) }}')" class="p-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 rounded-lg transition-colors" title="Edit Aktivitas">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <form method="POST" action="{{ route('wo.projects.rundown.destroy', [$project, $item]) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors" onclick="return confirm('Hapus aktivitas ini dari rundown?')" title="Hapus Aktivitas">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-500 dark:text-gray-400">
                                            Belum ada aktivitas rundown terdaftar untuk event ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>

            <!-- Checklist Tab -->
            <div x-show="activeTab === 'checklist'" class="space-y-6" style="display: none;">
                <!-- Statistics & Progress Bars -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Overall Progress Card -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white text-base">Progress Keseluruhan</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Persentase penyelesaian seluruh checklist persiapan pernikahan.</p>
                            </div>
                            <span class="text-2xl font-extrabold text-pink-500 font-mono">{{ $checklistPercent }}%</span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-2">
                            <div class="w-full bg-gray-100 dark:bg-gray-700 h-3 rounded-full overflow-hidden">
                                <div class="bg-pink-500 h-full rounded-full transition-all duration-500" style="width: {{ $checklistPercent }}%"></div>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-gray-450">
                                <span>{{ $doneChecklistCount }} Selesai</span>
                                <span>{{ $todoChecklistCount }} Belum Selesai</span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress per Kategori Card -->
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                        <h3 class="font-bold text-gray-900 dark:text-white text-base">Progress per Kategori</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($checklistCategories as $catName => $catData)
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $catName }}</span>
                                        <span class="font-mono text-gray-900 dark:text-white font-bold">{{ $catData['percent'] }}% <span class="text-[10px] font-normal text-gray-400">({{ $catData['done'] }}/{{ $catData['total'] }})</span></span>
                                    </div>
                                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                        <div class="bg-indigo-500 h-full rounded-full transition-all duration-500" style="width: {{ $catData['percent'] }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 col-span-2">Belum ada kategori terdaftar.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Toolbar & Actions -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Filters Left -->
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative max-w-xs w-full">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" x-model="searchChecklist" placeholder="Cari nama checklist..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <select x-model="filterChecklistCategory" class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-3 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            <option value="">Semua Kategori</option>
                            @foreach($checklists->pluck('category')->unique() as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                            <option value="Dokumen">Dokumen</option>
                            <option value="Pembayaran">Pembayaran</option>
                            <option value="Persiapan">Persiapan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>

                        <select x-model="filterChecklistStatus" class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-3 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            <option value="">Semua Status</option>
                            <option value="todo">Belum Selesai (Todo)</option>
                            <option value="done">Selesai (Done)</option>
                        </select>
                    </div>

                    <!-- Actions Right -->
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('wo.projects.checklists.generate', $project) }}" class="inline" onsubmit="return confirm('Menerapkan template akan menghapus checklist saat ini. Apakah Anda yakin?')">
                            @csrf
                            <button type="submit" class="flex items-center gap-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold py-2 px-3.5 rounded-xl transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                <span>Terapkan Template</span>
                            </button>
                        </form>
                        <button @click="showCreateChecklistModal = true" class="flex items-center gap-1.5 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2 px-4 rounded-xl shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Item</span>
                        </button>
                    </div>
                </div>

                <!-- Checklist Items Grid/List -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden divide-y divide-gray-50 dark:divide-gray-750">
                    @forelse($checklists as $item)
                        <div x-show="matchChecklist('{{ addslashes($item->name) }}', '{{ addslashes($item->category) }}', '{{ $item->status }}')" 
                             class="p-4 flex items-center justify-between gap-4 hover:bg-gray-50/40 dark:hover:bg-gray-900/10 transition-colors"
                             :class="{ 'opacity-60': '{{ $item->status }}' === 'done' }">
                            
                            <div class="flex items-center gap-3 w-full">
                                <!-- Checkbox Form Toggle -->
                                <form method="POST" action="{{ route('wo.projects.checklists.toggle', [$project, $item]) }}" class="inline shrink-0">
                                    @csrf
                                    @method('PATCH')
                                    <input type="checkbox" onchange="this.form.submit()" {{ $item->status === 'done' ? 'checked' : '' }} 
                                           class="w-4 h-4 text-pink-500 border-gray-300 dark:border-gray-700 rounded focus:ring-pink-500 dark:bg-gray-900 cursor-pointer">
                                </form>

                                <div class="space-y-0.5 w-full">
                                    <span class="font-semibold text-gray-900 dark:text-white text-xs md:text-sm block {{ $item->status === 'done' ? 'line-through text-gray-400 dark:text-gray-500' : '' }}">
                                        {{ $item->name }}
                                    </span>
                                    
                                    <div class="flex flex-wrap items-center gap-2 text-[10px]">
                                        <span class="px-2 py-0.5 rounded bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            {{ $item->category }}
                                        </span>

                                        @if($item->due_date)
                                            @php
                                                $dueDate = \Carbon\Carbon::parse($item->due_date);
                                                $isOverdue = $dueDate->isPast() && $item->status === 'todo';
                                            @endphp
                                            <span class="flex items-center gap-1 font-medium {{ $isOverdue ? 'text-red-500 font-bold' : 'text-gray-400' }}">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <span>Batas: {{ $dueDate->translatedFormat('d M Y') }} {{ $isOverdue ? '(Terlambat)' : '' }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-1 shrink-0">
                                <button @click="openEditChecklistModal({{ json_encode($item) }}, '{{ route('wo.projects.checklists.update', [$project, $item]) }}')" class="p-1.5 bg-gray-150 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-650 dark:text-gray-300 rounded-lg transition-colors" title="Edit Item">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form method="POST" action="{{ route('wo.projects.checklists.destroy', [$project, $item]) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-955/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus item checklist ini?')" title="Hapus Item">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-650 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Belum Ada Item Checklist</p>
                            <p class="text-xs text-gray-400 mt-1">Gunakan template standard atau tambahkan item persiapan manual.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Notes & Chat Tab -->
            <div x-show="activeTab === 'notes'" class="space-y-6" style="display: none;">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left: Message Stream List -->
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col h-[500px]">
                        <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-900/10">
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm">Riwayat Komunikasi Klien</h3>
                        </div>

                        <!-- Notes Stream -->
                        <div class="flex-1 overflow-y-auto p-6 space-y-4">
                            @forelse($clientNotes as $note)
                                @php
                                    $isMe = $note->user_id === auth()->id();
                                @endphp
                                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[80%] space-y-1">
                                        <!-- Sender details -->
                                        <span class="text-[10px] text-gray-400 block {{ $isMe ? 'text-right' : 'text-left' }}">
                                            {{ $note->user->name }} ({{ strtoupper($note->user->role) }}) • {{ $note->created_at->format('d M H:i') }}
                                        </span>
                                        
                                        <!-- Message bubble -->
                                        <div class="p-3.5 rounded-2xl text-xs shadow-sm 
                                            {{ $isMe ? 'bg-pink-600 text-white rounded-tr-none' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-tl-none' }}">
                                            <p class="leading-relaxed whitespace-pre-wrap">{{ $note->message }}</p>

                                            <!-- Attached Reference File -->
                                            @if($note->file_path)
                                                <div class="mt-2.5 pt-2.5 border-t {{ $isMe ? 'border-pink-500' : 'border-gray-200 dark:border-gray-600' }} flex items-center justify-between gap-4">
                                                    <div class="flex items-center gap-1.5 min-w-0">
                                                        <svg class="w-4 h-4 shrink-0 {{ $isMe ? 'text-pink-200' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                                        <span class="truncate block font-bold text-[10px] {{ $isMe ? 'text-pink-100' : 'text-gray-500' }}">{{ $note->file_name ?? 'Attachment' }}</span>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $note->file_path) }}" target="_blank" class="shrink-0 text-[10px] font-bold underline {{ $isMe ? 'text-white hover:text-pink-200' : 'text-pink-600 dark:text-pink-400' }}">Unduh</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-20 text-gray-400 text-xs">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-650 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    Belum ada pesan/catatan komunikasi dari Klien.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Right: Send New Note Form -->
                    <div class="lg:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm h-fit space-y-4">
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm border-b border-gray-50 dark:border-gray-700/50 pb-3">Kirim Tanggapan ke Klien</h3>
                        
                        <form method="POST" action="{{ route('wo.projects.notes.store', $project) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Pesan / Catatan</label>
                                <textarea name="message" required placeholder="Ketik pesan tanggapan, update dokumen, kontrak vendor, detail catering..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-32 resize-none"></textarea>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-550 uppercase tracking-wider block mb-1.5">File Lampiran (Opsional)</label>
                                <input type="file" name="reference_file" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                <p class="text-[9px] text-gray-400 mt-1">Format didukung: Gambar, PDF, Dokumen (Max 5MB).</p>
                            </div>

                            <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Kirim Balasan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Budget Item Modal -->
        <div x-show="showCreateBudgetModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showCreateBudgetModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Rincian Budget</h3>
                        <button @click="showCreateBudgetModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.projects.budget-items.store', $project) }}" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Kategori</label>
                                <select name="category" required class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Vendor Ditunjuk</label>
                                <select name="vendor_id" class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Vendor (Opsional)</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }} ({{ $vendor->category }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Estimasi Biaya (Rp)</label>
                                <input type="number" name="estimated_cost" required placeholder="Contoh: 15000000" class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Realisasi Biaya (Rp)</label>
                                <input type="number" name="actual_cost" required placeholder="Contoh: 14500000" class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div class="col-span-2">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status Pembayaran</label>
                                <select name="payment_status" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="unpaid">Belum Bayar (Unpaid)</option>
                                    <option value="dp">Uang Muka (DP)</option>
                                    <option value="paid">Lunas (Paid)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Catatan / Deskripsi Rincian</label>
                            <input type="text" name="description" placeholder="Contoh: Tambahan menu gubug, DP 30%..." class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Bukti Transfer (Max 2MB)</label>
                            <input type="file" name="payment_proof" class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showCreateBudgetModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Simpan Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Budget Item Modal -->
        <div x-show="showEditBudgetModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showEditBudgetModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Rincian Budget</h3>
                        <button @click="showEditBudgetModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="budgetEditData.action" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Kategori</label>
                                <select name="category" x-model="budgetEditData.category" required class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Vendor Ditunjuk</label>
                                <select name="vendor_id" x-model="budgetEditData.vendor_id" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Vendor (Opsional)</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }} ({{ $vendor->category }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Estimasi Biaya (Rp)</label>
                                <input type="number" name="estimated_cost" x-model="budgetEditData.estimated_cost" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Realisasi Biaya (Rp)</label>
                                <input type="number" name="actual_cost" x-model="budgetEditData.actual_cost" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div class="col-span-2">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status Pembayaran</label>
                                <select name="payment_status" x-model="budgetEditData.payment_status" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="unpaid">Belum Bayar (Unpaid)</option>
                                    <option value="dp">Uang Muka (DP)</option>
                                    <option value="paid">Lunas (Paid)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Catatan / Deskripsi Rincian</label>
                            <input type="text" name="description" x-model="budgetEditData.description" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Bukti Transfer (Biarkan kosong jika tidak diubah, Max 2MB)</label>
                            <input type="file" name="payment_proof" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showEditBudgetModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Perbarui Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Create Milestone Modal -->
        <div x-show="showCreateMilestoneModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showCreateMilestoneModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Milestone Baru</h3>
                        <button @click="showCreateMilestoneModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.projects.milestones.store', $project) }}" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Judul Milestone</label>
                            <input type="text" name="title" required placeholder="Contoh: Booking Catering" class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Deskripsi Singkat</label>
                            <textarea name="description" placeholder="Tulis catatan opsional..." class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-20 resize-none"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Batas Tanggal (Due Date)</label>
                                <input type="date" name="due_date" required class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Order Tampilan</label>
                                <input type="number" name="order" value="0" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status Persiapan</label>
                            <select name="status" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                <option value="pending">Pending (Belum Dimulai)</option>
                                <option value="in_progress">In Progress (Sedang Berjalan)</option>
                                <option value="done">Done (Selesai)</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showCreateMilestoneModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Simpan Milestone
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Milestone Modal -->
        <div x-show="showEditMilestoneModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showEditMilestoneModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Milestone</h3>
                        <button @click="showEditMilestoneModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="milestoneEditData.action" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Judul Milestone</label>
                            <input type="text" name="title" x-model="milestoneEditData.title" required class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Deskripsi Singkat</label>
                            <textarea name="description" x-model="milestoneEditData.description" class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-20 resize-none"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Batas Tanggal (Due Date)</label>
                                <input type="date" name="due_date" x-model="milestoneEditData.due_date" required class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Order Tampilan</label>
                                <input type="number" name="order" x-model="milestoneEditData.order" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status Persiapan</label>
                            <select name="status" x-model="milestoneEditData.status" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                <option value="pending">Pending (Belum Dimulai)</option>
                                <option value="in_progress">In Progress (Sedang Berjalan)</option>
                                <option value="done">Done (Selesai)</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showEditMilestoneModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Perbarui Milestone
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Create Task Modal -->
        <div x-show="showCreateTaskModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showCreateTaskModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Task Pekerjaan</h3>
                        <button @click="showCreateTaskModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.projects.tasks.store', $project) }}" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Pilih Milestone Induk</label>
                            <select name="milestone_id" required class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                <option value="">Hubungkan ke Milestone</option>
                                @foreach($milestones as $milestone)
                                    <option value="{{ $milestone->id }}">{{ $milestone->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Judul Task</label>
                            <input type="text" name="title" required placeholder="Contoh: Mengirim daftar menu ke mempelai" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">PIC / Anggota Tim</label>
                                <select name="assigned_to" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Anggota Tim</option>
                                    @foreach($teamMembers as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->sub_role ?? 'WO Owner' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Batas Tanggal (Due Date)</label>
                                <input type="date" name="due_date" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status Pekerjaan</label>
                            <select name="status" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                <option value="todo">Belum Dimulai (Todo)</option>
                                <option value="in_progress">Dalam Proses (In Progress)</option>
                                <option value="done">Selesai (Done)</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showCreateTaskModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Simpan Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Task Modal -->
        <div x-show="showEditTaskModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showEditTaskModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Task</h3>
                        <button @click="showEditTaskModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="taskEditData.action" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Pilih Milestone Induk</label>
                            <select name="milestone_id" x-model="taskEditData.milestone_id" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                <option value="">Hubungkan ke Milestone</option>
                                @foreach($milestones as $milestone)
                                    <option value="{{ $milestone->id }}">{{ $milestone->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Judul Task</label>
                            <input type="text" name="title" x-model="taskEditData.title" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">PIC / Anggota Tim</label>
                                <select name="assigned_to" x-model="taskEditData.assigned_to" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Anggota Tim</option>
                                    @foreach($teamMembers as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->sub_role ?? 'WO Owner' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Batas Tanggal (Due Date)</label>
                                <input type="date" name="due_date" x-model="taskEditData.due_date" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status Pekerjaan</label>
                            <select name="status" x-model="taskEditData.status" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                <option value="todo">Belum Dimulai (Todo)</option>
                                <option value="in_progress">Dalam Proses (In Progress)</option>
                                <option value="done">Selesai (Done)</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showEditTaskModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Perbarui Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Create Guest Modal -->
        <div x-show="showCreateGuestModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showCreateGuestModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Tamu Undangan</h3>
                        <button @click="showCreateGuestModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.projects.guests.store', $project) }}" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Tamu</label>
                            <input type="text" name="name" required placeholder="Contoh: Bpk. Ahmad Heryawan" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Kategori</label>
                                <select name="category" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="Umum">Umum (Default)</option>
                                    <option value="Keluarga Pria">Keluarga Pria</option>
                                    <option value="Keluarga Wanita">Keluarga Wanita</option>
                                    <option value="Teman">Teman</option>
                                    <option value="Kolega">Kolega</option>
                                    <option value="VVIP">VVIP</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Jumlah Pax</label>
                                <input type="number" name="guest_count" required value="1" min="1" class="w-full bg-gray-55 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status RSVP</label>
                                <select name="rsvp_status" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="pending">Belum Konfirmasi</option>
                                    <option value="confirmed">Hadir</option>
                                    <option value="declined">Tidak Hadir</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nomor Kursi / Meja</label>
                                <input type="text" name="seat_number" placeholder="Contoh: A-12 atau VIP-3" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Catatan / Alamat</label>
                            <textarea name="notes" placeholder="Catatan tambahan seperti diet khusus, rekanan, dll..." class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-20 resize-none"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showCreateGuestModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Simpan Tamu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Guest Modal -->
        <div x-show="showEditGuestModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showEditGuestModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Tamu Undangan</h3>
                        <button @click="showEditGuestModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="guestEditData.action" class="p-6 space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Tamu</label>
                            <input type="text" name="name" x-model="guestEditData.name" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Kategori</label>
                                <select name="category" x-model="guestEditData.category" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="Umum">Umum</option>
                                    <option value="Keluarga Pria">Keluarga Pria</option>
                                    <option value="Keluarga Wanita">Keluarga Wanita</option>
                                    <option value="Teman">Teman</option>
                                    <option value="Kolega">Kolega</option>
                                    <option value="VVIP">VVIP</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Jumlah Pax</label>
                                <input type="number" name="guest_count" x-model="guestEditData.guest_count" required min="1" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status RSVP</label>
                                <select name="rsvp_status" x-model="guestEditData.rsvp_status" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="pending">Belum Konfirmasi</option>
                                    <option value="confirmed">Hadir</option>
                                    <option value="declined">Tidak Hadir</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nomor Kursi / Meja</label>
                                <input type="text" name="seat_number" x-model="guestEditData.seat_number" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Catatan / Alamat</label>
                            <textarea name="notes" x-model="guestEditData.notes" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-20 resize-none"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showEditGuestModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Perbarui Tamu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import Guest Modal -->
        <div x-show="showImportGuestModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showImportGuestModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Import Daftar Tamu (CSV)</h3>
                        <button @click="showImportGuestModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.projects.guests.import', $project) }}" enctype="multipart/form-data" class="p-6 space-y-4">
                        @csrf
                        <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 space-y-2 text-xs text-gray-600 dark:text-gray-400">
                            <span class="font-bold text-gray-900 dark:text-white block">Petunjuk Format File:</span>
                            <p>Unggah berkas CSV Anda dengan baris header kolom sebagai berikut:</p>
                            <code class="block bg-white dark:bg-gray-950 p-2 rounded border border-gray-100 dark:border-gray-800 font-mono text-[10px] text-pink-600 overflow-x-auto">
                                Nama, Kategori, RSVP Status, Jumlah Tamu, Nomor Kursi, Catatan
                            </code>
                            <p class="text-[10px]">Pemisah kolom yang didukung: koma (<code>,</code>) atau titik koma (<code>;</code>).</p>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Pilih File CSV</label>
                            <input type="file" name="csv_file" required accept=".csv,.txt" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showImportGuestModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Upload & Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Create Rundown Modal -->
        <div x-show="showCreateRundownModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showCreateRundownModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Rundown Acara</h3>
                        <button @click="showCreateRundownModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.projects.rundown.store', $project) }}" class="p-6 space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Waktu Mulai</label>
                                <input type="time" name="time_start" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Waktu Selesai</label>
                                <input type="time" name="time_end" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Aktivitas / Acara</label>
                            <input type="text" name="activity" required placeholder="Contoh: Kirab Pengantin Masuk" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">PIC (Penanggung Jawab)</label>
                            <input type="text" name="pic" placeholder="Contoh: Sarah (WO Team) atau MC" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Catatan / Perlengkapan</label>
                            <textarea name="notes" placeholder="Tuliskan perlengkapan penunjang, catatan MUA, catering, musik, dll..." class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-20 resize-none"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showCreateRundownModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Simpan Aktivitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Rundown Modal -->
        <div x-show="showEditRundownModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showEditRundownModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Rundown Acara</h3>
                        <button @click="showEditRundownModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="rundownEditData.action" class="p-6 space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Waktu Mulai</label>
                                <input type="time" name="time_start" x-model="rundownEditData.time_start" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Waktu Selesai</label>
                                <input type="time" name="time_end" x-model="rundownEditData.time_end" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Aktivitas / Acara</label>
                            <input type="text" name="activity" x-model="rundownEditData.activity" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">PIC (Penanggung Jawab)</label>
                            <input type="text" name="pic" x-model="rundownEditData.pic" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Catatan / Perlengkapan</label>
                            <textarea name="notes" x-model="rundownEditData.notes" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-20 resize-none"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showEditRundownModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Perbarui Aktivitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Create Checklist Modal -->
        <div x-show="showCreateChecklistModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showCreateChecklistModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Item Checklist</h3>
                        <button @click="showCreateChecklistModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.projects.checklists.store', $project) }}" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Persiapan / Kegiatan</label>
                            <input type="text" name="name" required placeholder="Contoh: Mengurus KTP & KK ke KUA" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Kategori</label>
                                <select name="category" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="Persiapan">Persiapan (Default)</option>
                                    <option value="Dokumen">Dokumen</option>
                                    <option value="Pembayaran">Pembayaran</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Batas Tanggal (Due Date)</label>
                                <input type="date" name="due_date" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showCreateChecklistModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Simpan Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Checklist Modal -->
        <div x-show="showEditChecklistModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showEditChecklistModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Item Checklist</h3>
                        <button @click="showEditChecklistModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="checklistEditData.action" class="p-6 space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Persiapan / Kegiatan</label>
                            <input type="text" name="name" x-model="checklistEditData.name" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Kategori</label>
                                <select name="category" x-model="checklistEditData.category" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="Persiapan">Persiapan</option>
                                    <option value="Dokumen">Dokumen</option>
                                    <option value="Pembayaran">Pembayaran</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Batas Tanggal (Due Date)</label>
                                <input type="date" name="due_date" x-model="checklistEditData.due_date" class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showEditChecklistModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Perbarui Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-wo-layout>
