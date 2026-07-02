<x-wo-layout>
    @php
        $allocatedBudget = $budgetItems->sum('estimated_cost');
        $actualCost = $budgetItems->sum('actual_cost');
        $remainingTarget = $project->total_budget - $allocatedBudget;
        $allocatedPercent = $project->total_budget > 0 ? min(100, round(($allocatedBudget / $project->total_budget) * 100)) : 0;
    @endphp

    <div class="space-y-6" x-data="{ 
        activeTab: 'overview',
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

            <!-- Guests Tab Placeholder -->
            <div x-show="activeTab === 'guests'" class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 text-center space-y-4" style="display: none;">
                <div class="w-12 h-12 rounded-full bg-pink-50 dark:bg-pink-950/20 flex items-center justify-center text-pink-500 mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white">Guest List</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 max-w-sm mx-auto">Manajemen tamu undangan, status kehadiran (RSPV), dan generator QR Code/e-Invitation untuk check-in penerima tamu.</p>
                <span class="inline-block bg-pink-100 text-pink-600 dark:bg-pink-950/40 dark:text-pink-400 font-bold px-3 py-1 rounded text-[10px] uppercase tracking-wider">Segera Hadir di Tahap 4.5</span>
            </div>

            <!-- Rundown Tab Placeholder -->
            <div x-show="activeTab === 'rundown'" class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 text-center space-y-4" style="display: none;">
                <div class="w-12 h-12 rounded-full bg-pink-50 dark:bg-pink-950/20 flex items-center justify-center text-pink-500 mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white">Rundown & Susunan Acara</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 max-w-sm mx-auto">Penyusunan detail rundown per menit, nama penanggung jawab (PIC) per acara, dan catatan perlengkapan penunjang acara.</p>
                <span class="inline-block bg-pink-100 text-pink-600 dark:bg-pink-950/40 dark:text-pink-400 font-bold px-3 py-1 rounded text-[10px] uppercase tracking-wider">Segera Hadir di Tahap 4.6</span>
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
    </div>
</x-wo-layout>
