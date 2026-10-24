<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Models\MembershipPlan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class MembershipsRelationManager extends RelationManager
{
    protected static string $relationship = 'memberships';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('membership_plan_id')
                    ->relationship('plan', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (?int $state, Set $set): void {
                        $plan = MembershipPlan::find($state);
                        if ($plan !== null) {
                            $set('plan_price', $plan->price);
                            $set('final_price', $plan->price);
                            $set('remaining_amount', $plan->price);
                            $set('end_date', now()->addDays($plan->duration_days)->toDateString());
                        }
                    }),
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
                DatePicker::make('end_date')->required(),
                TextInput::make('plan_price')->numeric()->suffix('ل.س')->required()->disabled()->dehydrated(),
                TextInput::make('discount_amount')->numeric()->suffix('ل.س')->default(0)->required()->live()
                    ->disabled(fn (Get $get): bool => blank($get('membership_plan_id')))
                    ->afterStateUpdated(function (?string $state, Get $get, Set $set): void {
                        $finalPrice = max(0, (float) $get('plan_price') - (float) $state);
                        $set('final_price', $finalPrice);
                        $set('remaining_amount', max(0, $finalPrice - (float) $get('paid_amount')));
                    }),
                TextInput::make('final_price')->numeric()->suffix('ل.س')->required()->disabled()->dehydrated(),
                TextInput::make('paid_amount')->numeric()->suffix('ل.س')->default(0)->required()->live()
                    ->afterStateUpdated(fn (?string $state, Get $get, Set $set): mixed => $set('remaining_amount', max(0, (float) $get('final_price') - (float) $state))),
                TextInput::make('remaining_amount')->numeric()->suffix('ل.س')->required()->disabled()->dehydrated(),
                Select::make('payment_status')->options(['paid' => 'Payed', 'unpaid' => 'Unpaied', 'partial' => 'Partly paied'])->default('unpaid')->required(),
                Toggle::make('status')->label('Active membership')->default(true)
                    ->formatStateUsing(fn (?string $state): bool => $state === 'active')
                    ->dehydrateStateUsing(fn (bool $state): string => $state ? 'active' : 'cancelled'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start_date')
            ->columns([
                TextColumn::make('plan.name')->label('Plan')->searchable(),
                TextColumn::make('start_date')->date()->sortable(),
                TextColumn::make('end_date')->date()->sortable(),
                TextColumn::make('final_price')->money('SYP', decimalPlaces: 0),
                TextColumn::make('paid_amount')->money('SYP', decimalPlaces: 0),
                TextColumn::make('remaining_amount')->money('SYP', decimalPlaces: 0),
                TextColumn::make('payment_status')->badge(),
                TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
