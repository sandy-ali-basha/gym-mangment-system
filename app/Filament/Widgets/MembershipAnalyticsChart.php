<?php

namespace App\Filament\Widgets;

use App\Models\Membership;
use Filament\Widgets\ChartWidget;

class MembershipAnalyticsChart extends ChartWidget
{
    protected ?string $heading = 'الإيرادات حسب خطة الاشتراك';

    protected function getData(): array
    {
        $plans = Membership::query()->with('plan')->get()->groupBy('membership_plan_id');
        $labels = $plans->map(fn ($items): string => $items->first()->plan?->name ?? 'Unknown');
        $data = $plans->map(fn ($items): float => (float) $items->sum('paid_amount'));

        return ['datasets' => [['label' => 'الإيرادات المحصلة', 'data' => $data->values()->all()]], 'labels' => $labels->values()->all()];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
