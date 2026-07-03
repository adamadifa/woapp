<x-admin-layout>
    <div class="space-y-6">
        <!-- Top Title Row -->
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                <span class="px-3 py-1.5 bg-white dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 flex items-center gap-1.5 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Live Platform Status
                </span>
            </div>
        </div>

        <!-- 4 Stats Cards (Design 2 Layout with Pink Accent) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Revenue -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-emerald-500 font-semibold mt-1.5 flex items-center gap-0.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        Live <span class="text-gray-400 font-normal">active subscriptions total</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 text-amber-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <!-- Total WO Registered -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Wedding Organizers</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalWo }}</h3>
                    <p class="text-[11px] text-emerald-500 font-semibold mt-1.5 flex items-center gap-0.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        Live <span class="text-gray-400 font-normal">registered tenant accounts</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-900/20 text-rose-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>

            <!-- Total Customers / Clients -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Customers</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalClients }}</h3>
                    <p class="text-[11px] text-emerald-500 font-semibold mt-1.5 flex items-center gap-0.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        Live <span class="text-gray-400 font-normal">active bridal couple clients</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-900/20 text-teal-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>

            <!-- Active Projects -->
            <div class="bg-rose-500 p-6 rounded-2xl shadow-lg shadow-rose-100 dark:shadow-none text-white flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-rose-100 uppercase tracking-wider">Active Projects</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $totalProjects }}</h3>
                    <div class="flex items-center gap-3 mt-2 text-[10px] text-rose-100 font-semibold">
                        <span>Total Active: <strong>{{ $totalProjects }}</strong></span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-400 text-white flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 00-2 2H7m12 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
        </div>

        <!-- Charts Section (Real Chart.js Integration) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Chart Card (Revenue Trend - Line Chart) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Revenue Trend (Last 6 Months)</h4>
                    <span class="text-xs text-rose-500 font-bold bg-rose-50 dark:bg-rose-950/20 px-2.5 py-1 rounded-lg">IDR / Month</span>
                </div>
                <div class="h-64 relative">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Right Chart Card (Subscription Plans Distribution - Doughnut Chart) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Plan Distribution</h4>
                    <span class="text-xs text-gray-400">Total WOs</span>
                </div>
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="planChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Load Chart.js from CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isDark = document.documentElement.classList.contains('dark') || localStorage.getItem('darkMode') === 'true';
                const gridColor = isDark ? '#374151' : '#f3f4f6';
                const textColor = isDark ? '#9ca3af' : '#4b5563';

                // 1. Revenue Line Chart
                const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctxRevenue, {
                    type: 'line',
                    data: {
                        labels: @json($months),
                        datasets: [{
                            label: 'Revenue',
                            data: @json($monthlyRevenue),
                            borderColor: '#f43f5e',
                            backgroundColor: 'rgba(244, 63, 94, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#f43f5e',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: textColor, font: { family: 'Inter', size: 10 } }
                            },
                            y: {
                                grid: { color: gridColor },
                                ticks: {
                                    color: textColor,
                                    font: { family: 'Inter', size: 10 },
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });

                // 2. Subscription Plans Doughnut Chart
                const ctxPlan = document.getElementById('planChart').getContext('2d');
                new Chart(ctxPlan, {
                    type: 'doughnut',
                    data: {
                        labels: ['Free', 'Basic', 'Pro', 'Enterprise'],
                        datasets: [{
                            data: [
                                {{ $planDistribution['free'] }},
                                {{ $planDistribution['basic'] }},
                                {{ $planDistribution['pro'] }},
                                {{ $planDistribution['enterprise'] }}
                            ],
                            backgroundColor: ['#9ca3af', '#60a5fa', '#f43f5e', '#34d399'],
                            borderWidth: isDark ? 2 : 1,
                            borderColor: isDark ? '#1f2937' : '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor,
                                    font: { family: 'Inter', size: 11 },
                                    boxWidth: 12
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            });
        </script>

        <!-- Recent Transactions/Orders Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h4 class="font-bold text-sm text-gray-900 dark:text-white">Recent Orders</h4>
                <button class="text-xs text-rose-600 dark:text-rose-400 font-semibold hover:underline">View All</button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-700/20 text-gray-400 dark:text-gray-500 font-bold border-b border-gray-100 dark:border-gray-700">
                            <th class="p-4 select-none">Purchase Id</th>
                            <th class="p-4">Customer Name</th>
                            <th class="p-4">Product Name</th>
                            <th class="p-4">Amount</th>
                            <th class="p-4">Order Date</th>
                            <th class="p-4">Vendor</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="p-4 text-rose-600 dark:text-rose-400">#SUB{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="p-4 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-[10px]">
                                    {{ strtoupper(substr($order->woProfile->business_name ?? 'WO', 0, 2)) }}
                                </div>
                                {{ $order->woProfile->business_name ?? 'N/A' }}
                            </td>
                            <td class="p-4 text-gray-500 dark:text-gray-400">{{ ucfirst($order->plan) }} Plan Subscription</td>
                            <td class="p-4 font-bold text-gray-900 dark:text-white">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                            <td class="p-4 text-gray-400">{{ $order->created_at->format('j M, Y') }}</td>
                            <td class="p-4">{{ str_replace('_', ' ', ucfirst($order->payment_method)) }}</td>
                            <td class="p-4">
                                @if($order->status === 'active')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-950/20 dark:text-emerald-400">Active</span>
                                @elseif($order->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 dark:bg-amber-950/20 dark:text-amber-400">Pending</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 dark:bg-red-950/20 dark:text-red-400">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400 dark:text-gray-500">
                                Belum ada transaksi langganan terbaru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
