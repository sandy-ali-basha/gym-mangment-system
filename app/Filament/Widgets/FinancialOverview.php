<?php

namespace App\Filament\Widgets;

use App\Models\Coach;
use App\Models\Expense;
use App\Models\Membership;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $monthStart = now()->startOfMonth();
        $revenue = (float) Payment::whereBetween('paid_at', [$monthStart, now()])->sum('amount');
        $expenses = (float) Expense::whereBetween('incurred_at', [$monthStart, now()])->sum('amount');
        $staffCost = (float) Coach::where('is_active', true)->sum('base_salary');
        $outstanding = (float) Membership::sum('remaining_amount');
        $expiring = Membership::whereBetween('end_date', [today(), today()->addDays(30)])->count();

        return [
            Stat::make('الإيرادات الشهرية', number_format($revenue, 0).' ل.س')->description('المبالغ المحصلة هذا الشهر')->color('success'),
            Stat::make('المصروفات الشهرية', number_format($expenses, 0).' ل.س')->description('المصروفات المسجلة هذا الشهر')->color('danger'),
            Stat::make('صافي الربح', number_format($revenue - $expenses - $staffCost, 0).' ل.س')->description('بعد تكاليف الموظفين')->color($revenue - $expenses - $staffCost >= 0 ? 'success' : 'danger'),
            Stat::make('تكلفة الموظفين والمدربين', number_format($staffCost, 0).' ل.س')->description('رواتب المدربين النشطين')->color('warning'),
            Stat::make('الأرصدة المستحقة', number_format($outstanding, 0).' ل.س')->color('warning'),
            Stat::make('الاشتراكات المنتهية قريباً', $expiring)->description('خلال الثلاثين يوماً القادمة')->color('info'),
        ];
    }
}
