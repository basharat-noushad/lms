<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reports & Analytics</h1>
            <p class="text-gray-500 dark:text-gray-400">Track your platform's performance</p>
        </div>
        <div class="flex items-center space-x-4">
            <select wire:model.live="period" class="rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="month">Last 30 Days</option>
                <option value="year">This Year</option>
            </select>
            <button wire:click="exportCsv" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export CSV
            </button>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Revenue -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 dark:text-gray-400 font-medium">Total Revenue</h3>
                <span class="p-2 bg-green-100 text-green-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">
                        ${{ number_format($metrics['revenue']['value'], 2) }}
                    </div>
                    <div class="text-sm {{ $metrics['revenue']['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metrics['revenue']['growth'] >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}"/>
                        </svg>
                        {{ abs(round($metrics['revenue']['growth'], 1)) }}% vs last month
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrollments -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 dark:text-gray-400 font-medium">New Enrollments</h3>
                <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </span>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($metrics['enrollments']['value']) }}
                    </div>
                    <div class="text-sm {{ $metrics['enrollments']['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metrics['enrollments']['growth'] >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}"/>
                        </svg>
                        {{ abs(round($metrics['enrollments']['growth'], 1)) }}% vs last month
                    </div>
                </div>
            </div>
        </div>

        <!-- Students -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 dark:text-gray-400 font-medium">Total Students</h3>
                <span class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </span>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($metrics['students']['total']) }}
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        +{{ $metrics['students']['new'] }} new this month
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Revenue Trend</h3>
            <div class="h-80">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Enrollment Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Enrollment Trend</h3>
            <div class="h-80">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            let revenueChart, enrollmentChart;

            function initCharts(data) {
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');

                if (revenueChart) revenueChart.destroy();
                if (enrollmentChart) enrollmentChart.destroy();

                revenueChart = new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: data.revenue.labels,
                        datasets: [{
                            label: 'Revenue',
                            data: data.revenue.values,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });

                enrollmentChart = new Chart(enrollmentCtx, {
                    type: 'bar',
                    data: {
                        labels: data.enrollments.labels,
                        datasets: [{
                            label: 'Enrollments',
                            data: data.enrollments.values,
                            backgroundColor: '#3B82F6',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }

            // Initial load
            initCharts({
                revenue: @json($revenueData),
                enrollments: @json($enrollmentData)
            });

            // Update on event
            Livewire.on('update-charts', (data) => {
                initCharts(data[0]);
            });
        });
    </script>
    @endpush
</div>
