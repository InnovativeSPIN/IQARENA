<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/framer-motion@10.12.16/dist/framer-motion.min.js"></script>
    <style>
        :root {
            --color-primary: #F97316;
            --color-primary-hover: #EA580C;
            --color-background: #FFFFFF;
            --color-surface: #F9FAFB;
        }
    </style>
</head>
<body class="bg-[var(--color-surface)] font-sans">
      <?php include('./header.php') ?>

    <main class="container mx-auto px-4 py-8">
        <nav class="flex space-x-4 mb-8">
            <a href="dashboard.php" class="px-4 py-2 text-gray-600 hover:bg-gray-200 rounded">Dashboard</a>
            <a href="quiz-attend.php" class="px-4 py-2 text-gray-600 hover:bg-gray-200 rounded">Attend Quiz</a>
            <a href="results.php" class="px-4 py-2 text-gray-600 hover:bg-gray-200 rounded">Results</a>
            <a href="leaderboard.php" class="px-4 py-2 text-gray-600 hover:bg-gray-200 rounded">Leaderboard</a>
            <a href="analytics.php" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-primary-hover)] active:bg-[var(--color-primary-hover)]">Analytics</a>
        </nav>

        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800">Your Performance Analytics 📊</h2>
            <p class="text-gray-600">Dive into your quiz performance with interactive charts and insights.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-[var(--color-background)] p-6 rounded-lg shadow" data-animate>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quiz Scores Over Time</h3>
                <canvas id="scoreTrendChart"></canvas>
            </div>
            <div class="bg-[var(--color-background)] p-6 rounded-lg shadow" data-animate>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Subject-wise Performance</h3>
                <canvas id="subjectPerformanceChart"></canvas>
            </div>
            <div class="bg-[var(--color-background)] p-6 rounded-lg shadow" data-animate>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quiz Completion Rate</h3>
                <canvas id="completionRateChart"></canvas>
            </div>
            <div class="bg-[var(--color-background)] p-6 rounded-lg shadow" data-animate>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Leaderboard Rank Trend</h3>
                <canvas id="rankTrendChart"></canvas>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-8">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input id="search-input" type="text" placeholder="Search analytics..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
            </div>
            <select id="filter-time" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
                <option value="all">All Time</option>
                <option value="month">This Month</option>
                <option value="semester">This Semester</option>
            </select>
            <button class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-primary-hover)] flex items-center space-x-2" data-animate-button>
                <i data-lucide="refresh-cw"></i>
                <span>Refresh Data</span>
            </button>
        </div>
    </main>

    <script>
        lucide.createIcons();

        const analyticsData = {
            scoreTrend: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
                scores: [75, 80, 85, 90, 82]
            },
            subjectPerformance: {
                subjects: ['Computer Science', 'Web Development', 'Mathematics', 'Database'],
                scores: [85, 78, 92, 80]
            },
            completionRate: {
                completed: 8,
                total: 10
            },
            rankTrend: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
                ranks: [15, 13, 12, 10, 12]
            }
        };

        const scoreTrendChart = new Chart(document.getElementById('scoreTrendChart'), {
            type: 'line',
            data: {
                labels: analyticsData.scoreTrend.labels,
                datasets: [{
                    label: 'Quiz Scores',
                    data: analyticsData.scoreTrend.scores,
                    borderColor: 'var(--color-primary)',
                    backgroundColor: 'rgba(249, 115, 22, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    tooltip: { mode: 'index', intersect: false }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuad'
                },
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });

        const subjectPerformanceChart = new Chart(document.getElementById('subjectPerformanceChart'), {
            type: 'bar',
            data: {
                labels: analyticsData.subjectPerformance.subjects,
                datasets: [{
                    label: 'Average Score',
                    data: analyticsData.subjectPerformance.scores,
                    backgroundColor: ['var(--color-primary)', '#10B981', '#F59E0B', '#EF4444']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    tooltip: { mode: 'index', intersect: false }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuad'
                },
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });

        const completionRateChart = new Chart(document.getElementById('completionRateChart'), {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Remaining'],
                datasets: [{
                    data: [analyticsData.completionRate.completed, analyticsData.completionRate.total - analyticsData.completionRate.completed],
                    backgroundColor: ['var(--color-primary)', '#D1D5DB']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: { mode: 'index' }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuad'
                }
            }
        });

        const rankTrendChart = new Chart(document.getElementById('rankTrendChart'), {
            type: 'line',
            data: {
                labels: analyticsData.rankTrend.labels,
                datasets: [{
                    label: 'Leaderboard Rank',
                    data: analyticsData.rankTrend.ranks,
                    borderColor: 'var(--color-primary)',
                    backgroundColor: 'rgba(249, 115, 22, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    tooltip: { mode: 'index', intersect: false }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuad'
                },
                scales: {
                    y: { beginAtZero: false, reverse: true }
                }
            }
        });

        document.querySelectorAll('[data-animate]').forEach((el, index) => {
            el.style.opacity = 0;
            el.style.transform = 'translateY(20px)';
            setTimeout(() => {
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                el.style.opacity = 1;
                el.style.transform = 'translateY(0)';
            }, index * 200);
        });

        const buttons = document.querySelectorAll('[data-animate-button]');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transition = 'transform 0.3s ease';
                button.style.transform = 'scale(1.05)';
            });
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'scale(1)';
            });
        });

        document.getElementById('search-input').addEventListener('input', (e) => {
            console.log('Search:', e.target.value);
        });

        document.getElementById('filter-time').addEventListener('change', (e) => {
            console.log('Filter:', e.target.value);
        });

        document.querySelector('[data-animate-button]').addEventListener('click', () => {
            document.querySelectorAll('[data-animate]').forEach(el => {
                el.style.opacity = 0;
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    el.style.opacity = 1;
                    el.style.transform = 'translateY(0)';
                }, 200);
            });
        });
    </script>
</body>
</html>