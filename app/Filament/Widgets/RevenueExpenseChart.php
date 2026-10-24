<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class RevenueExpenseChart extends ChartWidget
{
    protected ?string $heading = 'الإيرادات والمصروفات الشهرية';

    protected function getData(): array
    {
        $labels = collect(range(5, 0))->map(fn (int $months): string => now()->subMonths($months)->format('M Y'));
        $revenue = $labels->map(fn (string $label): float => (float) Payment::whereMonth('paid_at', now()->parse($label)->month)->whereYear('paid_at', now()->parse($label)->year)->sum('amount'));
        $expenses = $labels->map(fn (string $label): float => (float) Expense::whereMonth('incurred_at', now()->parse($label)->month)->whereYear('incurred_at', now()->parse($label)->year)->sum('amount'));

        return ['datasets' => [
            ['label' => 'الإيرادات', 'data' => $revenue->all(), 'borderColor' => '#10b981'],
            ['label' => 'المصروفات', 'data' => $expenses->all(), 'borderColor' => '#ef4444'],
        ], 'labels' => $labels->all()];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
