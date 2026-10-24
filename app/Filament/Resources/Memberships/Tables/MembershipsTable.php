<?php

namespace App\Filament\Resources\Memberships\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembershipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.full_name')
                    ->label('العميل')
                    ->searchable(),
                TextColumn::make('plan.name')
                    ->label('خطة الاشتراك')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('coach.full_name')
                    ->label('المدرب')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('plan_price')
                    ->money('SYP', decimalPlaces: 0)
                    ->sortable(),
                TextColumn::make('discount_amount')
                    ->money('SYP', decimalPlaces: 0)
                    ->sortable(),
                TextColumn::make('final_price')
                    ->money('SYP', decimalPlaces: 0)
                    ->sortable(),
                TextColumn::make('paid_amount')
                    ->money('SYP', decimalPlaces: 0)
                    ->sortable(),
                TextColumn::make('remaining_amount')
                    ->money('SYP', decimalPlaces: 0)
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
