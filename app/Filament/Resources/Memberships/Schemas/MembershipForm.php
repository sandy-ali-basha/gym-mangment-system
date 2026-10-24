<?php

namespace App\Filament\Resources\Memberships\Schemas;

use App\Models\MembershipPlan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class MembershipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->relationship('client', 'full_name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('full_name')->required(),
                        TextInput::make('phone')->tel()->required(),
                        Select::make('gender')->options(['female' => 'Women', 'male' => 'Men'])->required(),
                        DatePicker::make('registered_at')->default(now())->required(),
                        Hidden::make('status')->default('active'),
                    ])
                    ->required(),
                Select::make('membership_plan_id')
                    ->relationship('plan', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (?int $state, Set $set): void {
                        $plan = MembershipPlan::find($state);

                        if ($plan === null) {
                            return;
                        }

                        $set('plan_price', $plan->price);
                        $set('final_price', $plan->price);
                        $set('remaining_amount', $plan->price);
                        $set('end_date', now()->addDays($plan->duration_days)->toDateString());
                    })
                    ->required(),
                Select::make('coach_id')
                    ->relationship('coach', 'full_name')
                    ->searchable()
                    ->preload(),
                DatePicker::make('start_date')
                    ->default(now())
                    ->live()
                    ->afterStateUpdated(function (?string $state, Get $get, Set $set): void {
                        $plan = MembershipPlan::find($get('membership_plan_id'));

                        if ($plan !== null && $state !== null) {
                            $set('end_date', Carbon::parse($state)->addDays($plan->duration_days)->toDateString());
                        }
                    })
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                TextInput::make('plan_price')
                    ->required()
                    ->numeric()
                    ->suffix('ل.س')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->suffix('ل.س')
                    ->default(0)
                    ->live()
                    ->disabled(fn (Get $get): bool => blank($get('membership_plan_id')))
                    ->afterStateUpdated(function (?string $state, Get $get, Set $set): void {
                        $finalPrice = max(0, (float) $get('plan_price') - (float) $state);
                        $set('final_price', $finalPrice);
                        $set('remaining_amount', max(0, $finalPrice - (float) $get('paid_amount')));
                    }),
                TextInput::make('final_price')
                    ->required()
                    ->numeric()
                    ->suffix('ل.س')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('paid_amount')
                    ->required()
                    ->numeric()
                    ->suffix('ل.س')
                    ->default(0)
                    ->live()
                    ->afterStateUpdated(function (?string $state, Get $get, Set $set): void {
                        $set('remaining_amount', max(0, (float) $get('final_price') - (float) $state));
                    }),
                TextInput::make('remaining_amount')
                    ->required()
                    ->numeric()
                    ->suffix('ل.س')
                    ->disabled()
                    ->dehydrated(),
                Select::make('payment_status')
                    ->options(['paid' => 'Payed', 'unpaid' => 'Unpaied', 'partial' => 'Partly paied'])
                    ->required()
                    ->default('unpaid'),
                Toggle::make('status')
                    ->label('Active membership')
                    ->default(true)
                    ->formatStateUsing(fn (?string $state): bool => $state === 'active')
                    ->dehydrateStateUsing(fn (bool $state): string => $state ? 'active' : 'cancelled'),
            ]);
    }
}
