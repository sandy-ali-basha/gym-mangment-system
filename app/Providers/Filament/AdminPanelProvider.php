<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Clients\ClientResource;
use App\Filament\Widgets\FinancialOverview;
use App\Filament\Widgets\MembershipAnalyticsChart;
use App\Filament\Widgets\RevenueExpenseChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('إدارة النادي الرياضي')
            ->login()
            ->navigationItems([
                NavigationItem::make('عميلات نساء')
                    ->group('العملاء')
                    ->icon('heroicon-o-user-group')
                    ->url(fn (): string => ClientResource::getUrl('index', ['tableFilters[gender][value]' => 'female'])),
                NavigationItem::make('عملاء رجال')
                    ->group('العملاء')
                    ->icon('heroicon-o-user-group')
                    ->url(fn (): string => ClientResource::getUrl('index', ['tableFilters[gender][value]' => 'male'])),
            ])
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
                FinancialOverview::class,
                RevenueExpenseChart::class,
                MembershipAnalyticsChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
