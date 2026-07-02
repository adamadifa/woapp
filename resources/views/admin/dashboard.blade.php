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

        <!-- Charts Placeholders -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Chart Card (Total Projects Status) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Total Projects Overview</h4>
                    <div class="flex items-center gap-3 text-xs">
                        <span class="flex items-center gap-1.5 text-rose-600 font-semibold"><span class="w-2 h-2 rounded-full bg-rose-500"></span> This Year</span>
                        <span class="flex items-center gap-1.5 text-gray-400"><span class="w-2 h-2 rounded-full bg-gray-300"></span> Last Year</span>
                    </div>
                </div>
                <!-- Visual Placeholder for Line Chart -->
                <div class="h-64 flex flex-col justify-end gap-4 relative">
                    <!-- Chart grid lines -->
                    <div class="absolute inset-0 flex flex-col justify-between py-2 pointer-events-none">
                        <div class="border-b border-gray-100 dark:border-gray-700 w-full h-0"></div>
                        <div class="border-b border-gray-100 dark:border-gray-700 w-full h-0"></div>
                        <div class="border-b border-gray-100 dark:border-gray-700 w-full h-0"></div>
                        <div class="border-b border-gray-100 dark:border-gray-700 w-full h-0"></div>
                    </div>
                    <!-- Simulated Wave Line Chart (SVG representation) -->
                    <div class="w-full h-48 relative overflow-hidden">
                        <svg class="w-full h-full" viewBox="0 0 100 50" preserveAspectRatio="none">
                            <path d="M0,45 Q15,20 30,35 T60,15 T90,25 T100,20 L100,50 L0,50 Z" fill="url(#roseGrad)" class="opacity-10" />
                            <path d="M0,45 Q15,20 30,35 T60,15 T90,25 T100,20" fill="none" stroke="#f43f5e" stroke-width="2" />
                            <defs>
                                <linearGradient id="roseGrad" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#f43f5e" />
                                    <stop offset="100%" stop-color="#ffffff" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-gray-400 dark:text-gray-500 font-semibold px-2">
                        <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span>
                    </div>
                </div>
            </div>

            <!-- Right Chart Card (Device Traffic) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <h4 class="font-bold text-sm text-gray-900 dark:text-white mb-6">Device Traffic</h4>
                <!-- Bar Chart Grid Representation -->
                <div class="h-64 flex items-end justify-between px-2 gap-4">
                    <div class="flex flex-col items-center gap-2 flex-1">
                        <div class="w-full bg-rose-50 dark:bg-rose-950/20 rounded-xl h-24 flex items-end justify-center">
                            <div class="w-full bg-rose-300 dark:bg-rose-700 rounded-xl h-[40%]"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-semibold">Linux</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 flex-1">
                        <div class="w-full bg-rose-50 dark:bg-rose-950/20 rounded-xl h-44 flex items-end justify-center">
                            <div class="w-full bg-rose-400 dark:bg-rose-600 rounded-xl h-[75%]"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-semibold">Mac</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 flex-1">
                        <div class="w-full bg-rose-50 dark:bg-rose-950/20 rounded-xl h-44 flex items-end justify-center">
                            <div class="w-full bg-rose-500 rounded-xl h-[95%]"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-semibold">iOS</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 flex-1">
                        <div class="w-full bg-rose-50 dark:bg-rose-950/20 rounded-xl h-36 flex items-end justify-center">
                            <div class="w-full bg-pink-400 rounded-xl h-[65%]"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-semibold">Windows</span>
                    </div>
                </div>
            </div>
        </div>

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
