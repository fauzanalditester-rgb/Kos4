<div class="space-y-4">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Laporan</h1>
            <p class="text-gray-400 text-sm mt-1">Ringkasan keuangan dan operasional.</p>
        </div>
        <a href="{{ route('admin.finances.export') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-transparent border border-gray-700 hover:bg-gray-800 text-gray-300 text-sm font-medium rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export CSV
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Total Income -->
        <div class="bg-[#111827] border border-gray-800/50 rounded-2xl p-6">
            <p class="text-gray-400 text-sm mb-2">Total Pemasukan (6 bln)</p>
            <p class="text-emerald-500 text-2xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>

        <!-- Total Expense -->
        <div class="bg-[#111827] border border-gray-800/50 rounded-2xl p-6">
            <p class="text-gray-400 text-sm mb-2">Total Pengeluaran (6 bln)</p>
            <p class="text-red-500 text-2xl font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
        </div>

        <!-- Net Profit -->
        <div class="bg-[#111827] border border-gray-800/50 rounded-2xl p-6">
            <p class="text-gray-400 text-sm mb-2">Laba Bersih (6 bln)</p>
            <p class="text-[#14b8a6] text-2xl font-bold">Rp {{ number_format($netProfit, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Cashflow Chart -->
    <div class="bg-[#111827] border border-gray-800/50 rounded-2xl p-6" x-data="cashflowChart()" x-init="initChart()">
        <h3 class="text-white font-semibold mb-6">Tren Cashflow</h3>
        <div class="h-72 relative">
            <canvas x-ref="canvas" class="w-full h-full"></canvas>
        </div>
    </div>
</div>

<script>
function cashflowChart() {
    return {
        months: {{ json_encode($months) }},
        data: {{ json_encode($cashflowData) }},
        initChart() {
            const canvas = this.$refs.canvas;
            const ctx = canvas.getContext('2d');
            
            // Set canvas size
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
            
            const width = canvas.width;
            const height = canvas.height;
            const padding = { top: 20, right: 20, bottom: 40, left: 50 };
            const chartWidth = width - padding.left - padding.right;
            const chartHeight = height - padding.top - padding.bottom;
            
            // Calculate values
            const incomeValues = this.data.map(d => d.income / 1000000);
            const expenseValues = this.data.map(d => d.expense / 1000000);
            const maxValue = Math.max(...incomeValues, ...expenseValues);
            const yMax = Math.ceil(maxValue / 6) * 6 || 6;
            
            // Clear canvas
            ctx.clearRect(0, 0, width, height);
            
            // Draw grid lines
            ctx.strokeStyle = '#374151';
            ctx.lineWidth = 1;
            ctx.setLineDash([4, 4]);
            
            for (let i = 0; i <= 4; i++) {
                const y = padding.top + (chartHeight / 4) * i;
                ctx.beginPath();
                ctx.moveTo(padding.left, y);
                ctx.lineTo(width - padding.right, y);
                ctx.stroke();
                
                // Y-axis labels
                ctx.fillStyle = '#9ca3af';
                ctx.font = '12px sans-serif';
                ctx.textAlign = 'right';
                const value = yMax - (yMax / 4) * i;
                ctx.fillText(value + 'jt', padding.left - 10, y + 4);
            }
            
            ctx.setLineDash([]);
            
            // Draw bars
            const barWidth = chartWidth / (this.months.length * 3);
            const gap = barWidth / 2;
            
            this.months.forEach((month, i) => {
                const x = padding.left + (chartWidth / this.months.length) * i + (chartWidth / this.months.length - gap * 3) / 2;
                
                // Income bar (teal)
                const incomeHeight = (incomeValues[i] / yMax) * chartHeight;
                const incomeY = padding.top + chartHeight - incomeHeight;
                ctx.fillStyle = '#14b8a6';
                ctx.beginPath();
                ctx.roundRect(x, incomeY, barWidth, incomeHeight, 4);
                ctx.fill();
                
                // Expense bar (red)
                const expenseHeight = (expenseValues[i] / yMax) * chartHeight;
                const expenseY = padding.top + chartHeight - expenseHeight;
                ctx.fillStyle = '#ef4444';
                ctx.beginPath();
                ctx.roundRect(x + barWidth + gap, expenseY, barWidth, expenseHeight, 4);
                ctx.fill();
                
                // Month label
                ctx.fillStyle = '#9ca3af';
                ctx.font = '12px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText(month, x + barWidth, height - 15);
            });
        }
    }
}
</script>
