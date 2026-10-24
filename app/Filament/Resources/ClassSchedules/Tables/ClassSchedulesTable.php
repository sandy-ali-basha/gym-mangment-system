<?php

namespace App\Filament\Resources\ClassSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClassSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('gymClass.name')
                    ->searchable(),
                TextColumn::make('coach.full_name')
                    ->label('Coach')
                    ->searchable(),
                TextColumn::make('days_of_week')
                    ->label('Days')
                    ->badge()
                    ->formatStateUsing(fn (?array $state): string => collect($state ?? [])->map(fn (string $day): string => ucfirst($day))->join(', '))
                    ->searchable(),
                TextColumn::make('starts_at')
                    ->time()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->time()
                    ->sortable(),
                TextColumn::make('location')
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
