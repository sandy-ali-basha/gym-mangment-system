<?php

namespace App\Filament\Resources\Coaches\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CoachForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('salary_type')
                    ->required()
                    ->default('fixed'),
                TextInput::make('base_salary')
                    ->required()
                    ->numeric()
                    ->suffix('ل.س')
                    ->default(0),
                TextInput::make('commission_rate')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
