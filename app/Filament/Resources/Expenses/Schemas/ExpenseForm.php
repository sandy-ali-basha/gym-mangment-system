<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category')
                    ->options([
                        'equipment' => 'Equipment', 'maintenance' => 'Maintenance', 'rent' => 'Rent',
                        'electricity' => 'Electricity', 'water' => 'Water', 'cleaning' => 'Cleaning',
                        'marketing' => 'Marketing', 'software' => 'Software', 'supplies' => 'Supplies',
                        'salaries' => 'Salaries', 'other' => 'Other',
                    ])
                    ->searchable()
                    ->required(),
                Textarea::make('description')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->suffix('ل.س'),
                DatePicker::make('incurred_at')
                    ->default(now())
                    ->required(),
                Select::make('payment_method')
                    ->options(['cash' => 'Cash', 'bank_transfer' => 'Bank transfer', 'card' => 'Card', 'other' => 'Other']),
                TextInput::make('vendor'),
                FileUpload::make('receipt_path')
                    ->label('Receipt attachment')
                    ->directory('expense-receipts')
                    ->openable()
                    ->downloadable(),
                Select::make('recorded_by')
                    ->label('Recorded by')
                    ->relationship('recordedBy', 'name')
                    ->default(fn (): ?int => auth()->id())
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
