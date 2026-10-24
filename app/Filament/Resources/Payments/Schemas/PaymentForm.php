<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('membership_id')
                    ->relationship('membership', 'id')
                    ->required(),
                Select::make('client_id')
                    ->relationship('client', 'id')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->suffix('ل.س'),
                DatePicker::make('paid_at')
                    ->required(),
                TextInput::make('payment_method')
                    ->required(),
                TextInput::make('reference'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('recorded_by')
                    ->numeric(),
            ]);
    }
}
